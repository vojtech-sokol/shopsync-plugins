---
name: prestashop
description: PrestaShop 8.1 e-shop - database tables, multi-shop/lang patterns, product/order/category sync. Use when user mentions "prestashop" or "presta", or works in project containing `lib/prestashop81/`.
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# PrestaShop 8.1

MySQL database, direct access via `qry()`/`res()`/`numrows()` helpers. Table prefix in `db_prefix` constant (typically `ps_`).

## Key Concepts

- **Multi-shop**: Every entity stored in base table + `_shop` table per `shopid`. Constants: `shopid`, `$shops` array.
- **Multi-language**: Text data in `_lang` tables per `id_lang` AND `id_shop`. Constants: `lang`, `$langs` array.
- **Product matching** (`paircol`): Match by `reference` (SKU) or `ean13`. Checked in both ps_product and ps_product_attribute.
- **Variants**: ps_product_attribute with price/weight as **delta** from base product. Linked to attribute values via ps_product_attribute_combination.
- **Categories**: Nested set tree (nleft/nright). Must call `regenerateTree()` after changes.
- **Stock**: ps_stock_available per product + variant + shop. `id_product_attribute=0` for base product total.
- **Tax classes**: `gettaxclass($vat)` maps VAT rate → `id_tax_rules_group` via config constants.
- **Custom sync columns**: `sync_id`, `sync_code`, `sync_fn`, `guid` added to key tables by ShopSync.
- **Features vs Attributes**: Features = product specs (ps_feature). Attributes = variant options like Color/Size (ps_attribute_group + ps_attribute).

## Save Pattern (3-table pattern)

Every entity insert/update touches 3 tables:
1. Base: `ps_product` / `ps_category` / `ps_feature`
2. Lang: `ps_product_lang` (per lang per shop)
3. Shop: `ps_product_shop` (per shop)

## References

- `references/tables_reference.md` - All table schemas with exact column types and lengths
- `references/library_reference.md` - ShopSync PHP library: classes, field mappings, save/load flows
- `references/schema.sql` - Full DB schema (for column lookups)
