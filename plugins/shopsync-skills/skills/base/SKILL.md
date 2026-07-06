---
name: base
description: Dev helper for base / base.com platform integration (legacy name "BaseLinker"). base is a hub connecting eshops to marketplaces, WMS, courier services and ERPs. Use when working on shopsync projects that integrate with base - orders, invoices, inventory products, courier packages, returns, CRM clients, external storages, base-connect. Provides API method reference, PHP client patterns, and data structures. Use when user mentions "base", "base.com" or "baselinker" together with shopsync/eshop/orders/invoices context, or works in project containing `lib/baselinker/`.
user-invocable: true
argument-hint: [topic]
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# base / base.com - Dev Helper

base (base.com) — formerly known as **BaseLinker** — is a Polish multi-channel commerce hub that links eshops, marketplaces (Allegro, Amazon, eBay, ...), WMS systems, couriers and ERPs. Single REST endpoint, method-style RPC. The PHP client library and folder structure still use the old "baselinker" name: code lives in `lib/baselinker/` under the `Baselinker` namespace, API host is still `api.baselinker.com`, auth header is still `X-BLToken`. Treat that as legacy naming — the platform itself is now branded "base".

For per-method specs (parameters, response, examples), see [references/api/](references/api/) — one markdown file per method, grouped by category.
For PHP library classes & methods, see [references/library-reference.md](references/library-reference.md).

## Key Files

- `lib/baselinker/inc.php` - `api_post()`, `build_post_fields()`, token constants
- `lib/baselinker/orders.php` - `Baselinker\Orders` (loads orders into ShopSync `$this->data`)
- `lib/baselinker/invoices.php` - `Baselinker\Invoices` (loads invoices; `processCorrectingInvoices()` resolves credit notes against the originating order)
- `lib/baselinker/products.php` - `Baselinker\Products` (writes products + batch stock/price updates to BL inventory)
- `lib/baselinker/products_export.php` - `Baselinker\ProductsExport` (reads products FROM BL inventory)
- `lib/baselinker/categories.php` - `Baselinker\Categories`
- `lib/baselinker/pictures.php` - `Baselinker\Pictures` (`updatePictures()`)
- `lib/baselinker/settings_gen.php` - settings template generator (scans recent orders for payment/shipping method names)
- `lib/baselinker/reset.php` - clears `temp/<profile>_*_last.txt` timestamps

## Script Bootstrap Pattern

```php
include "./config.php";
include "./lib/functions.php";
init();
include "./lib/baselinker/inc.php";
include "./lib/baselinker/orders.php";     // or invoices.php / products.php / ...
```

`inc.php` defines `bl_api_url` and `bl_api_token` constants from config section 8 immediately on include — no explicit auth call needed.

## Authentication & Transport

- **Single endpoint:** `POST https://api.baselinker.com/connector.php`
- **Auth header:** `X-BLToken: <token>` (read from `getCfg(8, "bl_api_token")`)
- **Body** (application/x-www-form-urlencoded):
  - `method` = method name (e.g. `getOrders`)
  - `parameters` = JSON-encoded string of method-specific parameters (`JSON_FORCE_OBJECT`)
- **Rate limit:** 100 requests / minute. `api_post()` enforces `usleep(500000)` (0.5s) between calls and retries up to 5 times on non-2xx, sleeping 5s between attempts.

## Core API Functions (`Baselinker` namespace, `inc.php`)

- `api_post($method, $data, $stripslashes = false)` - posts one method call, returns **decoded array** (`json_decode($output, true)`). Logs the request body to `temp_dir/request.txt`. Returns `false` after 5 failed retries.
- `build_post_fields($data, $existingKeys = '', &$returnArray = [])` - flattens a nested array into PHP-style `key[subkey]` form (rarely used — `api_post` JSON-encodes instead).
- Set `$stripslashes = true` to re-encode `+` as `%2B` in the parameters string (workaround for some BL methods that mishandle raw `+`).

## Response Envelope

Every response is JSON. Success:
```json
{ "status": "SUCCESS", ...method-specific fields... }
```
Error:
```json
{ "status": "ERROR", "error_code": "ERROR_X", "error_message": "..." }
```

