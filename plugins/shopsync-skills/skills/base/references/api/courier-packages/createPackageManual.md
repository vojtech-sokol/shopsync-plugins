# createPackageManual

**Category:** Courier Packages
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=createPackageManual&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=createPackageManual>

## Description

The method allows you to enter the shipping number and the name of the courier to the order (function used only to add shipments created outside BaseLinker).

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order identifier. |
| courier_code | varchar(20) | Yes | Courier code (courier code retrieved with `getCouriersList` or custom courier name). |
| package_number | varchar(40) | Yes | Shipping number (consignment number). |
| pickup_date | int | Yes | Date of dispatch (unix time format). |
| return_shipment | bool | No | Marks package as return shipment (defaults to false). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| package_id | int | Shipment ID. |
| package_number | varchar(40) | Shipping number (consignment number). |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "order_id": 6910995,
  "courier_code": "dhl",
  "package_number": "622222044730624327700197",
  "pickup_date": 1487006161,
  "return_shipment": true
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "package_id": 77014697,
  "package_number": "622222044730624327700198"
}
```

## PHP example

```php
<?php
$methodParams = '{
  "order_id": 6910995,
  "courier_code": "dhl",
  "package_number": "622222044730624327700197",
  "pickup_date": 1487006161,
  "return_shipment": true
}';

$apiParams = [
  "method"     => "createPackageManual",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
