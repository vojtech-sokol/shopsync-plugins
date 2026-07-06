# addInventoryDocumentFile

**Category:** Documents
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryDocumentFile&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryDocumentFile>

## Description

The method allows you to add an external PDF file to a warehouse document. It enables attaching a document issued in an external ERP system to the corresponding warehouse document in BaseLinker.

## Input Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| document_id | int | Warehouse document identifier from BaseLinker. |
| file | text | Document PDF file in binary format encoded in base64. Provide a prefix `data:` at the beginning. |
| external_document_number | varchar(100) | External system document number. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |

## Example request

```json
{
  "document_id": 4521,
  "file": "data:4AAQSkZJRgABA[...]",
  "external_document_number": "WZ/2026/03/001"
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
$methodParams = '{ "document_id": 4521, "file": "data:4AAQSkZJRgABA[...]", "external_document_number": "WZ\/2026\/03\/001" }';

$apiParams = [
  "method"     => "addInventoryDocumentFile",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
