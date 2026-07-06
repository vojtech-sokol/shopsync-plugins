# addInventoryPayer

**Category:** Payers
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryPayer&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryPayer>

## Description

The method allows you to add a new payer or update an existing one in BaseLinker storage.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| payer_id | int | No | Payer identifier for updating existing records. |
| name | varchar(100) | Yes | Payer name. |
| address | varchar(100) | No | Payer address. |
| postcode | varchar(20) | No | Payer postal code. |
| city | varchar(50) | No | Payer city. |
| tax_no | varchar(20) | No | Payer tax identification number. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| payer_id | int | Created or updated payer identifier. |

## Example request

```json
{
  "name": "Company Ltd",
  "address": "123 Main Street",
  "postcode": "12-345",
  "city": "London",
  "tax_no": "GB123456789"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "payer_id": 1
}
```

## PHP example

```php
<?php
$methodParams = '{ "name": "Company Ltd", "address": "123 Main Street", "postcode": "12-345", "city": "London", "tax_no": "GB123456789" }';

$apiParams = [
  "method"     => "addInventoryPayer",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
