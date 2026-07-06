# getExternalStorageProductsList

**Category:** External Storage
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getExternalStorageProductsList&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getExternalStorageProductsList>

## Description

The method allows to retrieve detailed data of selected products from an external storage (shop/wholesaler) connected to BaseLinker.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| storage_id | varchar(30) | Yes | Storage ID in format `[type:shop\|warehouse]_[id:int]` (e.g. `shop_2445`). |
| filter_category_id | varchar(30) | No | Retrieve products from a specific category. |
| filter_sort | varchar(30) | No | Sort product list: `id [ASC\|DESC]`, `name [ASC\|DESC]`, `quantity [ASC\|DESC]`, `price [ASC\|DESC]`. |
| filter_id | varchar(30) | No | Limit results to specific product ID. |
| filter_sku | varchar(32) | No | Limit results to specific SKU. |
| filter_ean | varchar(320) | No | Limit results to specific EAN. |
| filter_asin | varchar(50) | No | Limit results to specific ASIN. |
| filter_name | varchar(100) | No | Item name filter (part of name or empty field). |
| filter_price_from | float | No | Minimum price limit. |
| filter_price_to | float | No | Maximum price limit. |
| filter_quantity_from | int | No | Minimum quantity limit. |
| filter_quantity_to | int | No | Maximum quantity limit. |
| filter_available | int | No | `1` = available only, `0` = unavailable only, empty = all. |
| page | int | No | Results paging. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR` (with `error_message` and `error_code` fields). |
| storage_id | varchar(30) | Storage ID in format `[type:shop\|warehouse]_[id:int]`. |
| products | array | Array of product objects. |

### `products[]` fields

| Field | Type | Description |
|-------|------|-------------|
| product_id | varchar(30) | Main product ID. |
| sku | varchar(32) | Product SKU number. |
| ean | varchar(32) | Product EAN number. |
| asin | varchar(50) | Product ASIN number. |
| name | varchar(200) | Product name. |
| quantity | int | Stock quantity. |
| price_brutto | float | Product gross price (net price unavailable). |

## Example request

```json
{
  "storage_id": "shop_2445",
  "filter_category_id": 543
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "storage_id": "shop_2445",
  "products": [
    {
      "product_id": "2546",
      "sku": "PL53F",
      "ean": "63576363463",
      "asin": "B07EXAMPLE3",
      "name": "Nike PL35 shoes",
      "quantity": 5,
      "price_brutto": 254.55
    },
    {
      "product_id": "6532",
      "sku": "ZF55F",
      "ean": "6345623525",
      "asin": "B07EXAMPLE4",
      "name": "Adidas ZF3 shoes",
      "quantity": 2,
      "price_brutto": 455.76
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "storage_id": "shop_2445", "filter_category_id": 543 }';

$apiParams = [
  "method"     => "getExternalStorageProductsList",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
