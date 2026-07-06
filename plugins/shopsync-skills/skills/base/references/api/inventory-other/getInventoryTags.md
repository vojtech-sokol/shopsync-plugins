# getInventoryTags

**Category:** Inventory — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryTags&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryTags>

## Description

The method allows you to retrieve a list of tags for a BaseLinker catalog.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| tags | array | A list containing available tags — see fields below. |

### `tags[]` fields

| Field | Type | Description |
|-------|------|-------------|
| name | string | The tag name. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "tags": [
    {
      "name": "Summer"
    },
    {
      "name": "Winter"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getInventoryTags",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
