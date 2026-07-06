---
name: brani
description: Dev helper for Brani (brani.cz) warehouse/fulfillment (WMS) REST API integration. Use when working on shopsync projects that integrate with Brani sklad/balic - products (JSONL snapshot import), orders (order/upsert), stock movement documents (prijemky/vydejky), stock supplies, inventura, purchase orders, autoorder shoplists, manufacture recipes, carriers, webhooks. Provides API reference, PHP client patterns, and data structures. Use when user mentions "brani" or "brani.cz" or "brani sklad", or works in project containing lib/brani/.
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# Brani - Dev Helper

Brani (brani.cz) is a Czech **warehouse / fulfillment (WMS) platform** — modules "Brani sklad" (warehouse), "Brani Balič" (packing), "Brani výroba" (manufacturing), autoorder (purchasing). ShopSync typically syncs a customer's ERP (usually Pohoda) with Brani: products go IN via snapshot import, orders go IN via `order/upsert`, and warehouse results (closed movement documents, inventura, packed orders) come BACK to generate ERP documents.

- **Base URL:** `https://api.brani.cz` — REST, JSON, `Authorization: Bearer <token>` (token = `getCfg(8, "brani_token")`).
- **OpenAPI spec:** `https://api.brani.cz/openapi.json` (authoritative — fetch it when a schema detail is in doubt).
- **Webhook bridge (separate host):** `https://brani.esync.cz/gethook.php` — esync-side store of Brani webhook events (e.g. `balic_packed`), polled with `brani_eshop_id` + md5 hash auth, NOT the Bearer token.

For the endpoint catalog and key schemas, see [references/api-reference.md](references/api-reference.md).
For PHP client functions, typical sync scripts, and config keys, see [references/integration-patterns.md](references/integration-patterns.md).

## Key Files

### `lib/brani/` (per project)
- `inc.php` — curl transport: `api_get($route, $params)`, `api_post($route, $params, $data)`, `api_post_file($route, $params, $file_path, $field_name)`. **Two flavors exist across projects:**
  - newer (e.g. `brani_pohoda_lyofio`): `namespace Brani;` + extras `api_patch()`, `getStockSupplies()`, `getHooks()`
  - older (e.g. `brani_sklad_pohoda`): global namespace, only the 3 base functions
  Check which flavor the project has before writing `Brani\api_get(...)` vs `api_get(...)`.
- `products.php` — `Brani\Products` class: snapshot import (`save()`, `waitForSnapshotCompletion()`, `mapProductToBraniFormat()`). Some projects inline this flow in `scripts/brani_products.php` instead of using the class.

### `scripts/` (per project, follows shopsync conventions)
- `brani_products.php` — Pohoda store cards → JSONL gzip → `products/snapshots/import/`, poll status; may also sync manufacture recipes.
- `orders.php` — eshop/ERP orders → `order/upsert`.
- `order_states.php` — poll `getHooks("orders", $from, "balic_packed")` → generate ERP invoices for packed orders.
- `brani_prijemka.php` / `brani_vydejka.php` / `brani_inventura.php` — closed `stock/movement_documents` / `stock/inventura` → Pohoda příjemky/výdejky XML.
- `brani2.php` / `brani3.php` — purchase orders and autoorder shoplists → Pohoda issued orders.

## Endpoint Quick Map

| Area | Endpoints |
|------|-----------|
| Products | `POST products/snapshots/import/` (gzip JSONL multipart), `GET products/snapshots/`, `POST products/` (single upsert), `GET/DELETE products/{guid}`, `GET products/list` |
| Orders | `POST order/upsert`, `DELETE order/delete`, `POST order/priority`, `GET/POST/DELETE order/invoice`, order tags |
| Stock | `GET stock/supplies`, `GET stock/movements`, `GET stock/document_types`, `GET/POST stock/movement_documents`, `GET/PUT stock/movement_documents/{id}`, `GET stock/inventura[/{id}]`, `GET stock/order/{code}/picked-items` |
| Purchase orders | `GET/POST stock/purchase_orders`, `GET/PATCH .../{id}`, statuses, suppliers, link_to_receipt |
| Autoorder | `GET autoorder/shoplist/list`, `GET autoorder/shoplist/items/{id}`, upserts |
| Manufacture | `GET/POST manufacture/recipes`, `GET/PATCH manufacture/recipes/{id}`, `manufacture/orders`, `manufacture/log` |
| Webhooks | `GET/POST webhook`, `PATCH/DELETE webhook/{id}`, `GET webhook/events/{id}` |
| Other | `GET/POST eshop/info`, carriers, custom-products, balic |

## Important Conventions

- **Transport returns raw body, never throws.** `api_*()` print `"Pri operaci nastala chyba (HTTP %d)"` on non-200/201 (202 also OK for file upload) and still return the body — callers must `json_decode` and null-check (`if (!$resp || !isset($resp["documents"]))`).
- **Three different pagination shapes** — check per endpoint: movement docs/purchase orders use `documents|orders + page + items_per_page + total_items`; inventura uses `entries + total_entries + total_pages + page`; recipes use `items + total_items`. List of movement documents is usually filtered by `?date_from=Y-m-d` instead of paging.
- **Amounts and prices in order/product payloads are strings** (`"amount": "2.000"`, weight = string with exactly 3 decimals); movement-document `products[].amount` is numeric. Response amounts: use `amount_processed` (not `amount`) on closed document details.
- **Product identity:** `guid` (deterministic via `create_guid("brani" . $code)`), variant `code` = ERP product code (Pohoda `SKz.IDS`). Recipes have NO external code — match by name convention `"<code> - <name>"`.
- **Idempotency is client-side:** synthetic ERP document numbers (`PPRI<document_id>`, `BIP<id>`…), JSON state files (`sent_orders.json`), md5 payload hashes, `getLastUpd`/`setLastUpd` cursors. The API has upsert only for orders/products/shoplists.
- **Config lives in profile settings section 8** ("8. Ostatní"): `brani_token`, `brani_eshop_id`, `debug`, `brani_*_days_back`, `brani_receipt_doc_type_id`/`brani_issue_doc_type_id` (recipes). Read with `getCfg(8, "...")`.
- **Snapshot import is asynchronous** — upload returns `id`/`snapshotId`, then poll `GET products/snapshots/` every ~10 s (max ~30 attempts); terminal statuses `completed|done|success` vs `failed|error`.

## References

- [references/api-reference.md](references/api-reference.md) — condensed endpoint catalog by module, key request/response schemas (order upsert, product/variant, movement documents, recipes, purchase orders, supplies, webhooks), pagination patterns
- [references/integration-patterns.md](references/integration-patterns.md) — PHP client functions, snapshot import flow, typical script patterns from real projects, webhook bridge (gethook), config keys, dedup/idempotency patterns
- [references/api-full/INDEX.md](references/api-full/INDEX.md) — FULL generated API reference (all 98 endpoints with parameters and complete schemas), one file per module: [stock.md](references/api-full/stock.md), [orders.md](references/api-full/orders.md), [products.md](references/api-full/products.md), [manufacture.md](references/api-full/manufacture.md), [autoorder.md](references/api-full/autoorder.md), [webhooks.md](references/api-full/webhooks.md), [carriers.md](references/api-full/carriers.md), [balic.md](references/api-full/balic.md), [custom-products.md](references/api-full/custom-products.md), [eshop-info.md](references/api-full/eshop-info.md), [digital-products.md](references/api-full/digital-products.md). Regenerate with [scripts/gen_api_full.py](scripts/gen_api_full.py) when the spec changes.
