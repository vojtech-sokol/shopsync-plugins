# updateInventoryProductsPrices

**Category:** Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=updateInventoryProductsPrices&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=updateInventoryProductsPrices>

## Description

The method allows bulk update of gross prices of products (and/or their variants) in the BaseLinker catalog. Maximum 1000 products at a time.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | Yes | Catalog ID. The list of identifiers can be retrieved using the method `getInventories`. |
| products | array | Yes | An array of products, where the key is a product ID and the value is a list of prices. When determining the variant price, provide variant ID as a product ID. In the prices array the key should be the price group ID and the value — price for that price group. The list of price groups can be retrieved using the `getInventoryPriceGroups` method. |

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
      "105": 21.99,
      "106": 24.99
    },
    "2687": {
      "105": 21.99,
      "106": 23.99
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
$methodParams = '{ "inventory_id": "307", "products": { "2685": { "105": 21.99, "106": 24.99 }, "2687": { "105": 21.99, "106": 23.99 } } }';

$apiParams = [
  "method"     => "updateInventoryProductsPrices",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
