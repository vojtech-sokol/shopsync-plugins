# addInventoryWarehouse

**Category:** Warehouses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryWarehouse&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryWarehouse>

## Description

The method allows you to add a new warehouse available in BaseLinker inventories. Adding a warehouse with an identical identifier updates the previously saved warehouse. The method cannot edit warehouses created automatically for external stocks from shops or wholesalers. Such warehouses can be utilized in the `addInventory` method.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| warehouse_id | int | No | ID of the warehouse. Omit to create new. |
| name | varchar(100) | Yes | Warehouse name. |
| description | text | No | Warehouse description. |
| stock_edition | bool | Yes | Is manual editing of stocks permitted. A false value means that you can only edit your stock through the API. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| warehouse_id | int | The ID of created or updated warehouse. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "name": "Berlin",
  "description": "Warehouse located in Berlin",
  "stock_edition": false
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "warehouse_id": 206
}
```

## PHP example

```php
<?php
$methodParams = '{ "name": "Berlin", "description": "Warehouse located in Berlin", "stock_edition": false }';

$apiParams = [
  "method"     => "addInventoryWarehouse",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
