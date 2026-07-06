# getInvoices

**Category:** Invoices
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInvoices&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInvoices>

## Description

The method enables retrieval of invoices from BaseLinker's order management system, with optional filtering capabilities. The API returns a maximum of 100 invoices per request.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| invoice_id | int | No | Specific invoice identifier to retrieve single invoice. |
| order_id | int | No | Order identifier to retrieve associated invoice. |
| date_from | int | No | Unix timestamp indicating start date for invoice collection. |
| id_from | int | No | Invoice ID for retrieving subsequent invoices. |
| series_id | int | No | Invoice numbering series filter. |
| get_external_invoices | bool | No | Excludes invoices with external files when set to false. |
| get_government_data | bool | No | Includes government fields (`gov_id`, `gov_date`, `gov_status`) when true. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| invoices | array | Collection of invoice objects — see fields below. |

### `invoices[]` fields

| Field | Type | Description |
|-------|------|-------------|
| invoice_id | int | Invoice identifier. |
| order_id | int | Order identifier. |
| series_id | int | Series numbering identifier. |
| type | varchar(10) | `normal` or `correcting`. |
| number | varchar | Invoice number. |
| external_invoice_number | varchar | External system invoice number. |
| sub_id | int | Sub-identifier within numbering. |
| month | int | Numbering month. |
| year | int | Numbering year. |
| postfix | varchar(1) | Numbering postfix. |
| date_add | int | Creation date (unix). |
| date_sell | int | Sell date (unix). |
| date_pay_to | int | Payment due date (unix). |
| currency | char(3) | Currency code (e.g. EUR, PLN, GBP). |
| total_price_brutto | float | Gross total price. |
| total_price_netto | float | Net total price. |
| payment | varchar | Payment method. |
| additional_info | varchar | Additional information. |
| invoice_fullname | varchar | Billing — full name. |
| invoice_company | varchar | Billing — company. |
| invoice_nip | varchar | Billing — VAT/tax number. |
| invoice_address | varchar | Billing — address. |
| invoice_postcode | varchar | Billing — postcode. |
| invoice_city | varchar | Billing — city. |
| invoice_country | varchar | Billing — country. |
| invoice_country_code | varchar | Billing — country code. |
| seller | varchar | Seller information. |
| issuer | varchar | Issuer name. |
| correcting_to_invoice_id | int | Linked corrected invoice ID. |
| correcting_reason | varchar | Reason for correction. |
| correcting_items | bool | Whether items are being corrected. |
| correcting_data | bool | Whether invoice data is being corrected. |
| exchange_currency | varchar | Exchange currency. |
| exchange_rate | float | Exchange rate. |
| exchange_date | varchar | Exchange date. |
| exchange_info | varchar | Exchange info. |
| external_id | int(11) | External identifier. |
| items | array | Product line items — see fields below. |

### `items[]` fields

| Field | Type | Description |
|-------|------|-------------|
| name | varchar | Item name. |
| sku | varchar | Item SKU. |
| ean | varchar | Item EAN. |
| price_brutto | float | Gross price. |
| price_netto | float | Net price. |
| tax_rate | float | VAT rate (0–100). Special values: `-1` exempt, `-0.02`, `-0.03`. |
| quantity | int | Quantity. |
| is_shipment | int | `0` or `1`. |
| order_product_id | int | Linked order product ID. |

## Example request

```json
{
  "date_from": 1407341754
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "invoices": [
    {
      "invoice_id": 663197,
      "order_id": 5695322,
      "type": "normal",
      "number": "1/3/2016/shop",
      "year": 2016,
      "month": 3,
      "sub_id": 1,
      "postfix": "shop",
      "date_add": 1458161617,
      "date_sell": 1458161617,
      "date_pay_to": 0,
      "currency": "GBP",
      "total_price_brutto": 253,
      "total_price_netto": 205.691,
      "invoice_fullname": "",
      "invoice_company": "Jane Doe COMPANY",
      "invoice_nip": "999281736",
      "invoice_address": "Long Str 12",
      "invoice_city": "London",
      "invoice_postcode": "E2 8HQ",
      "invoice_country": "Great Britain",
      "invoice_country_code": "GB",
      "seller": "John Doe\r\nCOMPANY GMBH\r\nLong Str 66\r\nE2 8HQ London",
      "payment": "Cash on delivery",
      "correcting_to_invoice_id": 0,
      "correcting_reason": "",
      "correcting_items": false,
      "correcting_data": false,
      "external_invoice_number": "FV 101/03/2020",
      "exchange_currency": "",
      "exchange_rate": 0,
      "exchange_date": "",
      "exchange_info": "",
      "external_id": 662864993,
      "items": [
        {
          "name": "Wristwatch ALBATROSS ABDA72 - PROTECTOR",
          "price_brutto": 99,
          "price_netto": 80.4878,
          "tax_rate": 23,
          "quantity": 1,
          "is_shipment": 0
        },
        {
          "name": "Wristwatch Atim STELLI",
          "price_brutto": 139,
          "price_netto": 113.0081,
          "tax_rate": 23,
          "quantity": 1,
          "is_shipment": 0
        },
        {
          "name": "Delivery: courier COD",
          "price_brutto": 15,
          "price_netto": 12.1951,
          "tax_rate": 23,
          "quantity": 1,
          "is_shipment": 1
        }
      ]
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "date_from": 1407341754 }';

$apiParams = [
  "method"     => "getInvoices",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
