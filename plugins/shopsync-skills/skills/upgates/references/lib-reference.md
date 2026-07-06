# lib/upgates - PHP Class Reference (UpGates namespace)

All classes rely on `inc.php` being included first (defines `api_url`, `api_user`, `api_pass` constants from `getCfg(8, ...)` and the `api_*` HTTP functions). Routes are relative to `{api_url}` which already ends with `/api/v2`.

## inc.php - HTTP layer & helpers

- `api_get($route, $params = [])` - GET; params urlencoded via `urlencode2()` (space -> %20); prints URL when `getCfg(8, "debug") >= 1`
- `api_put($route, $params, $data)` - PUT, `$data` json-encoded body
- `api_post($route, $params, $data)` - POST (note: ignores `$params`, prints raw response)
- `api_delete($route, $params)` - DELETE
- `api_post_file($route, $params, $file_path, $file_name = null, $code = null)` - multipart POST (`CURLFile`), for `products/{code}/images`
- All: Basic auth, non-200/201 prints "Pri operaci nastala chyba (HTTP %d)", `usleep(500000)` after each call (rate-limit courtesy)
- `prepareProductData($src, $categories = null)` - transforms ERP rows into Upgates-ready array keyed by product code: sanitizes codes (`preg_replace('/[^a-zA-Z0-9_\/\-\.\s]/', '-', ...)`), writes `temp_dir/code_pairing.json` (orig -> sanitized), groups variant rows under `upgates_variants[option]`, attaches `upgates_pictures`/`upgates_pictures2`/`upgates_files` from `temp_dir/pictures.sqlite` (`sync_pictures` table), skips zero-price items unless `getCfg(4, "produkt_s_nulovou_cenou")`
- `build_post_fields()`, `urlencode2()`

## orders.php - `Orders` (read orders from eshop)

Props: `$data` (result array), `$perpage = 100`, `$excludeStates = ["X"]` (status_id values to skip).

- `load($days_back = 3, $date_from = null, $updates = false, $number = null)`
  - `$number` set -> `GET orders/{number}` (single order, response still has `orders` array)
  - else paginated `GET orders` filtered by `creation_time_from` (or `last_update_time_from` when `$updates = true`), value `date("c", ...)`
  - skips orders with empty `status_id` or status in `$excludeStates`; debug>=1 dumps each order to `temp_dir/order_{number}.json`
  - each order run through `loadOrder()` -> appended to `$this->data`
- `loadOrder($data)` - maps one Upgates order (currency, customer, items, shipment, payment) into internal shopsync order format in `$this->order`

## order_states.php - `OrderStates`

- `setState($order_number, $id_status, $tracking_number = "")` - `PUT orders` with body `{"orders": [{"order_number": ..., "status_id": ..., "tracking_code": ...}]}`
- `getStates($days_back = 3, $date_from = null)` - paginated `GET orders?last_update_time_from=...`, returns `[order_number => status_id]`

## products.php - `Products` (write to eshop)

- `update($data, $variants = false, $price_lang = "cs")` - price+stock update; builds items `{"code", "prices": [{"language": "cs", "pricelists": [{"name": "Výchozí", "price_original": X}]}], "stock": N}` (stock-only when price <= 0); slices by 100; `PUT products` with `{"products": [...]}` and, when `$variants`, again with `{"variants": [...]}`
- `updateBatchStock($data)` - stock-only variant of the same (always sends both products and variants bodies)
- `downloadAllCodes()` - paginated `GET products/simple`; returns `["products" => [...codes], "variants" => [...codes], "all" => merged]`

## products_export.php - `ProductsExport` (read products from eshop)

- `load($last = "1970-01-01")` - paginated `GET products` (incremental by last update); items via `loadProduct()`
- `loadProduct($data, $parent)` - maps product/variant into internal format
- `downloadImage($imgid, $pid = null)` - fetches product image

## categories.php - `Categories`

Props: `$default_parent = 2` (left menu), `$default_lang = "cs"`, mapping templates `$map_insert`/`$map_update` (used with global `getRequestBody()`), SQLite cache `temp_dir/upgates.sqlite` (`sync_categories`).

- `getEshopCategories()` - paginated `GET categories`; fills `eshop_categories_names[code]` (name in default lang) and `eshop_categories_parents[code]`
- `saveCategories($data)` - loads eshop categories, then per item `saveCategory()`; respects `rootcat` constant
- `saveCategory($d)` - existing -> `PUT categories` `{"categories": [{... "id_category": ...}]}`; new -> `POST categories` (only when parent already exists, otherwise logs "chybi rodic" - callers must iterate parents-first)
- `prepareCategoriesData($data)` / `saveCategoriesFile($data)` - dump ERP categories to `temp_dir/categories.json` keyed by id

## customers.php - `Customers`

- `loadExistingCustomers()` - paginated `GET customers`, builds email-keyed cache
- `save($data)` - splits into create/update batches (customer unique key = email), `processBatch()` -> `POST customers` / `PUT customers`, `updateCacheAfterCreate()`, `checkForErrors()`
- `prepareCustomerData($d)` - map internal customer to Upgates shape

## invoices.php - `Invoices`

- `load($days_back = 3, $date_from = null)` - paginated `GET invoices` (creation/last-update filters), each mapped via `loadOrder()` into internal document format

## settings_gen.php

Standalone helper: `GET shipments` and `GET payments`, dumps code lists for config mapping (shipping/payment pairing).

## Other

- `states.php` - order state mapping helpers
- `reset.php` - cleanup/reset helpers
- `templates/` - request body templates
