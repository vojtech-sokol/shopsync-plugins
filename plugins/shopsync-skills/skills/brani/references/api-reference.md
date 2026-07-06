# Brani API Reference

Base URL `https://api.brani.cz`, auth `Authorization: Bearer <token>`, JSON in/out. OpenAPI: `https://api.brani.cz/openapi.json` ("Brani Public API"). Fields marked `*` are required. Nullable fields accept `null`.

This file is the condensed overview. The FULL generated reference (every endpoint with all parameters and complete schemas) is in [api-full/INDEX.md](api-full/INDEX.md), split by module.

## Endpoint catalog (by module/tag)

### Brani sprava produktu
| Method | Path | Purpose |
|---|---|---|
| POST | `/products/snapshots/import` | Import product snapshot (multipart gzip JSONL file, field `file`) — async job |
| GET | `/products/snapshots` | List snapshot jobs (poll status here) |
| GET | `/products/snapshots/download/{id}` | Download a snapshot |
| POST | `/products/` | Create/edit a single product (upsert by `guid`) |
| GET / DELETE | `/products/{guid}` | Product detail / delete by GUID |
| GET | `/products/list` | List products |

### Objednávky
| Method | Path | Purpose |
|---|---|---|
| POST | `/order/upsert` | Add or update an order |
| DELETE | `/order/delete` | Delete order by its code |
| POST | `/order/priority` | Change order priority |
| POST | `/order/ordering` | Bulk set order sorting |
| GET/POST/DELETE | `/order/invoice` | Download / upload / delete invoice PDF for an order |
| POST | `/order/customs` | Set customs data by order code |
| GET | `/order/org-tags`, `/order/order-tags/{order_code}` | Tags; POST/DELETE `/order/order-tags` |

### Brani sklad
| Method | Path | Purpose |
|---|---|---|
| GET | `/stock/supplies` | Stock quantities per product code and location (incl. batches) |
| GET | `/stock/movements` | Stock movements |
| GET | `/stock/sectors`, `/stock/locations` | Sectors / positions |
| GET | `/stock/claims` | Stock claims |
| GET | `/stock/document_types` | List movement document types (ids used everywhere) |
| GET | `/stock/movement_documents?date_from=Y-m-d` | List documents (příjemky/výdejky/...) |
| POST | `/stock/movement_documents` | Create document |
| GET / PUT | `/stock/movement_documents/{document_id}` | Detail / edit |
| POST | `/stock/movement_documents/{id}/products` | Add products+prices to existing document |
| POST/GET/DELETE | `/stock/movement_documents/{id}/upload`, `/download/{file_id}`, `/download-all`, `/delete/{file_id}` | Document file attachments |
| GET | `/stock/inventura` / `/stock/inventura/{id}` | Inventory counts list / detail |
| GET | `/stock/order/{order_code}/picked-items` | Picked items of an order |
| GET | `/stock/order/{order_code}/awaiting-stock` | Missing products of an order |
| POST | `/stock/set_eshop_amounts`, `/stock/inventory`, `/stock/inicializace_skladu` | Set eshop amounts / stock at position / init from CSV |

### Purchase orders (vydané objednávky)
| Method | Path | Purpose |
|---|---|---|
| GET | `/stock/purchase_orders?page=&items_per_page=&with_closed=true` | Paginated list |
| POST | `/stock/purchase_orders` | Create |
| GET / PATCH | `/stock/purchase_orders/{id}` | Detail / update |
| GET | `/stock/purchase_orders/statuses`, `/suppliers` | Enumerations |
| POST/PATCH/DELETE | `/stock/purchase_orders/{id}/products` | Manage line items |
| POST | `/stock/purchase_orders/{id}/link_to_receipt/{document_id}` (`unlink_from_receipt`) | Link PO to a receipt document |

### Nákupní seznamy (autoorder)
| Method | Path | Purpose |
|---|---|---|
| GET | `/autoorder/shoplist/list` | Shoplists (no pagination) |
| GET | `/autoorder/shoplist/items/{shoplist_id}` | Shoplist items |
| POST | `/autoorder/shoplist`, `/autoorder/shoplist_item` | Upserts; DELETE `/autoorder/shoplist_item` |
| GET | `/autoorder/product/info[/{eshop_product_code}]`, `/autoorder/order/info/{order_id}`, `/autoorder/{autoorder_id}/suppliers` | Info lookups |

