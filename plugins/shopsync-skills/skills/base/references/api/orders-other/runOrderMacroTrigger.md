# runOrderMacroTrigger

**Category:** Orders — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=runOrderMacroTrigger&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=runOrderMacroTrigger>

## Description

The method allows you to run personal trigger for orders automatic actions.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order identifier from BaseLinker order manager. |
| trigger_id | int | Yes | Identifier of personal trigger from orders automatic actions. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |

## Example request

```json
{
  "order_id": "143476260",
  "trigger_id": "12413"
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
  "order_id": "143476260",
  "trigger_id": "12413"
}';

$apiParams = [
  "method"     => "runOrderMacroTrigger",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
