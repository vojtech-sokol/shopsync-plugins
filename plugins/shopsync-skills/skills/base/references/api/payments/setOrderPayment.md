# setOrderPayment

**Category:** Payments
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrderPayment&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrderPayment>

## Description

The method allows you to add a payment to the order.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order ID number. |
| payment_done | float | Yes | Amount of payment; changes current payment value (not additive). Marks order as paid if amount matches order value. |
| payment_date | int | Yes | Payment date as unixtime. |
| payment_comment | varchar(30) | Yes | Payments commentary. |
| external_payment_id | varchar(30) | No | External payment identifier. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |

## Example request

```json
{
  "order_id": 3754894,
  "payment_done": 120.57,
  "payment_date": 1444736731,
  "payment_comment": "bank transfer mBank 12.10.2015"
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
$methodParams = '{
  "order_id": 3754894,
  "payment_done": 120.57,
  "payment_date": 1444736731,
  "payment_comment": "bank transfer mBank 12.10.2015"
}';

$apiParams = [
  "method"     => "setOrderPayment",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
