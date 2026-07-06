# getOrderReturnPaymentsHistory

**Category:** Return Payments
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderReturnPaymentsHistory&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderReturnPaymentsHistory>

## Description

The method retrieves payment history for an order return, including external payment gateway identifiers. Multiple payment history entries can exist due to surcharges, value modifications, or manual adjustments.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| return_id | int | Yes | Order return identifier. |
| show_full_history | bool | No | Download full payment history, including order value change entries and manual order payment edits (defaults to `false`; when `false`, only entries with external payment IDs are returned). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| payments | array | Collection of payment records — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `payments[]` fields

| Field | Type | Description |
|-------|------|-------------|
| paid_before | float | Total amount paid before the given change. |
| paid_after | float | Total amount paid after the change. |
| total_price | float | Total order return price. |
| currency | text | Transaction currency code. |
| external_payment_id | text | External payment identifier from payment gateway. |
| date | int | Date of change record (unix time format). |

## Example request

```json
{ "return_id": 1102 }
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
      "external_payment_id": "189a1236-0aa9-21ee-15ab-8b0992243303"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "return_id": 1102 }';

$apiParams = [
  "method"     => "getOrderReturnPaymentsHistory",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
