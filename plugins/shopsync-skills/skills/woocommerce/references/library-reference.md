# WooCommerce PHP Library Reference

## Database Helpers (lib/woocommerce7/inc.php)

**Namespace:** `WooCommerce`

### readMeta($id, $table, $idreccol, $idcol, $keycol, $valcol)
Read all meta for an entity. Returns associative array `[key => value]`.

```php
$meta = WooCommerce\readMeta($postId);  // reads from wp_postmeta
$meta = WooCommerce\readMeta($orderId, "wc_orders_meta", "id", "order_id");  // HPOS meta
```

### updateMeta($arr, $data, $id, $table, ...)
Insert/update meta records. `$arr` maps meta_key => data field name. Prefix with `#` for literal values.

```php
$map = array(
    "_sku" => "code",           // meta_value = $data["code"]
    "_manage_stock" => "#yes",  // meta_value = "yes" (literal)
    "_stock" => "count",
);
WooCommerce\updateMeta($map, $productData, $postId);
```

---

## Orders - Database (lib/woocommerce7/orders.php)

**Namespace:** `WooCommerce`
**Class:** `Orders`

### Properties
| Property | Default | Description |
|----------|---------|-------------|
| `$data` | `[]` | Loaded orders array |
| `$order` | `null` | Current order being processed |
| `$order_id_column` | `"p.ID"` | Order ID column in SQL |
| `$order_date_column` | `"p.post_date"` | Order date column |
| `$item_paircol` | `"_sku"` | Product matching field |

### Methods
- `load($filter, $last = "1970-01-01")` - Load orders modified after `$last`, batch of 10. Filter is SQL WHERE addition.
- `loadOrder($res, $i)` - Parse single order from result set into internal structure.

### Internal Order Structure
```php
$order = array(
    "id" => post_ID,          // or custom field via pole_cisla_objednavky
    "number" => post_ID,
    "status" => post_status,   // wc-processing, wc-completed, etc.
    "currency_code" => _order_currency,
    "payment" => mapped_payment_method,  // via getCfgs(2)
    "carrier" => mapped_carrier,          // via getCfgs(3)
    "date" => post_date (Y-m-d),
    "datedue" => post_date + 14 days,
    "note" => post_excerpt,
    "total_incl_vat" => _order_total,
    "total_excl_vat" => _order_total - _order_tax,

    "invoice" => array(
        "company" => _billing_company,
        "name" => _billing_first_name + " " + _billing_last_name,
        "street" => _billing_address_1,
        "city" => _billing_city,
        "postcode" => _billing_postcode,
        "country" => _billing_country,
        "phone" => _billing_phone,
        "email" => _billing_email,
        "ic" => custom_field,
        "dic" => custom_field,
    ),
    "delivery" => array(/* same structure from _shipping_* fields */),

    "items" => array(
        array(
            "id" => _sku (or product meta),
            "name" => order_item_name,
            "price" => calculated (incl/excl VAT based on config),
            "count" => _qty,
            "vat" => calculated ratio,
        ),
        // shipping item, coupon item, etc.
    ),
);
```

### Custom field config (via getCfg)
- `pole_cisla_objednavky` - Custom order number meta field
- `pole_var_symbolu` - Variable symbol meta field
- `pole_ic` - Business ID (ICO) meta field
- `pole_dic` - Tax ID (DIC) meta field
- `pole_ic_dph` - VAT ID (IC DPH) meta field
- Payment mapping: `getCfgs(2)` - maps WC payment methods to ERP IDs
- Carrier mapping: `getCfgs(3)` - maps WC shipping methods to ERP IDs

---

## Orders HPOS (lib/woocommerce7/orders_hpos.php)

**Class:** `OrdersHPOS` - extends `Orders`

Same interface but reads from HPOS tables (`wc_orders`, `wc_order_addresses`, `wc_order_operational_data`) joined with `wp_posts` (post_type='shop_order_placehold').

---

## Order Refunds (lib/woocommerce7/order_refunds.php)

**Class:** `OrderRefunds` extends `Orders`

