# ABRA Flexi API Reference

## Connection & Authentication

- **Protocol:** HTTPS REST API
- **Payload format:** XML (default) or JSON
- **Auth:** HTTP Basic Auth (`sw_user`:`sw_pass`)
- **Base URL:** `{set_apppath}/c/{set_dbfile}` — e.g. `https://app.flexibee.eu/c/mycompany`
- **SSL:** verification is disabled in the PHP client (self-signed installs common)

## URL Pattern

```
{base}/{agenda}[/(filter)][.xml|.json]?detail={detail}&{params}&limit={N}&start={N}
```

- `agenda` - evidence type (e.g. `cenik`, `adresar`, `objednavka-prijata`)
- `(filter)` - URL-encoded filter expression wrapped in parens, placed in path (NOT query string)
- `.xml` / `.json` - response format suffix (XML default)
- Query params: `detail`, `relations`, `includes`, `limit`, `start`, `order`, `add-row-count=true`

**Examples:**
```
GET /c/mycompany/cenik.xml?detail=summary&limit=100
GET /c/mycompany/cenik/(kod%3D'PROD-1').xml?detail=full
GET /c/mycompany/objednavka-prijata/(lastUpdate%3E'2024-01-01T00%3A00%3A00%2B01%3A00').xml?detail=custom:id,cisDosle,firma(id,nazev)&relations=firma,polozkyObchDokladu
PUT /c/mycompany/objednavka-prijata.xml   (body: <winstrom>...</winstrom>)
DELETE /c/mycompany/cenik/123
```

## Filter Syntax (inside parentheses)

**Operators** (space-separated, not URL-encoded operators):

| Operator | Meaning | Example |
|----------|---------|---------|
| `=` | equals | `kod='AB-01'` |
| `!=` | not equals | `stav!='storno'` |
| `<` `>` `<=` `>=` | comparisons | `lastUpdate>'2024-01-01'` |
| `like` | SQL-like | `nazev like '%chair%'` |
| `begins` | starts with | `cisDosle begins '2025'` |
| `ends` | ends with | `kod ends 'XL'` |
| `is null` / `is not null` | null check | `dic is null` |
| `is empty` / `is not empty` | empty check | `cisDosle is not empty` |
| `in (…)` | set | `kod in ('A','B','C')` |
| `between x and y` | range | `cena between 100 and 500` |
| `and` / `or` / `()` | logic, grouping | `(A and B) or C` |

**String literals:** single quotes. Escape inner quote by doubling: `'O''Reilly'`.

**Date/time literals:** ISO-8601 with timezone, single-quoted. Generate via PHP `date("c", $ts)`.

**References to code-keyed entities:** use `code:` prefix: `stredisko='code:HLAVNI'`, `forma='code:DOBIRKA'`.

## `detail` Parameter (field selection)

| Value | Effect |
|-------|--------|
| `id` | Only IDs |
| `summary` | Minimal fields (id, code, name) |
| `full` | All scalar fields |
| `detail` (default) | Same as `full` |
| `custom:f1,f2,...` | Explicit list |
| `custom:id,kod,firma(nazev,ic)` | Nested child objects |

Nested selection works for both owned sub-objects (e.g. `firma(...)`) and collections (`polozkyObchDokladu(id,cenaMj,mnozMj)`).

## Relations / Expand

Pass `relations=` in query (via `$params` arg of `read()`):

```
relations=firma,mistUrc,polozkyObchDokladu
```

Return the referenced object as an inline associative array rather than a `code:` reference.

For deep includes use `includes=`:
```
includes=/cenik/sady-a-komplety/sady-a-komplety/cenik/,/cenik/skladKarty/skladova-karta/
```

## PHP Client: `Flexi\API::read()`

```php
read($agenda, $limit = 0, $detail = 'detail', $filter = '', $params = '', $urlspecial = '')
```

- `$agenda` - evidence name, e.g. `'cenik'`
- `$limit` - max records (0 = default, typically 25-100)
- `$detail` - `'summary'`, `'full'`, or `'custom:f1,f2(...)'`
- `$filter` - filter expression (goes inside `(...)` in URL, auto-encoded)
- `$params` - extra query string, e.g. `'relations=firma&start=100&limit=100&order=lastUpdate@D'`
- `$urlspecial` - bypass all of the above and use this raw URL path

**Returns:** `array(0 => record, 1 => record, ...)` on success; `false` on error. Exits on non-200 HTTP status (check `Flexi\API::$response`).

**Example:**
```php
$orders = Flexi\API::read(
    'objednavka-prijata',
    0,
    'custom:id,cisDosle,firma(id,nazev,ic),polozkyObchDokladu(id,kod,cenaMj,mnozMj,slevaPol)',
    "lastUpdate > '" . date("c", strtotime("-3 days")) . "' and cisDosle is not empty",
    'relations=firma,polozkyObchDokladu'
);
```

## PHP Client: `Flexi\API::send()`

```php
send($object, $data, $stopOnError = false)
```

- `$object` - agenda name, e.g. `'objednavka-prijata'`
- `$data` - XML string (whole `<winstrom>` document) as body
- `$stopOnError` - exit script on failure

PUTs to `{base}/{object}.xml`. Expects HTTP 201 Created. Response parsed into `Flexi\API::$response` as associative array. Returns the parsed response on success, `false` on failure.

Check `$response['success'] === 'true'` to confirm success.

## XML Document Structure (for PUT/create)

