# setOrderReturnFields

**Category:** Order Returns
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrderReturnFields&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrderReturnFields>

## Description

The method enables modification of particular fields within a specific order return. Only fields designated for editing need to be included; remaining fields may be excluded from the request.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| return_id | int | Yes | Order return identifier. |
| admin_comments | varchar(200) | No | Seller comments. |
| email | varchar(150) | No | Buyer e-mail address. |
| phone | varchar(100) | No | Buyer phone number. |
| user_login | varchar(30) | No | Buyer login. |
| delivery_price | float | No | Gross delivery price. |
| delivery_fullname | varchar(100) | No | Delivery address — name and surname. |
| delivery_company | varchar(100) | No | Delivery address — company. |
| delivery_address | varchar(100) | No | Delivery address — street and number. |
| delivery_postcode | varchar(100) | No | Delivery address — postcode. |
| delivery_city | varchar(100) | No | Delivery address — city. |
| delivery_state | varchar(100) | No | Delivery address — state/province. |
| delivery_country_code | char(2) | No | Delivery address — country code (two-letter, e.g. EN). |
| extra_field_1 | varchar(50) | No | Value of "extra field 1". |
| extra_field_2 | varchar(50) | No | Value of "extra field 2". |
| custom_extra_fields | array | No | Order return custom extra fields (key = field ID, value = field content). Retrieve field list via `getOrderReturnExtraFields`. Empty string removes the field. File format: `{"title": "file.pdf", "file": "data:4AAQSkZJRgABA..."}` (binary limited to 2MB). |

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
  "admin_comments": "New seller comments",
  "extra_field_1": "Very important client"
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
  "admin_comments": "New seller comments",
  "extra_field_1": "Very important client"
}';

$apiParams = [
  "method"     => "setOrderReturnFields",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
