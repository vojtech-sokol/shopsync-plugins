# runRequestParcelPickup

**Category:** Parcel Pickups
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=runRequestParcelPickup&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=runRequestParcelPickup>

## Description

The method allows you to request a parcel pickup for previously created shipments. The method sends a parcel pickup request to courier API if the courier API allows it.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| courier_code | varchar(20) | Yes | Courier code. |
| package_ids | array | No | Array of shipments ID, optional if `package_numbers` was provided. |
| package_numbers | array | No | Array of shipments number (consignment number), optional if `package_ids` was provided. |
| account_id | int | No | Courier API account id for the courier accounts retrieved from the request `getCourierAccounts`. |
| fields | array | Yes | List of form fields retrieved from the request `getRequestParcelPickupFields`. For checkbox with multiple selection, the information should be sent in separate arrays. |

### `fields[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | varchar(50) | The field ID. |
| value | text | Option ID or value. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| pickup_number | varchar(50) | The parcel pickup number provided by the courier API. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "courier_code": "dpd",
  "package_numbers": ["0000000815947Q", "0000000633844Q"],
  "account_id": 1645,
  "fields": [
    {
      "id": "pickup_date",
      "value": 1642672310
    }
  ]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "pickup_number": "20220119563"
}
```

## PHP example

```php
<?php
$methodParams = '{ "courier_code": "dpd", "package_numbers": [ "0000000815947Q", "0000000633844Q" ], "account_id": 1645, "fields": [ { "id": "pickup_date", "value": 1642672310 } ] }';

$apiParams = [
  "method"     => "runRequestParcelPickup",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
