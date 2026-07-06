# getOrdersByPhone

**Category:** Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrdersByPhone&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrdersByPhone>

## Description

The method allows you to search for orders related to the given phone number. This function is intended for use in caller recognition programs.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| phone | varchar(50) | Yes | The phone number we search for in orders. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` - request executed correctly. `ERROR` - an error occurred during an API request. Error details will be described in 2 additional returned fields: `error_message` and `error_code`. |
| orders | array | An array of information about the orders found. Each order is described by the fields listed below. |

### `orders[]` fields

| Field | Type | Description |
|-------|------|-------------|
| order_id | int | Order Identifier from BaseLinker order manager. |
| order_status_id | int | Order status (the list available to retrieve with `getOrderStatusList`). |
| delivery_fullname | varchar(100) | Delivery address — name and surname. |
| delivery_company | varchar(100) | Delivery address — company. |
| date_in_status | int | Date from which the order is in current status (unix time format). |
| date_add | int | Date of order creation (in unix time format). |

## Example request

```json
{
  "phone": "+48123456789"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "orders": [
    {
      "order_id": 510297,
      "order_status_id": 6624,
      "delivery_fullname": "John Doe",
      "delivery_company": "Company Ltd.",
      "date_in_status": "1305049346",
      "date_add": "1305049346"
    },
    {
      "order_id": "512256",
      "order_status_id": 6624,
      "delivery_fullname": "John Doe",
      "delivery_company": "Company Ltd.",
      "date_in_status": "1305059346",
      "date_add": "1305059346"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "phone": "+48123456789" }';

$apiParams = [
  "method"     => "getOrdersByPhone",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
