# deleteInventoryWarehouseLocationType

**Category:** Locations
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteInventoryWarehouseLocationType&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteInventoryWarehouseLocationType>

## Description

The method allows you to delete a single warehouse location type. The default location type cannot be deleted.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| location_type_id | int | Yes | ID of the location type to delete (the value of `location_type_id` returned by `getInventoryWarehouseLocationTypes`). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "location_type_id": 12
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
$methodParams = '{ "location_type_id": 12 }';

$apiParams = [
  "method"     => "deleteInventoryWarehouseLocationType",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
