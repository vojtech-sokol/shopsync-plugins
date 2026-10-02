<?php
/**
 * mrpks_codec.php - standalone helpers for the MRP K/S autonomous mode (HTTP API).
 *
 *  - mrpksParseResponse()   parse an mrpEnvelope response, detect <status><error>
 *  - mrpksDatasetRows()     dataset rows as a list of assoc arrays (safe for 0/1/n rows)
 *  - mrpksEncodeRequest()   wrap a plain <mrpRequest> into an <encodedBody> envelope
 *                           (zlib compression and/or AES-256-CTR + HMAC-SHA256)
 *  - mrpksDecodeResponse()  inverse of the above for <encodedBody> responses
 *  - mrpksCodecSelfTest()   verifies the crypto against the official test vectors (FAQ 483)
 *
 * No ShopSync dependencies. Requires ext-openssl, ext-zlib, ext-simplexml.
 * Run `php mrpks_codec.php` to execute the self-test (exit code 0 = all OK).
 */

namespace MRPKS\Codec;

/* ------------------------------------------------------------------ */
/* Response parsing                                                    */
/* ------------------------------------------------------------------ */

/**
 * Parse a (decoded) mrpEnvelope response.
 *
 * MRP answers HTTP 200 even when the command failed - the failure is only in
 * body/mrpResponse/status/error. Never treat HTTP 200 as success on its own.
 *
 * @return array{ok:bool, command:?string, requestId:?string, errorCode:?string,
 *               errorClass:?string, errorMessage:?string, data:?\SimpleXMLElement}
 */
function mrpksParseResponse(string $xml): array {
    $out = array("ok" => false, "command" => null, "requestId" => null, "errorCode" => null,
        "errorClass" => null, "errorMessage" => null, "data" => null);

    $prev = libxml_use_internal_errors(true);
    $doc = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_PARSEHUGE | LIBXML_NOCDATA);
    libxml_use_internal_errors($prev);
    if ($doc === false || !isset($doc->body->mrpResponse)) {
        $out["errorMessage"] = "Response is not a valid mrpEnvelope/body/mrpResponse document";
        return $out;
    }
    $resp = $doc->body->mrpResponse;
    if (isset($resp->status->request)) {
        $out["command"] = (string) $resp->status->request["command"];
        $out["requestId"] = (string) $resp->status->request["requestId"];
    }
    if (isset($resp->status->error)) {
        $err = $resp->status->error;
        $out["errorCode"] = (string) $err["errorCode"];
        $out["errorClass"] = (string) $err["errorClass"];
        $out["errorMessage"] = trim((string) $err->errorMessage);
        return $out;
    }
    $out["ok"] = true;
    $out["data"] = isset($resp->data) ? $resp->data : null;
    return $out;
}

/**
 * Rows of one dataset (data/datasets/<name>/rows/row/fields) as a list of
 * associative arrays. Always a list - also for exactly one row (the
 * json_decode(json_encode(simplexml)) trick used by lib/mrpks returns a bare
 * row in that case). Empty elements (<kod/>) become "" instead of empty arrays.
 */
function mrpksDatasetRows(?\SimpleXMLElement $data, string $dataset): array {
    $rows = array();
    if ($data === null || !isset($data->datasets->{$dataset}->rows->row)) {
        return $rows;
    }
    foreach ($data->datasets->{$dataset}->rows->row as $row) {
        $r = array();
        foreach ($row->fields->children() as $name => $value) {
            $r[$name] = (string) $value;
        }
        $rows[] = $r;
    }
    return $rows;
}

/* ------------------------------------------------------------------ */
/* Encoded communication (compression / encryption / authentication)  */
/* ------------------------------------------------------------------ */

function hmac(string $key, string $data): string {
    return hash_hmac("sha256", $data, $key, true);
}

/** Derive [encryptionKey, authenticationKey] from the 32-byte secret (base64, as entered in MRP). */
function mrpksDeriveKeys(string $secretBase64): array {
    $secret = base64_decode(trim($secretBase64), true);
    if ($secret === false || strlen($secret) !== 32) {
        throw new \InvalidArgumentException("MRP secret key must be base64 of exactly 32 bytes");
    }
    $encKey = hmac($secret, "\x01");
    $authKey = hmac($secret, $encKey . "\x02");
    return array($encKey, $authKey);
}

