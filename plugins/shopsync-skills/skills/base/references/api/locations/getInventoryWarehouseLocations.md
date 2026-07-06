# getInventoryWarehouseLocations

**Category:** Locations
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryWarehouseLocations&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryWarehouseLocations>

## Description

The method allows you to retrieve the list of warehouse locations (slots/bins) defined for a given Base inventory warehouse. Locations are returned in pages of 100 entries, sorted by name.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| warehouse_id | int | Yes | Warehouse identifier returned by `getInventoryWarehouses` (the `warehouse_id` field). |
| warehouse_type | varchar(20) | Yes | Warehouse type returned by `getInventoryWarehouses` (the `warehouse_type` field). |
| page | int | No | Results page number (100 locations per page, numbered from 1). Default: 1. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| locations | array | Array of warehouse location objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `locations[]` fields

| Field | Type | Description |
|-------|------|-------------|
| location_id | int | Location identifier for use in `addInventoryWarehouseLocation` or `deleteInventoryWarehouseLocation`. |
| name | varchar(20) | Location name (e.g., `A-01-A-1`). |
| color | char(6) | Location label color in 6-character lowercase hex format (without `#`). |
| is_pickable | bool | Whether the location is pickable. |
| priority | int | Priority value (1-99999). |
| location_type_id | int | Identifier of the location type. |
| zone_id | int | Identifier of the zone or 0 if not assigned. |
| rack_id | int | Identifier of the rack or 0 if not assigned. |

## Example request

```json
{
  "warehouse_id": 205,
  "warehouse_type": "bl",
  "page": 1
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "locations": [
    {
      "location_id": 3,
      "name": "A-01-L1",
      "color": "ffd416",
      "is_pickable": true,
      "priority": 5,
      "location_type_id": 1,
      "zone_id": 1233,
      "rack_id": 7124
    },
    {
      "location_id": 4,
      "name": "A-01-L2",
      "color": "47a274",
      "is_pickable": true,
      "priority": 4,
      "location_type_id": 1,
      "zone_id": 0,
      "rack_id": 0
    },
    {
      "location_id": 1,
      "name": "Admissions",
      "color": "5cb85c",
      "is_pickable": false,
      "priority": 1,
      "location_type_id": 7,
      "zone_id": 0,
      "rack_id": 0
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "warehouse_id": 205, "warehouse_type": "bl", "page": 1 }';

$apiParams = [
  "method"     => "getInventoryWarehouseLocations",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
