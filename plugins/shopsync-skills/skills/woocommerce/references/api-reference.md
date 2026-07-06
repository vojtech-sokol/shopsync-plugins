# WooCommerce REST API v3 Reference

Base URL: `/wp-json/wc/v3/`

## Authentication

**Over HTTPS (Basic Auth):**
```
curl https://example.com/wp-json/wc/v3/orders -u consumer_key:consumer_secret
```
Alternative: `?consumer_key=ck_xxx&consumer_secret=cs_xxx`

**Over HTTP:** OAuth 1.0a required (HMAC-SHA1/HMAC-SHA256). Timestamp within 15 minutes.

**API Keys:** Generated via WooCommerce > Settings > Advanced > REST API (Read, Write, or Read/Write).

## Endpoints Overview

### Core Resources (all support CRUD + Batch)

| Resource | List/Create | Single | Batch |
|----------|-------------|--------|-------|
| Orders | `GET/POST /orders` | `GET/PUT/DELETE /orders/{id}` | `POST /orders/batch` |
| Products | `GET/POST /products` | `GET/PUT/DELETE /products/{id}` | `POST /products/batch` |
| Product Variations | `GET/POST /products/{id}/variations` | `GET/PUT/DELETE /products/{id}/variations/{vid}` | `POST /products/{id}/variations/batch` |
| Product Attributes | `GET/POST /products/attributes` | `GET/PUT/DELETE /products/attributes/{id}` | `POST /products/attributes/batch` |
| Attribute Terms | `GET/POST /products/attributes/{id}/terms` | `GET/PUT/DELETE /products/attributes/{id}/terms/{tid}` | `POST /products/attributes/{id}/terms/batch` |
| Product Categories | `GET/POST /products/categories` | `GET/PUT/DELETE /products/categories/{id}` | `POST /products/categories/batch` |
| Product Tags | `GET/POST /products/tags` | `GET/PUT/DELETE /products/tags/{id}` | `POST /products/tags/batch` |
| Customers | `GET/POST /customers` | `GET/PUT/DELETE /customers/{id}` | `POST /customers/batch` |
| Coupons | `GET/POST /coupons` | `GET/PUT/DELETE /coupons/{id}` | `POST /coupons/batch` |
| Tax Rates | `GET/POST /taxes` | `GET/PUT/DELETE /taxes/{id}` | `POST /taxes/batch` |
| Webhooks | `GET/POST /webhooks` | `GET/PUT/DELETE /webhooks/{id}` | `POST /webhooks/batch` |

### Order Sub-resources
- `GET/POST /orders/{id}/notes`, `GET/DELETE /orders/{id}/notes/{nid}`
- `GET/POST /orders/{id}/refunds`, `GET/DELETE /orders/{id}/refunds/{rid}`

### Other Resources
- Payment Gateways: `GET /payment_gateways`, `GET/PUT /payment_gateways/{id}`
- Shipping Zones: `GET/POST /shipping/zones`, zone locations, zone methods
- Reports: `GET /reports`, `/reports/sales`, `/reports/top_sellers`
- Settings: `GET /settings`, `GET /settings/{group}`, `GET/PUT /settings/{group}/{id}`
- System Status: `GET /system_status`
- Data: `GET /data/countries`, `/data/currencies`, `/data/currencies/current`

## Common Query Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `page` | int | Page number (default: 1) |
| `per_page` | int | Items per page (default: 10) |
| `search` | string | Search term |
| `exclude` | array | Exclude IDs |
| `include` | array | Include only IDs |
| `offset` | int | Offset results |
| `order` | string | `asc` or `desc` |
| `orderby` | string | Sort field |

### Orders-specific
| Parameter | Description |
|-----------|-------------|
| `status` | `pending`, `processing`, `on-hold`, `completed`, `cancelled`, `refunded`, `failed`, `trash`, `any` |
| `customer` | Customer user ID |
| `product` | Product ID |
| `after` / `before` | ISO8601 date filter |
| `modified_after` / `modified_before` | Modified date filter |

