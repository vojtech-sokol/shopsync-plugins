# deleteCourierPackage

**Category:** Courier Packages
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteCourierPackage&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteCourierPackage>

## Description

The method allows you to delete a previously created shipment. The method removes the shipment from the BaseLinker system and from the courier system if the courier API allows it.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| courier_code | varchar(20) | Yes | Courier code. |
| package_id | int | No | Shipment ID (optional if `package_number` provided). |
| package_number | varchar(40) | No | Shipping number / consignment number (optional if `package_id` provided). |
| force_delete | bool | No | (optional, false by default) Forcing a shipment to be removed from BaseLinker database in the case of an error with the removal of the shipment in the courier API. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "courier_code": "dhl",
  "package_id": 77014696,
  "package_number": "622222044730624327700197"
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
$methodParams = '{
  "courier_code": "dhl",
  "package_id": 77014696,
  "package_number": "622222044730624327700197"
}';

$apiParams = [
  "method"     => "deleteCourierPackage",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
