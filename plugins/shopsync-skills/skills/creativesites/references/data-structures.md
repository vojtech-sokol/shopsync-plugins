# CREATIVE sites API - Data Structures

Lifted from the API Blueprint (`api-blueprint.apib`, "Data Structures" section). Fields marked `required` are mandatory on POST. `*Update` variants relax most required-ness; `*Create` variants are write-only shapes.

## Product

| Field | Type | Notes |
|---|---|---|
| `id` | number | Product ID (read-only from server) |
| `sku` | string (**required**) | Product code (primary match key) |
| `ean` | string | EAN |
| `name` | string | Product name |
| `sef` | string | Slug for URL |
| `description` | string | Full description |
| `shortDescription` | string | Short description |
| `mainImage` | string | URL — server downloads it |
| `imageList` | array[string] | Secondary image URLs |
| `imagesDesc` | string | Alt text for secondary images |
| `publish` | bool | Visibility |
| `unsaleable` | bool | Show but block purchase |
| `permanentlyUnavailable` | bool | |
| `availability` | number | `Availability.id` |
| `availableFrom` | string `YYYY-MM-DD` | |
| `specialGroupList` | array[number] | `Special.id` list |
| `cdate` / `mdate` | string `YYYY-MM-DD HH:MM:SS` | |
| `manufacturer` | number | `Manufacturer.id` |
| `primaryCategory` | number | `Category.id` |
| `categories` | array[number] | `Category.id` list |
| `autoAssignParents` | bool | Auto-assign to all parent categories |
| `stock` | number | Default warehouse stock |
| `supplierStock` | number | Non-standard |
| `stock_type1`, `stock_type2` | number | Dynamic stock types (see `/stocktypes`) |
| `weight` | number | |
| `weightUnit` | string | `kg`, `pounds` |
| `uomId` | number | `Uom.id` |
| `taxRate` | number | VAT % |
| `virtualVariantId` / `virtualVariantName` | string | |
| `activeVariants` | array[string] | Variant codes |
| `variants` | array[Variant] | |
| `parameters` | array[Parameter] | |
| `priceList` | array[Price] | One per shopper group |
| `metaTitle` / `metaDesc` / `metaKeywords` | string | SEO |
| `translations` | object keyed by lang | `name`, `sef`, `shortDescription`, `description`, `metaTitle`, `metaDesc`, `metaKeywords` per language |
| `store` | array[ProductStore] | Non-standard, per-store stock |
| `set` | array[Set] | Non-standard, product set/bundle items |
| `imageMetaData` | object | Non-standard, image mdate |
| `shippingBlacklist` | array[number] | Non-standard, `Shipping.id` list |

## Variant

| Field | Type | Notes |
|---|---|---|
| `code` | string (**required**) | Variant code (used for stock/price pairing) |
| `ean` | string | |
| `stock` | number | |
| `supplierStock` | number | Non-standard |
| `price` | number | |
| `priceInclVAT` | number | |
| `oldPrice` / `oldPriceInclVAT` | number | RRP / strike-through price |
| `availability` | number | |
| `weight` | number | |
| `availableFrom` | string | Non-standard for variants |
| `localImagePath` | string | Existing image in Media manager, e.g. `/images/...jpg` (non-standard) |
| `values` | array[VariantValue] (**required**) | Attribute values for this variant |
| `store` | array[ProductStore] | Non-standard |

### VariantValue
- `id` (number, **required**) — Attribute ID; custom text attrs use string `"custom_X"`
- `name` (string) — Attribute name (e.g. `Size`)
- `value` (string, **required**) — Concrete value (e.g. `XL`)

## Parameter (product spec)
- `id` (number, **required**) — `Parameter.id`
- `type` (number) — `0` = text (only type currently)
- `name` (string) — e.g. `Fabric`
- `value` (string, **required**) — e.g. `100% Cotton`
- `translations.<lang>.{ name, value }`

## Price / PriceUpdate
- `sgpId` (number, **required**) — Shopper group ID (default retail = `5`)
- `price` (number, **required** on POST) — net price
- `priceInclVAT` (number) — gross price
- `oldPrice` / `oldPriceInclVAT` (number) — RRP
- `purchasePrice` / `purchasePriceInclVAT` (number)
- `currency` (string, **required** for updates since 2021-09-13) — e.g. `EUR`, `CZK`

