---
name: abra-gen
description: Dev helper for ABRA Gen ERP API integration. Use when working on shopsync projects that integrate with ABRA Gen - orders, products, invoices, customers, stock. Provides API reference, PHP client patterns, and data structures. Use when user mentions "abra" and "gen" in same prompt, or works in project containing `lib/abra_gen/`.
user-invocable: true
argument-hint: [topic]
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# ABRA Gen API - Dev Helper

ABRA Gen is a Czech ERP system exposing a REST API (Basic Auth, JSON). The PHP client library is in `lib/abra_gen/` under the `AbraGen` namespace.

For detailed API reference (endpoints, data structures, business objects), see [references/api-reference.md](references/api-reference.md).
For the official e-shop integration flow (find/create firm, persons/osoby, offices, stock, pricing, categories — the canonical request bodies from ABRA's Postman collection), see [references/eshop-postman.md](references/eshop-postman.md).
For full HTML business object definitions (990 files), see [references/docs_html/](references/docs_html/) - files named `BO_<ObjectName>.htm` (e.g. `BO_StoreCard.htm`, `BO_ReceivedOrder.htm`).
For the complete OpenAPI/Swagger spec (every agenda + field), see [references/swagger-abra-gen.json](references/swagger-abra-gen.json) - a ~33 MB file; grep it for an object/path rather than reading it whole.

## Key Files

- `lib/abra_gen/inc.php` - `AbraGen\API` class (extends CurlTool), HTTP methods, auth, query encoding
- `lib/abra_gen/orders.php` - `AbraGen\Orders` class (create received orders, firms, firm offices)
- `lib/abra_gen/products.php` - `AbraGen\Products` class (load storecards, prices, stock)
- `lib/abra_gen/invoices.php` - `AbraGen\Invoices` class (create issued invoices)
- `lib/abra_gen/order_states.php` - Order state management
- `lib/abra_gen/settings_gen.php` - Settings template generator

## Script Bootstrap Pattern

```php
include "./config.php";
include "./lib/functions.php";
init();
include "./lib/abra_gen/inc.php";
include "./lib/abra_gen/orders.php";

AbraGen\API::login(sw_user, sw_pass, set_pohoda_db, set_dbfile);
// ... work ...
```

## Core API Class (`AbraGen\API`)

Static methods on `AbraGen\API` (extends `CurlTool`):

| Method | Signature | Purpose |
|--------|-----------|---------|
| `login()` | `login($login, $pass, $abraHost, $abraNazev, $setTimeLimit)` | Set credentials and host |
| `read()` | `read($agenda, $select, $where, $expand, $orderby, $start, $limit)` | GET with filter, select, expand, pagination (skip/take) |
| `send()` | `send($agenda, $data, $exitOnError, $method="POST")` | POST/PUT JSON data |
| `customQuery()` | `customQuery($agenda, $json)` | POST raw JSON query |
| `delete()` | `delete($agenda_id, $exitOnError)` | DELETE resource |

**URL Pattern:** `{abraHost}/{abraNazev}/{agenda}?select={fields}&where={condition}&expand={relations}&orderby={field}&skip={offset}&take={limit}`

**Query Encoding (in `where` conditions):**
- `=` encodes as `+eq+`, `<` as `+lt+`, `>` as `+gt+`, `!=` as `+ne+`
- Logic: `and`, `or`
- Date literals: `timestamp'YYYY-MM-DD HH:MM:SS'`
- Example: `hidden=false and country_id='00000CZ000'`

**Expand syntax:** `expand=StoreUnits(Weight,Code),Producer_ID(Name)` - loads related objects inline

**Return value:** Associative array with keys: `error`, `errorText`, `content`, `returnHttpStatus`, `success`

## Main API Endpoints (Agendas)

| Agenda | Business Object | Purpose |
|--------|----------------|---------|
| `storecards` | StoreCard | Products catalog |
| `storesubcards` | StoreSubCard | Stock per store (quantities) |
| `storeprices` | StorePrice | Price lists |
| `receivedorders` | ReceivedOrder | Orders from customers |
| `issuedinvoices` | IssuedInvoice | Issued invoices |
| `firms` | Firm | Companies/customers |
| `firmoffices` | FirmOffice | Delivery addresses (branches) |
| `vatrates` | VATRate | VAT rate definitions |
| `countries` | Country | Country list |
| `docqueues` | DocQueue | Document numbering queues |
| `paymenttypes` | PaymentType | Payment methods |
| `transportationtypes` | TransportationType | Shipping methods |
| `storemenuitemlinks` | StoreCardMenuItemLink | Product-to-category mapping |
| `reservations` | Reservation | Stock reservations |

Each agenda supports: GET (list), GET/{id}, POST (create), PUT/{id} (update), DELETE/{id}, POST/query

## Custom User-Defined Attributes ("x_" attributes)

ABRA Gen supports custom user-defined fields on most business objects. These are called **"x_" attributes** - their names always start with `x_` followed by the custom name (e.g. `x_eshop`, `x_barcode`, `x_custom_field`).

- They are defined per-object in ABRA Gen administration
- They appear as regular fields in API responses and can be used in `select`, `where`, and `expand`
- Example: `API::read("storecards", "id,code,x_eshop", "x_eshop=true")` - filter products flagged for e-shop
- When creating/updating objects, include x_ fields in the data array like any other field
- The BO HTML docs mark objects with `User fields: A` if they support custom attributes

## Important Conventions

- All IDs are 10-char strings (e.g. `"0000000000"`, `"1G10000101"`)
- Extend classes for project-specific logic in `scripts/` folder
- Use `getLastUpd` / `setLastUpd` for incremental sync timestamps
- Temp files: `temp_dir` constant; logging: `logln()`; config: `getCfg($section, $key, $default)`
- Field length limits: street (60), city (60), postcode (10), company name (100), recipient (30) - use `maxLen()`
- Prices: `PricesWithVAT=1` means prices include VAT; use `$date` suffix for date fields (e.g. `docdate$date`)
- Row types: `2` = text line, `3` = store card (product) line
- `totalrounding = -33554175` disables automatic rounding
