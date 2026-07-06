# setConnectContractorCreditLimit

**Category:** Base Connect — Contractor Credit
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setConnectContractorCreditLimit&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setConnectContractorCreditLimit>

## Description

The method allows you to set a new trade credit limit for a chosen contractor.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| connect_contractor_id | int | Yes | Contractor ID. |
| new_limit | float | Yes | New limit value. |
| message | text | Yes | Message shown in trade credit history. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` (request executed correctly) or `ERROR` (with `error_message` and `error_code` fields). |
| new_limit_set | text | New trade credit limit value (formatted with currency). |

## Example request

```json
{
  "connect_contractor_id": 2,
  "new_limit": 10000,
  "message": "Sample history message"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "new_limit_set": "10000.00 PLN"
}
```

## PHP example

```php
<?php
$methodParams = '{ "connect_contractor_id": 2, "new_limit": 10000, "message": "Sample history message" }';

$apiParams = [
  "method"     => "setConnectContractorCreditLimit",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
