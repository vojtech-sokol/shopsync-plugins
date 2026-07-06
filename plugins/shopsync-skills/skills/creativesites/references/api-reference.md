# CREATIVE sites API - Endpoint Reference

Compact list of all REST endpoints. Source of truth: [api-blueprint.apib](api-blueprint.apib). All requests need Basic Auth, JSON body, allowed IP. Default pagination upper bound: `perPage <= 200`.

## Products

| Method | Path | Notes |
|---|---|---|
| GET | `/products/{id}` | Single product detail |
| GET | `/products` | List, params: `page,perPage,list,filterBy,values,from,to`. `list` is comma-separated field whitelist (e.g. `id,sku,variants`, `sku,stock,publish`). `filterBy` accepts top-level columns (`cdate`, `mdate`, `publish`, ...). |
| PUT | `/products/{id}` | Update; body `{ "productList": [ProductUpdate] }`. `currency` is required when updating prices. |
| POST | `/products` | Create; body `{ "productList": [Product] }`. `sku` + `name` + at least one price are required. |
| DELETE | `/products/{id}` | Remove product |
| PUT | `/products/stock` | **Batch stock & availability**, body `{ "stockList": [StockAvail] }`. Each item carries `sku`, `stock`, `isVariant`. Optional: `availability`, `supplierStock`, `stock_type1/2`, `store`, `availableFrom`. |
| PUT | `/products/price` | **Batch price**, body `{ "priceList": [BatchPrice] }`. Each item: `sku`, `sgpId` (shopper group, default 5), `price`, `priceInclVAT`, `currency` (required), `isVariant`. Optional: `oldPrice`, `oldPriceInclVAT`, `purchasePrice`, `purchasePriceInclVAT`. |

Optional product filter parameters (from "Selecting" section): `publish`, `unsaleable`, `permanentlyUnavailable`, `manufacturer`, `primaryCategory`, `availability` — used as `filterBy` value with the matching value in `values`.

`abortOnError` query param on BATCH methods stops the import on the first error (default: continue).

## Orders

