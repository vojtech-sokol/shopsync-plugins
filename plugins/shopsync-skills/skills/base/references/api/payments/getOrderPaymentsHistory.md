# getOrderPaymentsHistory

**Category:** Payments
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderPaymentsHistory&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderPaymentsHistory>

## Description

The method allows you to retrieve payment history for a selected order, including an external payment identifier from the payment gateway. One order may have multiple entries due to surcharges, value changes, or manual edits.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order identifier from BaseLinker's order management system. |
| show_full_history | bool | No | Download full payment history, including order value change entries, manual order payment edits. Defaults to false, returning only entries with external payment identifiers. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| payments | array | Collection of payment records — see fields below. |

### `payments[]` fields

| Field | Type | Description |
|-------|------|-------------|
| paid_before | float | Amount paid prior to the change. |
| paid_after | float | Amount paid following the change. |
| total_price | float | Complete order cost. |
| currency | varchar | Payment currency code. |
| external_payment_id | varchar | Gateway payment reference. |
| date | int | Timestamp of record (Unix format). |
| comment | varchar | Associated payment notation. |

## Example request

```json
{
  "order_id": 3754894
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "payments": [
    {
      "paid_before": "0.00",
      "paid_after": "55.00",
      "total_price": "82.97",
      "date": "1515001701",
      "currency": "GBP",
      "external_payment_id": "189a1236-0aa9-21ee-15ab-8b0992243303",
      "comment": ""
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "order_id": 3754894 }';

$apiParams = [
  "method"     => "getOrderPaymentsHistory",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
