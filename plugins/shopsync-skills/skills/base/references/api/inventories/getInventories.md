# getInventories

**Category:** Inventories
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventories&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventories>

## Description

The method allows you to retrieve a list of catalogs available in the BaseLinker storage.

## Input Parameters

_None._ Input data is an empty array: `[]`.

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| inventories | array | Array of catalog objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `inventories[]` fields

| Field | Type | Description |
|-------|------|-------------|
| inventory_id | int | Catalog identifier. |
| name | varchar(100) | Catalog name. |
| description | text | Catalog description. |
| languages | array | Available languages in the catalog. |
| default_language | char(2) | Primary language setting. |
| price_groups | array | Price group IDs available in catalog. |
| default_price_group | int | Default price group identifier. |
| warehouses | array | Warehouse IDs available in catalog. |
| default_warehouse | varchar(30) | Primary warehouse identifier. |
| reservations | bool | Indicates reservation support capability. |
| is_default | bool | Indicates if catalog is default. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "inventories": [
    {
      "inventory_id": 306,
      "name": "Default",
      "description": "Default catalog",
      "languages": ["en"],
      "default_language": "en",
      "price_groups": [105],
      "default_price_group": 105,
      "warehouses": ["bl_205", "shop_2334", "warehouse_4556"],
      "default_warehouse": "bl_205",
      "reservations": false,
      "is_default": true
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getInventories",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
