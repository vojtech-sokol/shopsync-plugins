---
name: abra-flexi
description: Dev helper for ABRA Flexi (FlexiBee) ERP REST API integration. Use when working on shopsync projects that integrate with ABRA Flexi - orders, invoices, products (ceník), customers (adresář), stock. Provides API reference, PHP client patterns, query syntax, and data entity (evidence) definitions. Use when user mentions "abra" and "flexi" together, or works in project containing `lib/flexi/`.
user-invocable: true
argument-hint: [topic]
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# ABRA Flexi API - Dev Helper

ABRA Flexi (formerly FlexiBee) is a Czech cloud ERP exposing a REST API. Communication is via HTTP Basic Auth with XML or JSON payloads. The PHP client library is in `lib/flexi/` under the `Flexi` namespace.

For detailed API reference (URL pattern, query syntax, XML structure), see [references/api-reference.md](references/api-reference.md).
For the list of common evidence types (data entities), see [references/common-evidences.md](references/common-evidences.md).
For full per-entity property definitions (all 249 evidences), see `references/evidence/<name>.md` — e.g. `references/evidence/cenik.md`, `references/evidence/objednavka-prijata.md`. Each file lists every field with type, DB column, max length, mandatory/writable flags, and FK target. Mirror of `C:\Users\Vojtech Sokol\Documents\share\podklady\abra_flexi\evidence\`.

## Key Files

- `lib/flexi/inc.php` - `Flexi\API` class (extends CurlTool), HTTP methods, auth, `read()`, `send()`, helpers `asArray()`, `getFirst()`, `vatRateText()`, `exists()`
- `lib/flexi/orders.php` - `Flexi\Orders` class (export orders to Flexi as `objednavka-prijata` or invoices)
- `lib/flexi/products.php` - `Flexi\Products` class (load products from `cenik` with stock and pricing)
- `lib/flexi/order_states.php` - Order state synchronization
- `lib/flexi/settings_gen.php` - Settings template generator

## Script Bootstrap Pattern

```php
include "./config.php";
include "./lib/functions.php";
init();
include "./lib/flexi/inc.php";
include "./lib/flexi/orders.php";
// Flexi\API uses sw_user / sw_pass constants + set_apppath + set_dbfile for auth
// API base URL is built from: set_apppath . "/c/" . set_dbfile
```

## Core API Class (`Flexi\API`)

Static methods on `Flexi\API` (extends `CurlTool`):

| Method | Signature | Purpose |
|--------|-----------|---------|
| `read()` | `read($agenda, $limit, $detail, $filter, $params, $urlspecial)` | GET from evidence with filter, select, pagination |
| `send()` | `send($object, $data, $stopOnError)` | PUT XML/JSON to create or update |
| `asArray()` | `asArray($arr)` | Normalize single object to array of one |
| `getFirst()` | `getFirst($arr)` | Get first entry from result array |

**URL pattern:** `{set_apppath}/c/{set_dbfile}/{agenda}/({URL-encoded filter}).xml?detail={detail}&{params}&limit={limit}`

**Return value of `read()`:** Array of records (each record is associative array). Returns `false` on error. Stored in `Flexi\API::$response` as well.

## Query Syntax (filter condition)

Uses plain operators inside parentheses of URL (URL-encoded by `read()`):
- Equality: `field='value'` (strings single-quoted)
- Comparisons: `<`, `>`, `<=`, `>=`, `!=`
- Text matching: `field begins 'X'`, `field ends 'X'`, `field like 'X'`
- Empty check: `field is empty`, `field is not empty`
- Logic: `and`, `or`, parentheses for grouping
- Code refs: `stredisko='code:HLAVNI'` (references by code)
- Dates: ISO 8601: `lastUpdate > '2024-01-01T00:00:00+02:00'` — use `date("c", $timestamp)` in PHP

**Examples:**
```
lastUpdate > '2024-01-01T00:00:00+01:00' and cisDosle is not empty
stredisko='code:HLAVNI' and (cisDosle begins '2025' or cisDosle begins '2026')
kod='PROD-001'
```

## Detail (select) Syntax

Controls which fields come back:
- `detail` - full detail
- `summary` - minimal fields
- `id` - just IDs
- `custom:field1,field2,...` - pick specific fields
- Nested: `custom:id,kod,firma(id,nazev,ic),polozkyObchDokladu(id,kod,cenaMj)`

## Relations (expand) - `params` arg

Pass `"relations=firma,mistUrc,polozkyObchDokladu"` in `$params` (5th arg) to load related objects inline rather than as `code:` references. Also supports `includes=/path/to/nested/` for deep eager loading.

## Core Evidence Types (Agendas)

| Evidence | Czech | Purpose |
|----------|-------|---------|
| `cenik` | Ceník | Products / price list |
| `adresar` | Adresář | Companies / customers |
| `objednavka-prijata` | Obj. přijatá | Received orders (customer orders) |
| `objednavka-vydana` | Obj. vydaná | Issued orders (supplier orders) |
| `faktura-vydana` | Faktura vydaná | Issued invoices |
| `faktura-prijata` | Faktura přijatá | Received invoices |
| `skladova-karta` | Sklad. karta | Stock card (per-warehouse stock) |
| `sklad` | Sklad | Warehouse |
| `cenova-uroven` | Cen. úroveň | Price level |
| `individualni-cenik` | Individ. ceník | Per-customer pricing |
| `stredisko` | Středisko | Cost center |
| `mena` | Měna | Currency |
| `sazba-dph` | Sazba DPH | VAT rate |
| `forma-uhrady` | Forma úhrady | Payment method |
| `forma-dopravy` | Forma dopravy | Shipping method |
| `misto-urceni` | Místo určení | Delivery location |

See [references/common-evidences.md](references/common-evidences.md) for a fuller list.

## Line-Item Naming Convention

Line items (rows) for documents live under child evidences named `<doc>-polozka`:
- `objednavka-prijata-polozka` - received order rows
- `objednavka-vydana-polozka` - issued order rows
- `faktura-vydana-polozka` - issued invoice rows
- `faktura-prijata-polozka` - received invoice rows

In XML responses, rows appear wrapped under the parent key `polozkyObchDokladu`, then nested under the child evidence name. Use `Flexi\API::asArray()` to normalize single-item to array.

```php
$items_raw = $order["polozkyObchDokladu"] ?? null;
if (isset($items_raw["objednavka-prijata-polozka"])) {
    $items_raw = $items_raw["objednavka-prijata-polozka"];
}
foreach (Flexi\API::asArray($items_raw) as $item) { ... }
```

## Code Enum Values

Many select-type fields return values as `"enum.value"` strings. Common ones:
- `typSzbDphK` - VAT rate type: `typSzbDph.dphZakl` (basic), `typSzbDph.dphSniz` (reduced), `typSzbDph.dphSniz2` (2nd reduced), `typSzbDph.dphOsv` (exempt)
- `typCenyDphK` - Price type: `typCeny.sDph` (inc. VAT), `typCeny.bezDph` (excl. VAT)
- Relations to code-based entities are returned as `"code:XYZ"` (strip prefix with `str_replace("code:", "", ...)`)

Helper: `Flexi\vatRateText($rate, $orderData)` maps numeric VAT % to the `typSzbDph.*` string (honors OSS / EU VAT config).

## Discount Fields

On line items (e.g. `objednavka-prijata-polozka`):
- `cenaMj` - unit price BEFORE discount
- `slevaPol` - item discount [%]
- `slevaDokl` - document-level discount [%] (read-only on line)
- `uplSlevaDokl` - whether document discount applies to this line (boolean)
- `sumZkl`, `sumDph`, `sumCelkem` - computed net / VAT / total in local currency
- Final unit price = `cenaMj * (1 - slevaPol/100)` (then `slevaDokl` if `uplSlevaDokl`)

## Writing Data (PUT/create)

`Flexi\API::send($agenda, $xmlString)` PUTs an XML document. Templates for building XML live in `lib/flexi/templates/*.php` and `scripts/templates/*.php`. Root element is `<winstrom>` containing the entity (e.g. `<objednavka-prijata>`).

Response XML includes `<success>true</success>` and assigned IDs. Parsed via `simpleXmlToArray()` and returned as associative array.

## Important Conventions

- Format: XML by default (`Flexi\API::$format = 'xml'`). Set to `'json'` to use JSON.
- Auth: Basic Auth using `sw_user` / `sw_pass` constants
- Last response saved to `temp_dir . "/last_res.xml"` and `last_request.xml` for debugging
- Use `getLastUpd` / `setLastUpd` for incremental sync timestamps
- `logln()` for log output, `getCfg($section, $key, $default)` for config
- Date format in filters: ISO-8601 via `date("c", $timestamp)`
- String literals in filter: single quotes; escape internal quotes by doubling
- `code:` prefix appears on relation fields pointing to code-addressable entities — strip before use
- Extend classes (`Flexi\Orders`, `Flexi\Products`) for project-specific logic under `scripts/` folder
