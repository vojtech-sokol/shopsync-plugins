---
name: creativesites
description: Dev helper for CREATIVE sites e-shop platform REST API integration. Use when working on shopsync projects that integrate with CREATIVE sites eshop - orders, products, categories, customers, invoices, coupons, articles, stock, prices. Provides API reference, PHP client patterns, and data structures. Use when user mentions "creativesites" or "creative sites", or works in project containing `lib/creativesites/`.
user-invocable: true
argument-hint: [topic]
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# CREATIVE sites - Dev Helper

CREATIVE sites is a Czech / Slovak e-commerce platform with a REST API (typically `https://csapi.<domain>/`). The PHP client library is in `lib/creativesites/` under the `CreativeSites` namespace.

For full endpoint list, see [references/api-reference.md](references/api-reference.md).
For data structures (Product, Order, Variant, BillingAddress, etc.), see [references/data-structures.md](references/data-structures.md).
For PHP library classes & methods, see [references/library-reference.md](references/library-reference.md).
For the verbatim original API Blueprint (most detail), see [references/api-blueprint.apib](references/api-blueprint.apib).

## Key Files

- `lib/creativesites/inc.php` - `api_get/post/put/delete`, Basic Auth, `prepareProductData`, `convertCountryCode`, `getLastUpd2/setLastUpd2`
- `lib/creativesites/orders.php` - `CreativeSites\Orders` (load orders from eshop into ShopSync `$this->data`)
- `lib/creativesites/products.php` - `CreativeSites\Products` (save / batch stock / batch price updates)
- `lib/creativesites/products_export.php` - `CreativeSites\ProductsExport` (read products FROM eshop)
- `lib/creativesites/parameters.php` - `CreativeSites\Parameters` (variant attribute loader)
- `lib/creativesites/settings_gen.php` - settings template / config generator

## Script Bootstrap Pattern

```php
include "./config.php";
include "./lib/functions.php";
init();
include "./lib/creativesites/inc.php";
include "./lib/creativesites/orders.php";    // or products.php / products_export.php
// Authentication is automatic via api_user / api_pass constants from config section 8
```

## Authentication & Transport

- **HTTP Basic Auth** (`Authorization: Basic ...`). API only accepts JSON requests.
- Credentials: `api_user`, `api_pass`, base URL `api_url` — all loaded from `getCfg(8, "api_url" / "api_uzivatel" / "api_heslo")` in `inc.php`.
- IP allowlisting: requests must come from an allowed IP (configured server-side).
- All write methods (`api_post / api_put / api_delete`) sleep `usleep(1_000_000)` (1s) between calls; `api_get` too. There is no built-in rate-limit retry — on `429` you must back off.

## Core API Functions (CreativeSites namespace, inc.php)

- `api_get($route, $params = [])` - GET, returns **raw JSON string** (must `json_decode` it)
- `api_post($route, $params, $data)` - POST, returns **decoded array** (`json_decode($output, true)`)
- `api_put($route, $params, $data)` - PUT, returns decoded array
- `api_delete($route)` - DELETE, returns decoded array
- `prepareProductData($src, $categories = null)` - groups variants under their parent product `code`
- `convertCountryCode($input)` - ISO-2 ↔ ISO-3 country code conversion
- `getLastUpd2($table, $db)` / `setLastUpd2($table, $db)` - sync timestamps via `shopsync_last` table

**Note:** `api_get` mismatch with the others — it returns a JSON string, the rest return arrays. Always `json_decode(api_get(...), true)`.

## Main Endpoint Groups

Endpoints are grouped — full list with HTTP verbs in [api-reference.md](references/api-reference.md).

| Group | Main entity | Path prefix |
|---|---|---|
| Products | `Product`, `Variant`, `Price` | `/products`, `/products/stock`, `/products/price` |
| Orders | `Order`, `OrderItem` | `/orders`, `/orders/status` |
| Customers | `Customer` (`CustomerNoGdpr` for write) | `/users`, `/users/auth` |
| Invoices | `InvoiceBasic / Single / Multi` | `/invoices` |
| Coupons | `Coupon` | `/coupons`, `/coupons/archived` |
| Articles (blog) | `Article` | `/articles` |
| Helpers (product) | categories, groups, availabilities, attributes, parameters, manufacturers, uom, stores, stocktypes, ossproductrates | `/categories`, `/groups`, `/availabilities`, `/attributes`, `/parameters`, `/manufacturers`, `/uom`, `/stores`, `/stocktypes`, `/ossproductrates` |
| Helpers (order) | payments, shippings, countrycodes, orderstates, currencies, ordernotifications, invoice settings | `/payments`, `/shippings`, `/countrycodes`, `/orderstates`, `/currencies`, `/ordernotifications`, `/invoices/manage` |
| Helpers (customer) | shopper groups, GDPR, individual price discounts | `/shoppergroups`, `/gdpr/*`, `/users/discount` |
| Static fields | custom fields on orders / users / products | `/staticfields/orders`, `/staticfields/users`, `/staticfields/products` |
| Webhooks | order & customer hooks | `/hooks/orders`, `/hooks/users` |
| URL lookup | URL → entity resolver | `/urls/{entityType}/{id}`, `/urls/{entityType}` |
| Logs / Errors | activity logs, error code descriptions | `/logs/{date}`, `/errorcodes` |

## Response Format

Lists come back wrapped in a top-level key matching the entity:

