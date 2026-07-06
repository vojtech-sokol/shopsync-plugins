# getInventoryPayers

**Category:** Payers
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryPayers&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryPayers>

## Description

The method allows you to retrieve a list of payers available in BaseLinker storage.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| filter_id | int | No | Limits results to a specific payer ID. |
| filter_name | varchar(40) | No | Filters by payer name (full or partial match). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| payers | array | List of payer objects — see fields below. |

### `payers[]` fields

| Field | Type | Description |
|-------|------|-------------|
| payer_id | int | Payer identifier. |
| name | varchar(40) | Payer name. |
| address | varchar(200) | Optional payer address. |
| postcode | varchar(20) | Optional postal code. |
| city | varchar(80) | Optional city. |
| tax_no | varchar(40) | Optional tax identification number. |

## Example request

```json
{
  "filter_id": 1,
  "filter_name": "Company"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "payers": [
    {
      "payer_id": 1,
      "name": "Company Ltd",
      "address": "123 Main Street",
      "postcode": "12-345",
      "city": "London",
      "tax_no": "GB123456789"
    },
    {
      "payer_id": 2,
      "name": "Example Corp",
      "address": "456 Side Street",
      "postcode": "67-890",
      "city": "Manchester",
      "tax_no": "GB987654321"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"filter_id": 1, "filter_name": "Company"}';

$apiParams = [
  "method"     => "getInventoryPayers",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
