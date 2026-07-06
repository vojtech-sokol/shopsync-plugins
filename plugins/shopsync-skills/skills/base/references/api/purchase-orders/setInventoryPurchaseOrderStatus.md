# setInventoryPurchaseOrderStatus

**Category:** Purchase Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setInventoryPurchaseOrderStatus&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setInventoryPurchaseOrderStatus>

## Description

The method allows you to change the status of a purchase order.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Purchase order identifier. |
| status | int | Yes | New order status. Available values: 0 - draft, 1 - sent, 2 - received, 3 - completed, 4 - completed partially, 5 - canceled. |
| completed_items | array | No | List of items received — see fields below. |

### `completed_items[]` fields

| Field | Type | Description |
|-------|------|-------------|
| item_id | int | Item identifier. |
| completed_quantity | int | Received quantity. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |

## Example request

```json
{
  "order_id": 1234,
  "status": 2,
  "completed_items": [
    {
      "item_id": 1,
      "completed_quantity": 3
    }
  ]
}
```

## Example response

```json
{
  "status": "SUCCESS"
}
```

## PHP example

```php
<?php
$methodParams = '{ "order_id": 1234, "status": 2, "completed_items": [ { "item_id": 1, "completed_quantity": 3 } ] }';

$apiParams = [
  "method"     => "setInventoryPurchaseOrderStatus",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
