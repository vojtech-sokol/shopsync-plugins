# getInventoryFulfillmentDeliveries

**Category:** Fulfillment Deliveries
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryFulfillmentDeliveries&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryFulfillmentDeliveries>

## Description

The method allows you to retrieve a list of fulfillment deliveries with optional filtering. Results are paginated with 100 results per page.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| fulfillment_warehouse_id | int | No | Filter by fulfillment warehouse identifier. |
| warehouse_id | int | No | Filter by source warehouse identifier. |
| status | int | No | Filter by delivery status. |
| date_from | int | No | Date from filter (unix timestamp). |
| date_to | int | No | Date to filter (unix timestamp). |
| filter_document_number | varchar(30) | No | Filter by document number (partial match). |
| page | int | No | Results page (0-based, 100 results per page). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Error details (returned on ERROR status). |
| error_code | int | Error code (returned on ERROR status). |
| deliveries | array | Array of fulfillment delivery objects — see fields below. |

### `deliveries[]` fields

| Field | Type | Description |
|-------|------|-------------|
| delivery_id | int | Delivery identifier. |
| name | varchar(80) | Delivery name. |
| document_number | varchar(30) | Full document number. |
| date_created | int | Creation date (unix timestamp). |
| items_count | int | Number of items. |
| received_items | int\|null | Number of received items (null by default). |
| status | int | Delivery status (0-draft, 1-packing, 2-registered, 3-in_transit, 4-unpacking, 5-completed, 6-cancelled). |

## Example request

```json
{
  "status": 0,
  "page": 0
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "deliveries": [
    {
      "delivery_id": 42,
      "name": "Delivery March 2026",
      "document_number": "FD/1/03/2026",
      "date_created": 1741871400,
      "items_count": 2,
      "received_items": 2,
      "status": 0
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "status": 0, "page": 0 }';

$apiParams = [
  "method"     => "getInventoryFulfillmentDeliveries",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
