# setOrderFields

**Category:** Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrderFields&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrderFields>

## Description

The method allows you to edit selected fields (e.g. address data, notes, etc.) of a specific order. Only the fields that you want to edit should be given, other fields can be omitted in the request.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order identifier from the BaseLinker order manager. |
| admin_comments | varchar(200) | No | Seller comments. |
| user_comments | varchar(510) | No | Buyer comments. |
| payment_method | varchar(30) | No | Payment method. |
| payment_method_cod | bool | No | Flag indicating whether the type of payment is COD (cash on delivery). |
| email | varchar(150) | No | Buyer e-mail address. |
| phone | varchar(100) | No | Buyer phone number. |
| user_login | varchar(30) | No | Buyer login. |
| delivery_method | varchar(30) | No | Delivery method name. |
| delivery_price | float | No | Gross delivery price. |
| delivery_fullname | varchar(100) | No | Delivery address — name and surname. |
| delivery_company | varchar(100) | No | Delivery address — company. |
| delivery_address | varchar(156) | No | Delivery address — street and number. |
| delivery_postcode | varchar(100) | No | Delivery address — postcode. |
| delivery_city | varchar(100) | No | Delivery address — city. |
| delivery_state | varchar(100) | No | Delivery address — state/province. |
| delivery_country_code | char(2) | No | Delivery address — country code (two-letter, e.g. EN). |
| delivery_point_id | varchar(40) | No | Pick-up point delivery — pick-up point identifier. |
| delivery_point_name | varchar(100) | No | Pick-up point delivery — pick-up point name. |
| delivery_point_address | varchar(100) | No | Pick-up point delivery — pick-up point address. |
| delivery_point_postcode | varchar(100) | No | Pick-up point delivery — pick-up point postcode. |
| delivery_point_city | varchar(100) | No | Pick-up point delivery — pick-up point city. |
| invoice_fullname | varchar(100) | No | Billing details — name and surname. |
| invoice_company | varchar(100) | No | Billing details — company. |
| invoice_nip | varchar(100) | No | Billing details — Vat Reg. no./tax number. |
| invoice_address | varchar(100) | No | Billing details — street and house number. |
| invoice_postcode | varchar(100) | No | Billing details — postcode. |
| invoice_city | varchar(100) | No | Billing details — city. |
| invoice_state | varchar(100) | No | Billing details — state/province. |
| invoice_country_code | char(2) | No | Billing details — country code (two-letter, e.g. EN). |
| want_invoice | bool | No | Flag indicating whether the customer wants an invoice (1 - yes, 0 - no). |
| extra_field_1 | varchar(50) | No | Value of the 'extra field 1' - the seller can store any information there. |
| extra_field_2 | varchar(50) | No | Value of the 'extra field 2' - the seller can store any information there. |
| custom_extra_fields | array | No | A list containing order custom extra fields, where the key is the extra field ID and value is an extra field content for given extra field. The list of extra fields can be retrieved with `getOrderExtraFields` method. In case of removing a field the empty string is expected. In case of file the following format is expected: `{"title": "file.pdf" (varchar(40) - the file name) "file": "data:4AAQSkZJRgABA[...]" (base64 - the file body limited to 2MB)}`. |
| pick_state | int | No | Flag indicating the status of the order products collection (1 - all products have been collected, 0 - not all products have been collected). |
| pack_state | int | No | Flag indicating the status of the order products packing (1 - all products have been packed, 0 - not all products have been packed). |
| star | int | No | Order star type. Values from 0 to 5. 0 means no star. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` - request executed correctly. `ERROR` - an error occurred during an API request. Error details will be described in 2 additional returned fields: `error_message` and `error_code`. |

## Example request

```json
{
  "order_id": 3754894,
  "admin_comments": "New seller comments",
  "delivery_method": "New delivery method name"
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
$methodParams = '{ "order_id": 3754894, "admin_comments": "New seller comments", "delivery_method": "New delivery method name" }';

$apiParams = [
  "method"     => "setOrderFields",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
