# runOrderReturnMacroTrigger

**Category:** Returns — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=runOrderReturnMacroTrigger&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=runOrderReturnMacroTrigger>

## Description

The method allows you to run personal trigger for order returns automatic actions.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| return_id | int | Yes | Order return identifier from BaseLinker order manager. |
| trigger_id | int | Yes | Identifier of personal trigger from orders automatic actions. |

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
  "trigger_id": 1241
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
  "trigger_id": 1241
}';

$apiParams = [
  "method"     => "runOrderReturnMacroTrigger",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
