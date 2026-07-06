# getExternalStorageProductsPrices

**Category:** External Storage
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getExternalStorageProductsPrices&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getExternalStorageProductsPrices>

## Description

The method retrieves product pricing information from an external storage system (shop or wholesaler) that has been connected to BaseLinker.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| storage_id | varchar(30) | Yes | Storage identifier formatted as `[type:shop\|warehouse]_[id:int]` (e.g. `shop_2445`). |
| page | int | No | Optional results paging parameter. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` (request executed correctly) or `ERROR` (with `error_message` and `error_code` fields). |
| storage_id | varchar(30) | Echo of the storage identifier. |
| products | array | Collection of product records. |

### `products[]` fields

| Field | Type | Description |
|-------|------|-------------|
| product_id | varchar(30) | Primary product identifier. |
| price | float | Product pricing. |
| variants | array | Collection of variant records. |

### `variants[]` fields

| Field | Type | Description |
|-------|------|-------------|
| variant_id | varchar(30) | Primary variant identifier. |
| price | float | Variant pricing. |

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
      "price": 199.90,
      "variants": [
        { "variant_id": "7231", "price": 189.90 }
      ]
    },
    {
      "product_id": "6532",
      "price": 79.90,
      "variants": []
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "storage_id": "shop_2445" }';

$apiParams = [
  "method"     => "getExternalStorageProductsPrices",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
