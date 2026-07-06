# updateExternalStorageProductsQuantity

**Category:** External Storage
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=updateExternalStorageProductsQuantity&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=updateExternalStorageProductsQuantity>

## Description

The method allows to bulk update the product stock (and/or variants) in an external storage (shop/wholesaler) connected to BaseLinker. Maximum 1000 products at a time.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| storage_id | varchar(30) | Yes | Storage ID in format `[type:shop\|warehouse]_[id:int]` (e.g. `shop_2445`). |
| products | array | Yes | An array of products. Each product is a separate element of the array. The product consists of a 3-element array of components. |

### `products[]` structure

Each product is a three-element array:

| Index | Type | Description |
|-------|------|-------------|
| [0] | varchar | Product ID number. |
| [1] | int | Variant ID number; use `0` for main product, not variant. |
| [2] | int | Stock quantity. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` (request executed correctly) or `ERROR` (with `error_message` and `error_code` fields). |
| counter | int | Number of received items. |
| warnings | array | Contains warning notices for product updates. Keys are identifiers of sent items; values are error messages. Only keys with errors are returned. |

## Example request

```json
{
  "storage_id": "shop_2445",
  "products": [
    [1081730, 0, 100],
    [1081730, 1734642, 150]
  ]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "counter": 4,
  "warnings": ""
}
```

## PHP example

```php
<?php
$methodParams = '{ "storage_id": "shop_2445", "products": [ [ 1081730, 0, 100 ], [ 1081730, 1734642, 150 ] ] }';

$apiParams = [
  "method"     => "updateExternalStorageProductsQuantity",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
