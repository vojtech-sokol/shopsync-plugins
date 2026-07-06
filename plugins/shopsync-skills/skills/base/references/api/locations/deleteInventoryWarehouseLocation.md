# deleteInventoryWarehouseLocation

**Category:** Locations
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteInventoryWarehouseLocation&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteInventoryWarehouseLocation>

## Description

The method allows you to delete a single warehouse location from a Base inventory warehouse. The location is identified by `location_id` and must belong to the warehouse identified by `warehouse_type` + `warehouse_id`.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| warehouse_id | int | Yes | Warehouse identifier returned by `getInventoryWarehouses` (the `warehouse_id` field). The location must belong to this warehouse. |
| warehouse_type | varchar(20) | Yes | Warehouse type returned by `getInventoryWarehouses` (the `warehouse_type` field). |
| location_id | int | Yes | ID of the location to delete (the value of `location_id` returned by `getInventoryWarehouseLocations`). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "location_id": 17,
  "warehouse_id": 205,
  "warehouse_type": "bl"
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
$methodParams = '{ "location_id": 17, "warehouse_id": 205, "warehouse_type": "bl" }';

$apiParams = [
  "method"     => "deleteInventoryWarehouseLocation",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
