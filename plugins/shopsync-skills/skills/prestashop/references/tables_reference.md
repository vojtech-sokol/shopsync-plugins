# PrestaShop 8.1 - Database Tables Reference

All tables use configurable prefix (typically `ps_`), referenced as `db_prefix` in code.

## Products

### ps_product
```sql
id_product          int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_supplier         int(10) unsigned DEFAULT NULL
id_manufacturer     int(10) unsigned DEFAULT NULL
id_category_default int(10) unsigned DEFAULT NULL
id_shop_default     int(10) unsigned NOT NULL DEFAULT '1'
id_tax_rules_group  int(11) unsigned NOT NULL
on_sale             tinyint(1) unsigned NOT NULL DEFAULT '0'
online_only         tinyint(1) unsigned NOT NULL DEFAULT '0'
ean13               varchar(13) DEFAULT NULL
isbn                varchar(32) DEFAULT NULL
upc                 varchar(12) DEFAULT NULL
mpn                 varchar(40) DEFAULT NULL
ecotax              decimal(17,6) NOT NULL DEFAULT '0.000000'
quantity            int(10) NOT NULL DEFAULT '0'
minimal_quantity    int(10) unsigned NOT NULL DEFAULT '1'
price               decimal(20,6) NOT NULL DEFAULT '0.000000'
wholesale_price     decimal(20,6) NOT NULL DEFAULT '0.000000'
unity               varchar(255) DEFAULT NULL
unit_price_ratio    decimal(20,6) NOT NULL DEFAULT '0.000000'
reference           varchar(64) DEFAULT NULL
weight              decimal(20,6) NOT NULL DEFAULT '0.000000'
width               decimal(20,6) NOT NULL DEFAULT '0.000000'
height              decimal(20,6) NOT NULL DEFAULT '0.000000'
depth               decimal(20,6) NOT NULL DEFAULT '0.000000'
out_of_stock        int(10) unsigned NOT NULL DEFAULT '2'
active              tinyint(1) unsigned NOT NULL DEFAULT '0'
available_for_order tinyint(1) NOT NULL DEFAULT '1'
show_price          tinyint(1) NOT NULL DEFAULT '1'
condition           enum('new','used','refurbished') DEFAULT 'new'
visibility          enum('both','catalog','search','none') DEFAULT 'both'
cache_default_attribute int(10) unsigned DEFAULT NULL
date_add            datetime NOT NULL
date_upd            datetime NOT NULL
product_type        enum('standard','pack','virtual','combinations','') DEFAULT ''
-- Custom sync columns:
sync_id             varchar(45) DEFAULT NULL
sync_code           varchar(45) DEFAULT NULL
sync_storage        varchar(255) DEFAULT NULL
sync_db             varchar(45) DEFAULT NULL
guid                varchar(45) DEFAULT NULL
```

### ps_product_lang
```sql
id_product          int(10) unsigned NOT NULL
id_shop             int(11) unsigned NOT NULL DEFAULT '1'
id_lang             int(10) unsigned NOT NULL
name                varchar(128) NOT NULL
description         text
description_short   text
link_rewrite        varchar(128) NOT NULL
meta_title          varchar(128) DEFAULT NULL
meta_description    varchar(512) DEFAULT NULL
meta_keywords       varchar(255) DEFAULT NULL
available_now       varchar(255) DEFAULT NULL
available_later     varchar(255) DEFAULT NULL
delivery_in_stock   varchar(255) DEFAULT NULL
delivery_out_stock  varchar(255) DEFAULT NULL
PK (id_product, id_shop, id_lang)
```

