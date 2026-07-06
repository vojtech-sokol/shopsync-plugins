# WooCommerce Database Reference

Table prefix: `wp_` (varies per install, stored in `db_prefix` constant). Example schemas may use `cwp_`.

## Core WordPress Tables

### wp_posts
Products, orders (legacy), and other content.

| Column | Type | Description |
|--------|------|-------------|
| ID | bigint(20) PK | Post ID |
| post_author | bigint(20) | Author user ID |
| post_date | datetime | Creation date (local) |
| post_date_gmt | datetime | Creation date (GMT) |
| post_content | longtext | Full description (products) |
| post_title | text | Product name / Order title |
| post_excerpt | text | Short description |
| post_status | varchar(20) | `publish`, `draft`, `wc-processing`, `wc-completed`, etc. |
| post_name | varchar(200) | URL slug |
| post_modified | datetime | Last modified |
| post_parent | bigint(20) | Parent post (variants -> product, refunds -> order) |
| post_type | varchar(20) | `product`, `product_variation`, `shop_order`, `shop_order_placehold`, `shop_order_refund`, `attachment` |

**Key post_type values:**
- `product` - Simple/variable products
- `product_variation` - Product variants (post_parent = product ID)
- `shop_order` - Orders (legacy storage)
- `shop_order_placehold` - Orders (HPOS mode, placeholder)
- `shop_order_refund` - Refunds (post_parent = order ID)

### wp_postmeta
Key-value metadata for all posts (products, orders, attachments).

| Column | Type | Description |
|--------|------|-------------|
| meta_id | bigint(20) PK | Meta record ID |
| post_id | bigint(20) FK | -> posts.ID |
| meta_key | varchar(255) | Field name |
| meta_value | longtext | Field value |

---

## WooCommerce Order Tables (HPOS)

### wp_wc_orders
Main order table (HPOS mode).

| Column | Type | Description |
|--------|------|-------------|
| id | bigint(20) PK | Order ID |
| status | varchar(20) | `wc-processing`, `wc-completed`, `wc-on-hold`, etc. |
| currency | varchar(10) | ISO currency code |
| type | varchar(20) | Order type |
| tax_amount | decimal(26,8) | Total tax |
| total_amount | decimal(26,8) | Grand total |
| customer_id | bigint(20) FK | -> wc_customer_lookup |
| billing_email | varchar(320) | Billing email |
| date_created_gmt | datetime | Creation date |
| date_updated_gmt | datetime | Last update |
| parent_order_id | bigint(20) | Parent order (refunds) |
| payment_method | varchar(100) | Payment method ID |
| payment_method_title | text | Payment method name |
| transaction_id | varchar(100) | Transaction ID |
| customer_note | text | Customer note |

### wp_wc_order_addresses
Billing and shipping addresses per order.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint(20) PK | Address ID |
| order_id | bigint(20) FK | -> wc_orders.id |
| address_type | varchar(20) | `billing` or `shipping` |
| first_name | text | First name |
| last_name | text | Last name |
| company | text | Company |
| address_1 | text | Street address |
| address_2 | text | Address line 2 |
| city | text | City |
| state | text | State/province |
| postcode | text | Postal code |
| country | text | Country code |
| email | varchar(320) | Email (billing only) |
| phone | varchar(100) | Phone (billing only) |

### wp_wc_order_operational_data

| Column | Type | Description |
|--------|------|-------------|
| order_id | bigint(20) FK | -> wc_orders.id |
| created_via | varchar(100) | `checkout`, `admin`, `rest-api` |
| prices_include_tax | tinyint(1) | Prices include tax |
| shipping_tax_amount | decimal(26,8) | Shipping tax |
| shipping_total_amount | decimal(26,8) | Shipping total |
| discount_tax_amount | decimal(26,8) | Discount tax |
| discount_total_amount | decimal(26,8) | Discount total |
| date_paid_gmt | datetime | Payment date |
| date_completed_gmt | datetime | Completion date |
| order_key | varchar(100) | Unique order key |

### wp_wc_orders_meta
Custom meta for HPOS orders.

| Column | Type |
|--------|------|
| id | bigint(20) PK |
| order_id | bigint(20) FK |
| meta_key | varchar(255) |
| meta_value | text |

---

## Order Item Tables

### wp_woocommerce_order_items

