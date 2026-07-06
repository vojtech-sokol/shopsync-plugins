# addInventoryWarehouseLocation

**Category:** Locations
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryWarehouseLocation&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryWarehouseLocation>

## Description

The method allows you to add or update a warehouse location in a Base inventory warehouse.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| location_id | int | No | ID of location to update; omit to create new. |
| warehouse_id | int | Yes | Warehouse identifier from `getInventoryWarehouses`. |
| warehouse_type | varchar(20) | Yes | Warehouse type from `getInventoryWarehouses`. |
| name | varchar(20) | Conditional | Location name (e.g., `A-01-A-1`); required for new locations, optional for updates; must be unique within warehouse, max 20 characters, cannot contain semicolon. |
| color | char(6) | No | Location label color as 6-character hex string (e.g., `5cb85c`); normalized to lowercase; default: `4285f4`. |
| is_pickable | bool | No | Whether location is usable during pick & pack; default: true. |
| priority | int | No | Priority value (1..99999); lower values picked first; default: 1. |
| location_type_id | int | No | Existing location type identifier; omit for default type. |
| zone_id | int | No | Zone identifier; pass 0 for unassigned; changing zone without rack resets rack to 0. |
| rack_id | int | No | Rack identifier; pass 0 for unassigned; sets zone automatically if non-zero. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| location_id | int | ID of created or updated location. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "warehouse_id": 205,
  "warehouse_type": "bl",
  "name": "A-01-A-1",
  "color": "5cb85c",
  "is_pickable": true,
  "priority": 5,
  "location_type_id": 1,
  "zone_id": 0,
  "rack_id": 0
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "location_id": 17
}
```

## PHP example

```php
<?php
$methodParams = '{ "warehouse_id": 205, "warehouse_type": "bl", "name": "A-01-A-1", "color": "5cb85c", "is_pickable": true, "priority": 5, "location_type_id": 1, "zone_id": 0, "rack_id": 0 }';

$apiParams = [
  "method"     => "addInventoryWarehouseLocation",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