### ps_product_shop
```sql
id_product          int(10) unsigned NOT NULL
id_shop             int(10) unsigned NOT NULL
id_category_default int(10) unsigned DEFAULT NULL
id_tax_rules_group  int(11) unsigned NOT NULL
on_sale             tinyint(1) unsigned NOT NULL DEFAULT '0'
price               decimal(20,6) NOT NULL DEFAULT '0.000000'
wholesale_price     decimal(20,6) NOT NULL DEFAULT '0.000000'
unity               varchar(255) DEFAULT NULL
unit_price_ratio    decimal(20,6) NOT NULL DEFAULT '0.000000'
active              tinyint(1) unsigned NOT NULL DEFAULT '0'
show_price          tinyint(1) NOT NULL DEFAULT '1'
available_for_order tinyint(1) NOT NULL DEFAULT '1'
visibility          enum('both','catalog','search','none') DEFAULT 'both'
cache_default_attribute int(10) unsigned DEFAULT NULL
date_add            datetime NOT NULL
date_upd            datetime NOT NULL
PK (id_product, id_shop)
```

### ps_product_attribute (variants / combinations)
```sql
id_product_attribute int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_product           int(10) unsigned NOT NULL
reference            varchar(64) DEFAULT NULL
ean13                varchar(13) DEFAULT NULL
isbn                 varchar(32) DEFAULT NULL
upc                  varchar(12) DEFAULT NULL
mpn                  varchar(40) DEFAULT NULL
wholesale_price      decimal(20,6) NOT NULL DEFAULT '0.000000'
price                decimal(20,6) NOT NULL DEFAULT '0.000000'   -- delta from base
weight               decimal(20,6) NOT NULL DEFAULT '0.000000'   -- delta from base
default_on           tinyint(1) unsigned DEFAULT NULL
minimal_quantity     int(10) unsigned NOT NULL DEFAULT '1'
available_date       date DEFAULT NULL
-- Custom sync columns:
guid                 varchar(45) DEFAULT NULL
sync_id              varchar(45) DEFAULT NULL
sync_storage         varchar(45) DEFAULT NULL
```

### ps_product_attribute_shop
Same structure as ps_product_attribute but with `id_shop` and PK (id_product_attribute, id_shop).

### ps_product_attribute_combination
```sql
id_attribute            int(10) unsigned NOT NULL
id_product_attribute    int(10) unsigned NOT NULL
PK (id_attribute, id_product_attribute)
```

## Stock

### ps_stock_available
```sql
id_stock_available      int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_product              int(10) unsigned NOT NULL
id_product_attribute    int(10) unsigned NOT NULL  -- 0 = base product total
id_shop                 int(10) unsigned NOT NULL
id_shop_group           int(10) unsigned NOT NULL
quantity                int(10) NOT NULL DEFAULT '0'
depends_on_stock        tinyint(1) unsigned NOT NULL DEFAULT '0'
out_of_stock            int(10) unsigned NOT NULL DEFAULT '0'
physical_quantity       int(10) NOT NULL DEFAULT '0'
reserved_quantity       int(10) NOT NULL DEFAULT '0'
location                varchar(255) NOT NULL DEFAULT ''
```

## Categories

### ps_category
```sql
id_category         int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_parent           int(10) unsigned NOT NULL
id_shop_default     int(10) unsigned NOT NULL DEFAULT '1'
level_depth         tinyint(3) unsigned NOT NULL DEFAULT '0'
nleft               int(10) unsigned NOT NULL DEFAULT '0'
nright              int(10) unsigned NOT NULL DEFAULT '0'
active              tinyint(1) unsigned NOT NULL DEFAULT '0'
date_add            datetime NOT NULL
date_upd            datetime NOT NULL
position            int(10) unsigned NOT NULL DEFAULT '0'
is_root_category    tinyint(1) NOT NULL DEFAULT '0'
-- Custom sync columns:
sync_id             varchar(45) DEFAULT NULL
sync_fn             varchar(255) DEFAULT NULL
```

### ps_category_lang
```sql
id_category         int(10) unsigned NOT NULL
id_shop             int(11) unsigned NOT NULL DEFAULT '1'
id_lang             int(10) unsigned NOT NULL
name                varchar(128) NOT NULL
description         text
link_rewrite        varchar(128) NOT NULL
meta_title          varchar(255) DEFAULT NULL
meta_keywords       varchar(255) DEFAULT NULL
meta_description    varchar(512) DEFAULT NULL
PK (id_category, id_shop, id_lang)
```

### ps_category_shop
```sql
id_category     int(11) NOT NULL
id_shop         int(11) NOT NULL
position        int(10) unsigned NOT NULL DEFAULT '0'
PK (id_category, id_shop)
```