### Products-specific
| Parameter | Description |
|-----------|-------------|
| `status` | `draft`, `pending`, `private`, `publish`, `any` |
| `type` | `simple`, `grouped`, `external`, `variable` |
| `sku` | Filter by SKU |
| `category` | Category ID |
| `tag` | Tag ID |
| `on_sale` | Boolean |
| `stock_status` | `instock`, `outofstock`, `onbackorder` |
| `min_price` / `max_price` | Price range |

### Customers-specific
| Parameter | Description |
|-----------|-------------|
| `email` | Filter by email |
| `role` | `customer`, `subscriber`, `all`, etc. |

### Categories-specific
| Parameter | Description |
|-----------|-------------|
| `hide_empty` | Hide empty categories |
| `parent` | Parent category ID |

## Pagination Headers

- `X-WP-Total` - total items
- `X-WP-TotalPages` - total pages
- `Link` header with `rel="next"`, `rel="prev"`

## Batch Operations

`POST /{resource}/batch` with JSON body:
```json
{
    "create": [{ "name": "New" }],
    "update": [{ "id": 1, "name": "Updated" }],
    "delete": [2, 3]
}
```
Max 100 objects per batch.

---

## Order Object

| Field | Type | R/W | Description |
|-------|------|-----|-------------|
| `id` | int | R | Order ID |
| `number` | string | R | Order number |
| `status` | string | RW | `pending`, `processing`, `on-hold`, `completed`, `cancelled`, `refunded`, `failed` |
| `currency` | string | RW | ISO currency code |
| `date_created` / `_gmt` | datetime | R | Creation date |
| `date_modified` / `_gmt` | datetime | R | Last modified |
| `total` | string | R | Grand total |
| `total_tax` | string | R | Total tax |
| `discount_total` | string | R | Discount total |
| `shipping_total` | string | R | Shipping total |
| `shipping_tax` | string | R | Shipping tax |
| `cart_tax` | string | R | Cart item taxes |
| `prices_include_tax` | bool | R | Prices included tax |
| `customer_id` | int | RW | User ID (0 = guest) |
| `customer_note` | string | RW | Checkout note |
| `billing` | object | RW | Billing address |
| `shipping` | object | RW | Shipping address |
| `payment_method` | string | RW | Payment method ID |
| `payment_method_title` | string | RW | Payment method name |
| `transaction_id` | string | RW | Transaction ID |
| `date_paid` / `_gmt` | datetime | R | Paid date |
| `date_completed` / `_gmt` | datetime | R | Completed date |
| `meta_data` | array | RW | `[{id, key, value}]` |
| `line_items` | array | RW | Order line items |
| `shipping_lines` | array | RW | Shipping lines |
| `fee_lines` | array | RW | Fee lines |
| `coupon_lines` | array | RW | Coupon lines |
| `tax_lines` | array | R | Tax lines |
| `refunds` | array | R | Refund summaries |
| `set_paid` | bool | W | Set as paid on create |

