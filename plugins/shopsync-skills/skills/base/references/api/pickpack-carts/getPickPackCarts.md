# getPickPackCarts

**Category:** PickPack Carts
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getPickPackCarts&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getPickPackCarts>

## Description

The method allows you to retrieve a list of all PickPack carts belonging to the authenticated user. The method returns cart details including ID, name, color.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| carts | array | Array of cart objects — see fields below. |

### `carts[]` fields

| Field | Type | Description |
|-------|------|-------------|
| cart_id | int | Cart identifier. |
| name | varchar(5) | Cart name. |
| color | varchar(7) | Cart color in hex format. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "carts": [
    {
      "cart_id": 42,
      "name": "A",
      "color": "#CD5C5C"
    },
    {
      "cart_id": 43,
      "name": "B",
      "color": "#FF8C00"
    },
    {
      "cart_id": 44,
      "name": "C1",
      "color": "#32CD32"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getPickPackCarts",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