### ps_category_product
```sql
id_category     int(10) unsigned NOT NULL
id_product      int(10) unsigned NOT NULL
position        int(10) unsigned NOT NULL DEFAULT '0'
PK (id_category, id_product)
```

### ps_category_group
```sql
id_category     int(10) unsigned NOT NULL
id_group        int(10) unsigned NOT NULL
PK (id_category, id_group)
```

## Features / Parameters

### ps_feature
```sql
id_feature      int(10) unsigned NOT NULL AUTO_INCREMENT PK
position        int(10) unsigned NOT NULL DEFAULT '0'
-- Custom sync columns:
sync_id         varchar(45) DEFAULT NULL
sync_unit       varchar(45) DEFAULT NULL
```

### ps_feature_lang
```sql
id_feature      int(10) unsigned NOT NULL
id_lang         int(10) unsigned NOT NULL
name            varchar(128) DEFAULT NULL
PK (id_feature, id_lang)
```

### ps_feature_shop
```sql
id_feature      int(11) unsigned NOT NULL
id_shop         int(11) unsigned NOT NULL
PK (id_feature, id_shop)
```

### ps_feature_value
```sql
id_feature_value int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_feature       int(10) unsigned NOT NULL
custom           tinyint(3) unsigned DEFAULT NULL   -- 0=shared, 1=product-specific
```

### ps_feature_value_lang
```sql
id_feature_value int(10) unsigned NOT NULL
id_lang          int(10) unsigned NOT NULL
value            varchar(255) DEFAULT NULL
PK (id_feature_value, id_lang)
```

### ps_feature_product
```sql
id_feature       int(10) unsigned NOT NULL
id_product       int(10) unsigned NOT NULL
id_feature_value int(10) unsigned NOT NULL
PK (id_feature, id_product, id_feature_value)
```

## Attributes (for variant combinations)

### ps_attribute_group
```sql
id_attribute_group int(11) NOT NULL AUTO_INCREMENT PK
is_color_group     tinyint(1) NOT NULL
group_type         varchar(255) NOT NULL
position           int(11) NOT NULL
```

### ps_attribute_group_lang
```sql
id_attribute_group int(11) NOT NULL
id_lang            int(11) NOT NULL
name               varchar(128) NOT NULL
public_name        varchar(64) NOT NULL
PK (id_attribute_group, id_lang)
```

### ps_attribute
```sql
id_attribute       int(11) NOT NULL AUTO_INCREMENT PK
id_attribute_group int(11) NOT NULL
color              varchar(32) NOT NULL
position           int(11) NOT NULL
```

### ps_attribute_lang
```sql
id_attribute    int(11) NOT NULL
id_lang         int(11) NOT NULL
name            varchar(128) NOT NULL
PK (id_attribute, id_lang)
```

## Orders

