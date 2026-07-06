# getInventoryPriceGroups

**Category:** Price Groups
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryPriceGroups&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryPriceGroups>

## Description

The method allows to retrieve price groups existing in BaseLinker storage.

## Input Parameters

_None._ Input data is an empty array: `[]`.

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| price_groups | array | Array of price group objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `price_groups[]` fields

| Field | Type | Description |
|-------|------|-------------|
| price_group_id | int | Price group identifier. |
| name | varchar(100) | Name of the price group. |
| description | text | Price group description. |
| currency | char(3) | 3-letter currency symbol e.g. PLN, EUR. |
| is_default | bool | Flag indicating whether the price group is default. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "price_groups": [
    {
      "price_group_id": 104,
      "name": "Default",
      "description": "Default price group",
      "currency": "EUR",
      "is_default": true
    },
    {
      "price_group_id": 105,
      "name": "USA",
      "description": "Price group for US market",
      "currency": "USD",
      "is_default": false
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getInventoryPriceGroups",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
