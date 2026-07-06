# getInventorySuppliers

**Category:** Suppliers
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventorySuppliers&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventorySuppliers>

## Description

The method allows you to retrieve a list of suppliers available in BaseLinker storage.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| filter_id | int | No | Restricts results to a particular supplier ID. |
| filter_name | varchar(40) | No | Narrows results by supplier name using full or partial matching. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| suppliers | array | Collection of supplier objects — see fields below. |

### `suppliers[]` fields

| Field | Type | Description |
|-------|------|-------------|
| supplier_id | int | Unique supplier identifier. |
| name | varchar(40) | Supplier designation. |
| address | varchar(200) | Physical location (optional). |
| postcode | varchar(20) | Postal code (optional). |
| city | varchar(80) | City name (optional). |
| phone | varchar(40) | Contact telephone (optional). |
| email | varchar(200) | Primary email (optional). |
| email_copy_to | varchar(200) | Additional correspondence addresses (optional). |
| currency | varchar(3) | Default supplier currency code (optional). |
| tax_no | varchar(16) | Tax identification number (optional). |

## Example request

```json
{
  "filter_id": 1,
  "filter_name": "Example Supplier"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "suppliers": [
    {
      "supplier_id": 1,
      "name": "Supplier Ltd",
      "address": "123 Main Street",
      "postcode": "12-345",
      "city": "London",
      "phone": "+44123456789",
      "email": "contact@supplier.com",
      "email_copy_to": "manager@supplier.com",
      "currency": "GBP",
      "tax_no": "GB123456789"
    },
    {
      "supplier_id": 2,
      "name": "Example Wholesale",
      "address": "456 Side Street",
      "postcode": "67-890",
      "city": "Manchester",
      "phone": "+44987654321",
      "email": "info@example.com",
      "currency": "EUR"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"filter_id": 1, "filter_name": "Example Supplier"}';

$apiParams = [
  "method"     => "getInventorySuppliers",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
