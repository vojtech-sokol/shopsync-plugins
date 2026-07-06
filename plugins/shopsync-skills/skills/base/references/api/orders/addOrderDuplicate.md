# addOrderDuplicate

**Category:** Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addOrderDuplicate&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addOrderDuplicate>

## Description

The method allows you to add a new order to the BaseLinker order manager by duplicating an existing order. The duplicated order retains the source order's data but receives a distinct identifier.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | ID of the order to duplicate. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` - request executed correctly. `ERROR` - an error occurred during an API request. Error details will be described in 2 additional returned fields: `error_message` and `error_code`. |
| order_id | int | The identifier assigned to the newly created order. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "order_id": 12345
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "order_id": 12346
}
```

## PHP example

```php
<?php
$methodParams = '{ "order_id": 12345 }';

$apiParams = [
  "method"     => "addOrderDuplicate",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
