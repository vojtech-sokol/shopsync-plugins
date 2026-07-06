---
name: woocommerce
description: Dev helper for WooCommerce e-shop integration (database + REST API). Use when working on shopsync projects that integrate with WooCommerce - orders, products, categories, customers, stock. Two approaches - direct DB access (lib/woocommerce7/) and REST API (lib/woocommerce_api/), often combined. Use when user mentions "woocommerce" or "woo", or works in project containing `lib/woocommerce7/` or `lib/woocommerce_api/`.
user-invocable: true
argument-hint: [topic]
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# WooCommerce - Dev Helper

WooCommerce is a WordPress e-commerce plugin. ShopSync integrates via **two approaches** (often combined in one project):

1. **Direct database** (`lib/woocommerce7/`, namespace `WooCommerce`) - faster for bulk reads, direct SQL queries
2. **REST API** (`lib/woocommerce_api/`, namespace `WooCommerceAPI`) - cleaner for writes, uses `/wp-json/wc/v3/`

For REST API endpoints & object schemas, see [references/api-reference.md](references/api-reference.md).
For database tables & meta fields, see [references/db-reference.md](references/db-reference.md).
For PHP library class methods & field mappings, see [references/library-reference.md](references/library-reference.md).

## Key Files

### Database approach (lib/woocommerce7/)
- `inc.php` - `readMeta()`, `updateMeta()` helpers
- `orders.php` - `WooCommerce\Orders` - load orders from DB (post-based)
- `orders_hpos.php` - `WooCommerce\OrdersHPOS` - load orders from HPOS tables (wc_orders)
- `order_refunds.php` - `WooCommerce\OrderRefunds` - refund order loading
- `products.php` - `WooCommerce\Products` - save products via direct DB (postmeta)
- `products2.php` - `WooCommerce\Products` (extended) - variants, attributes, categories, producers
- `products_export.php` - `WooCommerce\ProductsExport` - export products FROM WooCommerce
- `wc_product_save.php` - Triggers `WC_Product->save()` via wp-load.php
- `install.php` - DB schema init (shopsync_last table, sync columns)

### REST API approach (lib/woocommerce_api/)
- `inc.php` - `api_get()`, `api_post()`, `api_put()` HTTP functions (Basic Auth)
- `products.php` - `WooCommerceAPI\Products` - save products via REST API with hash-based change detection
- `categories.php` - `WooCommerceAPI\Categories` - category sync via REST API
- `parameters.php` - `WooCommerceAPI\Parameters` - product attributes via REST API

## Script Bootstrap Pattern

```php
include "./config.php";
include "./lib/functions.php";
init();

// Database approach
include "./lib/woocommerce7/inc.php";
include "./lib/woocommerce7/orders.php";

// REST API approach
include "./lib/woocommerce_api/inc.php";
include "./lib/woocommerce_api/products.php";
```

## Core Functions

### Database helpers (WooCommerce namespace)
- `readMeta($id, $table, $idreccol, $idcol, $keycol, $valcol)` - read all meta for entity, returns `[key => value]`
- `updateMeta($arr, $data, $id, $table, ...)` - insert/update meta records; `#` prefix = literal value

### REST API functions (WooCommerceAPI namespace)
- `api_get($route, $params)` - GET with Basic Auth, returns JSON string
- `api_post($route, $params, $data)` - POST with JSON body, returns decoded array
- `api_put($route, $params, $data)` - PUT with JSON body, returns JSON string
- All have 500ms built-in throttle between requests

**REST API config:** `api_url` = `set_url` + `getCfg(8, "woo_api_path")`, credentials via `api_user`/`api_pass`

## Two Order Storage Models

WooCommerce has two order storage backends:

1. **Legacy (posts-based):** Orders in `wp_posts` (post_type='shop_order'), meta in `wp_postmeta`
   - Class: `WooCommerce\Orders` (orders.php)
2. **HPOS (High-Performance Order Storage):** Orders in `wp_wc_orders`, addresses in `wp_wc_order_addresses`, operational data in `wp_wc_order_operational_data`
   - Class: `WooCommerce\OrdersHPOS` (orders_hpos.php)
   - Posts table still used but with `post_type='shop_order_placehold'`

## Product Storage

Products are WordPress posts (`post_type='product'`), variants are `post_type='product_variation'`.
All product data stored in `wp_postmeta` as key-value pairs.

### Key Product Meta Fields
| Meta Key | Description |
|----------|-------------|
| `_sku` | Product SKU (matching field) |
| `_price` | Current active price |
| `_regular_price` | Regular price |
| `_sale_price` | Sale price |
| `_stock` | Stock quantity |
| `_stock_status` | `instock`, `outofstock`, `onbackorder` |
| `_manage_stock` | `yes`/`no` |
| `_weight` | Weight |
| `_tax_status` | `taxable`, `shipping`, `none` |
| `_tax_class` | Tax class slug |
| `_backorders` | `no`, `notify`, `yes` |
| `_virtual` | `yes`/`no` |
| `_downloadable` | `yes`/`no` |
| `_thumbnail_id` | Main image attachment ID |
| `_product_image_gallery` | Additional images (comma-separated IDs) |
| `_product_attributes` | Serialized attributes array |
| `_sync_id` | ShopSync: external ERP ID |
| `_sync_code` | ShopSync: external code |
| `_wholesale_price` | Purchase/wholesale price |

### Custom Label Meta (ShopSync-specific)
`_sync_novinka` (new), `_sync_doprodej` (clearance), `_sync_akce` (sale), `_sync_doporucujeme` (recommended), `_sync_sleva` (discount), `_sync_pripravujeme` (upcoming)

## Category System

WordPress taxonomies: `product_cat` for categories, `pa_*` for product attributes, `product_tag` for tags, `product_brand` for producers.

- Categories linked via `wp_term_relationships` (object_id = post ID, term_taxonomy_id)
- ShopSync adds `sync_id` to `wp_termmeta` for ERP matching
- REST API: `POST/PUT /products/categories`

## Tax Class Mapping

VAT rates map to WooCommerce tax classes:
- Standard rate → empty string (default)
- Reduced rate → `taxclasslow`
- Second reduced → `taxclassthird`
- Zero rate → `taxclassnull`

Configured via `woocommerce_tax_rates` table or WooCommerce settings.

## Important Conventions

- Table prefix in `db_prefix` constant (typically `wp_`, can vary per install)
- SQL helpers: `qry()`, `res()`, `numrows()`, `sqlSafe()` from `lib/functions.php`
- Config: `getCfg($section, $key)` - section 2 = payments, section 3 = shipping, section 8 = API settings
- Custom order fields: `pole_cisla_objednavky`, `pole_var_symbolu`, `pole_ic`, `pole_dic`, `pole_ic_dph` (configurable via settings)
- Products matched by `_sku` (configurable via `paircol`)
- Sync timestamps via `shopsync_last` table (`getLastUpd`/`setLastUpd`)
- REST API uses MD5 hash-based change detection (`data_hash.json` in temp dir) to skip unchanged items
- WooCommerce product save hook: call `wc_product_save.php?id=X` after direct DB changes to regenerate lookup tables
