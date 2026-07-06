# getInventoryDocumentItems

**Category:** Documents
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryDocumentItems&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryDocumentItems>

## Description

This method allows you to retrieve document items for a specific inventory document in BaseLinker. In case of a large number of items, pagination is possible.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| document_id | int | Yes | Inventory document ID. |
| page | int | No | Results page number (100 items per page, numbered from 1). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| items | array | List of document items — see fields below. |

### `items[]` fields

| Field | Type | Description |
|-------|------|-------------|
| document_id | int | The ID of the document to which this item belongs. |
| item_id | int | The main identifier of the document item. |
| position | int | The line item number within the document. |
| product_id | int | The product ID. |
| product_name | varchar(200) | The product name as copied at document creation. |
| product_ean | varchar(32) | The product EAN. |
| product_sku | varchar(50) | The product SKU. |
| quantity | int | The quantity of this line item in the document. |
| price | decimal(10,2) | The unit price. |
| total_price | decimal(10,2) | The total value of the item. |
| inventory_id | int | The catalog ID. |
| location_name | varchar(255) | The location. |
| expiry_date | varchar(10) | Date format YYYY-MM-DD (ISO 8601). |
| batch | varchar(128) | The product batch. |
| serial_no | varchar(128) | The product serial number. |
| comments | varchar(255) | Item comments or notes. |
| target_location_name | varchar(255) | The target location (only for Internal Transfer documents). |

## Example request

```json
{
  "document_id": 101,
  "page": 1
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "items": [
    {
      "document_id": 101,
      "item_id": 5001,
      "position": 1,
      "product_id": 2685,
      "product_name": "Lenovo X1 Notebook",
      "product_ean": "1234567890123",
      "product_sku": "LEN-X1",
      "quantity": 10,
      "price": 90.5,
      "total_price": 905,
      "inventory_id": 307,
      "location_name": "A-2-1",
      "expiry_date": "0000-00-00",
      "batch": "",
      "serial_no": "",
      "comments": "",
      "target_location_name": ""
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "document_id": 101, "page": 1 }';

$apiParams = [
  "method"     => "getInventoryDocumentItems",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
