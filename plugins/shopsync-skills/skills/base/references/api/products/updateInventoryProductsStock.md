# updateInventoryProductsStock

**Category:** Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=updateInventoryProductsStock&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=updateInventoryProductsStock>

## Description

The method allows to update stocks of products (and/or their variants) in BaseLinker catalog. Maximum 1000 products at a time.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | Yes | Catalog ID. The list of identifiers can be retrieved using the `getInventories` method. |
| products | array | Yes | An array of products, where the key is a product ID and the value is a list of stocks. When determining variant stock, provide variant ID as product ID. In the stocks array, the key should be warehouse ID and the value should be stock for that warehouse. Warehouse identifier format: `[type:bl\|shop\|warehouse]_[id:int]` (e.g. `bl_123`). The `getInventoryWarehouses` method retrieves warehouse identifiers. Stocks **cannot be assigned** to the warehouses created automatically for purposes of keeping external stocks (shops, wholesalers, etc.). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| counter | int | Number of updated products. |
| warnings | array | Warning list for product updates. The key of each element is the product identifier, the value is the update error message. Only the keys containing an error are returned. |

## Example request

```json
{
  "inventory_id": "307",
  "products": {
    "2685": {
      "bl_206": 5,
      "bl_207": 7
    },
    "2687": {
      "bl_206": 2,
      "bl_207": 4
    }
  }
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "counter": 2,
  "warnings": ""
}
```

## PHP example

```php
<?php
$methodParams = '{ "inventory_id": "307", "products": { "2685": { "bl_206": 5, "bl_207": 7 }, "2687": { "bl_206": 2, "bl_207": 4 } } }';

$apiParams = [
  "method"     => "updateInventoryProductsStock",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
