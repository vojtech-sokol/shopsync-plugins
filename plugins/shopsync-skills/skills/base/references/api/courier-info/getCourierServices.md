# getCourierServices

**Category:** Courier Info
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getCourierServices&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getCourierServices>

## Description

The method allows to retrieve additional courier services, which depend on other shipment settings. Applies exclusively to X-press, BrokerSystem, Wysyłam z Allegro, and ErliPRO couriers. Package details must be submitted in `createPackage` format to obtain available services.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| courier_code | varchar(20) | Yes | Courier code identifier. |
| order_id | int | Yes | Order identifier. |
| account_id | int | No | Courier API account identifier. If blank, the first account will be used. |
| fields | array | Yes | Form fields matching `createPackage` method structure; uses field id as key. |
| packages | array | Yes | Package information matching `createPackage` method format. |

### `fields[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | varchar(50) | The field ID. |
| value | text | Option ID or value (see `createPackage`). |

### `packages[]` fields

| Field | Type | Description |
|-------|------|-------------|
| weight | numeric | Weight in kilograms. |
| height | numeric | Height in centimeters. |
| length | numeric | Length in centimeters. |
| width | numeric | Width in centimeters. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| services | array | Available services with service ID as key (varchar) and service name as value (varchar). |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "courier_code": "xpress",
  "order_id": 6911000,
  "account_id": 294,
  "fields": [
    {"id": "package_type", "value": "Package"},
    {"id": "pickup_date", "value": "1487006161"},
    {"id": "pickup_hour", "value": "19"},
    {"id": "pickup_minute", "value": "16"},
    {"id": "service", "value": "5127"},
    {"id": "package_description", "value": "shipment description"}
  ],
  "packages": [
    {"length": 11, "height": 12, "width": 13, "weight": 4}
  ]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "services": {
    "5127": "NextDay 10-14 (14:00 15.02.2017)",
    "5128": "NextDay 14-17 (17:00 15.02.2017)",
    "5129": "NextDay 18-22 (22:00 15.02.2017)",
    "6201": "SameDay 10-14 (14:00 14.02.2017)",
    "6202": "SameDay 14-17 (17:00 14.02.2017)",
    "6203": "SameDay 18-22 (22:00 14.02.2017)"
  }
}
```

## PHP example

```php
<?php
$methodParams = '{
  "courier_code": "xpress",
  "order_id": 6911000,
  "account_id": 294,
  "fields": [
    {"id": "package_type", "value": "Package"},
    {"id": "pickup_date", "value": "1487006161"},
    {"id": "pickup_hour", "value": "19"},
    {"id": "pickup_minute", "value": "16"},
    {"id": "service", "value": "5127"},
    {"id": "package_description", "value": "shipment description"}
  ],
  "packages": [
    {"length": 11, "height": 12, "width": 13, "weight": 4}
  ]
}';

$apiParams = [
  "method"     => "getCourierServices",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
