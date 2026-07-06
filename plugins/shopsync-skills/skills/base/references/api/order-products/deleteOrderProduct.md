# deleteOrderProduct

**Category:** Order Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteOrderProduct&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteOrderProduct>

## Description

The method allows you to remove a specific product from the order.

## Input Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| order_id | int | Order ID from BaseLinker order manager. |
| order_product_id | int | Order item ID from BaseLinker order manager. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` indicates proper execution; `ERROR` indicates failure with additional `error_message` and `error_code` fields. |

## Example request

```json
{
  "order_id": 3754894,
  "order_product_id": 59157160
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
$methodParams = '{ "order_id": 3754894, "order_product_id": 59157160 }';

$apiParams = [
  "method"     => "deleteOrderProduct",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
