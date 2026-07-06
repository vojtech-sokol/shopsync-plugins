# Brani API — Full Reference (generated from openapi.json)

Generated from `https://api.brani.cz/openapi.json` (Brani Public API 0.1.0).
Auth for all endpoints: `Authorization: Bearer <token>`. Regenerate with `scripts/gen_api_full.py` when the spec changes.

| Module | File |
|---|---|
| Autoorder / nákupní seznamy (11 endpoints) | [autoorder.md](autoorder.md) |
| Brani Balič (packing) (5 endpoints) | [balic.md](balic.md) |
| Brani sklad (stock, movement documents, inventura, purchase orders) (34 endpoints) | [stock.md](stock.md) |
| Products (snapshots, single product CRUD) (7 endpoints) | [products.md](products.md) |
| Carriers (dopravci) (5 endpoints) | [carriers.md](carriers.md) |
| Custom products (4 endpoints) | [custom-products.md](custom-products.md) |
| Orders (upsert, invoices, tags, priority, customs) (12 endpoints) | [orders.md](orders.md) |
| Digital products (1 endpoints) | [digital-products.md](digital-products.md) |
| Manufacture (recipes, orders, log) (10 endpoints) | [manufacture.md](manufacture.md) |
| Eshop info (2 endpoints) | [eshop-info.md](eshop-info.md) |
| Webhooks (7 endpoints) | [webhooks.md](webhooks.md) |

Common error response: 422 `HTTPValidationError` — `{"detail": [{"loc": [...], "msg": "...", "type": "..."}]}`. Auth failure: 403 `{"detail": "Not authenticated"}`.