/** AES-256-CTR with the per-message key/IV derived from the variant key. Symmetric (encrypt == decrypt). */
function mrpksAesCtr(string $data, string $encKey, string $varKey): string {
    $finalKey = hmac($encKey, $varKey);
    $iv = substr(hash("sha256", $varKey, true), 0, 16);
    $out = openssl_encrypt($data, "aes-256-ctr", $finalKey, OPENSSL_RAW_DATA, $iv);
    if ($out === false) {
        throw new \RuntimeException("openssl_encrypt(aes-256-ctr) failed");
    }
    return $out;
}

/**
 * Wrap the INNER request (root element <mrpRequest>) into an encoded envelope.
 *
 * @param string      $mrpRequestXml  XML whose root is <mrpRequest> (NOT the whole mrpEnvelope)
 * @param string|null $secretBase64   key from MRP settings; null/"" = no encryption/authentication
 * @param bool        $compress       zlib compression - see the note in references/autonomous-api.md
 */
function mrpksEncodeRequest(string $mrpRequestXml, ?string $secretBase64, bool $compress = true): string {
    $useCrypto = ($secretBase64 !== null && $secretBase64 !== "");
    $payload = $compress ? gzcompress($mrpRequestXml) : $mrpRequestXml;
    $paramAttrs = $compress ? ' compression="zlib"' : '';
    $varKeyXml = "";
    $authAttr = "";
    $authXml = "";
    $authKey = null;

    if ($useCrypto) {
        list($encKey, $authKey) = mrpksDeriveKeys($secretBase64);
        // variant key: random, must never repeat (also across stations sharing the key)
        $varKey = hash("sha256", random_bytes(32) . php_uname() . microtime(true), true);
        $payload = mrpksAesCtr($payload, $encKey, $varKey);
        $paramAttrs .= ' encryption="aes"';
        $varKeyXml = "<varKey>" . base64_encode($varKey) . "</varKey>";
    }

    $params = "<mrpEncodingParams$paramAttrs>$varKeyXml</mrpEncodingParams>";

    if ($useCrypto) {
        // signed sequence = raw encodingParams bytes || raw encodedData bytes (before base64)
        $authCode = hmac($authKey, $params . $payload);
        $authAttr = ' authentication="hmac_sha256"';
        $authXml = "<authCode>" . base64_encode($authCode) . "</authCode>";
    }

    return '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
        . "<mrpEnvelope><encodedBody$authAttr>"
        . "<encodingParams><![CDATA[" . base64_encode($params) . "]]></encodingParams>"
        . "<encodedData><![CDATA[" . base64_encode($payload) . "]]></encodedData>"
        . $authXml
        . "</encodedBody></mrpEnvelope>";
}

/**
 * Decode an <encodedBody> response back to a plain envelope
 * (<mrpEnvelope><body><mrpResponse>...). Plain <body> responses are returned unchanged.
 */
function mrpksDecodeResponse(string $envelopeXml, ?string $secretBase64): string {
    $doc = simplexml_load_string($envelopeXml, "SimpleXMLElement", LIBXML_PARSEHUGE | LIBXML_NOCDATA);
    if ($doc === false) {
        throw new \RuntimeException("Response is not XML");
    }
    if (!isset($doc->encodedBody)) {
        return $envelopeXml;
    }
    $eb = $doc->encodedBody;
    $params = base64_decode(trim((string) $eb->encodingParams));
    $payload = base64_decode(trim((string) $eb->encodedData));
    $p = simplexml_load_string($params);

    if ((string) $eb["authentication"] === "hmac_sha256") {
        list(, $authKey) = mrpksDeriveKeys((string) $secretBase64);
        $expected = hmac($authKey, $params . $payload);
        if (!hash_equals($expected, base64_decode(trim((string) $eb->authCode)))) {
            throw new \RuntimeException("MRP response authCode mismatch");
        }
    }
    if ($p !== false && (string) $p["encryption"] === "aes") {
        list($encKey) = mrpksDeriveKeys((string) $secretBase64);
        $payload = mrpksAesCtr($payload, $encKey, base64_decode(trim((string) $p->varKey)));
    }
    if ($p !== false && (string) $p["compression"] === "zlib") {
        $inflated = @gzuncompress($payload);      // zlib stream (RFC 1950)
        if ($inflated === false) {
            $inflated = @gzinflate($payload);     // raw deflate fallback
        }
        if ($inflated === false) {
            throw new \RuntimeException("zlib inflate failed");
        }
        $payload = $inflated;
    }
    return "<mrpEnvelope><body>" . preg_replace('/^<\?xml[^>]*>\s*/', '', $payload) . "</body></mrpEnvelope>";
}

