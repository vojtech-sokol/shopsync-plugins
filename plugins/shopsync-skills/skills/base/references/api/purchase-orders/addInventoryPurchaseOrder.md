# addInventoryPurchaseOrder

**Category:** Purchase Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryPurchaseOrder&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryPurchaseOrder>

## Description

The method allows you to create a new purchase order in BaseLinker storage. Orders are created as drafts by default.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| warehouse_id | int | Yes | Warehouse identifier. |
| supplier_id | int | Yes | Supplier identifier. |
| payer_id | int | Yes | Payer identifier. |
| currency | varchar(3) | Yes | Order currency (e.g. EUR, USD). |
| name | varchar(80) | No | Order name. |
| notes | text | No | Order description/notes. |
| invoice_no | varchar(50) | No | Related invoice number. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| order_id | int | Created purchase order identifier. |
| document_number | varchar(50) | Generated document number. |

## Example request

```json
{
  "series_id": 15,
  "warehouse_id": 1,
  "supplier_id": 5,
  "payer_id": 1,
  "currency": "EUR",
  "date_created": 1640908800,
  "name": "Monthly stock delivery",
  "notes": "Monthly stock delivery",
  "invoice_no": "FV/2021/12/123"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "order_id": 1234,
  "document_number": "PO/2024/03/001"
}
```

## PHP example

```php
<?php
$methodParams = '{ "series_id": 15, "warehouse_id": 1, "supplier_id": 5, "payer_id": 1, "currency": "EUR", "date_created": 1640908800, "name": "Monthly stock delivery", "notes": "Monthly stock delivery", "invoice_no": "FV\/2021\/12\/123" }';

$apiParams = [
  "method"     => "addInventoryPurchaseOrder",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
