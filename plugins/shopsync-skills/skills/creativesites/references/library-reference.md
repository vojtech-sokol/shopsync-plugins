# CREATIVE sites PHP Library - Class Reference

Library location: `lib/creativesites/`, namespace `CreativeSites`. All classes assume the bootstrap (`config.php` + `lib/functions.php` + `init()` + `lib/creativesites/inc.php`) has run first.

## `inc.php` - Module functions

### Constants
- `api_url` ← `getCfg(8, "api_url")` (no trailing slash; the helpers prepend `/`)
- `api_user` ← `getCfg(8, "api_uzivatel")`
- `api_pass` ← `getCfg(8, "api_heslo")`

### HTTP helpers

```php
api_get(string $route, array $params = []): string        // raw JSON, must json_decode
api_post(string $route, array $params, array $data): ?array
api_put(string $route, array $params, array $data): ?array
api_delete(string $route): ?array
```

All four:
- prepend `api_url . "/"` to `$route`
- send HTTP Basic Auth (`api_user:api_pass`)
- disable SSL verification (`CURLOPT_SSL_VERIFYPEER/HOST = false`)
- sleep `usleep(1_000_000)` after the call (500_000 for DELETE)
- print `Při operaci nastala chyba (HTTP NNN): body` on non-2xx (except 400 in `api_get`)

⚠️ **Quirk:** `api_put` and `api_post` build query string with `&` only — no `?` separator. If you pass `$params`, prepend your `$route` with `?` or pre-bake it. Most callsites pass `array()` here.

⚠️ **Quirk:** `api_get` returns the raw JSON **string**; the rest return decoded arrays.

### `prepareProductData(array $src, $categories = null): array`
Groups variants under their parent product `code`. Input: flat array of ShopSync products (each with `code`, `name`, `price_novat`, optional `option` + `params2`). Output: keyed by parent `code` with a `variants` sub-array. Skips items missing `price_novat`, `name`, or `code`.

### `convertCountryCode(string $input): string`
- Pass ISO-2 (`SK`) → returns ISO-3 (`SVK`).
- Pass ISO-3 (`SVK`) → returns ISO-2 (`SK`).
- Returns empty string when unknown.

(Implementation: built-in JSON map of ~250 countries.)

### `getLastUpd2(string $table, $db) / setLastUpd2(string $table, $db)`
Read/write sync timestamps from a SQLite-style `shopsync_last` table. Special behaviour for `$table === 'products'`: after 22:00 local time, if at least 3h since the last reset, returns `""` (forces full re-pull). Sets global `$GLOBALS["timestart"]` for later `setLastUpd2` to consume.

### `build_post_fields($data, $existingKeys = '', &$returnArray = [])`
Flattens nested array to PHP form-style `key[sub][sub]` syntax. Rarely used (legacy curl helper); JSON is the primary content type.

## `orders.php` - `CreativeSites\Orders`

Pulls orders from the eshop and normalizes them into ShopSync's `$this->data[]` array.

### Properties
| Property | Default | Meaning |
|---|---|---|
| `$data` | `[]` | Accumulator of normalized orders (final output) |
| `$order` | `[]` | Current order being built (transient) |
| `$shipping_i`, `$payment_i`, `$coupon_i`, `$wrapping_i` | `null` | Indexes in `$order["items"]` of the shipping, payment, discount items, set during `loadOrder` |
| `$perpage` | `100` | Page size for `GET /orders` |
| `$excludeStates` | `["X"]` | Order status codes to skip (`X` = deleted by default) |

### Methods

```php
public function load($days_back = 3, $last = null)
```
Fetches orders via `GET /orders?filterBy=cdate`. Either uses `from = today - $days_back days` (default) or `from = $last` when provided. Iterates pages until short page is returned. Writes `temp_dir/ord_data.txt` with the last page's `print_r` dump for debugging. For each order not in `$excludeStates`, calls `loadOrder($data)` and pushes to `$this->data` if at least 3 keys ended up populated.

