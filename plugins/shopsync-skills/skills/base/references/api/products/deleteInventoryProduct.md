# deleteInventoryProduct

**Category:** Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteInventoryProduct&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteInventoryProduct>

## Description

The method allows you to remove the product from BaseLinker catalog.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| product_id | int | Yes | BaseLinker inventory product identifier. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |

## Example request

```json
{
  "product_id": 8
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
$methodParams = '{ "product_id": 8 }';

$apiParams = [
  "method"     => "deleteInventoryProduct",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
