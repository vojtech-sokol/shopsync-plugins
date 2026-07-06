# getInventoryWarehouseLocationTypes

**Category:** Locations
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryWarehouseLocationTypes&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryWarehouseLocationTypes>

## Description

The method allows you to retrieve the list of warehouse location types. The returned list is sorted alphabetically by name.

## Input Parameters

_None._ Input data is an empty array: `[]`.

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| location_types | array | Array of location type objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `location_types[]` fields

| Field | Type | Description |
|-------|------|-------------|
| location_type_id | int | Location type identifier. Use this value as `location_type_id` when calling `addInventoryWarehouseLocation` (create or update), `addInventoryWarehouseLocationType` (update) or `deleteInventoryWarehouseLocationType`. |
| name | varchar(50) | Location type name. |
| max_quantity | int | Maximum number of products allowed at a single location of this type. 0 means no limit. |
| max_weight | float | Maximum total weight (in kilograms) allowed at a single location of this type. 0 means no limit. |
| width | float | Width of a single location of this type, in centimeters. 0 means not set. |
| height | float | Height of a single location of this type, in centimeters. 0 means not set. |
| depth | float | Depth of a single location of this type, in centimeters. 0 means not set. |
| is_transfer_bin | bool | Whether locations serve as transfer bins. |
| is_default | bool | Whether this is the user's default location type. The default type is assigned automatically to new locations created without an explicit `location_type_id` and cannot be deleted. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "location_types": [
    {
      "location_type_id": 12,
      "name": "Pallet",
      "max_quantity": 200,
      "max_weight": 800,
      "width": 120,
      "height": 180,
      "depth": 80,
      "is_transfer_bin": false,
      "is_default": false
    },
    {
      "location_type_id": 5,
      "name": "Standard",
      "max_quantity": 0,
      "max_weight": 0,
      "width": 0,
      "height": 0,
      "depth": 0,
      "is_transfer_bin": false,
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
  "method"     => "getInventoryWarehouseLocationTypes",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
