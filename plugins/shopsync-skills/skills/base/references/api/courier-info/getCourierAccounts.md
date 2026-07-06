# getCourierAccounts

**Category:** Courier Info
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getCourierAccounts&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getCourierAccounts>

## Description

The method allows you to retrieve a list of accounts connected with a courier.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| courier_code | varchar(20) | Yes | Courier code. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| accounts | array | An array with a list of available accounts — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `accounts[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | int | Account ID. |
| name | text | Account name. |

## Example request

```json
{
  "courier_code": "dpd"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "accounts": [
    {"id": 60, "name": "London Branch"},
    {"id": 251, "name": "Manchester Branch"}
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "courier_code": "dpd" }';

$apiParams = [
  "method"     => "getCourierAccounts",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
