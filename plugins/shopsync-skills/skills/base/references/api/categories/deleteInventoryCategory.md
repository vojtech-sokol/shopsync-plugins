# deleteInventoryCategory

**Category:** Categories
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteInventoryCategory&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteInventoryCategory>

## Description

The method allows you to remove categories from BaseLinker warehouse. Along with the category, the products contained therein are removed (however, this does not apply to products in subcategories). The subcategories will be changed to the highest level categories.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| category_id | int | Yes | The number of the category to be removed in the BaseLinker storage. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "category_id": 6
}
```

## Example response

```json
{
  "status": "SUCCESS"
}
```

## PHP example

```php
<?php
$methodParams = '{ "category_id": 6 }';

$apiParams = [
  "method"     => "deleteInventoryCategory",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
