# `lib/baselinker/` PHP Library Reference

PHP client for BaseLinker. Namespace `Baselinker`. All classes call `Baselinker\api_post()` from `inc.php`. ShopSync data structures (`$this->data`, `$this->order`, `$this->product`) follow the platform-wide conventions used by other shopsync libs (`lib/shoptet_api/`, `lib/creativesites/`, etc.).

## `inc.php` — transport & constants

Constants (defined immediately on include):
- `bl_api_url` = `https://api.baselinker.com/connector.php`
- `bl_api_token` = `getCfg(8, "bl_api_token")`

Functions:

### `api_post($method, $data, $stripslashes = false)`

POST one method call. Returns decoded array (`json_decode($output, true)`).

- Encodes `$data` as `parameters=<JSON_FORCE_OBJECT>` in form body.
- Sends `X-BLToken: <bl_api_token>` header.
- Retries up to 5 times on non-2xx HTTP, sleeping 5s between attempts. Returns `false` after 5 failures.
- `usleep(500000)` (0.5s) on every successful call — basic rate-limit protection (BL caps at 100 req/min).
- Logs request body to `temp_dir/request.txt`.
- `$stripslashes = true` re-encodes `+` → `%2B` in the parameters string (only needed for the few methods BL parses with PHP-style form decoding instead of JSON).
- Writes `chyba <print_r>` to log if response `status != "SUCCESS"` — but still returns the decoded payload, so the caller must inspect `$res["status"]` to branch on success/error.

### `build_post_fields($data, $existingKeys = '', &$returnArray = [])`

Recursive flattener producing `key[subkey][subsubkey] => leaf` pairs from nested arrays. Rarely used because `api_post` JSON-encodes via `parameters=`; reserved for endpoints that expect classic PHP form arrays (none in current scripts).

---

## `Baselinker\Orders` — read orders for shopsync

**Public properties:**
- `$data = []` - collected orders (each entry is the `$this->order` shape below)
- `$order = []` - the currently-loaded order (workspace)
- `$shipping_i`, `$payment_i`, `$coupon_i`, `$wrapping_i` - indices into `$order["items"]` for the synthesized special lines (only `shipping_i` is actually populated)
- `$perpage = 100` - BL hard cap, informational
- `$excludeStates = ["X"]` - status IDs to skip (defaults; override before `load()`)
- `$date_field = "date_confirmed_from"` - which date axis to page on; set to `"date_from"` to page by creation instead of confirmation

**Methods:**

### `load($days_back = 3, $date_from = null, $extra_params = [])`

Page-loops `getOrders`:
- If `$date_from` parses to a unixtime, uses it (clamped not to be older than `now - $days_back * 86400`). Otherwise uses `now - $days_back * 86400`.
- Calls `getOrders` with `{date_field: <ts>, include_custom_extra_fields: 1, ...extra_params}`.
- Tracks already-processed `order_id`s in `$processed[]` to handle the date-cursor overlap when BL keeps returning the same boundary records.
- Advances `last_date_from` to the last order's `date_confirmed` (or `date_add` when `date_field == "date_from"`).
- Stops when `processed_since_last == 0` (no new orders in the batch).
- Calls `loadOrder($data)` per order; appended to `$this->data` if `count($this->order) > 2`.

**Common `extra_params`:** `status_id`, `filter_email`, `filter_order_source`, `filter_order_source_id`, `filter_external_order_id`.

### `loadOrder($data)` — internal, do not call directly

Populates `$this->order` from a BL `getOrders` row:

| ShopSync field | Source / transform |
|---|---|
| `currency_code` / `currency_rate` | `set_homecurrency` → rate 1; else `currency` with rate 1 (no exchange-rate field in `getOrders`) |
| `action` | `"order"` |
| `symvar`, `id`, `idord`, `number`, `numberorder` | `order_id` (all the same) |
| `status` | `order_status_id` |
| `source`, `source_id` | `order_source`, `order_source_id` |
| `paid` | `payment_done > 0 ? 1 : 0` |
| `date`, `datedue`, `datetax` | `date_add` (+14d for `datedue`) |
| `payment` | paired via `getCfgs(2)` from `payment_method` (stripos case-insensitive). `payment_orig` keeps the raw eshop value |
| `carrier` | paired via `getCfgs(3)` from `delivery_method`. `carrier_orig` keeps the raw value |
| `email` | `email` |
| `invoice.*` | `invoice_*` fields; `dic`/`icdph` from `invoice_nip` (spaces stripped) |
| `delivery.*` | `delivery_*` fields; if `delivery_street == ""`, falls back to `invoice` block |
| `pickup` | `delivery_point_id` |
| `items[].code` | `sku` |
| `items[].vat` | `tax_rate / 100` (stored as fraction, e.g. `0.21`) |
| `items[].price` | gross or net depending on `getCfg(1, "ceny_s_dani")` |
| Shipping line | Item with code `99991`, name = `delivery_method`, VAT = highest item VAT (tracked in `$last_tax_rate`) |
| `vatsum[]` / `basesum[]` | Accumulated by VAT rate; keys are integer percent (e.g. `21`). OSS rates added from `$GLOBALS["eu_vat_rates"]` if `getCfg(1, "oss") == "1"` and the delivery country is OSS-relevant; `GR` is rewritten to `EL` for EU VAT lookup |

