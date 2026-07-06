# addInventoryCategory

**Category:** Categories
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryCategory&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryCategory>

## Description

The method allows you to add a category to the BaseLinker catalog. Adding a category with the same identifier again, updates the previously saved category.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | No | Catalog ID retrieved via `getInventories` method. Omit this field to create a category available across all BaseLinker catalogs. |
| category_id | int | No | Category identifier for updates; leave blank when creating new categories. |
| name | varchar(200) | Yes | Category name. |
| parent_id | int | Yes | Parent category identifier from previous `addCategory` output. Top-level categories use `parent_id` of 0. Categories should be added starting from the hierarchy root so that the child is always added after the parent. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| category_id | int | Number of a category added or updated in BaseLinker storage. In an external application you should create a link between the internal number and the number received here. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | int | Present on `ERROR` status. |

## Example request

```json
{
  "name": "Textiles",
  "parent_id": 5
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "category_id": 6
}
```

## PHP example

```php
<?php
$methodParams = '{ "name": "Textiles", "parent_id": 5 }';

$apiParams = [
  "method"     => "addInventoryCategory",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