`api_post()` logs `chyba <print_r>` when `status != "SUCCESS"` but still returns the decoded payload — callers should check `$res["status"]` themselves if action depends on success.

## Method Categories

Each category lives in `references/api/<category>/`. Full method index in [references/api/README.md](references/api/README.md). Highlights:

| Category | Path | Main methods |
|---|---|---|
| Orders | [api/orders/](references/api/orders/) | `getOrders`, `addOrder`, `setOrderFields`, `setOrdersMerge`, `getOrderTransactionData` |
| Order Products | [api/order-products/](references/api/order-products/) | `addOrderProduct`, `setOrderProductFields`, `deleteOrderProduct` |
| Payments | [api/payments/](references/api/payments/) | `setOrderPayment`, `getOrderPaymentsHistory` |
| Statuses | [api/statuses/](references/api/statuses/) | `getOrderStatusList`, `setOrderStatus(es)` |
| Invoices | [api/invoices/](references/api/invoices/) | `getInvoices`, `addInvoice`, `addInvoiceCorrection`, `getSeries`, `getInvoiceFile`, `addOrderInvoiceFile` |
| Receipts | [api/receipts/](references/api/receipts/) | `getReceipts`, `getNewReceipts`, `addReceipt`, `setOrderReceipt` |
| Orders — other | [api/orders-other/](references/api/orders-other/) | `getOrderSources`, `getOrderExtraFields`, `getJournalList`, `runOrderMacroTrigger` |
| Order Returns | [api/order-returns/](references/api/order-returns/) | `getOrderReturns`, `addOrderReturn`, `setOrderReturnFields` |
| Return Products / Statuses / Payments | [api/return-products/](references/api/return-products/), [api/return-statuses/](references/api/return-statuses/), [api/return-payments/](references/api/return-payments/) | per-line ops |
| Courier Packages / Info / Labels | [api/courier-packages/](references/api/courier-packages/), [api/courier-info/](references/api/courier-info/), [api/courier-labels/](references/api/courier-labels/) | `createPackage(Manual)`, `getLabel`, `getProtocol`, `getCouriersList`, `getCourierFields`, `getCourierServices`, `getCourierAccounts` |
| Parcel Pickups | [api/parcel-pickups/](references/api/parcel-pickups/) | `getRequestParcelPickupFields`, `runRequestParcelPickup` |
| CRM Clients / Statuses | [api/crm-clients/](references/api/crm-clients/), [api/crm-statuses/](references/api/crm-statuses/) | `getCrmClients`, `addCrmClient`, `getCrmClientData` |
| Inventories | [api/inventories/](references/api/inventories/) | `getInventories`, `addInventory`, `deleteInventory` |
| Price Groups / Warehouses / Locations | [api/price-groups/](references/api/price-groups/), [api/warehouses/](references/api/warehouses/), [api/locations/](references/api/locations/) | catalog meta CRUD |
| Categories / Manufacturers / Suppliers / Payers | [api/categories/](references/api/categories/), [api/manufacturers/](references/api/manufacturers/), [api/suppliers/](references/api/suppliers/), [api/payers/](references/api/payers/) | catalog meta CRUD |
| Products | [api/products/](references/api/products/) | `getInventoryProductsList`, `getInventoryProductsData`, `getInventoryProductsStock`, `getInventoryProductsPrices`, `addInventoryProduct`, `deleteInventoryProduct`, `updateInventoryProductsStock`, `updateInventoryProductsPrices`, `getInventoryProductLogs`, `runProductMacroTrigger` |
| Documents (WMS) | [api/documents/](references/api/documents/) | `addInventoryDocument(Items/File)`, `getInventoryDocuments`, `getInventoryDocumentItems`, `setInventoryDocumentStatusConfirmed`, `getInventoryDocumentSeries` |
| Purchase Orders | [api/purchase-orders/](references/api/purchase-orders/) | `addInventoryPurchaseOrder(Items)`, `getInventoryPurchaseOrders`, `setInventoryPurchaseOrderStatus` |
| Fulfillment Deliveries | [api/fulfillment-deliveries/](references/api/fulfillment-deliveries/) | `addInventoryFulfillmentDelivery(Items)`, `getInventoryFulfillmentDeliveries` |
| Inventory — other | [api/inventory-other/](references/api/inventory-other/) | `getInventoryIntegrations`, `getInventoryExtraFields`, `getInventoryTags`, `getInventoryAvailableTextFieldKeys`, `getInventoryPrintoutTemplates` |
| Base Connect | [api/base-connect/](references/api/base-connect/), [api/contractor-credit/](references/api/contractor-credit/) | integrations + B2B credit accounts |
| External Storage | [api/external-storage/](references/api/external-storage/) | read-only access to integrated eshops' product catalog: `getExternalStoragesList`, `getExternalStorageProductsList/Data/Prices/Quantity`, `getExternalStorageCategories`, `updateExternalStorageProductsQuantity` |
| PickPack Carts | [api/pickpack-carts/](references/api/pickpack-carts/) | `getPickPackCarts` |

