# getInventoryCategories

**Category:** Categories
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryCategories&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryCategories>

## Description

The method retrieves a list of categories available within a BaseLinker catalog system.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | No | Catalog identifier obtainable via `getInventories` method. Omit this field to retrieve categories across all BaseLinker catalogs. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| categories | array | Array of category objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `categories[]` fields

| Field | Type | Description |
|-------|------|-------------|
| category_id | int | Unique category identifier. |
| name | varchar(200) | Category designation. |
| parent_id | int | Identifier of parent category. |

## Example request

```json
{}
```

## Example response

```json
{
  "status": "SUCCESS",
  "categories": [
    {
      "category_id": 5,
      "name": "Products",
      "parent_id": 0
    },
    {
      "category_id": 6,
      "name": "Textiles",
      "parent_id": 5
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{}';

$apiParams = [
  "method"     => "getInventoryCategories",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
