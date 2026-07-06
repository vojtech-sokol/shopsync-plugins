# getInventoryProductsPrices

**Category:** Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryProductsPrices&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryProductsPrices>

## Description

The method allows to retrieve the gross prices of products from BaseLinker inventories.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | Yes | Catalog ID. The list of identifiers can be retrieved using the method `getInventories`. |
| page | int | No | Results paging (1000 products per page for BaseLinker warehouse). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR` (with `error_message` and `error_code` on failure). |
| products | array | A list containing product prices, where the key is the product ID and the value is an object — see fields below. |

### `products[<product_id>]` fields

| Field | Type | Description |
|-------|------|-------------|
| prices | object | Keyed by price group identifier; value is the gross price set for that price group. |
| variants | array | Keyed by variant ID; value is an object keyed by price group identifier with gross prices. |

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
      "prices": {
        "105": 20.99,
        "106": 23.99
      }
    },
    "2686": {
      "prices": {
        "105": 21.99,
        "106": 24.99
      },
      "variants": {
        "2687": {
          "105": 21.99,
          "106": 23.99
        },
        "2688": {
          "105": 20.99,
          "106": 22.99
        }
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
  "method"     => "getInventoryProductsPrices",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
