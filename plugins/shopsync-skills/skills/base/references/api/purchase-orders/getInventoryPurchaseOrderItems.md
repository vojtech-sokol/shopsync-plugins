# getInventoryPurchaseOrderItems

**Category:** Purchase Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryPurchaseOrderItems&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryPurchaseOrderItems>

## Description

The method allows you to retrieve items from a specific purchase order.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Purchase order identifier. |
| page | int | No | Page number of the results if there are many items in a purchase order (100 items per page). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| items | array | Collection of order line items — see fields below. |

### `items[]` fields

| Field | Type | Description |
|-------|------|-------------|
| item_id | int | Item identifier. |
| product_id | int | Product identifier. |
| position | int | Line item number within purchase order. |
| product_name | varchar(200) | Product name on document. |
| product_sku | varchar(50) | Product SKU. |
| product_ean | varchar(32) | Product EAN. |
| supplier_code | varchar(50) | Optional product code from supplier. |
| quantity | int | Ordered quantity. |
| completed_quantity | int | Received quantity. |
| item_cost | decimal(10,2) | Item unit cost. |
| location | varchar(255) | Optional storage location. |
| expiry_date | date | Optional expiry date. |
| batch | varchar(128) | Optional batch number. |
| serial_no | varchar(128) | Optional serial number. |
| comments | varchar(255) | Optional item comments or notes. |

## Example request

```json
{
  "order_id": 1234
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "items": [
    {
      "item_id": 1,
      "product_id": 5432,
      "position": 1,
      "product_name": "Test Product 1",
      "product_sku": "TP-001",
      "product_ean": "5901234123457",
      "supplier_code": "SUP-001",
      "quantity": 5,
      "completed_quantity": 3,
      "item_cost": 10.99,
      "location": "A-1-2",
      "batch": "LOT2021",
      "expiry_date": "2023-12-31",
      "serial_no": "SN20211231001"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "order_id": 1234 }';

$apiParams = [
  "method"     => "getInventoryPurchaseOrderItems",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
