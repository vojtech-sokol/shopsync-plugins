# deleteOrderReturnProduct

**Category:** Return Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteOrderReturnProduct&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteOrderReturnProduct>

## Description

The method allows you to remove a specific product from the return.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| return_id | int | Yes | Order return ID. |
| order_return_product_id | int | Yes | Order return item ID. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "return_id": 1102,
  "order_return_product_id": 1232
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
$methodParams = '{
  "return_id": 1102,
  "order_return_product_id": 1232
}';

$apiParams = [
  "method"     => "deleteOrderReturnProduct",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
