# getExternalStorageProductsQuantity

**Category:** External Storage
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getExternalStorageProductsQuantity&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getExternalStorageProductsQuantity>

## Description

The method allows to retrieve stock from an external storage (shop/wholesaler) connected to BaseLinker.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| storage_id | varchar(30) | Yes | Storage ID in format `[type:shop\|warehouse]_[id:int]` (e.g. `shop_2445`). |
| page | int | No | Results paging. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` (request executed correctly) or `ERROR` (with `error_message` and `error_code` fields). |
| storage_id | varchar(30) | Storage ID in format `[type:shop\|warehouse]_[id:int]`. |
| products | array | Collection of product objects. |

### `products[]` fields

| Field | Type | Description |
|-------|------|-------------|
| product_id | varchar(30) | Main product ID. |
| quantity | int | Stock quantity. |
| variants | array | Collection of variant objects. |

### `variants[]` fields

| Field | Type | Description |
|-------|------|-------------|
| variant_id | varchar(30) | Variant main identifier. |
| quantity | int | Stock quantity. |

## Example request

```json
{ "storage_id": "shop_2445" }
```

## Example response

```json
{
  "status": "SUCCESS",
  "storage_id": "shop_2445",
  "products": [
    {
      "product_id": "2546",
      "quantity": 30,
      "variants": [{ "variant_id": "7231", "quantity": 14 }]
    },
    { "product_id": "6532", "quantity": 11, "variants": [] }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "storage_id": "shop_2445" }';

$apiParams = [
  "method"     => "getExternalStorageProductsQuantity",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
