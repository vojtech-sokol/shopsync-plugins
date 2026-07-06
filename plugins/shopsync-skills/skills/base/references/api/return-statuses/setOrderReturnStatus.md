# setOrderReturnStatus

**Category:** Return Statuses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrderReturnStatus&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrderReturnStatus>

## Description

The method allows you to change order return status.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| return_id | int | Yes | Order return ID number. |
| status_id | int | Yes | Status ID number. The status list can be retrieved using `getOrderReturnStatusList`. |

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
  "status_id": 10224
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
  "status_id": 10224
}';

$apiParams = [
  "method"     => "setOrderReturnStatus",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
