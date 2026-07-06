# getOrdersByEmail

**Category:** Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrdersByEmail&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrdersByEmail>

## Description

The method allows to search for orders related to the given e-mail address. This function is designed to be used in plugins for mail clients (Thunderbird, Outlook, etc.).

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| email | varchar(50) | Yes | The e-mail address to search for within orders. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR` (includes `error_message` and `error_code` fields on error). |
| orders | array | Array of order objects — see fields below. |

### `orders[]` fields

| Field | Type | Description |
|-------|------|-------------|
| order_id | int | Order identifier from BaseLinker order manager. |
| order_status_id | int | Order status (retrieve full list via `getOrderStatusList`). |
| date_in_status | int | Unix timestamp indicating when order entered current status. |
| date_add | int | Unix timestamp of order creation. |

## Example request

```json
{
  "email": "test@test.com"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "orders": [
    {
      "order_id": "143476149",
      "order_status_id": "1051",
      "date_in_status": "1599752305",
      "date_add": "1599752305"
    },
    {
      "order_id": "143476148",
      "order_status_id": "6624",
      "date_in_status": "1599731534",
      "date_add": "1599731534"
    },
    {
      "order_id": "143476147",
      "order_status_id": "1051",
      "date_in_status": "1599731405",
      "date_add": "1599731405"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "email": "test@test.com" }';

$apiParams = [
  "method"     => "getOrdersByEmail",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
