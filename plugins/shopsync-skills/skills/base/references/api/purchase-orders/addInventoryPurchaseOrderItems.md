# addInventoryPurchaseOrderItems

**Category:** Purchase Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryPurchaseOrderItems&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryPurchaseOrderItems>

## Description

The method allows you to add items to an existing purchase order. Entering the product with the ID and price updates the previously saved position only if all other parameters match. If any parameter differs (e.g. location), a new item will be added.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Purchase order identifier. |
| items | array | Yes | List of items to add — see fields below. |

### `items[]` fields

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| product_id | int | Yes | Product identifier. |
| quantity | int | Yes | Item quantity. |
| item_cost | decimal(10,2) | Yes | Item unit cost. |
| supplier_code | varchar(50) | No | Product code from supplier. |
| location | varchar(255) | No | Storage location. |
| batch | varchar(128) | No | Batch number. |
| expiry_date | date | No | Expiry date. |
| serial_no | varchar(128) | No | Serial number. |
| comments | varchar(255) | No | Item comments or notes. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Returned only on error. |
| error_code | varchar | Returned only on error. |
| items | array | List of created order items. |
| items[].item_id | int | Item identifier. |
| items[].position | int | Item position in order. |

## Example request

```json
{
  "order_id": 1234,
  "items": [
    {
      "product_id": 5432,
      "quantity": 5,
      "item_cost": 10.99,
      "supplier_code": "SUP-001",
      "location": "A-1-2",
      "batch": "LOT2021",
      "expiry_date": "2023-12-31",
      "serial_no": "SN20211231001",
      "comments": "Important item"
    }
  ]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "items": [
    {
      "item_id": 1,
      "position": 1
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "order_id": 1234, "items": [ { "product_id": 5432, "quantity": 5, "item_cost": 10.99, "supplier_code": "SUP-001", "location": "A-1-2", "batch": "LOT2021", "expiry_date": "2023-12-31", "serial_no": "SN20211231001", "comments": "Important item" } ] }';

$apiParams = [
  "method"     => "addInventoryPurchaseOrderItems",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
