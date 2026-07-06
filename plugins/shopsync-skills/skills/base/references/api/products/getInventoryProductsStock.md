# getInventoryProductsStock

**Category:** Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryProductsStock&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryProductsStock>

## Description

The method allows you to retrieve stock data of products from BaseLinker catalogs.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | Yes | Catalog ID retrievable via `getInventories` method. |
| page | int | No | Results paging (1000 products per page for BaseLinker warehouse). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR` (with `error_message` and `error_code` on failure). |
| products | array | Product stocks indexed by product ID — see fields below. |

### `products[<product_id>]` fields

| Field | Type | Description |
|-------|------|-------------|
| product_id | int | Product identifier. |
| stock | array | Warehouse stocks keyed by warehouse ID (format `[type]_[id]`, e.g. `bl_123`). |
| reservations | array | Reserved stock by warehouse (when enabled). |
| variants | array | Variant stocks indexed by variant ID, with warehouse-keyed values. |

## Example request

```json
{
  "inventory_id": "307"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "products": {
    "2685": {
      "product_id": 2685,
      "stock": { "bl_206": 5, "bl_207": 7 },
      "reservations": { "bl_206": 0, "bl_207": 2 }
    },
    "2686": {
      "product_id": 2686,
      "stock": { "bl_206": 5, "bl_207": 7 },
      "reservations": { "bl_206": 1, "bl_207": 3 },
      "variants": {
        "2687": { "bl_206": 2, "bl_207": 4 },
        "2688": { "bl_206": 3, "bl_207": 3 }
      }
    }
  }
}
```

## PHP example

```php
<?php
$methodParams = '{ "inventory_id": "307" }';

$apiParams = [
  "method"     => "getInventoryProductsStock",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
