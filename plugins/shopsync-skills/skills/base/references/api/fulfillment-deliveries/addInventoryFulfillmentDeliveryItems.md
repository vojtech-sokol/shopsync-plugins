# addInventoryFulfillmentDeliveryItems

**Category:** Fulfillment Deliveries
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryFulfillmentDeliveryItems&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryFulfillmentDeliveryItems>

## Description

The method allows you to add products to a fulfillment delivery. Items can only be added to deliveries in draft status. Products must meet specific criteria: they must exist in inventory and cannot be bundles, drafts, or main products with variants.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| delivery_id | int | Yes | Fulfillment delivery identifier. |
| items | array | Yes | Array of items to add to the delivery — see fields below. |

### `items[]` fields

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| product_id | int | Yes | Product identifier. |
| quantity | int | Yes | Quantity of the product. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| items | array | Array of added items — see fields below. |

### Response `items[]` fields

| Field | Type | Description |
|-------|------|-------------|
| item_id | int | Created item identifier. |
| product_id | int | Product identifier. |
| product_sku | text | Product SKU. |
| quantity | int | Total quantity after addition. |

## Example request

```json
{
  "delivery_id": 42,
  "items": [
    {"product_id": 101, "quantity": 10},
    {"product_id": 102, "quantity": 5}
  ]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "items": [
    {"item_id": 1, "product_id": 101, "product_sku": "SKU-001", "quantity": 10},
    {"item_id": 2, "product_id": 102, "product_sku": "SKU-002", "quantity": 5}
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"delivery_id": 42, "items": [{"product_id": 101, "quantity": 10}, {"product_id": 102, "quantity": 5}]}';

$apiParams = [
  "method"     => "addInventoryFulfillmentDeliveryItems",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
