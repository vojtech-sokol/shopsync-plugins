# addInventoryFulfillmentDelivery

**Category:** Fulfillment Deliveries
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryFulfillmentDelivery&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryFulfillmentDelivery>

## Description

The method allows you to create a new fulfillment delivery in draft status. A fulfillment delivery represents a shipment of products from a source warehouse to a fulfillment center.

## Input Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| warehouse_id | int | Source warehouse identifier. |
| fulfillment_warehouse_id | int | Fulfillment warehouse identifier. |
| name | varchar(80) | Delivery name. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| delivery_id | int | Created delivery identifier. |
| document_number | text | Generated document number. |

## Example request

```json
{
  "warehouse_id": 1,
  "fulfillment_warehouse_id": 5,
  "name": "Delivery March 2026"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "delivery_id": 42,
  "document_number": "FD/1/03/2026"
}
```

## PHP example

```php
<?php
$methodParams = '{ "warehouse_id": 1, "fulfillment_warehouse_id": 5, "name": "Delivery March 2026" }';

$apiParams = [
  "method"     => "addInventoryFulfillmentDelivery",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
