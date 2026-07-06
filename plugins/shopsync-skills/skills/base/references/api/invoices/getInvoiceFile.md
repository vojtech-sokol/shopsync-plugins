# getInvoiceFile

**Category:** Invoices
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInvoiceFile&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInvoiceFile>

## Description

This method enables retrieval of invoice files stored in BaseLinker's system.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| invoice_id | int | Yes | BaseLinker invoice identifier. |
| get_external | bool | No | When false (default), retrieves BaseLinker-generated invoices; when true, retrieves external accounting system invoices or API-uploaded files, falling back to BaseLinker format if unavailable. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| invoice | text | Invoice file in binary format encoded in base64, at the very beginning of the invoice string a prefix `data:` is provided. |
| invoice_number | varchar(30) | Invoice number from BaseLinker or external accounting system (if `get_external` is true). |

## Example request

```json
{
  "invoice_id": 153845
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "invoice": "data:4AAQSkZJRgABA[...]",
  "invoice_number": "FV 101/03/2023"
}
```

## PHP example

```php
<?php
$methodParams = '{ "invoice_id": 153845 }';

$apiParams = [
  "method"     => "getInvoiceFile",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
