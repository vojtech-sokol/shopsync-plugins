# addOrderReturnProduct

**Category:** Return Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addOrderReturnProduct&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addOrderReturnProduct>

## Description

Add new product to existing order return.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| return_id | int | Yes | Order return identifier. |
| order_product_id | int | No | ID of connected order item from BaseLinker order manager. |
| storage | varchar(9) | No | Type of product source storage — `db` (BaseLinker internal inventory), `shop` (online shop storage), `warehouse` (connected wholesaler). |
| storage_id | varchar(50) | No | Identifier of the storage (inventory/shop/warehouse). |
| product_id | varchar(50) | No | Product identifier in BaseLinker or shop storage. Blank if the product number is not known. |
| variant_id | varchar(30) | No | Product variant ID. Blank if the variant number is unknown. |
| auction_id | varchar(20) | No | Listing ID number (if the order comes from ebay/allegro). |
| name | varchar(200) | No | Product name. |
| sku | varchar(50) | No | Product SKU number. |
| ean | varchar(32) | No | Product EAN number. |
| location | varchar(50) | No | Product location. |
| warehouse_id | int | No | Product source warehouse identifier (only applies to products from BaseLinker inventory). By default determined based on warehouse identifiers in existing products of the return. |
| attributes | varchar(350) | No | Detailed product attributes (e.g. `Colour: blue` — variant name). |
| price_brutto | float | No | Single item gross price. |
| tax_rate | float | No | VAT rate (0–100). Special values: `-1` (EXPT/ZW exempt), `-0.02` (NP), `-0.03` (OO reverse charge). |
| quantity | int | No | Number of pieces. |
| weight | decimal(10,2) | No | Single piece weight. |
| status_id | int | No | Identifier of return item status. List via `getOrderReturnProductStatuses`. |
| return_reason_id | int | No | Identifier of return reason. List via `getOrderReturnReasonsList`. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| order_return_product_id | int | Identifier of the item added to the return. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "return_id": 60,
  "order_product_id": 59157160,
  "storage": "db",
  "storage_id": 0,
  "product_id": "5434",
  "variant_id": 52124,
  "auction_id": "1234567890",
  "name": "Harry Potter and the Chamber of Secrets",
  "sku": "LU4235",
  "ean": "1597368451236",
  "location": "A1-13-7",
  "attributes": "colour red",
  "price_brutto": 20,
  "tax_rate": 23,
  "quantity": 2,
  "weight": 1,
  "status_id": 1003,
  "return_reason_id": 1006
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "order_return_product_id": 591571
}
```

## PHP example

```php
<?php
$methodParams = '{
  "return_id": 60,
  "order_product_id": 59157160,
  "storage": "db",
  "storage_id": 0,
  "product_id": "5434",
  "variant_id": 52124,
  "auction_id": "1234567890",
  "name": "Harry Potter and the Chamber of Secrets",
  "sku": "LU4235",
  "ean": "1597368451236",
  "location": "A1-13-7",
  "attributes": "colour red",
  "price_brutto": 20,
  "tax_rate": 23,
  "quantity": 2,
  "weight": 1,
  "status_id": 1003,
  "return_reason_id": 1006
}';

$apiParams = [
  "method"     => "addOrderReturnProduct",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