## Category
- `id` (number)
- `parent` (number, **required**) — root = `0`
- `name` (string, **required**)
- `sef` (string)
- `publish` (bool)
- `order` (number) — sort key (no value = first)
- `image` (string) — URL
- meta + translations

## Special (group)
`id`, `name` (required), `productCount` (read-only).

## Availability
`id`, `name` (required), `pricePortalDays`, `translations.<lang>.name`.

## Attribute (variant attribute definition)
`id`, `name` (required), `translations.<lang>.name`.

## ParameterName
`id`, `type` (required, only `0`), `name` (required), `translations.<lang>.name`.

## Manufacturer
`id`, `name` (required), `translations.<lang>.name`.

## Order

| Field | Type | Notes |
|---|---|---|
| `id` | number (**required**) | |
| `cdate` / `mdate` | string | Creation / modification |
| `note` | string | Customer note |
| `adminNote` | string | Internal note |
| `orderStatus` | string | Status code, e.g. `C` |
| `currency` | string (**required**) | |
| `currencyRate` | number (**required**) | |
| `customerId` | number (**required**) | |
| `invoiceNumber` | string (**required**) | When exists |
| `subtotalPrice` | number | net total of items |
| `totalPrice` | number (**required**) | gross total = subtotal + tax + shipping + payment - discount |
| `tax` | number (**required**) | Includes shipping + billing tax |
| `address.billing` | BillingAddress (**required**) | |
| `address.shipping` | OrderShippingAddress | |
| `address.customerStaticFields` | object | |
| `items` | array[OrderItem] (**required**) | |
| `payment` | OrderPayment (**required**) | |
| `shipping` | OrderShipping (**required**) | |
| `discount` | Discount | |
| `voluntaryContribution` | number | |
| `creditDiscount` | number | |
| `cashPaymentRounding` | number | Auto-added when payment has `isCash: true` |
| `ship_id` | string | Tracking ID |

`OrderCreate` and `OrderUpdate` are leaner; `OrderCreate.items` uses `OrderItemCreate`, etc.

## OrderItem
- `id` (number, required) — Product ID
- `itemId` (number) — Order item ID (required for update)
- `sku` (string, required)
- `ean`, `name`
- `quantity` (number, required)
- `uom` (string) — Unit of measurement
- `price` (number, required) — Unit price excluding VAT
- `priceInclVAT` (number)
- `taxRate` (number, required) — percent
- `isVariant` (bool, required)
- `url` (string)
- `values` (VariantValue) — only for variant items
- `itemNote` (string) — non-standard

## BillingAddress
`name`, `surname`, `email`, `phone`, `street`, `city`, `zip`, `countryCode` (all required), plus optional `country`, `company`, `ico`, `dic`, `icDph`.

Phone validation: max 16 chars; allowed `0-9 + space / - –`; `/ - –` are normalized to space.

## ShippingAddress (customer)
`id` (for update), `default` (preselected on checkout), `addressName`, then same shape as BillingAddress (sans tax IDs).

## OrderShippingAddress
Same as ShippingAddress but without `default`.

## OrderPayment / OrderShipping (in order body)
- `OrderPayment`: `id` (req), `name`, `value` (req), `cod` (req), `transactionDetails` (read-only — GoPay etc.)
- `OrderShipping`: `id` (req), `name`, `value` (req), `deliveryPointId`, `externalDeliveryPointId`, `taxRate`

## Payment (helper)
`id`, `name` (req), `value` (req), `valueType` (req: `percent`|`total`), `cod`, `publish`, `allowedShopperGroup`, `isCash`, `translations`.

## Shipping (helper)
`id`, `name` (req), `publish`, `value` (req), `packageFee`, `zipRangeStart/End`, `weightRangeStart/End`, `priceRangeStart/End`, `allowedShopperGroups`, `allowedPaymentMethods`, `allowedCountries`, `translations`, `taxRate`.

