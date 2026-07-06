# PrestaShop 8.1 - ShopSync Library Reference

Library: `lib/prestashop81/`

## Architecture

Direct MySQL database access (not REST API). All classes in `namespace Prestashop`. Uses bridge pattern for remote DB access via encrypted HTTP.

Helper functions: `qry()`, `res()`, `numrows()`, `lastid()`, `logln()`, `sqlSafe()`, `getCfg()`, `getCfgs()`, `gettaxclass()`.

## Classes

### Products (`products.php`)
Server-side class that saves products to PrestaShop DB.

**Key properties:**
- `$paircol = "reference"` - match products by `reference` or `ean13`
- `$langs = [lang]`, `$shops = [shopid]` - multi-lang/shop arrays
- `$id` - current product id, `$patid` - current variant id

**Field mappings** (source data key → DB column):

| Mapping | Table | Fields |
|---|---|---|
| map_insert / map_update | ps_product | reference←code, ean13←EAN, weight←defweight, price←defprice, quantity←count, on_sale←label_clearanceSale, unity←unity, unit_price_ratio←koef |
| map_lang_insert / map_lang_update | ps_product_lang | name←name, description←desc2, description_short←desc1, meta_title←name, meta_description←name, meta_keywords←keywords, available_now←expedition |
| map_shop_insert / map_shop_update | ps_product_shop | price←defprice, unity←unity, unit_price_ratio←koef |
| map_atr_insert | ps_product_attribute | reference←option, ean13←EAN, weight←atrweight, price←defprice |
| map_atr_update | ps_product_attribute | reference←option, ean13←EAN, weight←_weight, price←_price, quantity←count |

**Save flow:**
1. `save($data)` → iterates array
2. `loadId($code)` → finds existing by paircol (reference or ean13), checks both ps_product and ps_product_attribute
3. `saveGeneral()` → INSERT or UPDATE ps_product + ps_product_lang + ps_product_shop, assigns manufacturer, tax class
4. `saveVariant()` → creates/updates ps_product_attribute + attribute groups/values + ps_product_attribute_combination
5. `saveCategories()` → ps_category_product assignments (by sync_id lookup)
6. `savePrices()` → ps_specific_price for group/volume pricing
7. `saveStock()` → ps_stock_available per shop
8. `saveParameters()` → ps_feature_product (empty stub in base, override in scripts)
9. `saveRelated()` → ps_accessory records

### Orders (`orders.php`)
Loads orders from PrestaShop DB (read direction: PS → ERP).

**Key properties:**
- `$paircol = "o.id_order"` or `"o.reference"`
- `$order_date_column = "o.date_add"`
- `$shipping_i`, `$payment_i`, `$coupon_i`, `$wrapping_i` - item indices

**Main SELECT joins:**
ps_orders → ps_address (delivery + invoice) → ps_customer → ps_currency → ps_carrier → ps_country → ps_shop

**Load flow:**
1. `load($filter)` → paginated query (LIMIT start,10)
2. `loadOrder($res, $i)` → extracts: number, date, email, currency, invoice/delivery addresses, payment/carrier mapping via getCfgs()
3. Order items from ps_order_detail with VAT calculation
4. Shipping as special item (code mapped via getCfgs(3))
5. Discounts from ps_order_cart_rule
6. Wrapping costs as special item
7. Order messages from ps_message

**Output data structure per order:**
```
number, idord, date, email, note, currency_code, currency_rate
payment (mapped ID), carrier (mapped ID), payment_orig, carrier_orig
invoice: {company, firstname, lastname, street, city, postcode, country, phone, phone_m, ic, dic, icdph}
delivery: {same structure}
items[]: {code, name, count, price, vat}
```

### Categories (`categories.php`)
Saves categories with nested set tree support.

**Key properties:**
- `$eshop_root_category = 2` - root category ID
- Parent lookup via sync_id in ps_category

**Save flow:**
1. Find existing by sync_id
2. INSERT/UPDATE ps_category (with parent, level_depth, active)
3. ps_category_lang per language (name, description, link_rewrite auto-generated)
4. ps_category_shop per shop
5. ps_category_group permissions
6. After all categories: call `Prestashop\regenerateTree()` to rebuild nleft/nright

### Parameters (`parameters.php`)
Saves product features (parametry).

**Save flow:**
1. Find existing by sync_id in ps_feature
2. INSERT/UPDATE ps_feature + ps_feature_lang + ps_feature_shop
3. Feature values managed via ps_feature_value + ps_feature_value_lang in the products_server script

### Invoices (`invoices.php`)
Same as Orders but joins ps_order_invoice for invoice number/date.

### CreditNotes (`credit_notes.php`)
Loads refunds from ps_order_slip + ps_order_slip_detail. Quantities are negative.

## Helper Functions (inc.php)

### regenerateTree()
Rebuilds category nested set (nleft/nright) by traversing ps_category tree. Must be called after any category changes.

### deactivateProducts($codes, $variants)
Sets active=0 on products whose reference NOT IN the provided codes list. Deletes orphaned product_attribute records.

### maintenence()
Cleans orphaned records:
- ps_specific_price with invalid id_product_attribute
- ps_product_attribute_shop with invalid id_product_attribute
- ps_stock_available with invalid id_product_attribute
- Fixes missing default_on variants
- Updates cache_default_attribute

## Multi-Shop Pattern

Every entity saved to 3 tables:
1. **Base table**: ps_product, ps_category, ps_feature
2. **Language table**: ps_product_lang (per id_lang AND id_shop)
3. **Shop table**: ps_product_shop (per id_shop)

Constants: `shopid` (current shop), `lang` (current language). Arrays `$shops` and `$langs` for multi-shop/lang.

## Tax Class Assignment

Function `gettaxclass($vat_rate)` returns `id_tax_rules_group` based on VAT percentage:
- `set_vat` → `taxclass` (standard rate)
- `set_vatlow` → `taxclasslow` (reduced rate)
- `set_vatthird` → `taxclassthird` (third rate)
- 0 → `taxclassnull` (zero rate)
