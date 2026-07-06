# getOrderReturnJournalList

**Category:** Returns — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderReturnJournalList&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderReturnJournalList>

## Description

The method allows you to download a list of return events from the last 3 days.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| last_log_id | int | No | Log ID number from which the logs are to be retrieved. |
| logs_types | array | No | Event ID list. |
| return_id | int | No | Return ID number. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| logs | array | List of event objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `logs[]` fields

| Field | Type | Description |
|-------|------|-------------|
| log_id | int | Event ID. |
| return_id | int | Return identifier. |
| log_type | int | Event type (1–12 representing various return actions: return creation, accepted, completed, canceled, refunded, delivery data edits, product additions/edits/removals, data changes, status changes). |
| object_id | int | Additional context depending on event type. |
| date | int | Event timestamp (unix time). |

## Example request

```json
{
  "last_log_id": 654258,
  "logs_types": [7, 13]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "logs": [
    {
      "log_id": 456269,
      "log_type": 13,
      "return_id": 1102,
      "object_id": 0,
      "date": 1516369287
    },
    {
      "log_id": 456278,
      "log_type": 7,
      "return_id": 1103,
      "object_id": 5107899,
      "date": 1516369390
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{
  "last_log_id": 654258,
  "logs_types": [7, 13]
}';

$apiParams = [
  "method"     => "getOrderReturnJournalList",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
