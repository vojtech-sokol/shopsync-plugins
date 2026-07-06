# getOrderExtraFields

**Category:** Orders — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderExtraFields&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderExtraFields>

## Description

This method retrieves extra fields configured for orders. Values for these fields can be modified using the `setOrderFields` method. To retrieve field values, include the `include_custom_extra_fields` parameter when calling `getOrders`.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| extra_fields | array | Array of order extra field definitions — see fields below. |

### `extra_fields[]` fields

| Field | Type | Description |
|-------|------|-------------|
| extra_field_id | int | Field identifier. |
| name | text | Field display name. |
| editor_type | text | Field input type — options include `text`, `number`, `select`, `checkbox`, `radio`, `date`, `file`. |
| options | array | Available values for `select`, `checkbox`, and `radio` editor types. Optional. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "extra_fields": [
    {
      "extra_field_id": 1,
      "name": "Additional Field 1",
      "editor_type": "text"
    },
    {
      "extra_field_id": 135,
      "name": "Client type",
      "editor_type": "radio",
      "options": ["B2B", "B2C"]
    },
    {
      "extra_field_id": 172,
      "name": "Shipping date deadline",
      "editor_type": "date"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getOrderExtraFields",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
