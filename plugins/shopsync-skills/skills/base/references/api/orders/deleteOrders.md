# deleteOrders

**Category:** Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteOrders&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteOrders>

## Description

The method allows you to delete multiple orders from the BaseLinker order manager.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_ids | array | Yes | Array of order identifiers from BaseLinker order manager (max 1000 at a time). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` - request executed correctly. `ERROR` - an error occurred during an API request. Error details will be described in 2 additional returned fields: `error_message` and `error_code`. |
| deleted_order_ids | array | Array of confirmed IDs of successfully deleted orders. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "order_ids": [12345, 123456, 1234567]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "deleted_order_ids": [12345, 123456, 1234567]
}
```

## PHP example

```php
<?php
$methodParams = '{ "order_ids": [ 12345, 123456, 1234567 ] }';

$apiParams = [
  "method"     => "deleteOrders",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
