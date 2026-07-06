# getReceipt

**Category:** Receipts
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getReceipt&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getReceipt>

## Description

The method allows you to retrieve a single receipt from the BaseLinker order manager. For fiscal printer integration, use `getNewReceipts` instead.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| receipt_id | int | Conditional | Receipt identifier. Not needed if `order_id` is provided. |
| order_id | int | Conditional | Order identifier. Not needed if `receipt_id` is provided. |

At least one of `receipt_id` or `order_id` is required.

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| receipt_id | int | Receipt identifier for `setOrderReceipt` method. |
| series_id | int | Receipt numbering series identifier. |
| receipt_full_nr | varchar(30) | BaseLinker-assigned number (e.g. `123/10/2018/P`). |
| year | int | Year component of receipt number. |
| month | int | Month component (0 for annual numbering). |
| sub_id | int | Monthly/yearly number component. |
| order_id | int | Associated order identifier. |
| date_add | int | Order creation date (unix timestamp). |
| payment_method | varchar(30) | Payment type name. |
| nip | varchar(30) | VAT registration number (may include letters, hyphens, spaces). |
| currency | char(3) | 3-letter currency code (e.g. EUR, PLN). |
| total_price_brutto | float | Total gross receipt value. |
| external_receipt_number | varchar(30) | Fiscal register or external system number. |
| exchange_currency | char(3) | Target currency for converted receipts. |
| exchange_rate | decimal(10,4) | Conversion rate from currency to `exchange_currency`. |
| exchange_date | varchar(10) | Exchange rate date. |
| exchange_info | varchar(10) | Exchange rate source information. |
| items | array | Receipt line items — see fields below. |

### `items[]` fields

| Field | Type | Description |
|-------|------|-------------|
| name | varchar | Item description. |
| sku | varchar | Product SKU. |
| ean | varchar | Product EAN. |
| price_brutto | float | Single item gross price. |
| tax_rate | float | VAT rate (0–100). Special values: `-1` `EXPT`, `-0.02` `NP`, `-0.03` `OO`. |
| quantity | int | Number of units. |

## Example request

```json
{
  "order_id": 143476260
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "receipt_id": 3857659,
  "series_id": 45051,
  "receipt_full_nr": "2/7/2020/P",
  "year": 2020,
  "month": 7,
  "sub_id": 2,
  "order_id": 143476260,
  "date_add": 1593971301,
  "payment_method": "",
  "nip": "",
  "total_price_brutto": 141,
  "external_receipt_number": "",
  "exchange_currency": "",
  "exchange_rate": "",
  "exchange_date": "",
  "exchange_info": "",
  "items": [
    {
      "name": "Product 1",
      "sku": "sku1",
      "ean": "",
      "price_brutto": 20,
      "tax_rate": 23,
      "quantity": 7
    },
    {
      "name": "Product 2",
      "sku": "sku2",
      "ean": "",
      "price_brutto": 1,
      "tax_rate": 5,
      "quantity": 1
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"order_id": 143476260}';

$apiParams = [
  "method"     => "getReceipt",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