### Billing / Shipping Address
`first_name`, `last_name`, `company`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country` (ISO 3166-1 alpha-2), `email` (billing only), `phone` (billing only)

### Line Item
| Field | Type | R/W |
|-------|------|-----|
| `id` | int | R |
| `name` | string | RW |
| `product_id` | int | RW |
| `variation_id` | int | RW |
| `quantity` | int | RW |
| `sku` | string | R |
| `price` | string | R |
| `subtotal` | string | RW |
| `subtotal_tax` | string | R |
| `total` | string | RW |
| `total_tax` | string | R |
| `tax_class` | string | RW |
| `meta_data` | array | RW |

### Shipping Line
`id` (R), `method_title` (RW), `method_id` (RW), `total` (RW), `total_tax` (R), `meta_data` (RW)

### Fee Line
`id` (R), `name` (RW), `tax_class` (RW), `tax_status` (`taxable`/`none`), `total` (RW), `total_tax` (R), `meta_data` (RW)

---

## Product Object

| Field | Type | R/W | Description |
|-------|------|-----|-------------|
| `id` | int | R | Product ID |
| `name` | string | RW | Product name |
| `slug` | string | RW | URL slug |
| `type` | string | RW | `simple`, `grouped`, `external`, `variable` |
| `status` | string | RW | `draft`, `pending`, `private`, `publish` |
| `description` | string | RW | Full HTML description |
| `short_description` | string | RW | Short description |
| `sku` | string | RW | SKU |
| `price` | string | R | Current price |
| `regular_price` | string | RW | Regular price |
| `sale_price` | string | RW | Sale price |
| `on_sale` | bool | R | Is on sale |
| `date_on_sale_from` / `_to` | string | RW | Sale date range |
| `manage_stock` | bool | RW | Enable stock management |
| `stock_quantity` | int | RW | Stock level |
| `stock_status` | string | RW | `instock`, `outofstock`, `onbackorder` |
| `backorders` | string | RW | `no`, `notify`, `yes` |
| `low_stock_amount` | int | RW | Low stock threshold |
| `weight` | string | RW | Weight |
| `dimensions` | object | RW | `{length, width, height}` |
| `tax_status` | string | RW | `taxable`, `shipping`, `none` |
| `tax_class` | string | RW | Tax class |
| `virtual` | bool | RW | No shipping |
| `downloadable` | bool | RW | Has downloads |
| `featured` | bool | RW | Featured product |
| `catalog_visibility` | string | RW | `visible`, `catalog`, `search`, `hidden` |
| `categories` | array | RW | `[{id, name, slug}]` |
| `tags` | array | RW | `[{id, name, slug}]` |
| `images` | array | RW | `[{id, src, name, alt}]` |
| `attributes` | array | RW | `[{id, name, options, position, visible, variation}]` |
| `default_attributes` | array | RW | `[{id, name, option}]` |
| `variations` | array | R | Variation IDs |
| `upsell_ids` | array | RW | Upsell product IDs |
| `cross_sell_ids` | array | RW | Cross-sell product IDs |
| `parent_id` | int | RW | Parent product ID |
| `purchase_note` | string | RW | Post-purchase note |
| `menu_order` | int | RW | Sort order |
| `meta_data` | array | RW | `[{id, key, value}]` |

### Product Variation (under /products/{id}/variations/)
Same as product plus: `image` (single object, not array). `manage_stock` can be `true`, `false`, or `"parent"`. Has `global_unique_id` (GTIN/UPC/EAN/ISBN).

---

## Category Object

| Field | Type | R/W |
|-------|------|-----|
| `id` | int | R |
| `name` | string | RW (mandatory) |
| `slug` | string | RW |
| `parent` | int | RW |
| `description` | string | RW |
| `display` | string | RW (`default`, `products`, `subcategories`, `both`) |
| `image` | object | RW (`{id, src, name, alt}`) |
| `menu_order` | int | RW |
| `count` | int | R |

---

## Customer Object

| Field | Type | R/W |
|-------|------|-----|
| `id` | int | R |
| `email` | string | RW (mandatory) |
| `first_name` | string | RW |
| `last_name` | string | RW |
| `username` | string | RW |
| `password` | string | W |
| `billing` | object | RW (same as order billing) |
| `shipping` | object | RW (same as order shipping) |
| `is_paying_customer` | bool | R |
| `meta_data` | array | RW |

---

## Webhook Topics

Format: `{resource}.{event}` -- e.g. `order.created`, `order.updated`, `product.created`, `product.updated`, `customer.created`, `coupon.updated`

## Error Response

```json
{"code": "woocommerce_rest_...", "message": "...", "data": {"status": 400}}
```
