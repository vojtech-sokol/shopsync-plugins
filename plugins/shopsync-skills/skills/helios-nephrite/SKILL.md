---
name: helios-nephrite
description: Dev helper for Helios Nephrite ERP API integration. Use when working on shopsync projects that integrate with Helios Nephrite (not Helios Inuvio or Helios Red) - orders, customers, products, categories. Provides API reference, PHP client patterns, and data structures. Use when user mentions "helios" and "nephrite" in same prompt, or works in project containing `lib/helios_nephrite/`.
user-invocable: true
argument-hint: [topic]
---

# Helios Nephrite API - Dev Helper

Helios Nephrite is an ERP system exposing a REST API (Basic Auth). The PHP client library is in `lib/helios_nephrite/` under the `HeliosNephrite` namespace.

For detailed API reference (endpoints, data structures, class methods), see [references/api-reference.md](references/api-reference.md).
For full endpoint schemas, see [references/swagger.json](references/swagger.json).

## Key Files

- `lib/helios_nephrite/inc.php` - HTTP functions, auth, pagination
- `lib/helios_nephrite/orders.php` - `HeliosNephrite\Orders` class
- `lib/helios_nephrite/customers.php` - `HeliosNephrite\Customers` class
- `lib/helios_nephrite/products.php` - `HeliosNephrite\Products` class

## Script Bootstrap Pattern

```php
include "./config.php";
include "./lib/functions.php";
init();
include "./lib/helios_nephrite/inc.php";
include "./lib/helios_nephrite/orders.php";

$loginResult = HeliosNephrite\api_login();
// ... work ...
HeliosNephrite\api_logout();
```

## Core API Functions

- `api_get($route, $params)` / `api_post` / `api_put` / `api_patch` / `api_delete` - HTTP methods, return JSON string or false
- `api_getAll($route, $params, $pageSize, $dataKey)` - Paginated fetch (Top/Skip), returns merged array
- `api_login()` / `api_logout()` - Auth (config from `getCfg(8, "helios_*")`)

## Main Endpoints

- `api/v1/eshop/orders` (key: `orders`) - GET list, GET by ID, POST create
- `api/v1/eshop/customers` (key: `customers`) - GET search, POST create
- `api/v1/eshop/products` (key: `products`) - GET search

Query params: `Top`, `Skip`, `Filter` (OData), `Timestamp` (unix)

## Important Conventions

- Order `name` field = Shoptet order code
- Extend classes for project-specific logic (override `modifyOrderInsert`)
- Use `getLastUpd` / `setLastUpd` for incremental sync
- Temp files: `temp_dir` constant; logging: `logln()`; config: `getCfg($section, $key, $default)`
