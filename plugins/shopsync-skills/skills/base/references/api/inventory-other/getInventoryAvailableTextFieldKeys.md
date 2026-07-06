# getInventoryAvailableTextFieldKeys

**Category:** Inventory — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryAvailableTextFieldKeys&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryAvailableTextFieldKeys>

## Description

The method retrieves a list of product text fields that can be overwritten for specific integration.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | Yes | Catalog ID. The list of identifiers can be retrieved by the `getInventories` method (`inventory_id` field). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| text_field_keys | array | A list containing product text fields, where the key is the code of the text field and the value is the text field name. |

## Example request

```json
{
  "inventory_id": 307
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "text_field_keys": {
    "name": "Product name (EN)",
    "description": "Description (EN)",
    "description_extra1": "Additional description 1 (EN)",
    "description_extra2": "Additional description 2 (EN)",
    "description_extra3": "Additional description 3 (EN)",
    "description_extra4": "Additional description 4 (EN)",
    "features": "Parameters (EN)",
    "extra_field_201": "Short text field",
    "extra_field_202": "Select field",
    "extra_field_203": "Long (translated) text field (DE)",
    "name|de|ebay_0": "eBay - Product name (DE)",
    "description|de|ebay_0": "eBay - Description (DE)",
    "description_extra1|de|ebay_0": "eBay - Additional description 1 (DE)",
    "description_extra2|de|ebay_0": "eBay - Additional description 2 (DE)",
    "description_extra3|de|ebay_0": "eBay - Additional description 3 (DE)",
    "description_extra4|de|ebay_0": "eBay - Additional description 4 (DE)",
    "features|de|ebay_0": "eBay - Parameters (DE)",
    "extra_field_4|de|ebay_0": "eBay - translated field (DE)",
    "name|de|ebay_301": "eBay [eBay Account 301] - Product name (DE)",
    "description|de|ebay_301": "eBay [eBay Account 301] - Description (DE)",
    "description_extra1|de|ebay_301": "eBay [eBay Account 301] - Additional description 1 (DE)",
    "description_extra2|de|ebay_301": "eBay [eBay Account 301] - Additional description 2 (DE)",
    "description_extra3|de|ebay_301": "eBay [eBay Account 301] - Additional description 3 (DE)",
    "description_extra4|de|ebay_301": "eBay [eBay Account 301] - Additional description 4 (DE)",
    "features|de|ebay_301": "eBay [eBay Account 301] - Parameters (DE)",
    "extra_field_4|de|ebay_301": "eBay [eBay Account 301] - Long (translated) text field (DE)"
  }
}
```

## PHP example

```php
<?php
$methodParams = '{ "inventory_id": 307 }';

$apiParams = [
  "method"     => "getInventoryAvailableTextFieldKeys",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
