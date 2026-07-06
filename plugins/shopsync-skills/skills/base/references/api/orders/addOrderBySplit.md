# addOrderBySplit

**Category:** Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addOrderBySplit&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addOrderBySplit>

## Description

Creates a new order by splitting selected products from an existing order. The new order inherits all fields and information from the original one.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | ID of the order to split. |
| items_to_split | array | Yes | A list of products to move to the new order — see fields below. |
| delivery_cost_to_split | float | No | Delivery cost (net or gross, depending on order) to transfer to the new order. |

### `items_to_split[]` fields

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| order_product_id | int | Yes | ID of the product in the original order (from `getOrders` method). |
| quantity | int | Yes | Quantity to be moved (must be less than or equal to the original quantity). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| new_order_id | int | ID of the newly created order. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "order_id": 1234567,
  "items_to_split": [
    {"order_product_id": 123, "quantity": 2},
    {"order_product_id": 456, "quantity": 1},
    {"order_product_id": 789, "quantity": 3}
  ],
  "delivery_cost_to_split": 123
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "new_order_id": 12345678
}
```

## PHP example

```php
<?php
$methodParams = '{
  "order_id": 1234567,
  "items_to_split": [
    {"order_product_id": 123, "quantity": 2},
    {"order_product_id": 456, "quantity": 1},
    {"order_product_id": 789, "quantity": 3}
  ],
  "delivery_cost_to_split": 123
}';

$apiParams = [
  "method"     => "addOrderBySplit",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