Same as Orders but: reads `post_type='shop_order_refund'`, uses parent order's address data, negates item quantities.

---

## Products - Database (lib/woocommerce7/products.php)

**Namespace:** `WooCommerce`
**Class:** `Products`

### Properties
| Property | Default | Description |
|----------|---------|-------------|
| `$paircol` | `"_sku"` | Product matching meta key |
| `$create_products` | `false` | Create new products if not found |

### Methods
- `save($data)` - Main entry. Iterates data array, calls `saveItem()` per product.
- `saveItem($d)` - Orchestrates: `loadId()` -> `saveGeneral()` -> `setOutOfStock()` -> `callWCProductSave()`
- `loadId($code)` - Find product by SKU. Returns post ID or null.
- `saveGeneral()` - Insert or update post + postmeta.
- `setOutOfStock()` - Sum variant stock, update parent stock status.
- `callWCProductSave()` - HTTP call to `wc_product_save.php?id=X` to regenerate WC lookup tables.

### Field Mapping (postmeta)
```php
// Insert mapping
$map_meta_insert = array(
    "_sku" => "code",
    "_stock" => "count",
    "_manage_stock" => "#yes",
    "_tax_status" => "#taxable",
    "_price" => "price",
    "_regular_price" => "regprice",
    "_sale_price" => "saleprice",
    "_weight" => "weight",
    "_sync_id" => "id",
    "_stock_status" => "_instore",    // "instock"/"outofstock"/"onbackorder"
    "_tax_class" => "_taxclass",       // mapped from VAT rate
    "_backorders" => "_backorders",
);

// Post fields
$map_post = array(
    "post_title" => "name",
    "post_excerpt" => "desc1",
    "post_content" => "desc2",
    "post_status" => "#publish",
);
```

### Stock Status Logic
```php
// _instore derived from count and backorders:
if ($count > 0) -> "instock"
if ($count <= 0 && $backorders) -> "onbackorder"
if ($count <= 0 && !$backorders) -> "outofstock"
```

### Tax Class Mapping
```php
// VAT rate -> WC tax class
standard (21%) -> ""              // default tax class
reduced (15%) -> "taxclasslow"
second reduced (10%) -> "taxclassthird"
zero (0%) -> "taxclassnull"
```

---

## Products Extended (lib/woocommerce7/products2.php)

Extends products.php with:

### Additional Methods
- `setProductType()` - Set `simple` or `variable` via term_relationships
- `saveProducer()` - Create/assign `product_brand` taxonomy
- `saveParameters()` - Create/update `pa_*` attribute taxonomies and terms
- `saveCategories()` - Assign `product_cat` terms by matching `sync_id` in termmeta
- Variant support: creates `product_variation` posts, maps `params2` to variant attributes

### Attribute Storage
```php
// _product_attributes meta (serialized array)
array(
    "pa_color" => array(
        "name" => "pa_color",
        "value" => "",
        "position" => 0,
        "is_visible" => 1,
        "is_variation" => 1,
        "is_taxonomy" => 1,
    ),
)
```

---

## Products - REST API (lib/woocommerce_api/products.php)

**Namespace:** `WooCommerceAPI`
**Class:** `Products`

### Key Differences from Database Version
- Uses REST API (`api_post`, `api_put`) instead of direct SQL
- MD5 hash-based change detection (skips unchanged products)
- Supports tags via REST API
- Preserves existing categories/tags if configured

### Methods
- `save($data)` - Process data, skip unchanged items (MD5 hash comparison)
- `saveItem($d)` - Save via REST API
- `loadId($code)` - Find by SKU (SQL query)
- `saveGeneral()` - POST/PUT to `/products` or `/products/{id}/variations`
- `saveProducer()` - Create/assign brand (direct DB)
- `deactivateProducts($codes, $variants)` - Set status to `private` via API

### REST API Endpoints Used
```
POST   /products                          Create product
PUT    /products/{id}                     Update product
POST   /products/{id}/variations          Create variant
PUT    /products/{id}/variations/{vid}    Update variant
POST   /products/attributes/{id}/terms    Create attribute value
POST   /products/tags                     Create tag
```

