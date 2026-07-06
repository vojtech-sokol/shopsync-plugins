# getRequestParcelPickupFields

**Category:** Parcel Pickups
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getRequestParcelPickupFields&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getRequestParcelPickupFields>

## Description

The method allows you to retrieve additional fields for a parcel pickup request.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| courier_code | varchar(20) | Yes | Courier code. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| fields | array | Array containing additional fields for parcel pickup requests — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `fields[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | varchar(50) | Field identifier. |
| name | varchar(50) | Field display name. |
| type | varchar(10) | `select`, `checkbox`, `text`, `date`. |
| desc | text | Additional field description. |
| options | array | List of available options (appears for `select`, `checkbox`). The key to each element is the option id (varchar). The value is the option name (varchar). |
| value | varchar(50) | Default field value. |

## Example request

```json
{
  "courier_code": "dpd"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "fields": [
    {"id": "pickup_date", "name": "Pickup date", "type": "date"}
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"courier_code": "dpd"}';

$apiParams = [
  "method"     => "getRequestParcelPickupFields",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
