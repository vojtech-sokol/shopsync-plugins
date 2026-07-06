# getOrderPrintoutTemplates

**Category:** Orders — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderPrintoutTemplates&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderPrintoutTemplates>

## Description

This method retrieves a list of all configured printout templates available for orders. The output includes technical identifiers used when executing a printout.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| printouts | array | All available order printout templates — see fields below. |

### `printouts[]` fields

| Field | Type | Description |
|-------|------|-------------|
| printout_id | int | Unique identifier for the template. |
| name | varchar | Template display name. |
| file_format | varchar | Output format such as PDF, HTML, or XLS. |
| language | varchar | Template language designation. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "printouts": [
    {
      "printout_id": 1,
      "name": "Order printout",
      "file_format": "PDF",
      "language": "en"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getOrderPrintoutTemplates",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
