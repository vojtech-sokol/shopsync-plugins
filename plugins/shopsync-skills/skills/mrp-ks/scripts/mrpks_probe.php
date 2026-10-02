<?php
/**
 * mrpks_probe.php - send one request to the MRP K/S autonomous mode and show the result.
 *
 * Usage:
 *   php mrpks_probe.php <host:port>                      connectivity probe (EXPEO1 that matches nothing)
 *   php mrpks_probe.php <host:port> <request.xml>        send a request file (full <mrpEnvelope>)
 *   php mrpks_probe.php <host:port> <COMMAND>            send an empty request for a read-only COMMAND
 *                                                        (e.g. EXPUHRADY, EXPDOPRAVA, EXPSKLADY, EXPCISRAD0)
 * Options:
 *   --key=<base64>   secret key if "Vyzadovat sifrovani" is enabled in MRP (encrypt + authenticate)
 *   --zlib           compress the request (encodedBody without encryption if no --key)
 *   --out=<file>     save the raw (decoded) response
 *   --rows=<n>       how many dataset rows to print per dataset (default 3)
 *
 * Never send write commands (IMPEO0, IMPFV0, OP2SV0, SV2FV0, ...) to a production MRP just to "test".
 */

require __DIR__ . "/mrpks_codec.php";

use function MRPKS\Codec\mrpksParseResponse;
use function MRPKS\Codec\mrpksDatasetRows;
use function MRPKS\Codec\mrpksEncodeRequest;
use function MRPKS\Codec\mrpksDecodeResponse;

$args = array();
$opts = array("key" => null, "zlib" => false, "out" => null, "rows" => 3);
foreach (array_slice($argv, 1) as $a) {
    if (preg_match('/^--(key|out|rows)=(.*)$/', $a, $m)) {
        $opts[$m[1]] = $m[2];
    } elseif ($a === "--zlib") {
        $opts["zlib"] = true;
    } else {
        $args[] = $a;
    }
}
if (count($args) < 1) {
    fwrite(STDERR, "usage: php mrpks_probe.php <host:port> [request.xml|COMMAND] [--key=..] [--zlib] [--out=..]\n");
    exit(2);
}

$host = preg_replace('#^https?://#i', '', trim($args[0]));   // lib/mrpks expects plain host:port
$target = $args[1] ?? null;

if ($target === null) {
    $request = '<mrpEnvelope><body><mrpRequest><request command="EXPEO1" requestId=""></request><data><filter>'
        . '<fltvalue name="SKKAR.UPD_DATE">&gt;1.1.2100 00:00</fltvalue>'
        . '<fltvalue name="malObraz">F</fltvalue><fltvalue name="velObraz">F</fltvalue>'
        . '</filter></data></mrpRequest></body></mrpEnvelope>';
} elseif (is_file($target)) {
    $request = file_get_contents($target);
} elseif (preg_match('/^[A-Z0-9_]+$/', $target)) {
    $request = '<mrpEnvelope><body><mrpRequest><request command="' . $target . '" requestId=""></request>'
        . '<data/></mrpRequest></body></mrpEnvelope>';
} else {
    fwrite(STDERR, "Second argument must be an existing file or an UPPERCASE command code\n");
    exit(2);
}

if ($opts["key"] !== null || $opts["zlib"]) {
    $doc = simplexml_load_string($request);
    if ($doc === false || !isset($doc->body->mrpRequest)) {
        fwrite(STDERR, "Request is not <mrpEnvelope><body><mrpRequest>, cannot encode\n");
        exit(2);
    }
    $request = mrpksEncodeRequest($doc->body->mrpRequest->asXML(), $opts["key"], (bool) $opts["zlib"]);
}

$t0 = microtime(true);
$ch = curl_init("http://" . $host);
curl_setopt_array($ch, array(
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $request,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array("Content-Type: text/plain"),
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 300,
));
$body = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$cerr = curl_error($ch);
curl_close($ch);
$ms = round((microtime(true) - $t0) * 1000);

echo "HTTP $http in {$ms} ms" . ($cerr ? " - curl: $cerr" : "") . "\n";
if ($body === false || $http != 200) {
    echo "MRP not reachable. Check: MRPKS.EXE -A running, 'Http server' + TCP port in Nastaveni rezimu sluzby,\n"
        . "service state 'Spusteno', firewall, and that set_apppath is host:port without http://\n";
    exit(1);
}

try {
    $body = mrpksDecodeResponse($body, $opts["key"]);
} catch (\Throwable $e) {
    echo "Decode failed: " . $e->getMessage() . "\n";
    exit(1);
}
if ($opts["out"]) {
    file_put_contents($opts["out"], $body);
    echo "Saved to " . $opts["out"] . "\n";
}

$r = mrpksParseResponse($body);
echo "command=" . $r["command"] . " requestId=" . $r["requestId"] . "\n";
if (!$r["ok"]) {
    echo "ERROR code=" . $r["errorCode"] . " class=" . $r["errorClass"] . "\n" . $r["errorMessage"] . "\n";
    exit(1);
}
echo "OK\n";

$data = $r["data"];
if ($data !== null && isset($data->datasets)) {
    foreach ($data->datasets->children() as $name => $ds) {
        $rows = mrpksDatasetRows($data, $name);
        echo "dataset <$name>: " . count($rows) . " rows\n";
        foreach (array_slice($rows, 0, (int) $opts["rows"]) as $row) {
            foreach ($row as $k => $v) {
                if (strlen($v) > 80) { $v = substr($v, 0, 77) . "..."; }   // base64 images etc.
                $row[$k] = $v;
            }
            echo "  " . json_encode($row, JSON_UNESCAPED_UNICODE) . "\n";
        }
    }
} elseif ($data !== null && isset($data->MRPKSData)) {
    foreach ($data->MRPKSData->children() as $name => $node) {
        echo "MRPKSData <$name>: " . count($node->children()) . " records\n";
    }
} elseif ($data !== null) {
    echo substr($data->asXML(), 0, 2000) . "\n";
}
exit(0);