## Common Pagination Patterns

`getOrders` / `getInvoices` page **by date + id_from**, not by page number — there is no `page` parameter on these. The classes in `lib/baselinker/orders.php` and `invoices.php` advance `id_from = last.order_id + 1` and update the date cursor between batches. BL returns max **100** orders per call.

`getInventoryProductsList`, `getInventoryDocuments`, `getOrderReturns`, etc. **do** use a `page` parameter.

## Key Config Keys (`getCfg(8, ...)`)

- `bl_api_token` - API token (header value)
- `bl_inventory_id` - default inventory for product sync
- `bl_warehouse_id` - default warehouse for stock writes
- `bl_pricelist_id` - default price list for price writes
- `debug` (any section 8 helper) - controls verbose logging

Section 2 = payment-method pairings (eshop → ERP), section 3 = shipping/carrier pairings. Classes match incoming order payment/delivery names via case-insensitive `stripos`, and log `Nesparovana plat./dopr. metoda` when debug ≥ 1.

## Important Conventions

- **Always JSON-encode parameters with `JSON_FORCE_OBJECT`** (the lib does this) — BL refuses bare arrays for object-shaped params.
- **`include_custom_extra_fields` ≠ default.** Pass `"true"` (string) or `1` when you need user-defined order fields. The `Orders` class hardcodes this; standalone callers must remember.
- **Product pair key is `sku`.** `Products::__construct` builds `$product_ids[sku] => id` and `$variants_ids[sku] => parent_id` maps from `getInventoryProductsList` + `getInventoryProductsData`, and caches them to `temp_dir/baselinker_product_ids.json` and `baselinker_variants_ids.json`.
- **Categories pairing** is read from `temp_dir/baselinker_categories_pairing.json` (manually populated, not fetched per run).
- **Batch chunk size = 100** for `updateInventoryProductsStock` / `updateInventoryProductsPrices` in `Products::updateBatchStock/Prices` (`array_slice($to_import, $slice * 100, 100, true)`).
- **Order sources** map name → numeric source IDs. Use `getOrderSources` to build the lookup (the `BlInvoices` example in `scripts/invoices.php` caches `$this->order_sources[$src][$src_id] => $src_name`).
- **Correcting invoices**: BL returns `type == "correcting"` invoices with an `order_id` pointing at the original order. `Invoices::processCorrectingInvoices()` re-fetches the original `normal` invoice by `order_id` and rewrites items — see `references/library-reference.md` for the current semantics and a known limitation around partial returns.
- **`getInvoices` returns net + gross** as `total_price_netto` / `total_price_brutto`. Items expose `price_netto` / `price_brutto` plus `tax_rate` (percent, e.g. `21`).
- **`order_id` vs `invoice_id`** are independent. Pagination on invoices uses `id_from = invoice_id + 1`. Pagination on orders uses `id_from = order_id + 1`.
- **External storage IDs** are prefixed strings like `"shop_1234"`, `"bl_5678"`, `"allegro_..."` — pass them verbatim.

## References

- [references/api/](references/api/) - full per-method documentation (one file per method, ~80 methods total) — mirror of the official BaseLinker docs
- [references/api/README.md](references/api/README.md) - method index by category, with global request info
- [references/library-reference.md](references/library-reference.md) - `lib/baselinker/` PHP classes: properties, methods, customization hooks
