# getInventoryPurchaseOrders

**Category:** Purchase Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryPurchaseOrders&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryPurchaseOrders>

## Description

The method allows you to retrieve a list of purchase orders from BaseLinker storage.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| warehouse_id | int | No | Warehouse ID (retrieve list via `getInventoryWarehouses`). |
| supplier_id | int | No | Limit results to specific supplier ID. |
| series_id | int | No | Limit results to specific document series ID. |
| date_from | int | No | Start date for document retrieval (Unix timestamp). |
| date_to | int | No | End date for document retrieval (Unix timestamp). |
| filter_document_number | varchar(50) | No | Filter by document number (full or partial match). |
| filter_product_id | int | No | Limit to orders containing product with given ID. |
| page | int | No | Results paging (100 documents per page). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| purchase_orders | array | List of purchase order objects — see fields below. |

### `purchase_orders[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | int | Purchase order identifier. |
| name | varchar(80) | Purchase order name. |
| series_id | int | Purchase order series identifier. |
| document_number | varchar(50) | Full document number. |
| date_created | int | Creation date (Unix timestamp). |
| date_sent | int | Sent date (Unix timestamp). |
| date_received | int | Received date (Unix timestamp). |
| date_completed | int | Completed date (Unix timestamp). |
| date_expected_delivery | int | Expected delivery date (Unix timestamp). |
| warehouse_id | int | Warehouse identifier. |
| supplier_id | int | Supplier identifier. |
| payer_id | int | Payer identifier. |
| currency | varchar(3) | Currency code (e.g. EUR, USD). |
| total_quantity | int | Total items quantity. |
| completed_total_quantity | int | Received items quantity. |
| total_cost | decimal(10,2) | Total order cost. |
| additional_cost | array | Additional costs list — see fields below. |
| completed_total_cost | decimal(10,2) | Cost of received items. |
| items_count | int | Number of unique items. |
| completed_items_count | int | Number of unique items received. |
| cost_invoice_no | varchar(50) | Related invoice number. |
| cost_invoice_file | varchar(255) | URL to invoice file download. |
| notes | text | Purchase order notes/description. |
| status | tinyint | Status: 0=draft, 1=sent, 2=received, 3=completed, 4=partially completed, 5=canceled. |

### `additional_cost[]` fields

| Field | Type | Description |
|-------|------|-------------|
| name | varchar(30) | Additional cost name. |
| cost | decimal(10,2) | Additional cost value. |

## Example request

```json
{
  "date_from": 1609459200,
  "date_to": 1640995199,
  "page": 1
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "purchase_orders": [
    {
      "id": 1234,
      "name": "Monthly Stock Order",
      "series_id": 15,
      "document_number": "PZ/2021/12/31",
      "date_created": 1640908800,
      "date_sent": 1640995200,
      "date_received": 1641254400,
      "date_completed": 0,
      "date_expected_delivery": 1641168000,
      "warehouse_id": 1,
      "supplier_id": 5,
      "payer_id": 3,
      "currency": "EUR",
      "total_quantity": 100,
      "completed_total_quantity": 50,
      "total_cost": 1000.00,
      "additional_cost": [
        {
          "name": "Transport",
          "cost": 120.50
        }
      ],
      "completed_total_cost": 500.00,
      "items_count": 5,
      "completed_items_count": 3,
      "cost_invoice_no": "FV/2021/12/123",
      "cost_invoice_file": "https://upload.example.com/purchase_orders/1234/invoice.pdf",
      "notes": "Monthly stock delivery",
      "status": 2
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "date_from": 1609459200, "date_to": 1640995199, "page": 1 }';

$apiParams = [
  "method"     => "getInventoryPurchaseOrders",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
