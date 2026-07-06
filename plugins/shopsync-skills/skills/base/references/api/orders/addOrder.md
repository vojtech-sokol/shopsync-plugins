# addOrder

**Category:** Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addOrder&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addOrder>

## Description

The method allows adding a new order to the BaseLinker order manager.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_status_id | int | Yes | Order status. The status list can be retrieved with `getOrderStatusList`. |
| custom_source_id | int | No | Custom order source identifier. Defaults to the default order source if omitted. |
| date_add | int | Yes | Order creation date in unix-time format. |
| currency | char(3) | Yes | 3-letter currency symbol (e.g. EUR, PLN). |
| payment_method | varchar(30) | Yes | Payment method. |
| payment_method_cod | bool | Yes | Flag indicating cash on delivery payment type. |
| paid | bool | Yes | Whether the order is paid. Value "1" automatically adds a full payment entry. |
| user_comments | varchar(510) | No | Buyer comments. |
| admin_comments | varchar(200) | No | Seller comments. |
| email | varchar(150) | Yes | Buyer e-mail address. |
| phone | varchar(100) | Yes | Buyer phone number. |
| user_login | varchar(30) | No | Allegro or eBay user login. |
| delivery_method | varchar(30) | Yes | Delivery method name. |
| delivery_price | float | Yes | Gross delivery price. |
| delivery_fullname | varchar(100) | Yes | Delivery address — name and surname. |
| delivery_company | varchar(100) | No | Delivery address — company. |
| delivery_address | varchar(156) | Yes | Delivery address — street and number. |
| delivery_postcode | varchar(100) | Yes | Delivery address — postcode. |
| delivery_city | varchar(100) | Yes | Delivery address — city. |
| delivery_state | varchar(20) | No | Delivery address — state/province. |
| delivery_country_code | char(2) | Yes | Delivery address — two-letter country code (e.g. EN). |
| delivery_point_id | varchar(40) | No | Pick-up point identifier. |
| delivery_point_name | varchar(100) | No | Pick-up point name. |
| delivery_point_address | varchar(100) | No | Pick-up point address. |
| delivery_point_postcode | varchar(100) | No | Pick-up point postcode. |
| delivery_point_city | varchar(100) | No | Pick-up point city. |
| invoice_fullname | varchar(100) | No | Billing details — name and surname. |
| invoice_company | varchar(100) | No | Billing details — company. |
| invoice_nip | varchar(100) | No | Billing details — VAT/tax number. |
| invoice_address | varchar(100) | No | Billing details — street and house number. |
| invoice_postcode | varchar(100) | No | Billing details — postcode. |
| invoice_city | varchar(100) | No | Billing details — city. |
| invoice_state | varchar(20) | No | Billing details — state/province. |
| invoice_country_code | char(2) | No | Billing details — two-letter country code. |
| want_invoice | bool | No | Customer wants an invoice (1 = yes, 0 = no). |
| extra_field_1 | varchar(50) | No | Additional field 1 for seller storage. |
| extra_field_2 | varchar(50) | No | Additional field 2 for seller storage. |
| custom_extra_fields | array | No | Custom fields (key = field ID, value = content). Retrieve definitions via `getOrderExtraFields`. |
| products | array | Yes | Array of order products — see fields below. |

### `products[]` fields

| Field | Type | Description |
|-------|------|-------------|
| storage | varchar | Warehouse type — `db` (BaseLinker), `shop` (online store), `warehouse` (wholesaler). |
| storage_id | int | Warehouse identifier; `0` for BaseLinker internal inventory. |
| product_id | varchar | BaseLinker or store warehouse product identifier. |
| variant_id | int | Product variant ID. |
| name | varchar | Product name. |
| sku | varchar | Product SKU. |
| ean | varchar | Product EAN. |
| location | varchar | Product location; separate multiple with semicolons. |
| warehouse_id | int | BaseLinker inventory source warehouse ID. |
| attributes | varchar | Product attributes (e.g. `Color: blue`). |
| price_brutto | float | Single item gross price. |
| tax_rate | float | VAT rate (0–100). Special values: `-1` exempt, `-0.02` NP, `-0.03` reverse charge. |
| quantity | int | Quantity of pieces. |
| weight | float | Single item weight. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| order_id | int | ID of the newly added order. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "order_status_id": 6624,
  "date_add": 1774597845,
  "user_comments": "User comment",
  "admin_comments": "Seller test comments",
  "phone": "693123123",
  "email": "test@test.com",
  "user_login": "nick1",
  "currency": "GBP",
  "payment_method": "PayPal",
  "payment_method_cod": "0",
  "paid": "1",
  "delivery_method": "Expedited shipping",
  "delivery_price": 10,
  "delivery_fullname": "John Doe",
  "delivery_company": "Company",
  "delivery_address": "Long Str 12",
  "delivery_city": "London",
  "delivery_state": "",
  "delivery_postcode": "E2 8HQ",
  "delivery_country_code": "GB",
  "invoice_fullname": "John Doe",
  "invoice_company": "Company",
  "invoice_nip": "GB8943245",
  "invoice_address": "Long Str 12",
  "invoice_city": "London",
  "invoice_postcode": "E2 8HQ",
  "invoice_country_code": "GB",
  "want_invoice": 0,
  "extra_field_1": "field test 1",
  "custom_extra_fields": {
    "135": "B2B",
    "172": "1646913115"
  },
  "products": [
    {
      "storage": "db",
      "storage_id": 0,
      "product_id": "5434",
      "variant_id": 52124,
      "location": "A1-13-7",
      "name": "Harry Potter and the Chamber of Secrets",
      "sku": "LU4235",
      "ean": "1597368451236",
      "price_brutto": 20,
      "tax_rate": 23,
      "quantity": 2,
      "weight": 1
    }
  ]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "order_id": 16331079
}
```

## PHP example

```php
<?php
$methodParams = '{
  "order_status_id": 6624,
  "date_add": 1774597845,
  "phone": "693123123",
  "email": "test@test.com",
  "currency": "GBP",
  "payment_method": "PayPal",
  "payment_method_cod": "0",
  "paid": "1",
  "delivery_method": "Expedited shipping",
  "delivery_price": 10,
  "delivery_fullname": "John Doe",
  "delivery_address": "Long Str 12",
  "delivery_city": "London",
  "delivery_postcode": "E2 8HQ",
  "delivery_country_code": "GB",
  "products": [
    {
      "storage": "db",
      "storage_id": 0,
      "product_id": "5434",
      "name": "Harry Potter and the Chamber of Secrets",
      "sku": "LU4235",
      "price_brutto": 20,
      "tax_rate": 23,
      "quantity": 2
    }
  ]
}';

$apiParams = [
  "method"     => "addOrder",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
