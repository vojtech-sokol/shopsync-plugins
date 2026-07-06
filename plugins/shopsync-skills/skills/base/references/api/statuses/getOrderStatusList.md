# getOrderStatusList

**Category:** Statuses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderStatusList&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderStatusList>

## Description

The method allows you to retrieve order statuses created by the customer in the BaseLinker order manager.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| statuses | array | Array of status objects — see fields below. |

### `statuses[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | int | Status identifier. |
| name | varchar | Status name (basic). |
| name_for_customer | varchar | Long status name displayed to customer on order page. |
| color | varchar | Status color in hexadecimal format. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "statuses": [
    {
      "id": 1051,
      "name": "New orders",
      "name_for_customer": "Order accepted",
      "color": "#0000FF"
    },
    {
      "id": 1052,
      "name": "To be paid (courier)",
      "name_for_customer": "Awaiting payment",
      "color": "#FFA500"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getOrderStatusList",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