### ps_orders
```sql
id_order                int(10) unsigned NOT NULL AUTO_INCREMENT PK
reference               varchar(32) DEFAULT NULL
id_shop                 int(11) unsigned NOT NULL DEFAULT '1'
id_carrier              int(10) unsigned NOT NULL
id_lang                 int(10) unsigned NOT NULL
id_customer             int(10) unsigned NOT NULL
id_cart                 int(10) unsigned NOT NULL
id_currency             int(10) unsigned NOT NULL
id_address_delivery     int(10) unsigned NOT NULL
id_address_invoice      int(10) unsigned NOT NULL
current_state           int(10) unsigned NOT NULL
payment                 varchar(255) NOT NULL
module                  varchar(255) DEFAULT NULL
conversion_rate         decimal(13,6) NOT NULL DEFAULT '1.000000'
total_discounts         decimal(20,6) NOT NULL DEFAULT '0.000000'
total_discounts_tax_incl decimal(20,6) NOT NULL DEFAULT '0.000000'
total_discounts_tax_excl decimal(20,6) NOT NULL DEFAULT '0.000000'
total_paid              decimal(20,6) NOT NULL DEFAULT '0.000000'
total_paid_tax_incl     decimal(20,6) NOT NULL DEFAULT '0.000000'
total_paid_tax_excl     decimal(20,6) NOT NULL DEFAULT '0.000000'
total_paid_real         decimal(20,6) NOT NULL DEFAULT '0.000000'
total_products          decimal(20,6) NOT NULL DEFAULT '0.000000'
total_products_wt       decimal(20,6) NOT NULL DEFAULT '0.000000'
total_shipping          decimal(20,6) NOT NULL DEFAULT '0.000000'
total_shipping_tax_incl decimal(20,6) NOT NULL DEFAULT '0.000000'
total_shipping_tax_excl decimal(20,6) NOT NULL DEFAULT '0.000000'
carrier_tax_rate        decimal(10,3) NOT NULL DEFAULT '0.000'
total_wrapping          decimal(20,6) NOT NULL DEFAULT '0.000000'
total_wrapping_tax_incl decimal(20,6) NOT NULL DEFAULT '0.000000'
total_wrapping_tax_excl decimal(20,6) NOT NULL DEFAULT '0.000000'
invoice_number          int(10) unsigned NOT NULL DEFAULT '0'
invoice_date            datetime NOT NULL
delivery_number         int(10) unsigned NOT NULL DEFAULT '0'
delivery_date           datetime NOT NULL
valid                   int(1) unsigned NOT NULL DEFAULT '0'
date_add                datetime NOT NULL
date_upd                datetime NOT NULL
note                    text
```

### ps_order_detail
```sql
id_order_detail         int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_order                int(10) unsigned NOT NULL
id_order_invoice        int(11) DEFAULT NULL
id_shop                 int(11) unsigned NOT NULL
product_id              int(10) unsigned NOT NULL
product_attribute_id    int(10) unsigned DEFAULT NULL
product_name            text NOT NULL
product_quantity        int(10) unsigned NOT NULL DEFAULT '0'
product_price           decimal(20,6) NOT NULL DEFAULT '0.000000'
product_ean13           varchar(13) DEFAULT NULL
product_isbn            varchar(32) DEFAULT NULL
product_upc             varchar(12) DEFAULT NULL
product_mpn             varchar(40) DEFAULT NULL
product_reference       varchar(64) DEFAULT NULL
product_weight          decimal(20,6) NOT NULL
id_tax_rules_group      int(11) unsigned DEFAULT '0'
tax_name                varchar(16) NOT NULL
tax_rate                decimal(10,3) NOT NULL DEFAULT '0.000'
unit_price_tax_incl     decimal(20,6) NOT NULL DEFAULT '0.000000'
unit_price_tax_excl     decimal(20,6) NOT NULL DEFAULT '0.000000'
total_price_tax_incl    decimal(20,6) NOT NULL DEFAULT '0.000000'
total_price_tax_excl    decimal(20,6) NOT NULL DEFAULT '0.000000'
reduction_percent       decimal(5,2) NOT NULL DEFAULT '0.00'
reduction_amount        decimal(20,6) NOT NULL DEFAULT '0.000000'
original_product_price  decimal(20,6) NOT NULL DEFAULT '0.000000'
```

### ps_address
```sql
id_address      int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_country      int(10) unsigned NOT NULL
id_state        int(10) unsigned DEFAULT NULL
id_customer     int(10) unsigned NOT NULL DEFAULT '0'
alias           varchar(32) NOT NULL
company         varchar(255) DEFAULT NULL
lastname        varchar(255) NOT NULL
firstname       varchar(255) NOT NULL
address1        varchar(128) NOT NULL
address2        varchar(128) DEFAULT NULL
postcode        varchar(12) DEFAULT NULL
city            varchar(64) NOT NULL
phone           varchar(32) DEFAULT NULL
phone_mobile    varchar(32) DEFAULT NULL
vat_number      varchar(32) DEFAULT NULL
dni             varchar(16) DEFAULT NULL
date_add        datetime NOT NULL
date_upd        datetime NOT NULL
active          tinyint(1) unsigned NOT NULL DEFAULT '1'
deleted         tinyint(1) unsigned NOT NULL DEFAULT '0'
```

