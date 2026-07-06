# setOrderStatus

**Category:** Statuses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrderStatus&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrderStatus>

## Description

The method allows you to change order status.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order ID number. |
| status_id | int | Yes | Status ID number. The status list can be retrieved using `getOrderStatusList`. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |

## Example request

```json
{
  "order_id": 3754894,
  "status_id": 34562
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
  "order_id": 3754894,
  "status_id": 34562
}';

$apiParams = [
  "method"     => "setOrderStatus",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
