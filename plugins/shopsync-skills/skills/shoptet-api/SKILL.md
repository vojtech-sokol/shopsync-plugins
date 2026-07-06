---
name: shoptet-api
description: Dev helper for Shoptet e-commerce API integration. Use when working on shopsync projects that communicate with Shoptet eshop API - orders, products, categories, customers, invoices, pictures. Provides API reference, PHP client patterns, and data structures. Use when user mentions "shoptet" and "api" together, or works in project containing `lib/shoptet_api/`.
user-invocable: true
argument-hint: [topic]
---

# Shoptet API - Dev Helper

Shoptet is a Czech e-commerce platform with a REST API at `https://api.myshoptet.com`. The PHP client library is in `lib/shoptet_api/` under the `Shoptet` namespace.

For full endpoint schemas, see [references/openapi.json](references/openapi.json).
For detailed class reference, see [references/api-reference.md](references/api-reference.md).

## Key Files

- `lib/shoptet_api/inc.php` - HTTP functions, auth (OAuth token), webhooks, jobs, utilities
- `lib/shoptet_api/orders.php` - `Shoptet\Orders` class (load, changeStatus)
- `lib/shoptet_api/products.php` - `Shoptet\Products` class (save, batch update)
- `lib/shoptet_api/categories.php` - `Shoptet\Categories` class (saveCategories)
- `lib/shoptet_api/customers.php` - `Shoptet\Customers` class
- `lib/shoptet_api/invoices.php` - `Shoptet\Invoices` class
- `lib/shoptet_api/pictures.php` - `Shoptet\Pictures` class (updatePictures)
- `lib/shoptet_api/credit_notes.php` - `Shoptet\CreditNotes` class
- `lib/shoptet_api/proforma_invoices.php` - `Shoptet\ProformaInvoices` class

## Script Bootstrap Pattern

```php
include "./config.php";
include "./lib/functions.php";
init();
include "./lib/shoptet_api/inc.php";
include "./lib/shoptet_api/orders.php";
// Token is obtained automatically on first API call
```

## Core API Functions (Shoptet namespace, inc.php)

- `api_get($route, $params)` - GET request, returns JSON string (auto-retries, handles rate limiting)
- `api_post($route, $params, $data)` - POST request
- `api_put($route, $params, $data)` - PUT request
- `api_patch($route, $params, $data)` - PATCH request
- `api_delete($route, $params)` - DELETE request
- `api_getToken()` - OAuth token management (auto-called, uses `shoptet_id` from config)
- `getHooks($entity, $from)` - Get webhook change notifications
- `getJobStatus($job_id)` - Check async job status (for snapshot exports)
- `prepareProductData($data, $categories)` - Transform product data for Shoptet upload

## Main Endpoints

### Orders
- `GET api/orders` - List (params: `creationTimeFrom`, `changeTimeFrom`, `page`)
- `GET api/orders/{code}` - Detail (include: `notes,shippingDetails,surchargeParameters`)
- `GET api/orders/snapshot` - Async bulk export
- `PATCH api/orders/{code}/status` - Change status (params: `suppressEmailSending`, `suppressSmsSending`)
- `PATCH api/orders/{code}/notes` - Update tracking number
- `GET api/orders/changes` - Webhook-style change list

### Products
- `GET api/products` - List with pagination
- `POST api/products` - Create product
- `PATCH api/products/batch` - Batch update
- `GET api/products/code/{code}` - Get by code
- `PATCH api/products/code/{code}` - Update by code
- `GET api/products/snapshot` - Async bulk export

### Categories
- `GET api/categories` - List all
- `POST api/categories` - Create
- `PATCH api/categories/{guid}` - Update
- `DELETE api/categories/{guid}` - Delete

### Customers, Invoices, Credit Notes, Proforma Invoices
- All follow same pattern: list, detail, snapshot, changes endpoints

## Response Format

All responses wrapped in `{"data": {...}}`:
```json
{"data": {"order": {...}}}
{"data": {"orders": [...]}, "paginator": {"page": 1, "pageCount": 5}}
```

## Important Conventions

- Auth: OAuth token via `shoptet_id` config key, auto-refreshed
- Rate limiting: built-in sleep (2.5s between write calls), auto-retry on 429
- Snapshot pattern: request snapshot -> poll job status -> download gzipped JSON
- Order codes are the primary identifier (e.g. `2024000123`)
- Config: `getCfg($section, $key)` - section 8 for API settings
- All write operations (`api_post/put/patch`) have 2.5s delay built in
