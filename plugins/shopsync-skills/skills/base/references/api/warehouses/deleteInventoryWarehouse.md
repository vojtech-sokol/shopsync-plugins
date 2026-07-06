# deleteInventoryWarehouse

**Category:** Warehouses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteInventoryWarehouse&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteInventoryWarehouse>

## Description

The method allows you to remove the warehouse available in BaseLinker inventories. The method does not allow to remove warehouses created automatically for external stocks.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| warehouse_id | int | Yes | ID of the warehouse. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "warehouse_id": 206
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
$methodParams = '{ "warehouse_id": 206 }';

$apiParams = [
  "method"     => "deleteInventoryWarehouse",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
