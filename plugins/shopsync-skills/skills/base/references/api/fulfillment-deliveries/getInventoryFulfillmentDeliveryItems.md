# getInventoryFulfillmentDeliveryItems

**Category:** Fulfillment Deliveries
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryFulfillmentDeliveryItems&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryFulfillmentDeliveryItems>

## Description

The method allows you to retrieve items from a specific fulfillment delivery. Results are paginated with 100 results per page.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| delivery_id | int | Yes | Fulfillment delivery identifier. |
| page | int | No | Results page (0-based, 100 results per page). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| items | array | Array of delivery items — see fields below. |
| error_message | varchar | Returned on error. |
| error_code | varchar | Returned on error. |

### `items[]` fields

| Field | Type | Description |
|-------|------|-------------|
| item_id | int | Item identifier. |
| position | int | Item position in the delivery. |
| product_id | int | Product identifier. |
| product_name | varchar(200) | Product name. |
| product_ean | varchar(32) | Product EAN. |
| product_sku | varchar(50) | Product SKU. |
| quantity | int | Quantity. |
| received_quantity | int\|null | Received quantity (null by default). |

## Example request

```json
{
  "delivery_id": 42
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "items": [
    {
      "item_id": 1,
      "position": 0,
      "product_id": 101,
      "product_name": "Product A",
      "product_ean": "5901234123457",
      "product_sku": "SKU-001",
      "quantity": 10,
      "received_quantity": 10
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "delivery_id": 42 }';

$apiParams = [
  "method"     => "getInventoryFulfillmentDeliveryItems",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
