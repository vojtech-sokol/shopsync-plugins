# addReceipt

**Category:** Receipts
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addReceipt&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addReceipt>

## Description

The method allows you to issue a receipt for an order.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order identifier. |
| series_id | int | No | Receipt numbering series identifier. If not provided, the default receipt series will be used. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| receipt_id | int | ID of the created receipt. |

## Example request

```json
{
  "order_id": 4893426,
  "series_id": 1
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "receipt_id": 19824373
}
```

## PHP example

```php
<?php
$methodParams = '{
  "order_id": 4893426,
  "series_id": 1
}';

$apiParams = [
  "method"     => "addReceipt",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