```php
public function loadOrder($data)
```
Converts a single CREATIVE sites order JSON into the internal `$this->order` shape:
- pairs payment by `getCfgs(2)` and shipping by `getCfgs(3)` via case-insensitive `stripos`
- maps billing/delivery using `convertCountryCode($code)` for `country`
- splits shipping, payment fee, discount (`Zĺava`), credit discount (`Zĺava kredit`) into separate synthetic items (codes `99991`, `99991`, `99992`, `99993`)
- VAT: stored as fraction (`taxRate / 100`); honours `getCfg(1, "ceny_s_dani")` (1 = prices include VAT)
- Pickup point: `$this->order["pickup"] = $data["shipping"]["deliveryPointId"]` when present
- Calls `$this->modifyOrder()` at the end (override hook)

```php
public function modifyOrder()
```
Empty by default — override in scripts to mutate `$this->order` before it's appended.

### Typical usage

```php
$ord = new \CreativeSites\Orders();
$ord->excludeStates = ["X", "S"];     // skip deleted + cancelled
$ord->load(7);                         // last 7 days
foreach ($ord->data as $order) {
    // push $order into the ERP
}
```

## `products.php` - `CreativeSites\Products`

Saves products from ShopSync into the eshop (create/update + batch stock + batch price).

### Properties
| Property | Default | Meaning |
|---|---|---|
| `$product_ids` | `[]` | Map `sku => productId`, populated by constructor |
| `$variants_ids` | `[]` | Map `variantCode => parentProductId`, populated by constructor |
| `$create_products` | `false` | When true, missing SKUs are created via `POST /products`; otherwise only existing products are updated |
| `$variants` | `true` | Whether to also load variants into `$variants_ids` |
| `$variantParams` | `[]` | `attributeId => [...]`, populated by `loadVariantParams()` |
| `$variantParamsNames` | `[]` | `attributeName => attributeId`, used to translate variant attribute names from ShopSync to eshop |
| `$createMissingVariantParams` | `true` | Auto-create attributes via `POST /attributes` when needed |
| `$id` | `null` | Result of last `loadId()` call |

### Methods

```php
public function __construct()
```
Hits `GET /products?list=id,sku,variants&perPage=1000` page by page to fill `$product_ids` and (when `$variants`) `$variants_ids`. Persists both maps to `temp_dir/products_ids.json` and `temp_dir/variants_ids.json`. Then calls `loadVariantParams()` when variants are enabled.

```php
public function save(array $data)
```
For each input row (ShopSync product/variant), calls `loadId($d["code"])` then `saveItem($d)`. Use this for full create/update flow.

```php
public function updateBatchStock(array $data)
```
Sends `PUT /products/stock` in chunks of 100. Each entry: `{ sku, stock, isVariant }`. Variants are identified by being present in `$variants_ids`; products by `$product_ids`. Skips rows where `count` is empty.

```php
public function updateBatchPrice(array $data, int $pricelist_id = 5)
```
Sends `PUT /products/price` in chunks of 100. Each entry: `{ sku, sgpId: $pricelist_id, price, priceInclVAT, currency: set_homecurrency, isVariant, oldPrice?, oldPriceInclVAT? }`. Uses `sale_price`/`sale_price_novat` when discounted; otherwise the regular `price`/`price_novat`. `oldPrice` set whenever an `old_price` is available.

```php
public function saveItem(array $d)
```
Sets `$this->item = $d` and dispatches to `saveGeneral()`.

```php
public function loadId(string $code): ?int
```
Looks up `$code` in `$this->product_ids`, stores it in `$this->id` and returns it. Variants are NOT searched here.

```php
public function saveGeneral()
```
The big one — builds either a create payload (when `$create_products && $id === null`) or update payload (otherwise), translating ShopSync data into `Product` / `ProductUpdate` shape:
- top-level fields (`name`, `sku`, `sef = basestring_url($name)`, `description`, `shortDescription`, `weight`, `weightUnit: "kg"`, `taxRate`)
- `priceList`: `sgpId: 5` retail price (or per-variant prices when variants present)
- `variants`: built from `$item["variants"]`, each with `code`, `priceInclVAT`, `oldPrice*`, `availability` mapping and a `values` array assembled from `params2` (variant attribute name → ID via `$variantParamsNames`, auto-create when `$createMissingVariantParams`)

