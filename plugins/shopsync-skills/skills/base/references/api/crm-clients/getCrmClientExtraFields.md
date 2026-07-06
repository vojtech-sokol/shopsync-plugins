# getCrmClientExtraFields

**Category:** CRM Clients
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getCrmClientExtraFields&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getCrmClientExtraFields>

## Description

The method returns extra fields defined for CRM clients. Values of those fields can be set with method `addCrmClient`. To retrieve field values, use `getCrmClientData` or include the `include_custom_extra_fields` parameter in `getCrmClients`.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` — request executed correctly; `ERROR` — an error occurred during an API request. |
| error_message | text | Present when status is `ERROR`. |
| error_code | text | Present when status is `ERROR`. |
| extra_fields | array | List of CRM client extra fields — see fields below. |

### `extra_fields[]` fields

| Field | Type | Description |
|-------|------|-------------|
| extra_field_id | int | Identifier for the extra field. |
| name | text | Field name. |
| editor_type | text | Type of editor: `text`, `number`, `select`, `checkbox`, `radio`, `date`, or `file`. |
| options | array | (Optional) Available values for `select`, `checkbox`, and `radio` editor types. |

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
      "name": "Loyalty card number",
      "editor_type": "text"
    },
    {
      "extra_field_id": 2,
      "name": "Customer segment",
      "editor_type": "select",
      "options": ["B2B", "B2C", "VIP"]
    },
    {
      "extra_field_id": 3,
      "name": "Contract signed at",
      "editor_type": "date"
    },
    {
      "extra_field_id": 4,
      "name": "Signed agreement",
      "editor_type": "file"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getCrmClientExtraFields",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