### ps_order_invoice
```sql
id_order_invoice            int(11) unsigned NOT NULL AUTO_INCREMENT PK
id_order                    int(11) NOT NULL
number                      int(11) NOT NULL
delivery_number             int(11) NOT NULL
total_discount_tax_excl     decimal(20,6) NOT NULL DEFAULT '0.000000'
total_discount_tax_incl     decimal(20,6) NOT NULL DEFAULT '0.000000'
total_paid_tax_excl         decimal(20,6) NOT NULL DEFAULT '0.000000'
total_paid_tax_incl         decimal(20,6) NOT NULL DEFAULT '0.000000'
total_products              decimal(20,6) NOT NULL DEFAULT '0.000000'
total_products_wt           decimal(20,6) NOT NULL DEFAULT '0.000000'
total_shipping_tax_excl     decimal(20,6) NOT NULL DEFAULT '0.000000'
total_shipping_tax_incl     decimal(20,6) NOT NULL DEFAULT '0.000000'
total_wrapping_tax_excl     decimal(20,6) NOT NULL DEFAULT '0.000000'
total_wrapping_tax_incl     decimal(20,6) NOT NULL DEFAULT '0.000000'
note                        text
date_add                    datetime NOT NULL
```

### ps_order_slip (credit notes)
```sql
id_order_slip               int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_customer                 int(10) unsigned NOT NULL
id_order                    int(10) unsigned NOT NULL
conversion_rate             decimal(13,6) NOT NULL DEFAULT '1.000000'
total_products_tax_excl     decimal(20,6) DEFAULT NULL
total_products_tax_incl     decimal(20,6) DEFAULT NULL
total_shipping_tax_excl     decimal(20,6) DEFAULT NULL
total_shipping_tax_incl     decimal(20,6) DEFAULT NULL
amount                      decimal(20,6) NOT NULL DEFAULT '0.000000'
date_add                    datetime NOT NULL
date_upd                    datetime NOT NULL
```

### ps_order_slip_detail
```sql
id_order_slip       int(10) unsigned NOT NULL
id_order_detail     int(10) unsigned NOT NULL
product_quantity    int(10) unsigned NOT NULL DEFAULT '0'
unit_price_tax_excl decimal(20,6) DEFAULT NULL
unit_price_tax_incl decimal(20,6) DEFAULT NULL
total_price_tax_excl decimal(20,6) DEFAULT NULL
total_price_tax_incl decimal(20,6) DEFAULT NULL
PK (id_order_slip, id_order_detail)
```

## Pricing

### ps_specific_price
```sql
id_specific_price       int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_product              int(10) unsigned NOT NULL
id_product_attribute    int(10) unsigned NOT NULL
id_shop                 int(11) unsigned NOT NULL DEFAULT '1'
id_currency             int(10) unsigned NOT NULL
id_country              int(10) unsigned NOT NULL
id_group                int(10) unsigned NOT NULL
id_customer             int(10) unsigned NOT NULL
price                   decimal(20,6) NOT NULL          -- fixed price, -1 = use base
from_quantity           mediumint(8) unsigned NOT NULL
reduction               decimal(20,6) NOT NULL
reduction_type          enum('amount','percentage') NOT NULL
reduction_tax           tinyint(1) NOT NULL DEFAULT '1'
from                    datetime NOT NULL
to                      datetime NOT NULL
```

## Images

### ps_image
```sql
id_image    int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_product  int(10) unsigned NOT NULL
position    smallint(2) unsigned NOT NULL DEFAULT '0'
cover       tinyint(1) unsigned DEFAULT NULL
sync_fn     varchar(255) DEFAULT NULL
```

### ps_image_lang
```sql
id_image    int(10) unsigned NOT NULL
id_lang     int(10) unsigned NOT NULL
legend      varchar(128) DEFAULT NULL
PK (id_image, id_lang)
```

### ps_image_shop
```sql
id_product  int(10) unsigned NOT NULL
id_image    int(11) unsigned NOT NULL
id_shop     int(11) unsigned NOT NULL
cover       tinyint(1) unsigned DEFAULT NULL
PK (id_image, id_shop)
```

