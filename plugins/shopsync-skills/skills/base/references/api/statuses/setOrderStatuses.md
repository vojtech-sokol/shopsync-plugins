# setOrderStatuses

**Category:** Statuses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrderStatuses&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrderStatuses>

## Description

The method allows you to batch set orders statuses.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_ids | array | Yes | Array of Order ID numbers. |
| status_id | int | Yes | Status ID number. The status list can be retrieved using `getOrderStatusList`. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |

## Example request

```json
{
  "order_ids": [3754894, 3754895],
  "status_id": 2
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
  "order_ids": [3754894, 3754895],
  "status_id": 2
}';

$apiParams = [
  "method"     => "setOrderStatuses",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
