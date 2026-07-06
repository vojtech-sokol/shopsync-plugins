# getOrderReturnStatusList

**Category:** Return Statuses
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderReturnStatusList&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderReturnStatusList>

## Description

The method allows you to download order return statuses created by the customer in the BaseLinker order manager.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| statuses | array | Array of status objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `statuses[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | int | Status identifier. |
| name | varchar | Status name (basic). |
| name_for_customer | varchar | Long status name displayed to customer on order page. |
| color | varchar | Status color in hexadecimal format. |

## Example request

```json
{}
```

## Example response

```json
{
  "status": "SUCCESS",
  "statuses": [
    {
      "id": 1051,
      "name": "New orders",
      "name_for_customer": "Order accepted"
    },
    {
      "id": 1052,
      "name": "To be paid (courier)",
      "name_for_customer": "Awaiting payment"
    },
    {
      "id": 1291,
      "name": "Ready to ship (courier)",
      "name_for_customer": "Processing"
    },
    {
      "id": 1470,
      "name": "To be paid (post mail)",
      "name_for_customer": "Awaiting payment"
    },
    {
      "id": 1471,
      "name": "Dispatched",
      "name_for_customer": "The parcel has been shipped"
    },
    {
      "id": 4073,
      "name": "Ready to ship (post mail)",
      "name_for_customer": "Processing"
    },
    {
      "id": 4128,
      "name": "Ready to ship (economy mail)",
      "name_for_customer": "Processing"
    },
    {
      "id": 4129,
      "name": "Ready to ship (priority mail)",
      "name_for_customer": "Processing"
    },
    {
      "id": 4130,
      "name": "Ready to ship (post priority)",
      "name_for_customer": "Processing"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{}';

$apiParams = [
  "method"     => "getOrderReturnStatusList",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
