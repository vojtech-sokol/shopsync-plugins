# setInventoryDocumentStatusConfirmed

**Category:** Documents
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setInventoryDocumentStatusConfirmed&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setInventoryDocumentStatusConfirmed>

## Description

The method allows you to confirm an inventory document, which will affect the stock levels in the warehouse.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| document_id | int | Yes | Document identifier. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |

## Example request

```json
{
  "document_id": 101
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
$methodParams = '{ "document_id": 101 }';

$apiParams = [
  "method"     => "setInventoryDocumentStatusConfirmed",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
