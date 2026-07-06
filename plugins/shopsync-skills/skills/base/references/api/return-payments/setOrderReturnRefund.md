# setOrderReturnRefund

**Category:** Return Payments
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrderReturnRefund&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrderReturnRefund>

## Description

The method allows you to mark an order return as refunded. Note this method doesn't issue an actual money refund.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| return_id | int | Yes | Order return ID. |
| order_refund_done | float | Yes | Refund amount. Updates the current refund value in the order return (replaces rather than adds). Marking order as refunded when amount equals order value. |
| refund_date | int | Yes | Refund date in unixtime format. |
| refund_comment | varchar(50) | Yes | Refund commentary. |
| external_refund_id | varchar(50) | No | External refund identifier. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "return_id": 1102,
  "order_refund_done": 25.5,
  "refund_date": 1702905036,
  "refund_comment": "by paypal"
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
  "return_id": 1102,
  "order_refund_done": 25.5,
  "refund_date": 1702905036,
  "refund_comment": "by paypal"
}';

$apiParams = [
  "method"     => "setOrderReturnRefund",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