## Discount / DiscountCreate
- Discount: `code` (string), `value` (number, **required**)
- DiscountCreate: `value` (number, **required**)

## OrderHook
- `id`, `event` (req, enum: `onOrderCreate` / `onOrderStatusChange` / `onOrderStatusChangeVerbose`)
- `active` (bool, req), `url` (string, req)
- `orderStatus` (array[string]) — limit hook to these status codes
- `orderMeaning` (array[string]) — `neutral` / `positive` / `negative`
- `cdate`, `mdate`

## CustomerHook
- `id`, `event` (req, enum: `onCustomerCreate` / `onCustomerChange`)
- `active`, `url`, `cdate`, `mdate`

## OrderStatus (definition)
`id`, `name` (req), `code` (req, e.g. `C`), `color` (hex without `#`), `meaning` (req — `neutral`/`positive`/`negative`), `orderCount`, `reserved` (true ⇒ can't be removed), `translations.<lang>.name`.

## StaticField
- `id` (number)
- `parent` (string, req) — `root` or `address > billing` etc.
- `label` (string, req) — column name
- `value` (string)
- `makeDynamic` (bool) — when true, label becomes a writable column
- `cdate`, `mdate`

## Invoice variants
- `InvoiceBasic`: `id` (req), `invoiceNumber` (req), `cdate`, `dueDays`
- `InvoiceSingle`: `id`, `url` (download/upload URL), `cdate`
- `InvoiceMulti`: `id`, `files: array[InvoiceFiles]`
- `InvoiceFiles`: `documentType` (`invoice`/`creditnote`/`proforma`/`deliverynote`), `url`, `cdate`

## StockAvail (batch stock body item)
- `id`, `sku` (req), `publish`, `availability`
- `stock` (req), `supplierStock`, `stock_type1`, `stock_type2`
- `availableFrom`, `isVariant` (req)
- `store` (array[ProductStore])

## BatchPrice (batch price body item)
- `id`, `sku` (req), `sgpId` (req)
- `price`, `priceInclVAT`, `oldPrice`, `oldPriceInclVAT`, `purchasePrice`, `purchasePriceInclVAT`
- `currency` (req), `isVariant` (req)

## Customer
- `id` (req), `active`, `cdate`, `mdate`
- `email` (req)
- `socialLogin` (array[SocialLogin])
- `sgpId`, `sgpName`
- `domain` (for multidomain shops)
- `address.billing` (BillingAddress, req), `address.shipping` (array[ShippingAddress])
- `gdpr.items` (array[Gdpr])
- `priceDiscount` (array[PriceDiscount]) — non-standard

`CustomerNoGdpr` adds writable `password` + `initializationVector` (Base64 + OpenSSL encrypted) but drops `gdpr`.

### PriceDiscount / PriceDiscountUpdate
- `identifier` (req) — SKU (or SKU prefix when `isPrefix: true`)
- `discountValue` (req)
- `isPrefix` (req)
- `userId` (req on `PriceDiscountUpdate`)

### SocialLogin
- `hybridAuthIdentifier` (req)
- `provider` (req) — `google` | `facebook` | `apple`

## Coupon
- `id`, `archived`, `code`
- `percentOrTotal` (req) — `percent` / `total`
- `type` (req) — `gift` / `permanent`
- `value` (req), `cdate`, `note`, `validFrom`, `validTo`, `minOrderValue`, `currency`

## Article (blog post, added 2026-05-12)
- `id`, `title`, `perex`, `content`, `sef` (absolute URL on read, slug on import)
- `mainImage`, `authorId`, `author`
- `access` — `public` / `registered` / `administrator`
- `visibleFrom`, `visibleTo` (nullable)
- `hiddenOnDomains` (array[string])
- `metaTitle`, `metaDesc`, `metaKeywords`
- `cdate`, `mdate`
- `translations.<lang>.{ title, perex, content, sef, metaTitle, metaDesc, metaKeywords }`

`ArticleImport.title` and `authorId` are required; SEF auto-generated from title.

## Currency
`id`, `code`, `name`, `rate`, `symbol` (HTML entity), `decimals`, `decimalSymbol`, `thousandSymbol`.

## Store / ProductStore (non-standard)
- Store: `id`, `store`, `street`, `city`, `zip`, `country`, `active`
- ProductStore: `storeId` (req), `storeName`, `stock` (req)

## Uom
`id`, `name` (req — e.g. `m2`, `ks`), `productCount`.

## OrderNotification
- `orderId` (req), `subject` (req), `body` (req — HTML supported)
- `attachments` (array[string] of URLs)

## Set / SetUpdate (product set / bundle)
- `productId` (req), `sku`
- `price` (req for Set), `priceType` — `percent` / `total` / `subtract`
- `quantity` (req for Set)
- `visible` (req for Set) — show on parent page

## OrderStatusOnOrder (status change body item)
- `id` (req, order ID)
- `orderStatus` (req)
- `notifyCustomer` (req)
- `attachDocumentType` — `invoice` / `creditnote` / `proforma` / `deliverynote` (non-standard)

## StockTypes
Just a name-mapping of `stock1`, `stock2` to slugs (`stock_type1`, …).

## InvoiceSettings
- `invoice.documentType` (req) — `invoice` / `creditnote` / `proforma` / `deliverynote`
- `invoice.attachmentStatusList` (req) — whitelist of order states that auto-attach
- `invoice.iconSuffix` — visual icon modifier in admin

## OssProductRateList
- `id` (req, product ID), `sku`, `countryCode` (req), `taxRate` (req, 0–100)

## Gdpr / GdprForms / GdprVersion / GdprApproval
- `Gdpr`: `id` (req), `date` (req), `version` (req), `formId` (req), `formName`
- `GdprForms`: enum map (`6 = Module Newsletter`, `100 = Checkout`, …)
- `GdprVersion`: `id`, `cdate` (req), `lang` (req), `gdprText` (req, HTML)
- `GdprApproval`: `gdprVersion` (req), `formId` (req), `email` (req), `cdate` (req)

## CountryCodes (subset shown)

ISO-3 codes. Full list in apib. Most common:
`AUT`, `BEL`, `BIH`, `BGR`, `HRV`, `CZE`, `DNK`, `EST`, `FIN`, `FRA`, `DEU`, `GBR`, `HUN`, `ISL`, `IRS`, `ITA`, `LVA`, `LIT`, `LUX`, `HOL`, `NOR`, `OTH`, `PLN`, `POR`, `ROM`, `SRB`, `SVK`, `SVN`, `ESP`, `SWE`, `CHE`, `TUN`, `TUR`.

> Beware some are non-standard: `LIT` (not LTU), `PLN` (not POL), `POR` (not PRT), `ROM` (not ROU), `HOL` (not NLD), `IRS` (not IRL), `GUO`. Use `inc.php::convertCountryCode()` to map ISO-2 ↔ these codes — it handles the standard ISO-3166-1 alpha-3 set.

## ErrorCodes — quick reference

| Range | Meaning |
|---|---|
| `1xxx` | resource already exists |
| `2xxx` | resource doesn't exist |
| `3xxx` | validation failure |
| `4xxx` | limit / range exceeded |
| `5xxx` | feature requires plan upgrade |
| `6xxx` | required permission / param missing |
| `9xxx` | custom (export-related) |

Selected common ones:

| Code | Message |
|---|---|
| 1001 | Product with given sku already exists |
| 1014 | Coupon with given code already exists |
| 2001 | Product doesn't exist |
| 2010 | Variant doesn't exist |
| 2017 | Order doesn't exist |
| 2020 | Customer doesn't exist |
| 3001 | Product data validation failed |
| 3014 | Phone validation failed |
| 3018 | Invalid datetime format |
| 4001 | PerPage range exceeded (> 200) |
| 4003 | Only one price per shopper group is allowed |
| 4004 | Only categories with no sub-categories can be removed |
| 4008 | Item is out of stock |
| 4010 | Maximum documents per order reached |
| 5001 | Setting unavailable, upgrade is required |
| 5002 | Endpoint unavailable |
| 6001 | Product SKU required (store availabilities) |
| 9001 | No suitable items to export |

Full list — see Data Structures > ErrorCodes in [api-blueprint.apib](api-blueprint.apib).
