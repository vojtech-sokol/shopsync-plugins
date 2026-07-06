# getOrderReturnExtraFields

**Category:** Order Returns
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderReturnExtraFields&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderReturnExtraFields>

## Description

The method retrieves extra fields configured for order returns. Field values can be set with `setOrderReturnFields` and retrieved via `getOrderReturns` with the `include_custom_extra_fields` parameter enabled.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| extra_fields | array | Collection of return extra fields — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `extra_fields[]` fields

| Field | Type | Description |
|-------|------|-------------|
| extra_field_id | int | Unique identifier of the extra field. |
| name | varchar | The field's display name. |
| editor_type | varchar | Field input type: `text`, `number`, `select`, `checkbox`, `radio`, `date`, or `file`. |
| options | array | Available values for `select`, `checkbox`, and `radio` editor types. |

## Example request

```json
{}
```

## Example response

```json
{
  "status": "SUCCESS",
  "extra_fields": [
    {"extra_field_id": 1, "name": "Additional Field 1", "editor_type": "text"},
    {"extra_field_id": 2, "name": "Additional Field 2", "editor_type": "text"},
    {"extra_field_id": 135, "name": "Client type", "editor_type": "radio", "options": ["B2B", "B2C"]},
    {"extra_field_id": 172, "name": "Shipping date deadline", "editor_type": "date"},
    {"extra_field_id": 196, "name": "Warranty Card", "editor_type": "file"}
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{}';

$apiParams = [
  "method"     => "getOrderReturnExtraFields",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
