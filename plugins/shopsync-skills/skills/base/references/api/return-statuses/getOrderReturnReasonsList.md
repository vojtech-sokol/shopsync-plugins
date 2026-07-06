# getOrderReturnReasonsList

**Category:** Return Statuses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderReturnReasonsList&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderReturnReasonsList>

## Description

The method retrieves a list of order return reasons available in the system. These values can be modified using the `setOrderReturnFields` method.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| return_reasons | array | Collection of return reason objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `return_reasons[]` fields

| Field | Type | Description |
|-------|------|-------------|
| return_reason_id | int | Unique identifier for the return reason. |
| name | varchar | Text label describing the return reason. |

## Example request

```json
{}
```

## Example response

```json
{
  "status": "SUCCESS",
  "return_reasons": [
    {
      "return_reason_id": 1001,
      "name": "None"
    },
    {
      "return_reason_id": 1002,
      "name": "Purchase mistake"
    },
    {
      "return_reason_id": 1003,
      "name": "Problem during transport"
    },
    {
      "return_reason_id": 1004,
      "name": "Delay in shipment"
    },
    {
      "return_reason_id": 1005,
      "name": "Damaged goods"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{}';

$apiParams = [
  "method"     => "getOrderReturnReasonsList",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
