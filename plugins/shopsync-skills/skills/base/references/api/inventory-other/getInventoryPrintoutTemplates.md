# getInventoryPrintoutTemplates

**Category:** Inventory — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryPrintoutTemplates&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryPrintoutTemplates>

## Description

This API endpoint retrieves a list of all configured printout templates available for inventory (products).

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| printouts | array | Array containing inventory printout template objects — see fields below. |

### `printouts[]` fields

| Field | Type | Description |
|-------|------|-------------|
| printout_id | int | Unique identifier of the printout template. |
| name | varchar | Name of the printout template. |
| file_format | varchar | Output format (e.g. PDF, HTML, XLS). |

## Example request

```json
null
```

## Example response

```json
{
  "status": "SUCCESS",
  "printouts": [
    {
      "printout_id": 1,
      "name": "Inventory printout",
      "file_format": "PDF"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = 'null';

$apiParams = [
  "method"     => "getInventoryPrintoutTemplates",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
