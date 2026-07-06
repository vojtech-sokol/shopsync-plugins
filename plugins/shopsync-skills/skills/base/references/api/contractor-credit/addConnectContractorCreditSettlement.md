# addConnectContractorCreditSettlement

**Category:** Base Connect — Contractor Credit
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addConnectContractorCreditSettlement&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addConnectContractorCreditSettlement>

## Description

The method allows you to add a manual credit settlement (repayment) for a chosen contractor in Base Connect. A settlement reduces blocked credit and records payment for previously charged orders. The settlement cannot exceed the contractor's currently blocked credit amount.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| connect_contractor_id | int | Yes | Contractor ID. The list of contractor identifiers can be retrieved using the `getConnectIntegrationContractors` method. |
| amount | float | Yes | Settlement amount. Must be a positive value and cannot exceed the contractor's currently blocked credit amount (`credit_to_pay`). Can be passed as string or number in JSON. |
| message | varchar(255) | Yes | Settlement note/comment describing the repayment, e.g., payment reference, bank transfer ID, etc. Maximum 255 characters. |
| order_id | int | No | Related order ID if the settlement is connected to a specific order. Use `0` or omit if not related to any specific order. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR` (with `error_message` and `error_code` fields). |
| credit_entry_id | int | The ID of the created credit settlement entry in the trade credit history. |
| new_blocked_credit | float | The contractor's new blocked credit amount (`credit_to_pay`) after the settlement. |
| new_available_credit | float | The contractor's new available credit amount after the settlement. |

## Example request

```json
{
  "connect_contractor_id": 2,
  "amount": "500.00",
  "message": "Bank transfer received - REF: BT2024/001",
  "order_id": 12345
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "credit_entry_id": 156,
  "new_blocked_credit": 1500,
  "new_available_credit": 3500
}
```

## PHP example

```php
<?php
$methodParams = '{ "connect_contractor_id": 2, "amount": "500.00", "message": "Bank transfer received - REF: BT2024\/001", "order_id": 12345 }';

$apiParams = [
  "method"     => "addConnectContractorCreditSettlement",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
