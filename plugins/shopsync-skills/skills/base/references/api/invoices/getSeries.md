# getSeries

**Category:** Invoices
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getSeries&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getSeries>

## Description

The method allows to download a series of invoice/receipt numbering.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| series | array | Collection containing numbering series information — see fields below. |

### `series[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | int | Series numbering identifier. |
| type | varchar(10) | Numbering type — possible values: `INVOICE`, `CORRECTION`, `RECEIPT`. |
| name | varchar(20) | Numbering name. |
| format | varchar(30) | Numbering format. |

## Example request

```json
{}
```

## Example response

```json
{
  "status": "SUCCESS",
  "series": [
    {
      "id": "15",
      "type": "INVOICE",
      "name": "default",
      "format": "%N/%Y"
    },
    {
      "id": "24525",
      "type": "INVOICE",
      "name": "Invoice DE",
      "format": "%N/%M/%Y/de"
    },
    {
      "id": "61178",
      "type": "RECEIPT",
      "name": "Receipt",
      "format": "%N/%M/%Y"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{}';

$apiParams = [
  "method"     => "getSeries",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
