# setOrderReturnStatuses

**Category:** Return Statuses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrderReturnStatuses&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrderReturnStatuses>

## Description

The method enables batch assignment of return statuses to multiple order returns simultaneously.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| return_ids | array | Yes | Array of order return ID numbers. |
| status_id | int | Yes | Order return status ID number. The status list can be retrieved using `getOrderReturnStatusList`. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "return_ids": [1102, 1105],
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
  "return_ids": [ 1102, 1105 ],
  "status_id": 10224
}';

$apiParams = [
  "method"     => "setOrderReturnStatuses",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