### Brani výroba (manufacture)
| Method | Path | Purpose |
|---|---|---|
| GET | `/manufacture/recipes?recipe_types=assembly,split,customization&page=&items_per_page=` | List active recipes (max 100/page) |
| POST | `/manufacture/recipes` | Create recipe |
| GET / PATCH | `/manufacture/recipes/{recipe_id}` | Detail (incl. inputs/outputs) / update (type immutable). No DELETE exists. |
| GET/POST, GET/PATCH | `/manufacture/orders[/{order_id}]` | Manufacturing orders |
| GET | `/manufacture/log[/{execution_id}]` | Production log |

### Webhooky / other
| Method | Path | Purpose |
|---|---|---|
| GET/POST | `/webhook` | List / register webhook (`event_type`, `url`) |
| PATCH/DELETE | `/webhook/{webhook_id}` | Update URL / delete |
| GET | `/webhook/events/{webhook_id}` (`/xml`, `/general/...`) | Poll stored events |
| GET/POST | `/eshop/info` | Read / update eshop info (statuses, shipping/payment methods) |
| GET/POST/DELETE | `/carriers/*` | Carrier service attributes, `POST /carriers/track-order` |
| POST/GET/DELETE | `/custom-products/*` | Custom products (upsert by `product_guid`) |
| GET/POST/DELETE | `/balic/*` | Storage locations, store items to location, consumables |

## Pagination — three shapes, check per endpoint

1. **Movement documents / purchase orders:** response `{documents|orders: [], page, items_per_page, total_items}`; loop while `page * items_per_page < total_items`. Movement documents list is usually filtered with `?date_from=Y-m-d` instead.
2. **Inventura:** `{entries: [], total_entries, total_pages, page}`; loop while `page < total_pages` (`?page=&per_page=50`).
3. **Recipes:** `{items: [], page, items_per_page, total_items}` (`?page=&items_per_page=100`, max 100).

## Key schemas

### POST /order/upsert — body `{"data": {...}}`
Order `data` (required fields marked *):
- `code*` string — unique order code, `creationTime*` (ISO 8601, must be in the past), `email*`, `phone*`
- `paid` bool, `cashDeskOrder` bool, `vs` string, `externalCode` string, `adminUrl` string
- `companyId` (IČ), `vatId` (DIČ), `taxId` (IČ DPH)
- `billingMethodCode` int (1=Dobírka, 2=Převodem, 3=...), or `paymentMethodGuid` / `shippingGuid` — GUIDs must match methods sent via `POST /eshop/info`
- `shippingDetails` `{branchId, carrierId}` — pickup point delivery
- `billingAddress*` `{fullName*, company, street*, houseNumber, city*, zip*, countryCode* (ISO 3166 alpha-2), district, additional, regionName, companyId, vatId, taxId}`
- `deliveryAddress*` — same shape, all optional except `fullName*`
- `notes*` `{trackingNumber, eshopRemark, customerRemark}`
- `status` `{id*}` — id must match statuses sent via `POST /eshop/info`
- `price*` `{withVat*, toPay*, currencyCode*}` — **strings** (e.g. `"1210.00"`)
- `items*` array:
  - `itemId` int (unique within order), `itemType*` (product, second-hand, service, shipping, payment, discount...), `code*`, `name*`, `variantName`, `productGuid*` (nullable), `amount*` **string**, `amountUnit*` (e.g. "ks"), `weight*` string (kg), `vatRate` string, `itemPriceWithVat` string (total line price), `stockLocation`, `ean`, `image`, `brand`, `supplierName`, `remark`, `buyPrice`, customs fields `content_*`

