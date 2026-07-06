# addOrderInvoiceFile

**Category:** Invoices
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addOrderInvoiceFile&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addOrderInvoiceFile>

## Description

This method facilitates attachment of external invoice files to previously issued BaseLinker invoices, enabling replacement of standard BaseLinker invoices with those from external systems like ERP programs.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| invoice_id | int | Yes | BaseLinker invoice identifier. |
| file | text | Yes | Invoice PDF in binary format, base64-encoded with `data:` prefix. Brazil allows XML base64 with `data:` prefix. |
| external_invoice_number | varchar(30) | Yes | External system invoice number (replaces BaseLinker invoice number). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |

## Example request

```json
{
  "invoice_id": 153845,
  "file": "data:4AAQSkZJRgABA[...]",
  "external_invoice_number": "FV/2024/001"
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
  "invoice_id": 153845,
  "file": "data:4AAQSkZJRgABA[...]",
  "external_invoice_number": "FV\/2024\/001"
}';

$apiParams = [
  "method"     => "addOrderInvoiceFile",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
