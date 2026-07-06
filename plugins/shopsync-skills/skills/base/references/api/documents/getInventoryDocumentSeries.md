# getInventoryDocumentSeries

**Category:** Documents
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryDocumentSeries&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryDocumentSeries>

## Description

The method retrieves information about inventory document series available in BaseLinker, with each series linked to specific warehouses and numbering formats.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| document_series | array | List of document series — see fields below. |

### `document_series[]` fields

| Field | Type | Description |
|-------|------|-------------|
| document_series_id | int | Unique identifier. |
| name | varchar(20) | Series name. |
| document_type | int | Document category: 0=GR, 1=IGR, 2=GI, 3=IGI, 4=IT, 5=OB. |
| warehouse_id | int | Associated warehouse identifier. |
| format | varchar(30) | Numbering format pattern. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "document_series": [
    {
      "document_series_id": 3,
      "name": "GRN",
      "document_type": 1,
      "warehouse_id": 205,
      "format": "%N\/%M\/%Y\/GR"
    },
    {
      "document_series_id": 4,
      "name": "GIN",
      "document_type": 2,
      "warehouse_id": 205,
      "format": "%N\/%M\/%Y\/GR"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getInventoryDocumentSeries",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
