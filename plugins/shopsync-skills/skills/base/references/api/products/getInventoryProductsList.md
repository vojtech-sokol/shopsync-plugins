# getInventoryProductsList

**Category:** Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryProductsList&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryProductsList>

## Description

The method allows to retrieve a basic data of chosen products from BaseLinker catalogs.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | Yes | Catalog identifier (retrieve list via `getInventories` method). |
| filter_id | int | No | Restrict results to specific product ID. |
| filter_category_id | int | No | Retrieve products from specific category. |
| filter_ean | varchar(32) | No | Limit results to specific EAN including additional product EANs. |
| filter_sku | varchar(50) | No | Restrict results to specific SKU. |
| filter_name | varchar(200) | No | Item name filter (partial match or empty field). |
| filter_price_from | float | No | Minimum price threshold. |
| filter_price_to | float | No | Maximum price threshold. |
| filter_stock_from | int | No | Minimum quantity limit. |
| filter_stock_to | int | No | Maximum quantity limit. |
| page | int | No | Results pagination (1000 products per page for BaseLinker warehouse). |
| filter_sort | varchar(30) | No | Sorting values: `id [ASC\|DESC]`. |
| filter_locations | varchar(20) | No | Filter by location name. |
| include_variants | bool | No | Include product variants additionally to products. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR` (with `error_message` and `error_code` on failure). |
| products | array | Products indexed by product ID — see fields below. |

### `products[<product_id>]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | int | Product ID. |
| parent_id | int | `0` for main products; main product ID for variants. |
| ean | varchar(32) | Product EAN. |
| sku | varchar(32) | Product SKU. |
| name | varchar(200) | Product name. |
| prices | array | Gross prices keyed by price group ID. |
| stock | array | Stock quantities keyed by warehouse ID (format `[type]_[id]`). |

## Example request

```json
{
  "inventory_id": 307,
  "filter_id": 2685
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "products": {
    "2685": {
      "id": 2685,
      "parent_id": 0,
      "ean": "63576363463",
      "sku": "PL53F",
      "name": "Nike PL35 shoes",
      "prices": {"105": 20.99, "106": 23.99},
      "stock": {"bl_206": 5, "bl_207": 7}
    },
    "2686": {
      "id": 2686,
      "parent_id": 0,
      "ean": "6345623525",
      "sku": "ZF55F",
      "name": "Adidas ZF3 shoes",
      "prices": {"105": 21.99, "106": 24.99},
      "stock": {"bl_206": 8, "bl_207": 9}
    }
  }
}
```

## PHP example

```php
<?php
$methodParams = '{"inventory_id": 307, "filter_id": 2685}';

$apiParams = [
  "method"     => "getInventoryProductsList",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
