# getExternalStoragesList

**Category:** External Storage
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getExternalStoragesList&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getExternalStoragesList>

## Description

The method allows you to retrieve a list of available external storages (shops, wholesalers) that can be referenced via API.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` (request executed correctly) or `ERROR` (with `error_message` and `error_code` fields). |
| storages | array | Array of storage objects. |

### `storages[]` fields

| Field | Type | Description |
|-------|------|-------------|
| storage_id | varchar(30) | Format is `[type:shop\|warehouse]_[id:int]` (e.g. `shop_2445`). |
| name | varchar(100) | The storage name. |
| methods | array | List of method names supported by that storage. |
| read | bool | Read permission status for the storage. |
| write | bool | Write permission status for the storage. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "storages": [
    {
      "storage_id": "shop_2444",
      "name": "Online store",
      "methods": [
        "getExternalStorageCategories",
        "getExternalStorageProductsData",
        "getExternalStorageProductsList",
        "getExternalStorageProductsPrices",
        "getExternalStorageProductsQuantity",
        "updateExternalStorageProductsQuantity"
      ],
      "read": true,
      "write": false
    },
    {
      "storage_id": "warehouse_1334",
      "name": "Wholesaler",
      "methods": [
        "getExternalStorageCategories",
        "getExternalStorageProductsData",
        "getExternalStorageProductsList",
        "getExternalStorageProductsPrices",
        "getExternalStorageProductsQuantity"
      ],
      "read": true,
      "write": false
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getExternalStoragesList",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
