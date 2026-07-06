# addOrderReturn

**Category:** Order Returns
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addOrderReturn&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addOrderReturn>

## Description

The method allows adding a new order return to BaseLinker.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | No | Order ID in BaseLinker panel. |
| status_id | int | Yes | Order return status. The status list can be retrieved with `getOrderReturnStatusList`. |
| custom_source_id | int | No | Identifier of custom order source. Defaults to the default order source if omitted. |
| reference_number | varchar(100) | No | Reference number from external source. |
| date_add | int | Yes | Date of order return creation (in unix time format). |
| currency | char(3) | Yes | 3-letter currency symbol (e.g. EUR, PLN). |
| refunded | bool | Yes | Information whether the order return is already refunded. Value "1" automatically marks as refunded. |
| admin_comments | varchar(200) | No | Seller comments. |
| email | varchar(150) | No | Buyer e-mail address. |
| phone | varchar(100) | No | Buyer phone number. |
| user_login | varchar(30) | No | Marketplace user login. |
| delivery_price | float | No | Gross delivery price. |
| delivery_fullname | varchar(100) | No | Delivery address — name and surname. |
| delivery_company | varchar(100) | No | Delivery address — company. |
| delivery_address | varchar(100) | No | Delivery address — street and number. |
| delivery_postcode | varchar(100) | No | Delivery address — postcode. |
| delivery_city | varchar(100) | No | Delivery address — city. |
| delivery_state | varchar(20) | No | Delivery address — state/province. |
| delivery_country_code | char(2) | No | Delivery address — country code (two-letter, e.g. EN). |
| extra_field_1 | varchar(50) | No | Value of "additional field 1". |
| extra_field_2 | varchar(50) | No | Value of "additional field 2". |
| custom_extra_fields | array | No | Order return custom extra fields (key = field ID, value = field content). Empty string removes the field. Files use format `{"title": "file.pdf", "file": "data:4AAQSkZJRgABA..."}` (binary limited to 2MB). |
| products | array | No | Array of return products — see fields below. |
| refund_account_number | varchar(50) | No | Bank account number for refund. |
| refund_iban | varchar(34) | No | IBAN of bank account. |
| refund_swift | varchar(11) | No | SWIFT of bank account. |

### `products[]` fields

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| order_product_id | int | No | ID of connected order item from BaseLinker. |
| storage | varchar | Yes | Warehouse type — `db` (BaseLinker internal inventory), `shop` (online store), `warehouse` (connected wholesaler). |
| storage_id | int | Yes | Warehouse identifier; `0` for BaseLinker internal inventory. |
| product_id | varchar | No | Product identifier in BaseLinker or store warehouse. |
| variant_id | int | No | Product variant ID. |
| name | varchar | Yes | Product name. |
| sku | varchar | No | Product SKU. |
| ean | varchar | No | Product EAN. |
| location | varchar | No | Product location. |
| warehouse_id | int | No | Product source warehouse identifier; applies to BaseLinker inventory only. |
| attributes | varchar | No | Specific product attributes (e.g. `Color: blue`). |
| price_brutto | float | Yes | Single item gross price. |
| tax_rate | float | Yes | VAT rate (0–100). Special values: `-1` exempt, `-0.02` NP, `-0.03` reverse charge. |
| quantity | int | Yes | Quantity of pieces. |
| weight | float | No | Single item weight. |
| status_id | int | No | Identifier of return item status. |
| return_reason_id | int | No | Identifier of return reason. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| return_id | int | Identifier of the added return. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "order_id": 151502889,
  "status_id": 1009,
  "reference_number": "R1234",
  "date_add": 1779366966,
  "currency": "GBP",
  "refunded": 0,
  "admin_comments": "Seller test comments",
  "email": "test@test.com",
  "phone": "693123123",
  "user_login": "nick1",
  "delivery_price": 10,
  "delivery_fullname": "John Doe",
  "delivery_company": "Company",
  "delivery_address": "Long Str 12",
  "delivery_postcode": "E2 8HQ",
  "delivery_city": "London",
  "delivery_state": "",
  "delivery_country_code": "GB",
  "extra_field_1": "field test 1",
  "extra_field_2": "",
  "custom_extra_fields": {
    "125": "888579",
    "126": "return info"
  },
  "products": [
    {
      "order_product_id": 59157160,
      "storage": "db",
      "storage_id": 0,
      "product_id": "5434",
      "variant_id": 52124,
      "name": "Harry Potter and the Chamber of Secrets",
      "sku": "LU4235",
      "ean": "1597368451236",
      "location": "A1-13-7",
      "price_brutto": 20,
      "tax_rate": 23,
      "quantity": 2,
      "weight": 1,
      "status_id": 1003,
      "return_reason_id": 1006
    }
  ],
  "refund_account_number": "12345678901234567890123456",
  "refund_iban": "PL61109010140000071219812874",
  "refund_swift": "WBKPPLPP"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "return_id": 16331079
}
```

## PHP example

```php
<?php
$methodParams = '{
  "order_id": 151502889,
  "status_id": 1009,
  "reference_number": "R1234",
  "date_add": 1779366966,
  "currency": "GBP",
  "refunded": 0,
  "admin_comments": "Seller test comments",
  "email": "test@test.com",
  "phone": "693123123",
  "user_login": "nick1",
  "delivery_price": 10,
  "delivery_fullname": "John Doe",
  "delivery_company": "Company",
  "delivery_address": "Long Str 12",
  "delivery_postcode": "E2 8HQ",
  "delivery_city": "London",
  "delivery_state": "",
  "delivery_country_code": "GB",
  "extra_field_1": "field test 1",
  "extra_field_2": "",
  "custom_extra_fields": {
    "125": "888579",
    "126": "return info"
  },
  "products": [
    {
      "order_product_id": 59157160,
      "storage": "db",
      "storage_id": 0,
      "product_id": "5434",
      "variant_id": 52124,
      "name": "Harry Potter and the Chamber of Secrets",
      "sku": "LU4235",
      "ean": "1597368451236",
      "location": "A1-13-7",
      "price_brutto": 20,
      "tax_rate": 23,
      "quantity": 2,
      "weight": 1,
      "status_id": 1003,
      "return_reason_id": 1006
    }
  ],
  "refund_account_number": "12345678901234567890123456",
  "refund_iban": "PL61109010140000071219812874",
  "refund_swift": "WBKPPLPP"
}';

$apiParams = [
  "method"     => "addOrderReturn",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
