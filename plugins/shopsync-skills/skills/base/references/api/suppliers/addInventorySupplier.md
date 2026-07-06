# addInventorySupplier

**Category:** Suppliers
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventorySupplier&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventorySupplier>

## Description

The method allows you to add a new supplier or update an existing one in BaseLinker storage.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| supplier_id | int | No | Identifier for updating existing supplier. |
| name | varchar(40) | Yes | Supplier name. |
| take_product_cost_from | varchar(20) | Yes | Source of product cost for this supplier. Available values: `cost` (Product cost at the supplier), or price group ID. |
| take_product_code_from | varchar(20) | Yes | Source of product code for this supplier. Available values: `sku` (Product SKU), `ean` (Product EAN), `code` (Product code at the supplier), or extra field ID. |
| address | varchar(200) | No | Supplier address. |
| postcode | varchar(20) | No | Supplier postal code. |
| city | varchar(80) | No | Supplier city. |
| phone | varchar(40) | No | Supplier phone number. |
| email | varchar(200) | No | Supplier email address. |
| email_copy_to | varchar(200) | No | Additional email addresses for correspondence. |
| currency | varchar(3) | No | Default supplier currency (e.g. EUR, USD). |
| tax_no | varchar(16) | No | Supplier tax identification number. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| supplier_id | int | Created or updated supplier identifier. |

## Example request

```json
{
  "name": "Supplier Ltd",
  "take_product_cost_from": "cost",
  "take_product_code_from": "sku",
  "address": "123 Main Street",
  "postcode": "12-345",
  "city": "London",
  "phone": "+44123456789",
  "email": "contact@supplier.com",
  "email_copy_to": "manager@supplier.com",
  "currency": "GBP",
  "tax_no": "GB123456789"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "supplier_id": 1
}
```

## PHP example

```php
<?php
$methodParams = '{ "name": "Supplier Ltd", "take_product_cost_from": "cost", "take_product_code_from": "sku", "address": "123 Main Street", "postcode": "12-345", "city": "London", "phone": "+44123456789", "email": "contact@supplier.com", "email_copy_to": "manager@supplier.com", "currency": "GBP", "tax_no": "GB123456789" }';

$apiParams = [
  "method"     => "addInventorySupplier",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