| Method | Path | Notes |
|---|---|---|
| GET | `/orders/{id}` | Single order |
| GET | `/orders` | List, params: `page,perPage,filterBy,values,from,to,domain`. Filter examples: `filterBy=cdate&from=2025-01-01`, `filterBy=orderStatus&values=C,P`. `domain` for multidomain shops. |
| PUT | `/orders/{id}` | Update full order, body `{ "orderList": [OrderUpdate] }` |
| PUT | `/orders/status/{id}` | Update single order status: body `{ "orderList": [OrderStatusOnOrder] }` (carries `orderStatus`, `notifyCustomer`, optional `attachDocumentType`) |
| PUT | `/orders/status` | **Batch** status update, body `{ "orderList": [OrderStatusOnOrder] }`. Supports `abortOnError`. |
| POST | `/orders` | Create order, body `{ "orderList": [OrderCreate] }` |
| DELETE | `/orders/{id}` | Remove order (use with care; some states are reserved and can't be removed) |

`POST /ordernotifications` (helper group) — sends mail notification with optional attachments (non-standard).

## Invoices

Three modes:
- **basic** - list of invoice numbers
- **single doc mode** - one document per order (configurable)
- **multi doc mode** - multiple document types per order (`invoice`, `creditnote`, `proforma`, `deliverynote`)

| Method | Path | Notes |
|---|---|---|
| GET | `/invoices/{id}` | Single invoice. Response schema depends on mode (`InvoiceBasic` / `InvoiceSingle` / `InvoiceMulti`). |
| GET | `/invoices` | List |
| PUT | `/invoices/{id}` | Upload invoice file (URL passed in `url`), single or multi-mode |
| POST | `/invoices` | Create new invoice attachment for order |
| DELETE | `/invoices/{id}` | Remove invoice |
| GET | `/invoices/manage/{type}` | Get invoice mode settings for document type |
| GET | `/invoices/manage` | All invoice settings |
| PUT | `/invoices/manage/{type}` | Update settings for document type |
| POST | `/invoices/manage` | Create new settings entry |

## Customers (Users)

| Method | Path | Notes |
|---|---|---|
| GET | `/users/{id}` | Customer detail. Response = `Customer` schema (includes `gdpr` history). |
| GET | `/users` | List, params: `page,perPage,filterBy,values,from,to` |
| PUT | `/users/{id}` | Update; body `{ "customerList": [CustomerNoGdpr] }`. **Note:** shipping `id` required to update existing address; if omitted, a new address is added. |
| POST | `/users` | Create; body `{ "customerList": [CustomerNoGdpr] }`. Shipping `id` not required on create. |
| DELETE | `/users/{id}` | Remove customer |
| POST | `/users/auth` | Authenticate customer (`CustomerAuthNormal` with encrypted password or `CustomerAuthHybrid` for social login) |
| PUT | `/users/discount` | **Batch** individual price discounts: body `{ "discountList": [PriceDiscountUpdate] }` (non-standard) |

Password must be OpenSSL-encrypted + Base64; needs server-side cipher + passphrase config. Send `password` + `initializationVector` both Base64-encoded.

## Coupons

| Method | Path | Notes |
|---|---|---|
| GET | `/coupons/{id}` | Detail |
| GET | `/coupons` | List, optional `filterBy,values,from,to` (e.g. `filterBy=code&values=X`, `filterBy=validFrom&from=...`) |
| GET | `/coupons/archived` | Archived coupons list |
| PUT | `/coupons/{id}` | Update |
| POST | `/coupons` | Create. If no `code` is sent, one is generated automatically. |
| DELETE | `/coupons/{id}` | Archives the coupon (can't be deleted for security reasons) |

Coupon types: `gift` (one-time) / `permanent`. Value types: `percent` / `total`.

## Articles (blog posts)

Added 2026-05-12.

| Method | Path | Notes |
|---|---|---|
| GET | `/articles/{id}` | Article detail |
| GET | `/articles` | List, params: `page,perPage,filterBy,values,from,to`. Filter cols: `cdate`, `mdate`, `access`, `authorId`. |
| PUT | `/articles/{id}` | Update; body `{ "articleList": [ArticleUpdate] }` |
| POST | `/articles` | Create; body `{ "articleList": [ArticleImport] }` |
| DELETE | `/articles/{id}` | Remove |

## URL Lookup

| Method | Path | Notes |
|---|---|---|
| GET | `/urls/{entityType}/{id}` | Get the public URL for the given entity |
| GET | `/urls/{entityType}` | Paginate all URLs of that type, params: `page,perPage` |

Supported `entityType` values: `product`, `category`, `article`, `manufacturer`.

## Product Helpers

### Categories

| Method | Path | Notes |
|---|---|---|
| GET | `/categories/{id}` | Detail |
| GET | `/categories` | List |
| PUT | `/categories/{id}` | Update |
| POST | `/categories` | Create |
| DELETE | `/categories/{id}` | Remove. Only leaf categories can be removed. Deleting a category auto-removes product relations. Root parent = `0`. |

### Special groups (`/groups`)

`GET`, `PUT /{id}`, `POST`, `DELETE /{id}` for sale / new / recommended badges (see `Special` schema).

### Availabilities (`/availabilities`)

`GET`, `PUT /{id}`, `POST`, `DELETE /{id}`. Deleting auto-removes from products / variants.

### Attributes (`/attributes`) — variant attribute definitions

`GET`, `PUT /{id}`, `POST`, `DELETE /{id}`. e.g. "Color", "Size". `loadVariantParams()` in the PHP lib hits this endpoint.

### Parameters (`/parameters`) — product parameters (text spec values)

`GET`, `PUT /{id}`, `POST`, `DELETE /{id}`. e.g. "Fabric", "Material".

### Manufacturers (`/manufacturers`)

`GET`, `PUT /{id}`, `POST`, `DELETE /{id}`.

### Units of measurement (`/uom`)

`GET`, `PUT /{id}`, `POST`, `DELETE /{id}` (`ks`, `m2`, `kg`...).

### Stores (`/stores`)

`GET /{id}`, `GET /stores` (read-only for the public API). Used with non-standard store-level stock.

### Stock types (`/stocktypes`)

`GET /stocktypes` only — enumerates dynamic stock type slugs (`stock_type1`, `stock_type2`).

### OSS product rates (`/ossproductrates`)

`GET /{id}`, `GET`, `POST`. Non-standard. Per-country tax rates for OSS regime.

## Order Helpers

| Endpoint | Methods |
|---|---|
| `/payments` | GET single, GET list, PUT, POST, DELETE |
| `/shippings` | GET single, GET list, PUT, POST, DELETE |
| `/countrycodes` | GET (list of supported country codes) |
| `/orderstates` | GET single, GET list, PUT, POST, DELETE — define custom order statuses. Reserved states can't be removed. |
| `/currencies` | GET single, GET list (with rate, symbol, format) |
| `/ordernotifications` | POST — send custom email about an order (non-standard) |

Both payment and shipping support `translations` and `taxRate`. Shipping has range gating (`zipRangeStart/End`, `weightRange...`, `priceRange...`) and country allowlist.

## Customer Helpers

| Endpoint | Methods | Notes |
|---|---|---|
| `/shoppergroups` | GET single, GET list, PUT, POST, DELETE | Used as `sgpId` everywhere |
| `/gdpr/forms` | GET | Enumerates form IDs (`Checkout=100`, `Newsletter=6`, …) |
| `/gdpr/versions` | GET list, GET single, POST | Stores GDPR text versions per lang |
| `/gdpr/approvals` | POST | Record a customer's GDPR approval |
| `/users/discount` | PUT (batch) | Non-standard — individual SKU discount per customer |

## Static fields

Custom (or dynamic) fields on orders / users / products. Each set has the same shape: `GET /{id}`, `GET`, `PUT /{id}`, `POST`, `DELETE /{id}`.

- `/staticfields/orders` — order-level (`parent: "root"`, `parent: "address > billing"`, etc.)
- `/staticfields/users`
- `/staticfields/products`

`makeDynamic: true` upgrades a static label into a writable column on POST/PUT (currently 256-char string only).

## Webhooks

| Endpoint | Methods | Events |
|---|---|---|
| `/hooks/orders` | GET / GET list / PUT / POST / DELETE | `onOrderCreate`, `onOrderStatusChange`, `onOrderStatusChangeVerbose` |
| `/hooks/users` | GET / GET list / PUT / POST / DELETE | `onCustomerCreate`, `onCustomerChange` |

Order hooks can be scoped via `orderStatus` list (status codes) or `orderMeaning` list (`neutral`/`positive`/`negative`).

## Logs & Errors

| Endpoint | Notes |
|---|---|
| `GET /logs/{date}` | Activity log for the given day. Params: `filterByPhrase`, `filterByMethod`. Now powered by Elasticsearch (2022-10-26). |
| `GET /errorcodes` | All error code descriptions |
| `GET /errorcodes/{id}` | Single error description |

## Allowed HTTP responses

- `200 OK`, `201 Created`, `204 No Content` - success
- `400 Bad Request` - missing / malformed parameters
- `401 Unauthorized` - bad auth header
- `403 Forbidden` - access denied
- `404 Not Found`
- `405 Method Not Allowed`
- `426 Upgrade Required` - feature requires plan upgrade (5xxx error codes)
- `429 Too Many Requests` - rate limited / Semaphore queue exhausted