```json
{ "productList":  [...], "metaData": { "page": 1, "pages": 4, "perPage": 200, "total": 643 } }
{ "orderList":    [...], "metaData": { ... } }
{ "customerList": [...] }
{ "couponList":   [...] }
{ "articleList":  [...], "metaData": { ... } }
{ "categoryList": [...] }
```

Single GET returns the entity directly; POST / PUT typically return `{ "message": "Import successful.", "<entity>List": [id, id, ...] }`.

## Pagination & Filtering

Default per-page upper bound is 200 (`4001 PerPage range exceeded`). Standard params on list endpoints:

| Param | Use |
|---|---|
| `page` | 1-based page number |
| `perPage` | items per page (≤200) |
| `list` | comma-separated whitelist of fields (use `%2C` for the comma) |
| `filterBy` | top-level field name, e.g. `cdate`, `mdate`, `orderStatus`, `code`, `validFrom` |
| `values` | comma-separated values to match (for non-date filters) |
| `from` / `to` | date range, used when `filterBy` is a date column |
| `domain` | (orders only) limit by multidomain hostname |

Example loop (matches `Products` / `ProductsExport`):

```php
$page = 1;
while (true) {
    $resp = json_decode(api_get("products", [
        "filterBy" => "mdate", "mdate" => rawurlencode($last),
        "page" => $page, "perPage" => 100,
    ]), true);
    if (!isset($resp["productList"]) || count($resp["productList"]) == 0) break;
    foreach ($resp["productList"] as $p) { /* ... */ }
    if (count($resp["productList"]) < 100) break;
    $page++;
}
```

## Key Conventions

- **Product pair key:** `sku` (Product.sku). Variants pair on `Variant.code`. `Products::__construct` builds two id-maps: `product_ids[sku] => id` and `variants_ids[code] => parent_id`.
- **Stock / price batch:** items must carry `isVariant` (bool); product or variant is matched by `sku` (for products) or by the variant `code` (stored under `sku` field in the batch payload).
- **Shopper group prices (`sgpId`):** ALL prices live per-shopper-group. Default retail = `sgpId: 5` (used as the constant in this lib). Use `GET /shoppergroups` to enumerate.
- **`currency` is required when updating prices** (since 2021-09-13).
- **`isCash` / `cod`** on payment methods — when true, the order auto-adds `cashPaymentRounding`.
- **Multilang:** every product / category / availability / attribute / parameter / order state / payment / shipping supports a `translations` object keyed by lang code (`cz`, `sk`, …).
- **Variant attributes:** `Variant.values` is an array of `{ id, name, value }`. Custom text attributes use `id` as string `"custom_X"`.
- **Country codes are ISO-3** (`SVK`, `CZE`, `HUN`, ...) — see `CountryCodes` structure. `inc.php::convertCountryCode()` converts ISO-2 ↔ ISO-3.
- **Non-standard features** (must be enabled by CREATIVE sites sales): supplier stock, store-level stock (`store`/`storeId`), `localImagePath` for variants, `availableFrom` on variants, `shippingBlacklist`, product sets, `imageMetaData`, OSS product rates, individual price discounts, multi-doc invoices, `attachDocumentType` on status change, `itemNote` on order items, `ordernotifications` endpoint.

## Order Status Codes

Order status is a single-character `code` (e.g. `C`). Each status has a `meaning` of `neutral` / `positive` / `negative`. Statuses are defined per-shop via `GET /orderstates`. The default `excludeStates = ["X"]` in `Orders` class skips deleted orders.

## Webhooks

`POST /hooks/orders` lets you register URLs called on order events:
- `onOrderCreate`
- `onOrderStatusChange` (status change data only)
- `onOrderStatusChangeVerbose` (full order data)

Similarly `onCustomerCreate` / `onCustomerChange` for `/hooks/users`. Optional filter by `orderStatus` list or `orderMeaning` list.

## Error Codes

API returns 4xx/5xx HTTP plus a body with a numeric code. Code ranges:
- `1xxx` - already exists
- `2xxx` - doesn't exist
- `3xxx` - validation
- `4xxx` - limit / range exceeded
- `5xxx` - feature requires plan upgrade
- `6xxx` - missing required permission / param
- `9xxx` - custom (export-related)

`GET /errorcodes/{id}` returns the human-readable description. Full table in [data-structures.md](references/data-structures.md).

## Important Patterns from this Codebase

- **Hash-based change detection** — `ProductsExport` and product save flows usually persist `product_ids.json` / `variants_ids.json` to `temp_dir` to skip re-fetching on subsequent runs.
- **Batch chunk size:** `Products::updateBatchStock` / `updateBatchPrice` slice into chunks of 100 (`array_slice($to_import, $slice * 100, 100)`).
- **Pricelist ID 5** is hardcoded as default in this lib (`updateBatchPrice($data, $pricelist_id = 5)` and `saveGeneral` priceList entry).
- **Order-to-ShopSync mapping** (`Orders::loadOrder`): payment/carrier names are paired against `getCfgs(2)` (payments) and `getCfgs(3)` (shipping) by case-insensitive `stripos` match — log "Nesparovana plat./dopr. metoda" when debug>=1.
- **VAT handling:** items use `taxRate` as a percentage (e.g. `20`). Multiply by `/100` when storing as a fraction. Shipping & payment fees get split out as separate order items (codes `99991`, `99991`, `99992` for coupon, `99993` for credit discount).
- **Reset cycle for products sync:** `getLastUpd2()` triggers a full re-fetch (`return ""`) after 22:00 if at least 3h has passed since last reset — see `shopsync_last` rows `products` and `products_reset`.
