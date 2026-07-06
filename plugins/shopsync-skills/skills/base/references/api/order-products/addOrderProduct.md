# addOrderProduct

**Category:** Order Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addOrderProduct&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addOrderProduct>

## Description

The method allows you to add a new product to your order.

## Input Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| order_id | int | Order identifier from BaseLinker order manager. |
| storage | varchar(9) | Product source storage type: `db` (internal inventory), `shop` (online shop), or `warehouse` (wholesaler). |
| storage_id | varchar(50) | Storage identifier for inventory/shop/warehouse source. |
| product_id | varchar(50) | Product identifier in BaseLinker or shop storage; optional. |
| variant_id | varchar(30) | Product variant ID; optional if unknown. |
| auction_id | varchar(20) | Listing ID for eBay/Allegro orders. |
| name | varchar(200) | Product name. |
| sku | varchar(50) | Product SKU number. |
| ean | varchar(32) | Product EAN number. |
| location | varchar(50) | Product location; multiple locations separated by semicolons. |
| warehouse_id | int | Source warehouse identifier for BaseLinker inventory products. |
| attributes | varchar(350) | Product attributes detail, e.g., variant name. |
| price_brutto | float | Single item gross price. |
| tax_rate | float | VAT rate (0–100); special values: `-1` exempt, `-0.02` NP, `-0.03` reverse charge. |
| quantity | int | Number of pieces. |
| weight | decimal(10,2) | Single piece weight. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR` with `error_message` and `error_code` on failure. |
| order_product_id | int | Identifier of item added to order. |

## Example request

```json
{
  "order_id": 3754894,
  "storage": "db",
  "storage_id": 0,
  "product_id": "5434",
  "variant_id": 52124,
  "name": "Harry Potter and the Chamber of Secrets",
  "sku": "LU4235",
  "ean": "1597368451236",
  "location": "A1-13-7",
  "attributes": "colour red",
  "price_brutto": 20,
  "tax_rate": 23,
  "quantity": 2,
  "weight": 1
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "order_product_id": 59157160
}
```

## PHP example

```php
<?php
$methodParams = '{"order_id": 3754894, "storage": "db", "storage_id": 0, "product_id": "5434", "variant_id": 52124, "name": "Harry Potter and the Chamber of Secrets", "sku": "LU4235", "ean": "1597368451236", "location": "A1-13-7", "attributes": "colour red", "price_brutto": 20, "tax_rate": 23, "quantity": 2, "weight": 1}';

$apiParams = [
  "method"     => "addOrderProduct",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
