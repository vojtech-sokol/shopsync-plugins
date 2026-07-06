# getInventoryWarehouses

**Category:** Warehouses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryWarehouses&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryWarehouses>

## Description

The method allows you to retrieve a list of warehouses available in BaseLinker inventories. The list includes warehouses created automatically for the purpose of keeping external stocks (shops, wholesalers etc.).

## Input Parameters

_None._ Input data is an empty array: `[]`.

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| warehouses | array | Array of warehouse objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `warehouses[]` fields

| Field | Type | Description |
|-------|------|-------------|
| warehouse_type | varchar(30) | Identifies warehouse category; `bl` denotes BaseLinker-native warehouses; other values reflect integration type (e.g., `shop`, `warehouse`, `fulfillment`, `blconnect`). |
| warehouse_id | int | Warehouse identifier. |
| name | varchar(100) | Warehouse name. |
| description | text | Warehouse description. |
| stock_edition | bool | Indicates whether manual stock editing is permitted; false means stock editing only via API. |
| is_default | bool | Indicates if warehouse is default. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "warehouses": [
    {
      "warehouse_type": "bl",
      "warehouse_id": 205,
      "name": "Default",
      "description": "Default warehouse located in London",
      "stock_edition": true,
      "is_default": true
    },
    {
      "warehouse_type": "shop",
      "warehouse_id": 2334,
      "name": "MyShop.com",
      "description": "Warehouse keeping stocks for Myshop.com",
      "stock_edition": false,
      "is_default": false
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getInventoryWarehouses",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
