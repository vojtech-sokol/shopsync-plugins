# deleteInventoryPriceGroup

**Category:** Price Groups
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteInventoryPriceGroup&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteInventoryPriceGroup>

## Description

The method allows you to remove the price group from BaseLinker storage.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| price_group_id | int | Yes | Price group identifier. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "price_group_id": 105
}
```

## Example response

```json
{
  "status": "SUCCESS"
}
```

## PHP example

```php
<?php
$methodParams = '{ "price_group_id": 105 }';

$apiParams = [
  "method"     => "deleteInventoryPriceGroup",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