/* ------------------------------------------------------------------ */
/* Self-test against the official example values (FAQ 483, chapter 3) */
/* ------------------------------------------------------------------ */

function mrpksCodecSelfTest(): bool {
    $hex = function ($s) { return hex2bin(str_replace(" ", "", $s)); };
    $secret = "bRtFEufmEgrJyhai6ltDSV9svtpN3Jb/5oWBBYhDJ30=";
    $varKey = $hex("1F 5A C7 7E D3 0C C0 A5 F7 5B B0 35 FF 05 66 A5 0D B2 12 7A AB 32 D8 62 4E 0D A4 D4 18 6E 7F 2F");
    $plain = $hex("01 02 03 04 05 06 07 08 09 0A 0B 0C 0D 0E 0F 10 11 12 13 14");

    list($encKey, $authKey) = mrpksDeriveKeys($secret);
    $checks = array(
        "encryption key" => array($encKey, $hex("DE B5 81 AB EC C4 A5 A5 5D C7 6C 08 A9 75 49 62 BD A0 54 10 E1 A3 0D 5E 99 05 AD FA 65 6C F2 C9")),
        "auth key" => array($authKey, $hex("5B DF 74 9A 16 63 DF 20 6A 1E 9E 36 03 96 33 75 92 FD D8 2F 66 05 CF 3A F8 D4 D4 54 6B 64 05 06")),
        "final key" => array(hmac($encKey, $varKey), $hex("00 06 29 E3 9E 79 F3 F5 2B 05 D8 58 72 40 C3 81 CA 14 A0 EC 17 27 A9 5A FA D4 80 EB D5 6E 1C 40")),
        "IV" => array(substr(hash("sha256", $varKey, true), 0, 16), $hex("09 18 29 E9 98 18 6D 9F B0 78 72 2E 0B 91 44 06")),
        "AES-CTR ciphertext" => array(mrpksAesCtr($plain, $encKey, $varKey), $hex("01 EC 4D BE B1 04 CD 38 E9 0A 4E CC C5 C5 35 9C D0 AA D8 AF")),
        "HMAC auth code" => array(hmac($authKey, $plain), $hex("B5 75 94 6C 75 DC A6 5C E0 DA 8A C2 AC F4 73 72 34 09 68 99 53 6E 88 05 51 CA D1 AE 99 DE F3 6A")),
    );
    $ok = true;
    foreach ($checks as $name => $pair) {
        $pass = hash_equals($pair[1], $pair[0]);
        $ok = $ok && $pass;
        echo str_pad($name, 20) . ($pass ? "OK" : "FAIL got " . bin2hex($pair[0])) . "\n";
    }

    // round trip of the envelope helpers
    $inner = '<mrpResponse><status><request command="EXPEO1"/></status><data/></mrpResponse>';
    $env = mrpksEncodeRequest($inner, $secret, true);
    $back = mrpksDecodeResponse($env, $secret);
    $rt = (strpos($back, $inner) !== false);
    $ok = $ok && $rt;
    echo str_pad("envelope round trip", 20) . ($rt ? "OK" : "FAIL") . "\n";
    return $ok;
}

if (PHP_SAPI === "cli" && isset($argv[0]) && realpath($argv[0]) === __FILE__) {
    exit(mrpksCodecSelfTest() ? 0 : 1);
}