| Column | Type | Description |
|--------|------|-------------|
| order_item_id | bigint(20) PK | Item ID |
| order_item_name | text | Item display name |
| order_item_type | varchar(200) | `line_item`, `shipping`, `tax`, `coupon`, `fee` |
| order_id | bigint(20) FK | -> wc_orders.id / posts.ID |

### wp_woocommerce_order_itemmeta

| Column | Type | Description |
|--------|------|-------------|
| meta_id | bigint(20) PK | Meta record ID |
| order_item_id | bigint(20) FK | -> woocommerce_order_items |
| meta_key | varchar(255) | Field name |
| meta_value | longtext | Field value |

**Key order item meta keys (line_item):**
| Meta Key | Description |
|----------|-------------|
| `_product_id` | Product post ID |
| `_variation_id` | Variation post ID (0 if simple) |
| `_qty` | Quantity |
| `_line_total` | Line total after discounts (excl. tax) |
| `_line_subtotal` | Line subtotal before discounts (excl. tax) |
| `_line_tax` | Line tax after discounts |
| `_line_subtotal_tax` | Line tax before discounts |
| `discount_amount` | Discount amount |
| `discount_amount_tax` | Discount tax |

---

## Product Meta Fields

Stored in `wp_postmeta` for posts with `post_type='product'` or `'product_variation'`.

### Core Product Meta
| Meta Key | Type | Description |
|----------|------|-------------|
| `_sku` | string | SKU (Stock Keeping Unit) |
| `_price` | float | Current active price |
| `_regular_price` | float | Regular price |
| `_sale_price` | float | Sale price |
| `_stock` | int | Stock quantity |
| `_stock_status` | string | `instock`, `outofstock`, `onbackorder` |
| `_manage_stock` | string | `yes` / `no` |
| `_weight` | float | Weight |
| `_length`, `_width`, `_height` | float | Dimensions |
| `_tax_status` | string | `taxable`, `shipping`, `none` |
| `_tax_class` | string | Tax class slug |
| `_backorders` | string | `no`, `notify`, `yes` |
| `_virtual` | string | `yes` / `no` |
| `_downloadable` | string | `yes` / `no` |
| `_visibility` | string | `visible`, `catalog`, `search`, `hidden` |
| `_thumbnail_id` | int | Main image attachment ID |
| `_product_image_gallery` | string | Comma-separated attachment IDs |
| `_product_attributes` | serialized | Product attributes config |
| `_default_attributes` | serialized | Default variant attributes |
| `_wholesale_price` | float | Wholesale/purchase price |
| `_post_status` | string | Override post status |

### ShopSync Custom Meta
| Meta Key | Description |
|----------|-------------|
| `_sync_id` | External ERP entity ID |
| `_sync_code` | External code |
| `_sync_fn` | External function/source |
| `_sync_novinka` | Label: new product |
| `_sync_doprodej` | Label: clearance sale |
| `_sync_akce` | Label: on sale |
| `_sync_doporucujeme` | Label: recommended |
| `_sync_sleva` | Label: discount |
| `_sync_pripravujeme` | Label: coming soon |
| `_sync_storage` | Storage/warehouse info |

### Order Meta (legacy, in wp_postmeta)
| Meta Key | Description |
|----------|-------------|
| `_order_currency` | Currency code |
| `_order_total` | Grand total |
| `_order_tax` | Total tax |
| `_order_shipping` | Shipping total |
| `_order_shipping_tax` | Shipping tax |
| `_payment_method_title` | Payment method display name |
| `_billing_first_name` | Billing first name |
| `_billing_last_name` | Billing last name |
| `_billing_company` | Billing company |
| `_billing_address_1` | Billing street |
| `_billing_city` | Billing city |
| `_billing_postcode` | Billing postcode |
| `_billing_country` | Billing country (ISO) |
| `_billing_email` | Billing email |
| `_billing_phone` | Billing phone |
| `_shipping_first_name` | Shipping first name |
| `_shipping_last_name` | Shipping last name |
| `_shipping_company` | Shipping company |
| `_shipping_address_1` | Shipping street |
| `_shipping_city` | Shipping city |
| `_shipping_postcode` | Shipping postcode |
| `_shipping_country` | Shipping country (ISO) |

---

## Taxonomy Tables

### wp_terms
| Column | Type |
|--------|------|
| term_id | bigint(20) PK |
| name | varchar(200) |
| slug | varchar(200) |
| term_group | bigint(10) |