## Other Key Tables

### ps_manufacturer
```sql
id_manufacturer int(10) unsigned NOT NULL AUTO_INCREMENT PK
name            varchar(64) NOT NULL
active          tinyint(1) NOT NULL DEFAULT '0'
date_add        datetime NOT NULL
date_upd        datetime NOT NULL
```

### ps_currency
```sql
id_currency     int(10) unsigned NOT NULL AUTO_INCREMENT PK
name            varchar(64) NOT NULL
iso_code        varchar(3) NOT NULL DEFAULT '0'
precision       int(2) NOT NULL DEFAULT '6'
conversion_rate decimal(13,6) NOT NULL
active          tinyint(1) unsigned NOT NULL DEFAULT '1'
```

### ps_carrier
```sql
id_carrier      int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_reference    int(10) unsigned NOT NULL
name            varchar(64) NOT NULL
active          tinyint(1) unsigned NOT NULL DEFAULT '0'
deleted         tinyint(1) unsigned NOT NULL DEFAULT '0'
is_free         tinyint(1) unsigned NOT NULL DEFAULT '0'
```

### ps_country
```sql
id_country      int(10) unsigned NOT NULL AUTO_INCREMENT PK
iso_code        varchar(3) NOT NULL
active          tinyint(1) unsigned NOT NULL DEFAULT '0'
```

### ps_customer
```sql
id_customer     int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_shop         int(11) unsigned NOT NULL DEFAULT '1'
id_default_group int(10) unsigned NOT NULL DEFAULT '1'
company         varchar(255) DEFAULT NULL
firstname       varchar(255) NOT NULL
lastname        varchar(255) NOT NULL
email           varchar(255) NOT NULL
passwd          varchar(255) NOT NULL
active          tinyint(1) unsigned NOT NULL DEFAULT '0'
date_add        datetime NOT NULL
guid            varchar(45) DEFAULT NULL
```

### ps_shop
```sql
id_shop         int(11) NOT NULL AUTO_INCREMENT PK
id_shop_group   int(11) NOT NULL
name            varchar(64) NOT NULL
active          tinyint(1) NOT NULL
```

### ps_accessory (related products)
```sql
id_product_1    int(10) unsigned NOT NULL
id_product_2    int(10) unsigned NOT NULL
sync_id1        int(11) DEFAULT NULL
sync_id2        int(11) DEFAULT NULL
KEY (id_product_1, id_product_2)
```

### ps_pack (bundle products)
```sql
id_product_pack             int(10) unsigned NOT NULL
id_product_item             int(10) unsigned NOT NULL
id_product_attribute_item   int(10) unsigned NOT NULL
quantity                    int(10) unsigned NOT NULL DEFAULT '1'
PK (id_product_pack, id_product_item, id_product_attribute_item)
```

### ps_configuration (key-value settings)
```sql
id_configuration int(10) unsigned NOT NULL AUTO_INCREMENT PK
id_shop          int(11) unsigned DEFAULT NULL
name             varchar(254) NOT NULL
value            text
date_add         datetime NOT NULL
date_upd         datetime NOT NULL
```

## Custom Sync Columns (added by ShopSync install.php)

| Table | Column | Type | Purpose |
|---|---|---|---|
| ps_product | sync_id | varchar(45) | External record ID |
| ps_product | sync_code | varchar(45) | External product code |
| ps_product | sync_storage | varchar(255) | Warehouse code |
| ps_product | sync_db | varchar(45) | Source database |
| ps_product | guid | varchar(45) | GUID |
| ps_product_attribute | sync_id, guid, sync_storage | varchar(45) | Variant sync |
| ps_category | sync_id | varchar(45) | External category ID |
| ps_category | sync_fn | varchar(255) | Synced image filename |
| ps_feature | sync_id | varchar(45) | External feature ID |
| ps_feature | sync_unit | varchar(45) | Unit suffix |
| ps_image | sync_fn | varchar(255) | Synced image filename |
| ps_customer | guid | varchar(45) | GUID |
| ps_accessory | sync_id1, sync_id2 | int(11) | Sync pair IDs |
