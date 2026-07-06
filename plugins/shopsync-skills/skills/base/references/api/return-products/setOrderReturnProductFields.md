# setOrderReturnProductFields

**Category:** Return Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrderReturnProductFields&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrderReturnProductFields>

## Description

The method allows you to edit the data of selected items (e.g. prices, quantities etc.) of a specific order.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| return_id | int | Yes | Order return identifier from the BaseLinker order manager. |
| order_return_product_id | int | Yes | Order return item ID from BaseLinker order manager. |
| storage | varchar(9) | No | Type of product source storage (`db`, `shop`, `warehouse`). |
| storage_id | varchar(50) | No | Identifier of the storage. |
| product_id | varchar(50) | No | Product identifier in BaseLinker or shop storage. |
| variant_id | varchar(30) | No | Product variant ID. |
| auction_id | varchar(20) | No | Listing ID number (eBay/Allegro orders). |
| name | varchar(200) | No | Product name. |
| sku | varchar(50) | No | Product SKU number. |
| ean | varchar(32) | No | Product EAN number. |
| location | varchar(50) | No | Product location. |
| warehouse_id | int | No | Product source warehouse identifier. |
| attributes | varchar(350) | No | Detailed product attributes (e.g. `Colour: blue`). |
| price_brutto | float | No | Single item gross price. |
| tax_rate | float | No | VAT rate (0–100, or special values: `-1`, `-0.02`, `-0.03`). |
| quantity | int | No | Number of pieces. |
| weight | decimal(10,2) | No | Single piece weight. |
| status_id | int | No | Identifier of product return status. |
| return_reason_id | int | No | Identifier of return reason. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "return_id": 1102,
  "order_return_product_id": 1232,
  "attributes": "new product attribute",
  "quantity": 5
}
```

## Example response

```json
{
  "status": "SUCCESS"
}
```

## PHP example

```php
<?php
$methodParams = '{
  "return_id": 1102,
  "order_return_product_id": 1232,
  "attributes": "new product attribute",
  "quantity": 5
}';

$apiParams = [
  "method"     => "setOrderReturnProductFields",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