Calls `modifyOrderItem($i2, $item, $data)` per item and `modifyOrder($data)` at the end — both are empty hooks for subclassing.

### Customization hooks

Subclass and override:
- `modifyOrder($data)` - final per-order tweaks (carrier paid status, extra fields, etc.)
- `modifyOrderItem($i2, $item, $data)` - per-item tweaks (rename, repricing, ...)

Example use in `scripts/orders.php` and `scripts/invoices.php` — the subclass typically also re-fetches `getOrders` for a single order to get richer fields (custom_extra_fields, delivery method, etc.) that `getInvoices` doesn't return on its own.

---

## `Baselinker\Invoices` — read invoices for shopsync

Same shape as `Orders` but for invoices. Builds `$this->order["invoice_type"]` from BL `type` (`normal` / `correcting`) and `$this->order["correcting_reason"]` from `correcting_reason`.

**Public properties:** mirror `Orders` plus the read-only `$excludeStates`.

### `load($days_back = 3, $date_from = null, $extra_params = [])`

Page-loops `getInvoices` keyed on `date_from` + `id_from` (NOT a `page` parameter — BL doesn't accept one here). Advances `id_from = data.invoice_id + 1`. Stops when `getInvoices` returns empty.

### `loadOrder($data)` — internal

Same field mapping as `Orders::loadOrder` plus:
- `id` ← `invoice_id`
- `idord` ← `order_id`
- `number` ← BL invoice number
- `invoice_type` ← `type` (`normal` / `correcting`)
- `correcting_reason` ← `correcting_reason` (empty string if not set)
- `total_incl_vat` / `total_excl_vat` ← from `total_price_brutto` / `total_price_netto` (rounded by `getCfg(1, "zaokrouhleni_polozky", 4)`)
- `delivery` is initialized as a copy of `invoice` (delivery details are NOT in `getInvoices`; subclasses typically re-fetch the underlying order via `getOrders` to fill `delivery`)
- Per-item: shipping/payment fees are NOT synthesized — only the raw line items are populated

### `processCorrectingInvoices()`

For each item in `$this->data` with `invoice_type == "correcting"`:

1. Spawns a fresh `Invoices` instance and re-runs `load(365, "1970-01-01", ["order_id" => idord])` to find sibling invoices for the same order.
2. Picks the first `invoice_type == "normal"` as `$reginv` (the original).
3. Indexes `$reginv["items"]` by `code` into `$reg_items`.
4. For each item in the correcting doc:
   - `count` ← `-$reg_items[code]["count"]` (negative of original quantity)
   - If `price == 0`, fill from original
5. Recomputes `total_incl_vat` / `total_excl_vat` from the modified items.
6. Adds:
   - `text` = `"Opravný daňový doklad k daňovému dokladu č. <num>\r\nDůvod opravy: <reason>\r\n"`
   - `date_orig` = original `date`
   - `orig_number` = original `number`

**KNOWN LIMITATION:** This logic treats every line of the correcting doc as a full cancellation of the matching original line. It does **not** compute `original − corrected` differences. Consequences:
- Partial returns are over-credited (whole original qty gets cancelled even when the customer kept some).
- Items present in the original but absent from the correcting doc are lost (never enter the loop).
- Items only in the correcting doc keep their positive `count`.

See the conversation history with the user 2026-05-25 for the planned redesign (loop original × correcting, emit `diff_count = corr - orig` lines).

---

## `Baselinker\Products` — write products to BL inventory

Constructor: `__construct($inventory_id, $warehouse_id, $pricelist_id = null)`.

**Public properties:**
- `$product_ids[sku] => product_id` - built from `getInventoryProductsList` + `getInventoryProductsData`
- `$variants_ids[sku] => parent_product_id` - same source
- `$product_data[sku] => <full product>` - cached product data
- `$create_products = false` - if you want to gate creation (not currently used internally, set by callers)
- `$inventory_id`, `$warehouse_id`, `$pricelist_id` - constructor args
- `$eshop_categories[cat_id] => bl_category_id` - read from `temp_dir/baselinker_categories_pairing.json` (populated by `Categories::saveCategory`)
- `$eshop_manufacturers[name] => manufacturer_id` - filled from `getInventoryManufacturers`
- `$map_insert`, `$map_update`, `$map_fields_insert`, `$map_fields_update` - column-to-payload maps used by `\getRequestBody()` (a global helper from `lib/functions.php`)

**On construction:** loops `getInventoryProductsList` (paged), batches IDs into `getInventoryProductsData`, fills `$product_ids` + `$variants_ids` + `$product_data`. Writes both id maps to `temp_dir/baselinker_product_ids.json` and `temp_dir/baselinker_variants_ids.json`. `die()`s if no products fetched at all (assumed first-run config error).

### `updateBatchStock($data, $warehouse_id)`

- Filters `$data` to entries whose `code` matches a known product or variant.
- For products: uses `$product_ids[code]`; for variants: `$variants_ids[code]`.
- Slices into chunks of **100** and POSTs each as `updateInventoryProductsStock({inventory_id, products: {id: {warehouse_id: count}}})`.

### `updateBatchPrices($data, $pricelist_id)`

Same slicing pattern, but only handles products (not variants — the loop check is `array_key_exists($d["code"], $this->product_ids)`). Sends `updateInventoryProductsPrices({inventory_id, products: {id: {pricelist_id: price_novat}}})`.

### `save($data)`

For each item: resolves `$this->id` via `loadId($d["code"])` and calls `saveItem($d)`. After the loop, calls `updateBatchStock` and `updateBatchPrices` for all items (using the constructor's `warehouse_id`/`pricelist_id`).

### `saveItem($d)`

Builds a per-product payload via `\getRequestBody()` (from `lib/functions.php`) using `$map_*` arrays.
- Category lookup uses `$eshop_categories[<input cat>]`.
- Manufacturer lookup goes through `getManufaturer($name)` which auto-creates via `addInventoryManufacturer` if missing.
- VAT goes into `_taxclass` ← `d["vat"]`.
- Text fields (name, description) packed under `_text_fields` for `\getRequestBody` to map into `text_fields` on the request.
- If `$this->id` is set → `addInventoryProduct({..., product_id: id})` (BL uses the same method for create & update).
- Else → `addInventoryProduct(...)` then store the returned `product_id` into `$product_ids[code]` and re-flush the JSON map.

### `getManufaturer($name)` (sic — typo preserved in source)

Returns `manufacturer_id` from cache, or auto-creates via `addInventoryManufacturer` and caches the new ID. Returns `false` on empty name or API failure.

### `loadId($code)`

Trims, strips `+`, returns `$product_ids[code]` or `false`. Does NOT consult `$variants_ids`.

---

## `Baselinker\ProductsExport` — read products FROM BL inventory

**Public properties:**
- `$data` - flat list of products + variants in ShopSync `$this->product` shape
- `$product` - currently loaded product (workspace)
- `$product_data` - raw BL product data by `sku`
- `$download_images = false` - if `true`, downloads first image of each product into `img_dir`
- `$pricelist_id = 1` - which BL pricelist's price to copy into `price`/`price_vat`
- `$inventory_id = 0` - REQUIRED before `load()`
- `$stock_id = 0` - not currently consulted in `loadProduct()`
- `$eshop_manufacturers[manufacturer_id] => name` (reverse direction vs `Products`)

### `load($last = "1970-01-01")`

- Fetches manufacturers (`getInventoryManufacturers`) into `$eshop_manufacturers`.
- Pages `getInventoryProductsList` (1000 IDs per page logged, but BL's actual cap is per-call), batches each page's IDs into `getInventoryProductsData`, accumulates raw rows into `$product_data`.
- After fetch, iterates products:
  - If `variants` present, calls `loadProduct($p, $v)` per variant, also fills `$product_ids2[variant.sku] => variant_id`.
  - Else builds a synthetic variant from product-level fields and calls `loadProduct($p, $v)` with `simple_product: true`, also fills `$product_ids2[product.sku] => product_id`.
- Persists `$product_ids2` to `temp_dir/products_ids_<inventory_id>.json`.
- The `$last` argument is accepted but not currently used (no change-detection yet).

### `loadProduct($p, $v)` — internal

Builds `$this->product`:
- `id`, `code` ← `v.sku`
- `name` ← `p.text_fields.name`
- `producer` ← `$eshop_manufacturers[p.manufacturer_id]` (name)
- `desc2` ← `htmlspecialchars(p.text_fields.description)`
- `price`, `price_vat` ← `v.prices[pricelist_id]` (with `tax_rate` strip)
- `ean` ← `v.ean`
- `vat` ← `p.tax_rate`
- `categories[]` ← `p.category_id` (single-entry array)
- `weight` ← `p.weight`
- `img[]` ← if `$download_images`, downloads first BL image into `img_dir` and records `{fn, desc}`

Calls `modifyLoadProduct($p, $v)` hook at the end.

---

## `Baselinker\Categories` — write categories to BL

**Public properties:**
- `$inventory_id = 0` - target inventory
- `$map_insert`, `$map_update` - column maps: `name`, `parent_id`
- `$eshop_categories[shopsync_cat_id] => bl_category_id` - persisted to `temp_dir/baselinker_categories_pairing.json`

### `getEshopCategories()`

Loads `$eshop_categories` from `temp_dir/baselinker_categories_pairing.json` (commented-out branch would also re-fetch via `getInventoryCategories` — currently disabled).

### `getEshopCategories2($inventory_id = null, $default_parent = 0)`

Fetches `getInventoryCategories` and returns `[category_id => {name, desc, parent}]`. `parent` defaults to `$default_parent` when BL reports root (`parent_id == 0`). Pure helper — does NOT touch `$this->eshop_categories`.

### `saveCategories($data)` / `saveCategory($d)`

For each ShopSync category:
- Maps `parent` via `$eshop_categories`, falls back to 0.
- If `id` already in `$eshop_categories` → update via `addInventoryCategory({..., category_id})`.
- Else → create, then store the new BL `category_id` in `$eshop_categories` and flush the JSON file.

---

## `Baselinker\Pictures` — write product images to BL

Constructor: `__construct($inventory_id)`. **Requires** `temp_dir/baselinker_product_ids.json` to exist (populated by a prior `Products` run) — `die()`s otherwise.

### `updatePictures($data)`

For each item with `picts[]`:
- Looks up `$baselinker_product_ids[code]` to get the BL `product_id`.
- Builds `images = {0: "url:<absolute URL>", 1: ...}` — BL accepts `url:` prefixed values pointing at a hosted image.
- Calls `addInventoryProduct({inventory_id, product_id, images})` to update only the image set (BL accepts partial updates on this endpoint).

URL construction uses `set_url . "/" . rawurlencode(basename($pict["dest"]))` — image files must be reachable at `set_url/...` (i.e. published to the public images dir).

---

## `settings_gen.php` (standalone bootstrap)

Run as: `php lib/baselinker/settings_gen.php` (relative to repo root, after `cd lib/baselinker`).

Generates `temp/<profile>_settings_template2.json` containing:
- Section 8 entries: `bl_api_token`, `bl_inventory_id`, `bl_warehouse_id`, `bl_pricelist_id`
- Section 2 (payments): one row per distinct `payment_method` seen in the last 7 days of orders
- Section 3 (shipping): one row per distinct `delivery_method`

Use it to populate the GUI's settings editor with the methods this BL account actually uses.

---

## `reset.php` (standalone bootstrap)

Run as: `php lib/baselinker/reset.php`. Deletes every `temp/<profile>_*_last.txt` — the per-table "last sync" timestamps consulted by `getLastUpd()`. Forces full re-fetch on next run for all tables (orders, products, invoices, ...).

---

## Common gotchas

- `api_post` returns `false` only on transport failure (5 retries exhausted). On `status: ERROR` it logs and returns the decoded body — callers must check `$res["status"] == "SUCCESS"` before using fields.
- BL truncates / mishandles raw `+` in some `parameters` payloads; if you observe data corruption with leading `+` in SKUs, set `$stripslashes = true` on the call.
- `getInvoices` does NOT include delivery address or carrier — fetch the underlying order via `getOrders({order_id})` if you need those.
- `getOrders` returns max 100 records per call. Pagination MUST advance both the date cursor AND `id_from` to avoid skipping orders at the boundary. Use the `$processed[]` set in `Orders::load` as a reference if you need to re-implement this elsewhere.
- `Products::__construct` performs the full inventory enumeration on every instantiation — expensive for large catalogs. The cache file `baselinker_product_ids.json` is written but NOT read on subsequent constructions (`Pictures` is the only consumer that reads it).
- `Products::saveItem` uses `addInventoryProduct` for both create and update — BL distinguishes by presence/absence of `product_id` in the payload.
- Custom extra fields are NOT returned by default — pass `include_custom_extra_fields: 1` (or `"true"`) on `getOrders` / `getInvoices`. `Orders::load` already does this.
