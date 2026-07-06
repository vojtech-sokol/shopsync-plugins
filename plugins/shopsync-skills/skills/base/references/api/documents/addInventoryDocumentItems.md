# addInventoryDocumentItems

**Category:** Documents
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryDocumentItems&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryDocumentItems>

## Description

The method allows you to add items to an existing inventory document.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| document_id | int | Yes | Document identifier. |
| items | array | Yes | List of document items — see fields below. |

### `items[]` fields

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| product_id | int | Yes | The product ID. |
| quantity | int | Yes | The quantity of this line item in the document. |
| price | decimal(10,2) | No | Item unit price. |
| location_name | varchar(255) | No | Source storage location. |
| target_location_name | varchar(255) | No | Target storage location (only for Internal Transfer documents). |
| expiry_date | varchar(10) | No | The expiry date. Date format YYYY-MM-DD (ISO 8601). |
| batch | varchar(128) | No | Batch number. |
| serial_no | varchar(128) | No | The product serial number. |
| comments | varchar(255) | No | Item comments or notes. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| items | array | List of created document items. |
| items[].item_id | int | Created item identifier. |

## Example request

```json
{
  "document_id": 101,
  "items": [
    {
      "product_id": 5432,
      "quantity": 5,
      "price": 10.99,
      "location_name": "A-1-2",
      "target_location_name": "B-1-2",
      "expiry_date": "2023-12-31",
      "batch": "LOT2021",
      "serial_no": "SN20211231001",
      "comments": "Important item"
    }
  ]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "items": [
    {
      "item_id": 1001
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "document_id": 101, "items": [ { "product_id": 5432, "quantity": 5, "price": 10.99, "location_name": "A-1-2", "target_location_name": "B-1-2", "expiry_date": "2023-12-31", "batch": "LOT2021", "serial_no": "SN20211231001", "comments": "Important item" } ] }';

$apiParams = [
  "method"     => "addInventoryDocumentItems",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