### Product snapshot JSONL line / POST /products/ — `Product-Input`
- `name*`, `guid*` (UUID string or numeric id), `creationTime*`, `changeTime`, `visibility*` ("visible"), `type` ("product"; sets use `setItems`), `brand` `{code, name}`, `additionalName`, `internalNote`, `images` [], `setItems` []
- `variants*` array of `Variant-Input`:
  - `code*` string, `name`, `weight*` — **string with exactly 3 decimals** (`"0.500"`), `minStockSupply` string, `visible` bool (default true), `manufacturerCode`, `pluCode`, `ean`, `isbn`, `serialNo`, `mpn`, `negativeStockAllowed` string ("no"/"yes", default "no"), `image` (URL, must also be in product `images`), `amountDecimalPlaces` int (default 0; 3 for kg-sold items)
  - `price` `{vatRate, price (with VAT), commonPrice, buyPrice (without VAT)}` — number or string

Snapshot import: gzip the JSONL (one product JSON per line), upload multipart as field `file` (content type `application/gzip`) to `products/snapshots/import/`. Response contains `id` (or `snapshotId`); poll `GET products/snapshots/` for `status`: `completed|done|success` vs `failed|error` (+ `error` message).

### stock/movement_documents
`MovementDocumentCreate` (POST): `document_type_id*` int, `document_number`, `order_number`, `package_number`, `comment`, `status` enum `open|closed|error` (default open), `shipping_cost`, `customs_cost`, `currency` (ISO 4217), `products` `[{amount, product_code, price?}]`.
List response: `{documents: [MovementDocument], page, items_per_page, total_items}` where `MovementDocument` = `{document_id*, document_type_id*, document_number, order_number, package_number, comment, status*, date*, archived, shipping_cost, customs_cost, currency}`.
Detail (`GET .../{id}`) adds `products` `[{product_code, product_name, variant_name, amount, amount_processed, ...}]` and `product_prices` `[{product_code, price}]`. **Use `amount_processed` for closed documents.**
Document type ids are account-specific — enumerate via `GET /stock/document_types`.

### manufacture/recipes
`RecipeCreate`: `name*`, `recipe_type*` (`assembly` = mix inputs into output, `split` = divide input, `customization`), `track_remainder` bool (default false), `notes`, `receipt_document_type_id` int|null, `issue_document_type_id` int|null (both "required for assembly and split" per docs but schema accepts null), `archive_documents` bool (default false), `inputs` `[{product_code*, amount* (number|string), unit (default "ks")}]`, `outputs` `[{product_code*, amount* int}]` (pieces per batch), `remainders` `[{product_code*, unit*}]`.
`RecipeUpdate` (PATCH): all optional; `recipe_type` validation-only (immutable).
List `RecipeResponse` has NO inputs/outputs — fetch detail (`RecipeDetail`) to compare. Recipes have no external code; use a name convention like `"<product_code> - <product_name>"` for matching.

### stock/purchase_orders
`PurchaseOrderCreate`: `name*`, `status_id*`, `supplier_id*`, `document_number*` (nullable), `order_number*` (nullable), `comment*` (nullable), `estimated_delivery_at*` (nullable). List items include `movement_document.document_id`, `supplier.name`, `created_at`. No filter by movement document — page everything and join client-side.

### stock/supplies (GET) — array of `StockSupply`
`{code*, location_name*, amount* int, batches: [{name*, expires_at, amount*}]}` — one row per product code × location; sum `amount` by `code` for totals.

### stock/inventura
List entry: `{id, name, date_end, ...}`; detail `{changes: [{code, before_amount, after_amount}]}` — positive delta → příjemka, negative → výdejka.

### autoorder shoplists
`GET /autoorder/shoplist/list` → `[{shoplist_id, shoplist_state ("ordered"...), shoplist_archived bool, shoplist_date, shoplist_name, document_id}]`.
`GET /autoorder/shoplist/items/{id}` → `[{product_code, eshop_product_code, product_name, amount, in_stock, price}]`.

### webhooks
`POST /webhook` body: `{event_type*, url*}`. `GET /webhook/events/{webhook_id}` → `{webhook_events: [{id, order_code, event_creation, event_status_id, event_package_number, event_order_history, processed, fail_counter, last_errors}], total_items, items_per_page, page}`.
