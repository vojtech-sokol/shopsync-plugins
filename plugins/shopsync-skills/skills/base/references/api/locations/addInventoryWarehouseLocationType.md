# addInventoryWarehouseLocationType

**Category:** Locations
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryWarehouseLocationType&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryWarehouseLocationType>

## Description

The method allows you to add or update a warehouse location type.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| location_type_id | int | No | ID of existing type to modify; omit to create new. |
| name | varchar(50) | Conditional | Type name (e.g., `Pallet`); required for new types, optional for updates; max 50 chars; must be unique. |
| max_quantity | int | No | Maximum number of products allowed at a single location of this type. 0 means no limit. Range: 0-999999999; default: 0. |
| max_weight | float | No | Maximum total weight in kilograms allowed at a single location of this type. 0 means no limit. Range: 0-9999.99; default: 0. |
| width | float | No | Width in centimeters; 0 means unset; range 0-9999.99; default: 0. |
| height | float | No | Height in centimeters; 0 means unset; range 0-9999.99; default: 0. |
| depth | float | No | Depth in centimeters; 0 means unset; range 0-9999.99; default: 0. |
| is_transfer_bin | bool | No | Whether locations of this type are used as transfer bins; default: false. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| location_type_id | int | ID of created or updated type. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "name": "Pallet",
  "max_quantity": 200,
  "max_weight": 800,
  "width": 120,
  "height": 180,
  "depth": 80,
  "is_transfer_bin": false
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "location_type_id": 12
}
```

## PHP example

```php
<?php
$methodParams = '{ "name": "Pallet", "max_quantity": 200, "max_weight": 800, "width": 120, "height": 180, "depth": 80, "is_transfer_bin": false }';

$apiParams = [
  "method"     => "addInventoryWarehouseLocationType",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