```xml
<?xml version="1.0" encoding="UTF-8"?>
<winstrom version="1.0">
    <objednavka-prijata>
        <kod>OBJ-001</kod>
        <typDokl>code:OBP</typDokl>
        <stredisko>code:HLAVNI</stredisko>
        <datVyst>2025-01-15</datVyst>
        <firma>
            <kod>FIRM-001</kod>
            <nazev>ACME s.r.o.</nazev>
            <ic>12345678</ic>
            <ulice>Hlavni 1</ulice>
            <mesto>Praha</mesto>
            <psc>11000</psc>
            <stat>code:CZ</stat>
        </firma>
        <polozkyObchDokladu>
            <objednavka-prijata-polozka>
                <kod>PROD-1</kod>
                <nazev>Product 1</nazev>
                <mnozMj>2</mnozMj>
                <cenaMj>100</cenaMj>
                <typCenyDphK>typCeny.sDph</typCenyDphK>
                <typSzbDphK>typSzbDph.dphZakl</typSzbDphK>
            </objednavka-prijata-polozka>
        </polozkyObchDokladu>
    </objednavka-prijata>
</winstrom>
```

**Key rules:**
- Root is always `<winstrom version="1.0">`
- Child elements are evidence entries (can be multiple)
- Owned sub-objects are inlined (e.g. `<firma>` nested inside order)
- Collections use plural parent with child `<evidencename-polozka>` elements
- Values referencing code-keyed entities: `<stat>code:CZ</stat>`
- Date format: `YYYY-MM-DD` (date only) or ISO-8601 (datetime)
- Boolean values: `true` / `false` (lowercase)

**Update vs. create:** PUT with same XML structure. Matching existing record by `id` or `kod` (update) vs. new record (create) is automatic based on presence. Add attribute `action="create"` / `action="update"` to force.

## Pagination

Use `start` + `limit` in `$params`:
```php
$ic = 0;
while (true) {
    $batch = Flexi\API::read('cenik', 100, $fields, $cond, "start=$ic&limit=100");
    if (!is_array($batch) || count($batch) == 0) break;
    // ... process ...
    if (count($batch) < 100) break;
    $ic += 100;
}
```

To include total count add `add-row-count=true` to params — response contains `@rowCount` attribute.

## XML Response Structure

```xml
<winstrom version="1.0">
    <success>true</success>
    <stats>...</stats>
    <cenik>
        <id>123</id>
        <kod>PROD-1</kod>
        <nazev>Product 1</nazev>
    </cenik>
    <cenik>
        ...
    </cenik>
</winstrom>
```

Parsed to associative array. `$result[$agenda]` contains the records. Single record is returned as object, multiple as indexed array — use `Flexi\API::asArray()` to normalize.

## HTTP Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK (GET) |
| 201 | Created (PUT on new record) |
| 400 | Bad request (malformed XML / filter) |
| 401 | Unauthorized (wrong `sw_user` / `sw_pass`) |
| 404 | Evidence or record not found |
| 500 | Server error |

On error, the body contains `<winstrom><success>false</success><message>...</message></winstrom>`.

## Error Handling Helpers (PHP client)

- Full response: `Flexi\API::$response` after every call
- Last request/response written to `temp_dir/last_request.xml` and `temp_dir/last_res.xml`
- Error details: `print_r($response, true)` saved to `temp_dir/err.txt` on failed `send()`
- Enable verbose with `getCfg(8, "debug") >= 2`

## Helpers in `lib/flexi/inc.php`

| Function | Purpose |
|----------|---------|
| `Flexi\API::asArray($x)` | Normalize single object / array of one to indexed array |
| `Flexi\API::getFirst($x)` | Get first element from result |
| `Flexi\API::rawUrl($s)` | Pre-encode `(`, `)`, `"` for URL path |
| `Flexi\vatRateText($rate, $order)` | Map numeric VAT % to `typSzbDph.*` enum (OSS-aware) |
| `Flexi\exists($evid, $code, $pairField, $extra)` | Cached "does record with code exist?" check |

## Common Pitfalls

- **XML control characters** - `fetchContent` strips them with `preg_replace('/[[:cntrl:]]/', '', ...)` before XML parse; if you see parse errors, check for stray binary in source data
- **`code:` prefix** - always strip before comparison / use
- **Single vs. array response** - a filter returning one record still must be iterated (the client normalizes to `[0 => $obj]`)
- **Nested collections** - in `polozkyObchDokladu`, the rows are double-wrapped: `$order["polozkyObchDokladu"]["objednavka-prijata-polozka"]` — unwrap before iterating
- **`sumZkl` / `sumCelkem` are read-only** - you send `cenaMj`, `mnozMj`, and rates; sums are computed server-side
- **Date timezone** - ISO strings must include timezone offset; `date("c", $ts)` handles this
- **Cenik code vs id** - Shoptet integration typically uses Flexi `cenik.id` (integer) as the external code; Flexi `cenik.kod` is the product SKU
- **Format toggle** - setting `Flexi\API::$format = 'json'` changes URL suffix and parsing; the client unwraps `{"winstrom": ...}`

## Common PHP Patterns

### Incremental sync (lastUpdate > timestamp)
```php
$last = getLastUpd("my_job", "file");
$filter = "lastUpdate > '" . date("c", strtotime($last)) . "' and kod is not empty";
$records = Flexi\API::read('cenik', 0, 'custom:id,kod,nazev,cenaZakl', $filter);
// ... process ...
setLastUpd("my_job", "file");
```

### Code → ID mapping
```php
$map = array();
$rows = Flexi\API::read('cenik', 0, 'custom:id,kod', '');
foreach ($rows as $r) {
    $map[$r["kod"]] = $r["id"];
}
```

### Existence check (cached)
```php
if (Flexi\exists("adresar", $email, "email")) {
    // firm with this email exists
}
```

### Create with embedded address and lines
See "XML Document Structure" above and the `scripts/templates/orders_*.php` files for live examples.
