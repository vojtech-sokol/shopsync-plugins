# addInventoryDocument

**Category:** Documents
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryDocument&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryDocument>

## Description

The method allows creation of new inventory documents in BaseLinker storage. Documents are generated as drafts requiring user confirmation or the `setInventoryDocumentStatusConfirmed` API method.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| warehouse_id | int | Yes | Source warehouse identifier. |
| document_type | int | Yes | Document type: 0-GR, 1-IGR, 2-GI, 3-IGI, 4-IT, 5-OB. |
| target_warehouse_id | int | No | Target warehouse identifier — required only for transfer documents (type 4). |
| date_add | int | No | Date of document creation (unix timestamp). If not specified, the current date will be used. |
| date_execute | int | No | Date of document execution (unix timestamp). If not specified, the current date will be used. |
| contractor | varchar(500) | No | Contractor description/notes. |
| invoice_no | varchar(50) | No | Related invoice number. |
| notes | varchar(500) | No | Document notes/comments. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| document_id | int | Created document identifier. |
| document_number | varchar(30) | Generated document number. |

## Example request

```json
{
  "warehouse_id": 205,
  "document_type": 2,
  "date_add": 1740479190,
  "date_execute": 1740479190,
  "notes": "Important delivery - handle with care"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "document_id": 101,
  "document_number": "GR/2021/1"
}
```

## PHP example

```php
<?php
$methodParams = '{"warehouse_id": 205, "document_type": 2, "date_add": 1740479190, "date_execute": 1740479190, "notes": "Important delivery - handle with care"}';

$apiParams = [
  "method"     => "addInventoryDocument",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
