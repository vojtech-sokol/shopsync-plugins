# getCrmClientStatuses

**Category:** CRM Statuses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getCrmClientStatuses&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getCrmClientStatuses>

## Description

The method allows you to retrieve CRM client statuses created by the user in the order manager.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` — request executed correctly; `ERROR` — an error occurred during an API request. When an error occurs, additional fields `error_message` and `error_code` are returned. |
| statuses | array | Array of CRM client status objects — see fields below. |

### `statuses[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | int | Status identifier number. |
| name | text | Status name label. |
| color | text | Status color (hex, e.g. `#1C8752`). |
| group_id | int | Status group ID. The group details can be retrieved with `getCrmClientStatusGroups` method. |
| is_primary | int | Whether this is the primary (default) status (0 or 1). |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "statuses": [
    {
      "id": 1,
      "name": "Standard",
      "color": "#B6BCC5",
      "group_id": 1,
      "is_primary": 1
    },
    {
      "id": 2,
      "name": "Regular",
      "color": "#1C8752",
      "group_id": 1,
      "is_primary": 0
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getCrmClientStatuses",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
