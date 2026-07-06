# getOrderPickPackHistory

**Category:** Orders — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderPickPackHistory&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderPickPackHistory>

## Description

The method allows you to retrieve pick pack history for a selected order.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order identifier from BaseLinker's order management system. |
| action_type | int | No | Filters results to specific event types. Values range from 1–18, representing operations like reservation, picking, packing, and photo management events. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| history | array | Pick pack history entries — see fields below. |

### `history[]` fields

| Field | Type | Description |
|-------|------|-------------|
| action_type | int | Event classification (1–18). |
| profile_id | varchar | Name of user performing the action. |
| station_id | int | Packing station identifier. |
| cart_id | int | Assigned cart identifier. |
| entry_date | int | Unix timestamp of the event. |

## Example request

```json
{
  "order_id": 3754894
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "history": [
    {"action_type": 1, "profile_id": "John Doe", "station_id": 13465, "cart_id": 0, "entry_date": 1702905036},
    {"action_type": 2, "profile_id": "John Doe", "station_id": 13465, "cart_id": 0, "entry_date": 1702905324},
    {"action_type": 5, "profile_id": "John Doe", "station_id": 13465, "cart_id": 76, "entry_date": 1702905918}
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"order_id": 3754894}';

$apiParams = [
  "method"     => "getOrderPickPackHistory",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
