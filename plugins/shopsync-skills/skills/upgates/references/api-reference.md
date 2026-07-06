# Upgates API v2 - Endpoint Reference

Base URL: `https://NAZEV-ESHOPU.admin.ZNACKA-SERVERU.upgates.com/api/v2`
Auth: HTTP Basic (API user from admin, Doplňky / API). Docs: `https://docs.upgates.com/api-reference/{slug}`.

No downloadable OpenAPI/API Blueprint exists. The old Apiary blueprint (upgatesapiv2.docs.apiary.io) is retired; the Zudoku docs site loads its OpenAPI internally via GraphQL. This file is the curated summary; the ORIGINAL full reference (139 endpoints, original Czech descriptions, request/response schemas, examples - extracted from the prerendered docs pages' embedded OpenAPI data on 2026-07-06) lives in `api-full/` - start at `api-full/_index.md`, then read the relevant `api-full/{slug}.json`.

## Rate Limiting (docs.upgates.com/api/rate-limiting)

| Plan | Per hour | Per day | Effective total/day |
|----------|----------|---------|---------------------|
| Bronze | 10 | 100 | 340 |
| Silver | 15 | 300 | 660 |
| Gold | 50 | 600 | 1800 |
| Platinum | 100 | 1500 | 3900 |
| Exclusive| 100 | 1500 | 3900+ (extendable) |

- Add-on packages: +1000 req each (25/h + 400/day), max 60 packages
- Max **3 concurrent requests** (429 when exceeded)
- PUT payload max **100 items** in JSON (413 when exceeded)
- 429 responses carry `Retry-After` header (GMT)
- Tracking headers: `X-Rate-Limit-Hour`, `X-Rate-Limit-Day`, `X-Rate-Limit-Hour-Remaining`, `X-Rate-Limit-Day-Remaining`, `X-Rate-Limit-Total-Remaining`
- Login limiting: 5 failed attempts/hour/IP -> 403

## Pagination

List endpoints: `page` param (default 1), max 100 items/page. Response fields: `current_page`, `current_page_items`, `number_of_items`, `number_of_pages` + the entity array (`products`, `orders`, ...). No `data` wrapper.

## Status

- `GET /api/v2/status` - API health + list of endpoints permitted for the current API user (no permission needed)

## Products (`/api-reference/produkty`)

| Method | Path | Notes |
|--------|------|-------|
| GET | `/products` | full products, paginated; filters `code`, `codes` (`;`-separated), `product_id(s)`, `variant_codes`, `creation_time_from`, `last_update_time_from`, `page` |
| GET | `/products/simple` | lightweight list incl. variants - best for code inventory |
| GET | `/products/{code}` | full detail |
| GET | `/products/{code}/simple` | simplified detail |
| GET | `/products/{code}/prices` | prices of product + variants |
| GET | `/products/{code}/parameters` | parameters |
| GET | `/products/{code}/labels` | labels/badges (štítky) |
| GET | `/products/{code}/files` | attached files |
| GET | `/products/{code}/related` | related/alternative/accessory products |
| PUT | `/products` | update, max 100 items; body `{"products": [...]}` or `{"variants": [...]}` |
| POST | `/products` | create, max 100 items |
| DELETE | `/products` | by `code` / `codes` |
| DELETE | `/products/variants` | by `codes` |
| POST | `/products/{code}/images` | multipart form-data upload (`file`, optional `file_name`) |
| GET | `/products/images-queue` | background image-download queue status |

- Matching key: `code` (product and variant). Variant null fields inherit from parent.
- Price update shape: `{"code": "X", "prices": [{"language": "cs", "pricelists": [{"name": "Výchozí", "price_original": 123.45}]}], "stock": 5}`
- Stock-only update: `{"code": "X", "stock": 5}` - send under both `products` and `variants` keys to cover both.

## Orders (`/api-reference/objednavky`)

| Method | Path | Notes |
|--------|------|-------|
| GET | `/orders` | paginated list |
| GET | `/orders/{order_number}` | detail (response still has `orders` array) |
| GET | `/orders/{order_number}/pdf` | binary PDF |
| PUT | `/orders` | body `{"orders": [...], "send_emails_yn": bool, "send_sms_yn": bool}` |
| POST | `/orders` | create; `external_order_number`, `language_id`, `prices_with_vat_yn`; order_number auto-assigned; customer matched by email |
| DELETE | `/orders` | `order_number` / `order_numbers` |

GET filters: `order_numbers`, `creation_time_from/to`, `last_update_time_from`, `paid_yn`, `delivered_yn`, `status`, `status_id`, `status_ids`, `language`, `email`, `phone`, `external_order_number`, `payment_type`, `shipment_type`, `order_by` (creation_time|last_update_time), `order_dir`, `page`.

Updatable via PUT: `status_id`/`status`, `paid_date`, `delivered_date`, `tracking_code`, `internal_note`, `resolved_yn`, customer data, product quantities, invoice generation flags.

Order object (key fields): `order_number`, `order_id`, `case_number`, `external_order_number`, `uuid`, `language_id`, `currency_id`, `default_currency_rate`, `prices_with_vat_yn`, `status`, `status_id`, `paid_date`, `delivered_date`, `tracking_code`, `tracking_url`, `resolved_yn`, `internal_note`, `creation_time`, `last_update_time`, `variable_symbol`, `total_weight`, `order_total`, `invoice_number`, `admin_url`.
- `customer`: billing fields (`firstname_invoice`, `surname_invoice`, `street`, `city`, `zip`, `country_id`...), postal fields with `_postal` suffix, `company`, `ico`, `dic`, `vat_payer_yn`, `email`, `phone`, `customer_note`, `customer_pricelist_id`
- `products[]`: `product_id`, `option_set_id` (variant id), `code`, `code_supplier`, `ean`, `title`, `quantity`, `unit`, `price_per_unit`, `price_per_unit_with_vat`, `price_per_unit_without_vat`, `vat`, `buy_price`, `recycling_fee`, `weight`, `availability`, `invoice_info`, `parameters[]`, `configurations[]`, `categories[]`, `image_url`
- `discounts`: `discount_voucher` (code/amount/type), `quantity_discount`, `loyalty_points`
- `shipment`: `id`, `code`, `name`, `price`, `vat`, `type`, `affiliate_id`, `packeta_carrier_id`
- `payment`: `id`, `code`, `name`, `payment_method`, `price`, `vat`, `type`
- `attachments[]`, `metas[]` (key/type/value)

## Order statuses (`/api-reference/stavy-objednavek`)

| Method | Path | Notes |
|--------|------|-------|
| GET | `/order-statuses` | `type` filter (18 enum values: Received, Canceled, Sent, PaymentSuccessful, PaymentFailed, Homecredit*...) |
| GET | `/order-statuses/{id}` | detail |
| PUT | `/order-statuses` | `id` + `descriptions` required; `color`, `mark_resolved_yn`, `mark_paid_yn`, `mark_delivered_yn` |
| POST | `/order-statuses` | create custom status |
| DELETE | `/order-statuses/{id}` | delete |

## Categories (`/api-reference/kategorie`)

| Method | Path | Notes |
|--------|------|-------|
| GET | `/categories` | filters: `code`, `codes`, `category_id`, `ids`, `parent_id`, `active_yn`, `creation_time_from`, `last_update_time_from`, `language`, `page` |
| PUT | `/categories` | array of categories, match by `code` or `category_id`; response `updated_yn` |
| POST | `/categories` | create - **parents must be sent before subcategories**; response `inserted_yn` |
| DELETE | `/categories` | by `id` / `ids` / `code` |

## Customers (`/api-reference/zakaznici`)

| Method | Path | Notes |
|--------|------|-------|
| GET | `/customers` | filters incl. email, phone, company, newsletter_yn, times; paginated |
| PUT | `/customers` | batch update; **unique key = email** |
| POST | `/customers` | batch create |
| DELETE | `/customers` | by id(s) or email |
| GET | `/customers/{customer_id}/agreements` | GDPR consents |
| POST | `/customers/login` | verify email+password, returns bool |

## Invoices (`/api-reference/faktury`)

| Method | Path | Notes |
|--------|------|-------|
| GET | `/invoices` | filters: `invoice_numbers`, `creation_time_from/to`, `last_update_time_from`, `paid_yn`, `type` (invoice, creditNote, receipt), `page` |
| GET | `/invoices/{invoice_number}` | detail: dates, amounts, supplier/customer, items, VAT recap |
| GET | `/invoices/{invoice_number}/pdf` | binary PDF |

Read-only - invoices are created via order flags, not directly.

## Webhooks (`docs.upgates.com/webhooks/intro`)

- Managed **only via API** (`/api-reference/webhooky`), bound to the creating API user's permissions
- Events for: orders, order statuses, payments, products, categories, pricelists, customers, shipments, availabilities, documents, labels, languages
- Delivery: HTTP POST, JSON body = list of entity identifiers + `project_name`
- Success = HTTP 200/204 within **1 second**; otherwise retried every 5 minutes
- Source IP = project server IP (admin: Settings / Domains and SSL); no payload signature

## Other resource groups (same CRUD conventions, docs slug in parens)

`aktuality` news, `ceniky` pricelists, `clanky` articles, `dopravy` shipments (GET /shipments), `dostupnosti` availabilities, `jazyky` languages, `kosiky` carts, `konverzni-kody` conversion codes, `nastaveni-eshopu` eshop settings, `objednavky-historie` order history, `objednavky-prilohy` order attachments, `parametry` parameters, `platby` payments (GET /payments), `presmerovani` redirects, `produkty-recenze-a-hodnoceni` reviews, `produkty-seznamy` product lists, `provozovatel-eshopu` shop operator, `radce` advisor, `sklady` warehouses, `skupiny-zakazniku` customer groups, `slevove-kupony` discount coupons, `soubory` files, `stitky` labels, `vlastni-pole` custom fields (metas), `vyrobci` manufacturers, `webhooky` webhooks.

Cross-cutting schemas: `/api-reference/~schemas` (DateTime = ISO 8601, Language = ISO 639-1); endpoint index: `/api-reference/~endpoints`.
