# getInventoryDocuments

**Category:** Documents
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryDocuments&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryDocuments>

## Description

This method retrieves a list of inventory documents from BaseLinker, supporting pagination and filtering by document type, date range, and other criteria.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| filter_source_object_type | int | No | Source object type filter: 1=order, 2=purchase order, 3=stock take, 4=order return, 7=fulfillment delivery, 8=transfer. |
| filter_source_object_id | int | No | Source object ID to filter by. |
| filter_document_id | int | No | Specific inventory document ID. |
| filter_document_type | int | No | Document type: 0=GR, 1=IGR, 2=GI, 3=IGI, 4=IT, 5=OB. |
| filter_document_status | int | No | Document status: 0=Draft, 1=Confirmed. |
| filter_date_from | int | No | Minimum creation date as unix timestamp. |
| filter_date_to | int | No | Maximum creation date as unix timestamp. |
| filter_warehouse_id | int | No | Warehouse ID. |
| page | int | No | Results page number (100 documents per page, starting from 1). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| documents | array | Array of inventory document objects — see fields below. |

### `documents[]` fields

| Field | Type | Description |
|-------|------|-------------|
| document_id | int | Document identifier. |
| document_type | int | 0=GR, 1=IGR, 2=GI, 3=IGI, 4=IT, 5=OB. |
| document_status | int | 0=Draft, 1=Confirmed. |
| direction | int | 0=incoming, 1=outgoing. |
| document_series_id | int | Document series identifier. |
| full_number | varchar | Full document number. |
| date_created | int | Creation date (unix timestamp). |
| date_confirmed | int | Confirmation date (unix timestamp); 0 if not confirmed. |
| warehouse_id | int | Source warehouse identifier. |
| warehouse_id2 | int | Destination warehouse for transfers. |
| items_count | int | Number of items. |
| total_quantity | int | Total quantity. |
| total_price | decimal | Total document price. |
| connection_type | int | 1=order, 2=purchase order, 3=stock take, 4=order return, 7=fulfillment delivery, 8=transfer. |
| connection_id | int | Connection ID. |
| notes | varchar | Document notes. |
| source_object_type | int | Source object type. |
| source_object_id | int | Source object ID. |

## Example request

```json
{
  "filter_source_object_type": 1,
  "filter_source_object_id": 123456,
  "filter_document_type": 1,
  "filter_date_from": 1693459200,
  "page": 1
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "documents": [
    {
      "document_id": 101,
      "document_type": 1,
      "document_status": 1,
      "direction": 0,
      "document_series_id": 3,
      "full_number": "GRN/0001/09/2023",
      "date_created": 1693471200,
      "date_confirmed": 1693478400,
      "warehouse_id": 205,
      "warehouse_id2": 0,
      "items_count": 3,
      "total_quantity": 50,
      "total_price": 1080,
      "connection_type": 1,
      "connection_id": 123456,
      "notes": "Important delivery",
      "source_object_type": 2,
      "source_object_id": 789
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"filter_source_object_type": 1, "filter_source_object_id": 123456, "filter_document_type": 1, "filter_date_from": 1693459200, "page": 1}';

$apiParams = [
  "method"     => "getInventoryDocuments",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
