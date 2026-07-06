# deleteInventoryManufacturer

**Category:** Manufacturers
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteInventoryManufacturer&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteInventoryManufacturer>

## Description

The method allows you to remove manufacturer from BaseLinker catalog.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| manufacturer_id | int | Yes | The ID of the manufacturer removed from BaseLinker warehouse. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "manufacturer_id": 8
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
$methodParams = '{ "manufacturer_id": 8 }';

$apiParams = [
  "method"     => "deleteInventoryManufacturer",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
