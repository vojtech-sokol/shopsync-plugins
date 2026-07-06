# getInventoryProductLogs

**Category:** Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryProductLogs&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryProductLogs>

## Description

This method retrieves a list of events related to product or variant changes in the BaseLinker catalog.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| product_id | int | Yes | Product or variant identifier. |
| date_from | int | No | Unix timestamp for log retrieval start date. |
| date_to | int | No | Unix timestamp for log retrieval end date. |
| log_type | int | No | Event type filters: `1` stock change, `2` price change, `3` creation, `4` deletion, `5` text modifications, `6` locations, `7` links, `8` gallery, `9` variants, `10` bundle products. |
| sort | varchar(4) | No | Sorting order: `ASC` or `DESC`; default ascending. |
| page | int | No | Results pagination (100 entries per page). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR` (with `error_message` and `error_code` on failure). |
| logs | array | Array of log entries — see fields below. |

### `logs[]` fields

| Field | Type | Description |
|-------|------|-------------|
| profile | varchar(100) | Profile name making the change. |
| date | int | Event timestamp. |
| entries | array | Array of event objects — see fields below. |

### `logs[].entries[]` fields

| Field | Type | Description |
|-------|------|-------------|
| type | int | Event type identifier. |
| info | string/int | Event details. |
| from | mixed | Previous state. |
| to | mixed | New state. |

## Example request

```json
{
  "product_id": 2685,
  "date_from": 1609459200,
  "log_type": [1, 2]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "logs": [
    {
      "profile": "API",
      "date": 1609459200,
      "entries": [
        {"type": 1, "info": "bl_205", "from": 50, "to": 100},
        {"type": 2, "info": 105, "from": 19.99, "to": 24.99}
      ]
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"product_id": 2685, "date_from": 1609459200, "log_type": [1, 2]}';

$apiParams = [
  "method"     => "getInventoryProductLogs",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