### wp_term_taxonomy
| Column | Type | Description |
|--------|------|-------------|
| term_taxonomy_id | bigint(20) PK | |
| term_id | bigint(20) FK | -> terms.term_id |
| taxonomy | varchar(32) | `product_cat`, `product_tag`, `pa_*`, `product_type`, `product_brand` |
| description | longtext | |
| parent | bigint(20) | Parent term (for hierarchies) |
| count | bigint(20) | Post count |

### wp_term_relationships
Links posts to taxonomy terms.

| Column | Type | Description |
|--------|------|-------------|
| object_id | bigint(20) | Post/product ID |
| term_taxonomy_id | bigint(20) | -> term_taxonomy |
| sync_id | varchar(45) | ShopSync: ERP category ID |

### wp_termmeta
| Column | Type |
|--------|------|
| meta_id | bigint(20) PK |
| term_id | bigint(20) FK |
| meta_key | varchar(255) |
| meta_value | longtext |

**Key taxonomy values:**
- `product_cat` - Product categories
- `product_tag` - Product tags
- `product_type` - `simple`, `variable`, `grouped`, `external`
- `product_brand` - Producer/manufacturer
- `pa_*` - Product attributes (e.g. `pa_color`, `pa_size`)
- `product_visibility` - `outofstock`, `featured`, etc.

---

## Other WooCommerce Tables

### wp_woocommerce_attribute_taxonomies
Product attribute definitions.

| Column | Type | Description |
|--------|------|-------------|
| attribute_id | bigint(20) PK | |
| attribute_name | varchar(200) | Slug (used in `pa_` prefix) |
| attribute_label | varchar(200) | Display label |
| attribute_type | varchar(20) | `select`, `text` |
| attribute_orderby | varchar(20) | Sort order |
| sync_id | varchar(45) | ShopSync: ERP attribute ID |
| sync_unit | varchar(45) | ShopSync: unit of measure |

### wp_wc_product_meta_lookup
Denormalized product data for fast queries.

| Column | Type |
|--------|------|
| product_id | bigint(20) PK |
| sku | varchar(100) |
| virtual | tinyint(1) |
| downloadable | tinyint(1) |
| min_price | decimal(19,4) |
| max_price | decimal(19,4) |
| onsale | tinyint(1) |
| stock_quantity | double |
| stock_status | varchar(100) |
| tax_status | varchar(100) |
| tax_class | varchar(100) |
| total_sales | bigint(20) |

### wp_woocommerce_tax_rates
| Column | Type |
|--------|------|
| tax_rate_id | bigint(20) PK |
| tax_rate_country | varchar(2) |
| tax_rate_state | varchar(200) |
| tax_rate | varchar(8) |
| tax_rate_name | varchar(200) |
| tax_rate_class | varchar(200) |

### wp_wc_customer_lookup
| Column | Type |
|--------|------|
| customer_id | bigint(20) PK |
| user_id | bigint(20) FK |
| username | varchar(60) |
| first_name | varchar(255) |
| last_name | varchar(255) |
| email | varchar(100) |
| country | char(2) |
| postcode | varchar(20) |
| city | varchar(100) |

### wp_wc_order_stats
Denormalized order statistics.

| Column | Type |
|--------|------|
| order_id | bigint(20) PK |
| date_created | datetime |
| num_items_sold | int(11) |
| total_sales | double |
| tax_total | double |
| shipping_total | double |
| net_total | double |
| status | varchar(20) |
| customer_id | bigint(20) |

### shopsync_last
ShopSync sync timestamp tracking.

| Column | Type | Description |
|--------|------|-------------|
| table | varchar(45) PK | Sync operation name |
| dt | datetime | Last sync timestamp |

---

## Key Relationships

```
wp_posts (product) 
  -> wp_postmeta (product data: _sku, _price, _stock, ...)
  -> wp_term_relationships -> wp_term_taxonomy -> wp_terms (categories, attributes, tags)
  -> wp_posts (product_variation, post_parent = product ID)
      -> wp_postmeta (variant data)

wp_wc_orders (HPOS order)
  -> wp_wc_order_addresses (billing + shipping)
  -> wp_wc_order_operational_data (shipping, discounts, dates)
  -> wp_wc_orders_meta (custom fields)
  -> wp_woocommerce_order_items -> wp_woocommerce_order_itemmeta

wp_posts (legacy order, post_type='shop_order')
  -> wp_postmeta (order data: _billing_*, _shipping_*, _order_total, ...)
  -> wp_woocommerce_order_items -> wp_woocommerce_order_itemmeta
```
