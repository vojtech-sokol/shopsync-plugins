# getCourierPackagesStatusHistory

**Category:** Courier Packages
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getCourierPackagesStatusHistory&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getCourierPackagesStatusHistory>

## Description

The method allows you to retrieve the history of the status list of the given shipments. Maximum 100 shipments at a time.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| package_ids | array | Yes | An array with a list of parcel IDs. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| packages_history | array | Array of shipments, key parcel ID. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `packages_history[<package_id>][]` fields

| Field | Type | Description |
|-------|------|-------------|
| tracking_status_date | int | Status date. |
| courier_status_code | varchar(100) | Original status code in the courier system. |
| tracking_status | int | Tracking status code: `0` Unknown, `1` Courier label created, `2` Shipped, `3` Not delivered, `4` Out for delivery, `5` Delivered, `6` Return, `7` Aviso, `8` Waiting at point, `9` Lost, `10` Canceled, `11` On the way, `12` Exception, `13` Transferred abroad. |

## Example request

```json
{
  "package_ids": [7323859]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "packages_history": {
    "7323859": [
      {"tracking_status_date": 1513764000, "courier_status_code": "030103", "tracking_status": 1},
      {"tracking_status_date": 1513782900, "courier_status_code": "040101", "tracking_status": 2},
      {"tracking_status_date": 1513843200, "courier_status_code": "330137", "tracking_status": 11},
      {"tracking_status_date": 1513850400, "courier_status_code": "170304", "tracking_status": 11},
      {"tracking_status_date": 1513862040, "courier_status_code": "170101", "tracking_status": 4},
      {"tracking_status_date": 1513875240, "courier_status_code": "190101", "tracking_status": 5}
    ]
  }
}
```

## PHP example

```php
<?php
$methodParams = '{ "package_ids": [ 7323859 ] }';

$apiParams = [
  "method"     => "getCourierPackagesStatusHistory",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
