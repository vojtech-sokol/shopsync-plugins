---
name: upgates
description: Dev helper for Upgates e-shop platform integration (REST API v2 + XML feeds). Use when working on shopsync projects that communicate with Upgates eshop - orders, products, variants, categories, customers, invoices, stock, order states, pictures. Provides API reference, PHP client patterns, and XML import/export structures. Use when user mentions "upgates", or works in project containing `lib/upgates/`.
user-invocable: true
argument-hint: [topic]
---

# Upgates - Dev Helper

Upgates is a Czech e-commerce platform with a REST API v2 at `https://NAZEV-ESHOPU.admin.ZNACKA-SERVERU.upgates.com/api/v2` (per-shop URL, found in admin under Doplňky / API). The PHP client library is in `lib/upgates/` under the `UpGates` namespace.

There is no public machine-readable spec: the old API Blueprint on Apiary (`upgatesapiv2.docs.apiary.io`) was retired and now only redirects to https://docs.upgates.com/api-reference (Zudoku-based, spec loaded via internal GraphQL - not downloadable). Docs URL pattern: `https://docs.upgates.com/api-reference/{resource}` (Czech slugs, e.g. `produkty`, `objednavky`).

For the full endpoint catalog, see [references/api-reference.md](references/api-reference.md).
For the ORIGINAL full API reference (all 139 endpoints with Czech descriptions, request/response schemas and examples, extracted from the docs' embedded OpenAPI data), see [references/api-full/_index.md](references/api-full/_index.md) and the per-resource `references/api-full/{slug}.json` files.
For PHP class reference, see [references/lib-reference.md](references/lib-reference.md).
For XML feed structures, see [references/xml-products.md](references/xml-products.md) and [references/xml-categories.md](references/xml-categories.md).

## Key Files

- `lib/upgates/inc.php` - HTTP functions (Basic auth), `prepareProductData()` (pictures/variants merge)
- `lib/upgates/orders.php` - `UpGates\Orders` class (load, loadOrder)
- `lib/upgates/order_states.php` - `UpGates\OrderStates` class (setState, getStates)
- `lib/upgates/products.php` - `UpGates\Products` class (update, updateBatchStock, downloadAllCodes)
- `lib/upgates/products_export.php` - `UpGates\ProductsExport` class (load from eshop, downloadImage)
- `lib/upgates/categories.php` - `UpGates\Categories` class (getEshopCategories, saveCategories)
- `lib/upgates/customers.php` - `UpGates\Customers` class (loadExistingCustomers, save)
- `lib/upgates/invoices.php` - `UpGates\Invoices` class (load)
- `lib/upgates/settings_gen.php` - dumps shipments + payments lists
- `lib/upgates/states.php`, `lib/upgates/reset.php`, `lib/upgates/templates/`

## Script Bootstrap Pattern

```php
include "./config.php";
include "./lib/functions.php";
init();
include "./lib/upgates/inc.php";
include "./lib/upgates/orders.php";
```

## Core API Functions (UpGates namespace, inc.php)

- `api_get($route, $params)` - GET, returns JSON string; route is relative to api_url (e.g. `"orders"`, `"products/simple"`)
- `api_put($route, $params, $data)` - PUT, `$data` json-encoded
- `api_post($route, $params, $data)` - POST
- `api_delete($route, $params)` - DELETE
- `api_post_file($route, $params, $file_path, $file_name, $code)` - multipart upload (product images)
- All calls: HTTP Basic auth from config, `usleep(500000)` built-in delay, errors printed on non-200/201
- Config: `getCfg(8, "api_url")`, `getCfg(8, "api_uzivatel")`, `getCfg(8, "api_heslo")`, `getCfg(8, "debug")`

## Main Endpoints (all under /api/v2)

- `GET/PUT/POST/DELETE products` - batch by `code`; PUT body `{"products": [...]}` OR `{"variants": [...]}` (same payload, separate calls to hit variants)
- `GET products/simple` - lightweight paginated list (codes + variants), used by `downloadAllCodes()`
- `GET products/{code}`, `.../prices`, `.../parameters`, `.../files`, `.../related`; `POST products/{code}/images` (form-data)
- `GET/PUT/POST/DELETE orders`, `GET orders/{order_number}` - filters: `creation_time_from`, `last_update_time_from`, `status_id`, `paid_yn`, `page`; PUT body `{"orders": [...], "send_emails_yn": false}`
- `GET/PUT/POST/DELETE categories` - by `code` or `category_id`; parents must be created before children
- `GET/PUT/POST/DELETE customers` - unique key is `email`
- `GET invoices`, `GET invoices/{invoice_number}` (+ `/pdf`) - `type`: invoice | creditNote | receipt
- `GET/PUT/POST order-statuses` - custom order states
- `GET shipments`, `GET payments`, `GET status` (permitted endpoints check)

## Response Format

No wrapper object; lists are paginated (100/page max):
```json
{"orders": [...], "current_page": 1, "number_of_pages": 5, "number_of_items": 420}
```
Loop pattern: `while (true) { ... if ($resp["number_of_pages"] == $page) break; $page++; }`

## Important Conventions

- Auth: HTTP Basic (API user created in Upgates admin, Doplňky / API); 5 failed logins/hour/IP -> 403 block
- Rate limits are LOW and plan-tiered (Bronze 10/h+100/day ... Platinum 100/h+1500/day; add-on packages purchasable). Max 3 concurrent requests. 429 has `Retry-After` header; watch `X-Rate-Limit-*-Remaining` headers
- PUT/POST limited to 100 items per request -> slice batches by 100 (see `Products::update()`)
- Products & variants are matched by unique `code`; a variant's null fields inherit from parent product
- Prices structure: `"prices": [{"language": "cs", "pricelists": [{"name": "Výchozí", "price_original": 123}]}]`
- Dates ISO 8601; language attributes ISO 639-1; PUT orders sends emails/SMS unless `send_emails_yn`/`send_sms_yn` = false
- Webhooks: managed only via API, POST with entity IDs, retry every 5 min until 200/204, 1s response timeout
- Bulk product/category data is better done via XML feeds (import/export in admin) than API - see XML references; XSD: `https://files.upgates.com/schema/products_v2.xsd`
