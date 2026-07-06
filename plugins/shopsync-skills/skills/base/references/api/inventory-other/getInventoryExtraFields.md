# getInventoryExtraFields

**Category:** Inventory — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryExtraFields&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryExtraFields>

## Description

The method allows you to retrieve a list of extra fields for a BaseLinker catalog.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| extra_fields | array | Array containing extra field objects — see fields below. |

### `extra_fields[]` fields

| Field | Type | Description |
|-------|------|-------------|
| extra_field_id | int | Identifier for the additional field. |
| name | varchar | Field designation/label. |
| kind | int | Field type classification: 0 for short fields (max 200 characters), 1 for long fields with per-integration overwrite capability. |
| editor_type | varchar | Input interface type. Available options include `text`, `number`, `select`, `checkbox`, `radio`, `date`, `file`. |
| options | array | Available values for `select`, `checkbox`, and `radio` editor types (optional). |

## Example request

```json
{}
```

## Example response

```json
{
  "status": "SUCCESS",
  "extra_fields": [
    {
      "extra_field_id": 201,
      "name": "Short text field",
      "kind": 0,
      "editor_type": "text"
    },
    {
      "extra_field_id": 202,
      "name": "Select field",
      "kind": 0,
      "editor_type": "select",
      "options": ["First option", "Second option", "Third option"]
    },
    {
      "extra_field_id": 203,
      "name": "Long (translated) text field",
      "kind": 1,
      "editor_type": "text"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{}';

$apiParams = [
  "method"     => "getInventoryExtraFields",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
