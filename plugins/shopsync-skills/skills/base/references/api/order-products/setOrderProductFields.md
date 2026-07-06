# setOrderProductFields

**Category:** Order Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrderProductFields&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrderProductFields>

## Description

The method allows you to edit the data of selected items (e.g. prices, quantities etc.) of a specific order. Only fields needing modification should be included; others can be omitted.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order identifier from BaseLinker order manager. |
| order_product_id | int | Yes | Order item ID from BaseLinker order manager. |
| storage | varchar(9) | No | Product source storage type: `db` (internal inventory), `shop` (online shop), `warehouse` (wholesaler). |
| storage_id | varchar(50) | No | Storage identifier (inventory/shop/warehouse). |
| product_id | varchar(50) | No | Product identifier in BaseLinker or shop storage. |
| variant_id | varchar(30) | No | Product variant ID. |
| auction_id | varchar(20) | No | Listing ID (eBay/Allegro orders). |
| name | varchar(200) | No | Product name. |
| sku | varchar(50) | No | Product SKU number. |
| ean | varchar(32) | No | Product EAN number. |
| location | varchar(50) | No | Product location. |
| warehouse_id | int | No | Product source warehouse identifier (BaseLinker inventory only). |
| attributes | varchar(350) | No | Detailed product attributes (e.g., `Colour: blue`). |
| price_brutto | float | No | Single item gross price. |
| tax_rate | float | No | VAT tax rate (0–100); special values: `-1` (`EXPT`/`ZW`), `-0.02` (`NP`), `-0.03` (`OO`). |
| quantity | int | No | Number of pieces. |
| weight | float | No | Single piece weight. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Error description (when status is `ERROR`). |
| error_code | int | Error code (when status is `ERROR`). |

## Example request

```json
{
  "order_id": 3754894,
  "order_product_id": 59157160,
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
$methodParams = '{ "order_id": 3754894, "order_product_id": 59157160, "attributes": "new product attribute", "quantity": 5 }';

$apiParams = [
  "method"     => "setOrderProductFields",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