POST goes to `/products`, PUT to `/products/{id}`.

```php
public function loadVariantParams()
```
Hits `GET /attributes`, populates `$variantParams[$attr["id"]] = []` and `$variantParamsNames[$attr["name"]] = $attr["id"]`. The shared `Parameters` class also has this method — `Products` uses its own copy because it needs both maps.

### Typical usage

```php
$prod = new \CreativeSites\Products();    // ⚠ loads ALL products & variants up-front — slow on large catalogues
$prod->create_products = true;
$prod->save($data);                       // full create/update
// OR — light path:
$prod->updateBatchStock($data);           // batch stock only
$prod->updateBatchPrice($data, 5);        // batch retail price only (sgpId=5)
```

## `products_export.php` - `CreativeSites\ProductsExport`

Reads products **out of** the eshop (opposite direction to `Products`). Used when the eshop is the source of truth and ShopSync replicates into the ERP.

### Properties
| Property | Default | Meaning |
|---|---|---|
| `$data` | `[]` | Output accumulator |
| `$product` | `[]` | Current product being built |
| `$lang` | `"sr"` | Translation lang to extract |
| `$pricelist` | `"5"` | Shopper group to read price from |
| `$page_size` | `100` | `perPage` |

### Methods

```php
public function load($last = "1970-01-01")
```
`GET /products?filterBy=mdate&mdate=<$last>&perPage=$page_size&page=N`. Iterates pages. For products with variants, calls `loadProduct($variant, $parent)` for each variant; otherwise `loadProduct($data)`.

```php
public function loadProduct($data, $parent = null)
```
Builds `$this->product` from a single CREATIVE sites product (or variant + parent). Sets `is_variant = true` when a parent is passed.

```php
public function downloadImage($imgid, $pid = null)
```
Helper for materializing remote image URLs into the project temp dir.

## `parameters.php` - `CreativeSites\Parameters`

Single helper:

```php
public function loadVariantParams()
```
Hits `GET /attributes`, populates `$this->variantParams[$id]` and `$this->variantParamsNames[$name] = $id`. `Products` class includes its own copy of this method (duplicated logic).

## `settings_gen.php`

Generates the project settings template (`temp/creativesites_settings_template.json`) from the eshop config (`payments`, `shippings`, `orderstates` etc.). Run once per project to bootstrap config sections 2 (payments) and 3 (shipping carriers).

## Common Idioms

### Pairing fields used in shopsync wrappers

| Eshop field | ShopSync internal | Notes |
|---|---|---|
| Product `sku` | `code` | Primary match |
| Variant `code` | `code` (with `option` overriding) | Variant flow uses `option` field |
| Order `id` | `id`, `idord`, `number`, `numberorder`, `symvar` | All set to the same numeric ID |
| Address `countryCode` (ISO-3) | `country` (after `convertCountryCode`) | Becomes ISO-2 |
| Item `taxRate` (percent) | `vat` (fraction = pct/100) | |
| Currency code | `currency_code` | Compare against `set_homecurrency` constant |
| `cdate` | `date` (`Y-m-d`) | Order date = creation date |
| Tracking | `ship_id` | Read-only in this lib |

### Synthetic line items (always added by `loadOrder`)
| Internal code | Meaning |
|---|---|
| `99991` | Shipping fee + Payment fee (separate items, both `99991`) |
| `99992` | Discount / coupon (`Zĺava <code>`) |
| `99993` | Credit discount (`Zĺava kredit`) |

### Cache files written to `temp_dir`
- `products_ids.json` — `sku => id` map
- `variants_ids.json` — `code => parentId` map
- `ord_data.txt` — last `print_r` of the last orders page (debug only)
