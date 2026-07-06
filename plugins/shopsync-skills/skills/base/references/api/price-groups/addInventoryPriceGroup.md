# addInventoryPriceGroup

**Category:** Price Groups
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryPriceGroup&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryPriceGroup>

## Description

The method allows to create a price group in BaseLinker storage. Providing a price group ID will update the existing price group.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| price_group_id | int | No | Price group identifier. Omit to create new. |
| name | varchar(100) | Yes | Name of the price group. |
| description | text | No | Price group description. |
| currency | char(3) | Yes | 3-letter currency symbol e.g. PLN, EUR. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| price_group_id | int | The ID number of added or updated price group. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "name": "USA",
  "description": "Price group for US market",
  "currency": "USD"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "price_group_id": 105
}
```

## PHP example

```php
<?php
$methodParams = '{ "name": "USA", "description": "Price group for US market", "currency": "USD" }';

$apiParams = [
  "method"     => "addInventoryPriceGroup",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