### Field Mapping (REST API)
```php
$map_product_insert = array(
    "sku" => "code",
    "name" => "name",
    "type" => "#simple",       // or #variable
    "description" => "desc1",
    "short_description" => "desc2",
    "regular_price" => "_price",
    "categories" => "_categories",   // [{id: X}]
    "attributes" => "_attributes",    // [{id, options, visible, variation}]
    "tags" => "_tags",               // [{id: X}]
    "weight" => "_weight",
);

$map_variant_insert = array(
    "sku" => "option",
    "regular_price" => "_price",
    "attributes" => "_attributes_variant",  // [{id, option}]
);
```

---

## Categories - REST API (lib/woocommerce_api/categories.php)

**Namespace:** `WooCommerceAPI`
**Class:** `Categories`

### Methods
- `getCategoryId($id_erp)` - Find category by `sync_id` in termmeta
- `saveCategories($data)` - Batch save categories
- `saveCategory($d)` - POST/PUT to `/products/categories`

### Matching Pattern
Categories matched by `sync_id` stored in `wp_termmeta` (meta_key='sync_id').

```php
// Find: SELECT term_id FROM termmeta WHERE meta_key='sync_id' AND meta_value='$erp_id'
$wooId = $this->getCategoryId($erpId);
// Create: POST /products/categories {name, parent, meta_data: [{key: "sync_id", value: $erpId}]}
// Update: PUT /products/categories/{$wooId} {name, parent}
```

---

## Parameters - REST API (lib/woocommerce_api/parameters.php)

**Namespace:** `WooCommerceAPI`
**Class:** `Parameters`

### Methods
- `getAttributeId($id_erp)` - Find attribute by `sync_id` in `woocommerce_attribute_taxonomies`
- `saveAttributes($data)` - Batch save attributes
- `saveAttribute($d)` - POST/PUT to `/products/attributes`

---

## Products Export (lib/woocommerce7/products_export.php)

**Namespace:** `WooCommerce`
**Class:** `ProductsExport`

Exports products FROM WooCommerce. Used for reverse sync (eshop -> ERP).

### Methods
- `load($filter, $last)` - Load products in batches of 10
- `loadProduct($res, $i)` - Extract product data with meta, images, attributes
- `downloadImage($imgid, $pid)` - Download product image file
- `modifyProduct($data, $res, $i)` - Hook for custom modifications (override in scripts)

### Exported Structure
```php
$product = array(
    "id" => post_ID,
    "name" => post_title,
    "desc1" => post_content,
    "desc2" => post_excerpt,
    "code" => _sku,
    "ean" => custom_field,
    "price" => _price (excl. VAT),
    "price_vat" => _price (incl. VAT),
    "reg_price" => _regular_price,
    "count" => _stock,
    "weight" => _weight,
    "vat" => set_vat constant,
    "img" => array(image_paths),
    "params" => array(attribute_name => value),
);
```

---

## Common Patterns

### DB + API Hybrid
Products often use REST API for writes (cleaner, handles cache/hooks) but DB for fast lookups:
```php
// Lookup via DB (fast)
$productId = $this->loadId($sku);  // SQL query on postmeta

// Write via API (proper)
WooCommerceAPI\api_put("products/" . $productId, array(), $productData);
```

### Install / Schema Init (install.php)
```sql
CREATE TABLE shopsync_last (
    `table` varchar(45) NOT NULL PRIMARY KEY,
    `dt` datetime
);

ALTER TABLE woocommerce_attribute_taxonomies
    ADD COLUMN sync_id VARCHAR(45) NOT NULL,
    ADD COLUMN sync_unit VARCHAR(45) NULL;

ALTER TABLE term_relationships
    ADD COLUMN sync_id VARCHAR(45) NOT NULL;
```

### Config Sections
- Section 1: Order settings (custom fields, invoice prefix)
- Section 2: Payment method mapping (WC method -> ERP ID)
- Section 3: Shipping method mapping (WC carrier -> ERP ID)
- Section 4: Product settings (EAN field, tax handling)
- Section 8: API connection settings (woo_api_path, credentials)
