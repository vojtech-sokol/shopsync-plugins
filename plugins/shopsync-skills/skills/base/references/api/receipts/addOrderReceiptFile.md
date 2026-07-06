# addOrderReceiptFile

**Category:** Receipts
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addOrderReceiptFile&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addOrderReceiptFile>

## Description

The method allows you to add an external file to a receipt previously issued from BaseLinker. It enables replacing a standard receipt from BaseLinker with a receipt issued e.g. in an ERP program.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| receipt_id | int | Yes | BaseLinker receipt identifier. |
| file | text | Yes | Receipt PDF file in binary format encoded in base64, at the very beginning of the receipt string provide a prefix `data:` e.g. `data:4AAQSkSzkJRgABA[...]`. |
| external_receipt_number | varchar(20) | Yes | External system receipt number (overwrites BaseLinker receipt number). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |

## Example request

```json
{
  "receipt_id": 153845,
  "file": "data:4AAQSkZJRgABA[...]",
  "external_receipt_number": "RC40/08/2023"
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
  "receipt_id": 153845,
  "file": "data:4AAQSkZJRgABA[...]",
  "external_receipt_number": "RC40\/08\/2023"
}';

$apiParams = [
  "method"     => "addOrderReceiptFile",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
