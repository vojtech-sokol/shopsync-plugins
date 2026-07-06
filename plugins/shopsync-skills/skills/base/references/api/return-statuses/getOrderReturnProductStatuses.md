# getOrderReturnProductStatuses

**Category:** Return Statuses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderReturnProductStatuses&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderReturnProductStatuses>

## Description

The method retrieves a list of order return item statuses. Values of those fields can be set with method `setOrderReturnFields`.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| order_return_product_statuses | array | Collection of return status objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `order_return_product_statuses[]` fields

| Field | Type | Description |
|-------|------|-------------|
| status_id | int | Identifier for the order return item status. |
| name | varchar | Description of the order return status. |

## Example request

```json
{}
```

## Example response

```json
{
  "status": "SUCCESS",
  "order_return_product_statuses": [
    {
      "status_id": 1001,
      "name": "None"
    },
    {
      "status_id": 1002,
      "name": "Accepted"
    },
    {
      "status_id": 1003,
      "name": "Damaged"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{}';

$apiParams = [
  "method"     => "getOrderReturnProductStatuses",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
