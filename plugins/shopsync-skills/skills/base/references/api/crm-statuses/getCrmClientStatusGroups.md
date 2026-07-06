# getCrmClientStatusGroups

**Category:** CRM Statuses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getCrmClientStatusGroups&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getCrmClientStatusGroups>

## Description

The method allows you to retrieve the list of CRM client status groups.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` — request executed correctly; `ERROR` — an error occurred during an API request. When an error occurs, additional fields `error_message` and `error_code` are included. |
| status_groups | array | Array of CRM client status group objects — see fields below. |

### `status_groups[]` fields

| Field | Type | Description |
|-------|------|-------------|
| group_id | int | Status group identifier. |
| name | text | Status group name. |
| is_main_group | int | Boolean indicator (0 or 1) for whether this represents the default group. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "status_groups": [
    {
      "group_id": 1,
      "name": "No group",
      "is_main_group": 1
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getCrmClientStatusGroups",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
