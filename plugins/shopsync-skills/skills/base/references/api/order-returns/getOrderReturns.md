# getOrderReturns

**Category:** Order Returns
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderReturns&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderReturns>

## Description

The method retrieves order returns from BaseLinker's return manager starting from a specified date. Results can be filtered using multiple parameters, with a maximum of 100 returns per request.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | No | Identifier of the order associated with the return. |
| return_id | int | No | Specific return identifier (to fetch a single return). |
| date_from | int | No | Return creation date threshold in unix timestamp format. |
| id_from | int | No | Return ID to start collecting subsequent returns from. |
| status_id | int | No | Status identifier; omit to include all statuses. |
| filter_order_return_source | varchar(20) | No | Filter by source (e.g. `ebay`, `amazon`). |
| filter_order_return_source_id | int | No | Filter by source ID; requires the source filter set first. |
| include_custom_extra_fields | bool | No | Include custom field values (default `false`). |
| include_connect_data | bool | No | Include Base Connect contractor data (default `false`). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| returns | array | Collection of return objects — see fields below. |

### `returns[]` fields

| Field | Type | Description |
|-------|------|-------------|
| return_id | int | Return identifier. |
| order_id | int | Connected order identifier. |
| shop_order_id | int | Shop order identifier. |
| external_order_id | varchar | External order identifier. |
| reference_number | varchar | Reference number. |
| order_return_source | varchar | Return source (e.g. `personal`, `ebay`). |
| order_return_source_id | int | Return source ID. |
| status_id | int | Return status identifier. |
| date_add | int | Creation date (unix timestamp). |
| date_in_status | int | Date of entering current status (unix timestamp). |
| user_login | varchar | Marketplace user login. |
| currency | char(3) | Currency symbol. |
| refunded | varchar | Refunded amount. |
| email | varchar | Buyer e-mail. |
| phone | varchar | Buyer phone. |
| delivery_price | float | Gross delivery price. |
| delivery_fullname | varchar | Delivery name. |
| delivery_company | varchar | Delivery company. |
| delivery_address | varchar | Delivery street and number. |
| delivery_postcode | varchar | Delivery postcode. |
| delivery_city | varchar | Delivery city. |
| delivery_state | varchar | Delivery state/province. |
| delivery_country | varchar | Delivery country name. |
| delivery_country_code | char(2) | Delivery country code. |
| extra_field_1 | varchar | Additional field 1. |
| extra_field_2 | varchar | Additional field 2. |
| custom_extra_fields | array | Custom field values (when requested). |
| admin_comments | varchar | Seller comments. |
| delivery_package_module | varchar | Delivery package module. |
| delivery_package_nr | varchar | Delivery package number. |
| connect_data | object | Connect contractor data: `connect_integration_id`, `connect_contractor_id`, `connect_sale_id`. |
| products | array | Array of return products — see fields below. |
| refund_account_number | varchar | Refund bank account number. |
| refund_iban | varchar | Refund IBAN. |
| refund_swift | varchar | Refund SWIFT. |
| fulfillment_status | int | `0` active, `5` accepted, `1` done, `2` canceled. |

### `products[]` fields

| Field | Type | Description |
|-------|------|-------------|
| order_return_product_id | int | Return product identifier. |
| storage | varchar | Warehouse type. |
| storage_id | int | Warehouse identifier. |
| product_id | varchar | Product identifier. |
| variant_id | int | Product variant ID. |
| name | varchar | Product name. |
| sku | varchar | Product SKU. |
| ean | varchar | Product EAN. |
| location | varchar | Product location. |
| warehouse_id | int | Source warehouse ID. |
| auction_id | varchar | Auction ID. |
| attributes | varchar | Product attributes. |
| price_brutto | float | Single item gross price. |
| tax_rate | float | VAT rate. |
| quantity | int | Quantity. |
| weight | float | Single item weight. |
| bundle_id | int | Bundle ID. |
| status_id | int | Return item status identifier. |
| return_reason_id | int | Return reason identifier. |

## Example request

```json
{ "date_from": 1407341754 }
```

## Example response

```json
{
  "status": "SUCCESS",
  "returns": [
    {
      "return_id": 1022,
      "order_id": 12422,
      "shop_order_id": -1,
      "external_order_id": "",
      "reference_number": "",
      "order_return_source": "personal",
      "order_return_source_id": 0,
      "status_id": 1006,
      "date_add": 1705569412,
      "date_in_status": 1706650702,
      "user_login": "nick1",
      "currency": "PLN",
      "refunded": "0.00",
      "email": "test@test.com",
      "phone": "693123123",
      "delivery_price": 0,
      "extra_field_1": "",
      "extra_field_2": "",
      "custom_extra_fields": "",
      "admin_comments": "",
      "delivery_package_module": "",
      "delivery_package_nr": "",
      "connect_data": {
        "connect_integration_id": 1,
        "connect_contractor_id": 34,
        "connect_sale_id": 18452
      },
      "products": [
        {
          "order_return_product_id": 2216,
          "storage": "db",
          "storage_id": 2,
          "product_id": "13",
          "variant_id": "0",
          "name": "Harry Potter and the Chamber of Secrets",
          "sku": "24366",
          "ean": "",
          "location": "",
          "warehouse_id": 2,
          "auction_id": "0",
          "attributes": "",
          "price_brutto": 50,
          "tax_rate": 23,
          "quantity": 2,
          "weight": 0.26,
          "bundle_id": 0,
          "status_id": 1001,
          "return_reason_id": 1020
        }
      ],
      "refund_account_number": "",
      "refund_iban": "",
      "refund_swift": "",
      "fulfillment_status": 0
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "date_from": 1407341754 }';

$apiParams = [
  "method"     => "getOrderReturns",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
