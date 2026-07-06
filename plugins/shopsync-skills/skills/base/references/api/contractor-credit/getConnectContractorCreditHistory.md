# getConnectContractorCreditHistory

**Category:** Base Connect — Contractor Credit
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getConnectContractorCreditHistory&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getConnectContractorCreditHistory>

## Description

This method retrieves information about a chosen contractor's trade credit history from the Base Connect system.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| connect_contractor_id | int | Yes | Contractor ID identifier. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` (request executed correctly) or `ERROR` (with `error_message` and `error_code` fields). |
| credit_data | array | List of Base Connect contractor trade credit records. |

### `credit_data[]` fields

| Field | Type | Description |
|-------|------|-------------|
| credit_entry_id | int | Entry identifier. |
| date_add | int | Unix timestamp of entry creation date. |
| description | text | Entry description text. |
| currency | char(3) | Three-character currency code. |
| type | text | Either `charge` or `payment`. |
| amount | float | Numeric entry amount. |
| is_accepted | int | Status indicator (`0` = waiting, `1` = active). |

## Example request

```json
{ "connect_contractor_id": 2 }
```

## Example response

```json
{
  "status": "SUCCESS",
  "credit_data": [
    {
      "credit_entry_id": 1,
      "date_add": "1716296890",
      "description": "First trade credit charge",
      "currency": "PLN",
      "type": "payment",
      "amount": "100.00",
      "is_accepted": "1"
    },
    {
      "credit_entry_id": 2,
      "date_add": "1716296767",
      "description": "Trade credit payment",
      "currency": "PLN",
      "type": "charge",
      "amount": "9.99",
      "is_accepted": "0"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "connect_contractor_id": 2 }';

$apiParams = [
  "method"     => "getConnectContractorCreditHistory",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
