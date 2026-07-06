# addInventory

**Category:** Inventories
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventory&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventory>

## Description

The method allows you to add the BaseLinker catalogs. Adding a catalog with the same identifier again will cause updates of the previously saved catalog.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | No | Catalog ID retrievable via `getInventories` method. |
| name | varchar(100) | Yes | Catalog name. |
| description | text | No | Catalog description. |
| languages | array | Yes | Available languages in inventory. |
| default_language | char(2) | Yes | Default inventory language. Must be included in the `languages` parameter. |
| price_groups | array | Yes | Price group identifiers available in inventory (from `getInventoryPriceGroups`). |
| default_price_group | int | Yes | ID of the price group default for the inventory. The identifier must be included in the `price_groups` parameter. |
| warehouses | array | Yes | Warehouse identifiers available in the inventory. Format: `[type:bl\|shop\|warehouse]_[id:int]` (e.g., `shop_2445`). |
| default_warehouse | varchar(30) | Yes | Identifier of the warehouse default for the inventory. The identifier must be included in the `warehouses` parameter. |
| reservations | bool | No | Whether inventory supports reservations. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| inventory_id | int | Returned catalog ID. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "name": "Additional catalog",
  "description": "Additional product catalog",
  "languages": ["en", "de"],
  "default_language": "en",
  "price_groups": [105],
  "default_price_group": 105,
  "warehouses": ["bl_205", "shop_2334"],
  "default_warehouse": "bl_205",
  "reservations": true
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "inventory_id": 307
}
```

## PHP example

```php
<?php
$methodParams = '{
  "name": "Additional catalog",
  "description": "Additional product catalog",
  "languages": ["en", "de"],
  "default_language": "en",
  "price_groups": [105],
  "default_price_group": 105,
  "warehouses": ["bl_205", "shop_2334"],
  "default_warehouse": "bl_205",
  "reservations": true
}';

$apiParams = [
  "method"     => "addInventory",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
