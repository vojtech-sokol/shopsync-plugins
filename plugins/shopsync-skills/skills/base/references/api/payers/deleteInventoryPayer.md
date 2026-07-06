# deleteInventoryPayer

**Category:** Payers
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteInventoryPayer&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteInventoryPayer>

## Description

The method allows you to remove a payer from BaseLinker storage.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| payer_id | int | Yes | Payer identifier. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |

## Example request

```json
{
  "payer_id": 1
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
$methodParams = '{ "payer_id": 1 }';

$apiParams = [
  "method"     => "deleteInventoryPayer",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
