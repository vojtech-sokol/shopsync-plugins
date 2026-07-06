# getJournalList

**Category:** Orders — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getJournalList&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getJournalList>

## Description

The method allows you to download a list of order events from the last 3 days. The feature requires enablement in account API settings and may return empty responses if disabled.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| last_log_id | int | No | Log ID number from which the logs are to be retrieved. |
| logs_types | array | No | Event ID list. |
| order_id | int | No | Order ID number. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| logs | array | List of events — see fields below. |

### `logs[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | int | Event ID. |
| order_id | int | Order identifier. |
| log_type | int | Event type (1–22, with specific meanings for order creation, payments, invoicing, package management, etc.). |
| object_id | int | Additional information depending on event type. |
| date | int | Event date. |

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
      "order_id": 6911942,
      "object_id": 0,
      "date": 1516369287
    },
    {
      "log_id": 456278,
      "log_type": 7,
      "order_id": 8911945,
      "object_id": 5107899,
      "date": 1516369390
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "last_log_id": 654258, "logs_types": [ 7, 13 ] }';

$apiParams = [
  "method"     => "getJournalList",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
