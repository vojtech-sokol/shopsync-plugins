# addInvoiceCorrection

**Category:** Invoices
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInvoiceCorrection&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInvoiceCorrection>

## Description

The method allows to issue an order invoice correction. Either `original_invoice_id` or `return_order_id` must be provided. When `return_order_id` is supplied, all other fields are disregarded except `series_id`, and the invoice uses return order data. Optional fields default to series settings or system defaults if omitted.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| original_invoice_id | int | Conditional | Original invoice identifier. Either this or `return_order_id` is required. |
| return_order_id | int | Conditional | Return order identifier. Either this or `original_invoice_id` is required. |
| series_id | int | No | Series numbering identifier. |
| date_sell | int | No | Sell date in unix timestamp. |
| correcting_reason | int | No | Reason codes: `1` prepayments return, `2` compulsory discounts, `3` price increase post-invoicing, `4` refund undue amounts, `5` goods return, `6` pricing/tax errors, `7` address correction, `8` contract withdrawal, `9` other. |
| correcting_items | bool | No | Whether to correct invoice items (0 or 1). |
| correcting_data | bool | No | Whether to correct invoice data (0 or 1). |
| invoice_fullname | varchar(100) | No | Full name for invoice. |
| invoice_company | varchar(100) | No | Company name. |
| invoice_address | varchar(100) | No | Address. |
| invoice_postcode | varchar(100) | No | Postal code. |
| invoice_city | varchar(100) | No | City. |
| invoice_state | varchar(100) | No | State/Province. |
| invoice_country_code | varchar(100) | No | Country code (e.g. PL). |
| invoice_nip | varchar(100) | No | Tax ID number. |
| items | array | No | Array of correctable items — see fields below. |
| fv_payment | varchar(100) | No | Payment method. |
| fv_person | varchar(100) | No | Issuer name. |

### `items[]` fields

| Field | Type | Description |
|-------|------|-------------|
| item_name | string | Item name. |
| item_sku | string | Item SKU. |
| item_ean | string | Item EAN. |
| item_quantity | numeric | Item quantity. |
| item_price_brutto | numeric | Item gross price. |
| item_tax_rate | numeric | Item VAT rate. |
| order_product_id | int | Optional. If absent, the item is added as a new position. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| invoice_id | int | ID of the added invoice. |

## Example request

```json
{
  "original_invoice_id": 1,
  "series_id": 2,
  "date_sell": 1407341754,
  "correcting_reason": 1,
  "correcting_items": 1,
  "correcting_data": 1,
  "invoice_fullname": "John Doe",
  "invoice_company": "Big Company",
  "invoice_address": "Street 10",
  "invoice_postcode": "01-234",
  "invoice_city": "Warsaw",
  "invoice_state": "Masovian",
  "invoice_country_code": "PL",
  "invoice_nip": "1234567890",
  "items": [
    {
      "item_name": "Test Product",
      "item_sku": "TestProductSku",
      "item_ean": "12345678",
      "item_quantity": 1,
      "item_price_brutto": 25,
      "item_tax_rate": 19
    }
  ],
  "fv_payment": "Transfer",
  "fv_person": "Kierownik"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "invoice_id": 19824373
}
```

## PHP example

```php
<?php
$methodParams = '{
  "original_invoice_id": 1,
  "series_id": 2,
  "date_sell": 1407341754,
  "correcting_reason": 1,
  "correcting_items": 1,
  "correcting_data": 1,
  "invoice_fullname": "John Doe",
  "invoice_company": "Big Company",
  "invoice_address": "Street 10",
  "invoice_postcode": "01-234",
  "invoice_city": "Warsaw",
  "invoice_state": "Masovian",
  "invoice_country_code": "PL",
  "invoice_nip": "1234567890",
  "items": [
    {
      "item_name": "Test Product",
      "item_sku": "TestProductSku",
      "item_ean": "12345678",
      "item_quantity": 1,
      "item_price_brutto": 25,
      "item_tax_rate": 19
    }
  ],
  "fv_payment": "Transfer",
  "fv_person": "Kierownik"
}';

$apiParams = [
  "method"     => "addInvoiceCorrection",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
