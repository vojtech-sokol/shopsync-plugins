# getInventoryPurchaseOrderSeries

**Category:** Purchase Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryPurchaseOrderSeries&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryPurchaseOrderSeries>

## Description

The method allows you to retrieve a list of purchase order document series available in BaseLinker storage.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| warehouse_id | int | No | Filter series by warehouse ID. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| series | array | List of document series — see fields below. |

### `series[]` fields

| Field | Type | Description |
|-------|------|-------------|
| series_id | int | Series identifier. |
| name | varchar(20) | Series name. |
| warehouse_id | int | Warehouse identifier. |
| format | varchar(30) | Document number format. |

## Example request

```json
{
  "warehouse_id": 1
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "series": [
    {
      "series_id": 15,
      "name": "PSO",
      "warehouse_id": 1,
      "format": "%N/%M/%Y/PSO"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "warehouse_id": 1 }';

$apiParams = [
  "method"     => "getInventoryPurchaseOrderSeries",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
