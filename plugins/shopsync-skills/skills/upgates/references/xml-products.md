# Upgates Products XML Structure

Source: https://docs.upgates.com/import-export/xml/products (import + export feed share the structure).
XSD schema: `https://files.upgates.com/schema/products_v2.xsd`

- Root: `<PRODUCTS version="2.0">` (v1.0 legacy) containing `<PRODUCT>` elements
- Matching key on import: `<CODE>` (existing product updated, unknown code creates new product)
- Language mutations: elements inside `<DESCRIPTIONS>`, `<PRICES>`, image `<TITLES>` etc. carry mandatory `language` attribute (ISO 639-1: cs, sk, en...)
- Dates ISO 8601 (`YYYY-MM-DDTHH:MM`), numbers unformatted (no spaces/currency), HTML in CDATA or entity-encoded

## PRODUCT element

### Identification & flags
- `CODE` - matching key (required)
- `PRODUCT_ID` - internal id (export only)
- `ACTIVE_YN` (0/1), `ARCHIVED_YN`
- `CAN_ADD_TO_BASKET_YN`, `LIMIT_ORDERS` (bool or "sale")

### Descriptions (per language)
```xml
<DESCRIPTIONS>
  <DESCRIPTION language="cs">
    <TITLE>...</TITLE>                      <!-- required for new products, generates URL -->
    <SHORT_DESCRIPTION>...</SHORT_DESCRIPTION>  <!-- plain text -->
    <LONG_DESCRIPTION><![CDATA[...]]></LONG_DESCRIPTION>  <!-- HTML -->
    <URL>...</URL>
  </DESCRIPTION>
</DESCRIPTIONS>
<SEO_OPTIMALIZATION>  <!-- per-language SEO title/description/url ending -->
```

### Categorization
- `CATEGORIES` > `CATEGORY` - `CODE`, `NAME`, primary flag, `POSITION`
- `MANUFACTURER` - text, matched to existing manufacturer
- `GROUPS` - customer group restrictions

### Prices (per language / currency mutation)
```xml
<PRICES>
  <PRICE language="cs">
    <PRICELISTS>
      <PRICELIST>
        <NAME>Výchozí</NAME>
        <PRICE_ORIGINAL>123.45</PRICE_ORIGINAL>   <!-- base price -->
        <PRODUCT_DISCOUNT>10</PRODUCT_DISCOUNT>    <!-- % -->
        <PRICE_SALE>99</PRICE_SALE>                <!-- promo price -->
        <!-- PRICE_WITH_VAT / PRICE_WITHOUT_VAT are export-only computed -->
      </PRICELIST>
    </PRICELISTS>
    <PRICE_PURCHASE>80</PRICE_PURCHASE>
    <PRICE_COMMON>150</PRICE_COMMON>               <!-- common/retail reference -->
  </PRICE>
</PRICES>
<VAT>21</VAT>
```

### Stock & availability
- `STOCK` - quantity; `STOCK_POSITION` - shelf
- `STOCKS` > per-warehouse `<STOCK>` entries (multi-warehouse)
- `AVAILABILITY` - text status matched to availability list ("Skladem")

### Images & files
```xml
<IMAGES>
  <IMAGE>
    <URL>https://...</URL>
    <MAIN_YN>1</MAIN_YN>
    <LIST_YN>0</LIST_YN>
    <TITLES><TITLE language="cs">...</TITLE></TITLES>
    <LANGUAGES>  <!-- per-language visibility -->
  </IMAGE>
</IMAGES>
<FILES>  <!-- same shape: URL + per-language TITLES -->
```

### Parameters & configurations
- `PARAMETERS` > `PARAMETER`: `NAME`, `VALUE`, optional `IMAGE_URL` (informative parameters)
- `CONFIGURATIONS` > `CONFIGURATION type="one_value|more_values|text|separator|file"`: `VALUE` blocks with `NAME`, `IMAGE_URL`, `DEFAULT_YN`, price adjustment (buyer-selected options)

### Variants
```xml
<VARIANTS>
  <VARIANT>
    <CODE>...</CODE>          <!-- required, matching key -->
    <MAIN_YN>1</MAIN_YN>
    <ACTIVE_YN>1</ACTIVE_YN>
    <CAN_ADD_TO_BASKET_YN>1</CAN_ADD_TO_BASKET_YN>
    <PARAMETERS>...</PARAMETERS>   <!-- distinguishing params -->
    <PRICES>...</PRICES>           <!-- same structure as product -->
    <IMAGES>...</IMAGES>
    <STOCK>...</STOCK>
    <METAS>...</METAS>
  </VARIANT>
</VARIANTS>
```
Variant omitted/empty values inherit from the parent product.

### Relations & sets
- `RELATED_PRODUCTS`, `ALTERNATIVE_PRODUCTS`, `ACCESSORIES`, `GIFTS` - reference by product code
- `SETS` - bundles with quantity attributes

### Custom fields
- `METAS` > `META type="radio|checkbox|input|date|email|number|select|textarea|formatted"` with per-language `META_VALUES`
