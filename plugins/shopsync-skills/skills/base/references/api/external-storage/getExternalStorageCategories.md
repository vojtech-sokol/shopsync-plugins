# getExternalStorageCategories

**Category:** External Storage
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getExternalStorageCategories&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getExternalStorageCategories>

## Description

The method allows you to retrieve a category list from an external storage (shop/wholesale) connected to BaseLinker.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| storage_id | varchar(30) | Yes | Storage ID in format `[type:shop\|warehouse]_[id:int]` (e.g. `shop_2445`). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` (request executed correctly) or `ERROR` (with `error_message` and `error_code` fields). |
| storage_id | varchar(30) | Echo of input storage identifier in `[type:shop\|warehouse]_[id:int]` format. |
| categories | array | Collection of category objects. |

### `categories[]` fields

| Field | Type | Description |
|-------|------|-------------|
| category_id | int | Numeric category identifier. |
| name | varchar(200) | Textual category designation. |
| parent_id | int | Parent category numeric reference. |

## Example request

```json
{ "storage_id": "shop_2445" }
```

## Example response

```json
{
  "status": "SUCCESS",
  "storage_id": "shop_2445",
  "categories": [
    {
      "category_id": 235,
      "name": "Shoes",
      "parent_id": 0
    },
    {
      "category_id": 654,
      "name": "Winter shoes",
      "parent_id": 235
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "storage_id": "shop_2445" }';

$apiParams = [
  "method"     => "getExternalStorageCategories",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
