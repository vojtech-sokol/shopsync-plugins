# getCrmClients

**Category:** CRM Clients
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getCrmClients&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getCrmClients>

## Description

The method retrieves a list of CRM clients with optional filtering. Results are limited to 100 clients per request. For extended details including notes and custom fields, the `getCrmClientData` method should be used instead.

## Input Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| page | int | Results page number (100 results per page, numbered from 1). |
| filter_crm_client_id | int | Filter by exact CRM client ID. |
| filter_email | varchar(220) | Filter by email (partial match). |
| filter_phone | varchar(156) | Filter by phone (partial match). |
| filter_login | varchar(156) | Filter by login (partial match). |
| filter_invoice_company | varchar(500) | Filter by invoice company name (partial match). |
| filter_invoice_tax_id | varchar(50) | Filter by invoice tax ID (partial match). |
| filter_invoice_fullname | varchar(500) | Filter by invoice full name (partial match). |
| filter_status_id | int | Filter by exact status ID. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| clients | array | Collection of client objects — see fields below. |

### `clients[]` fields

| Field | Type | Description |
|-------|------|-------------|
| crm_client_id | int | Client identifier. |
| status_id | int | Client status identifier. |
| star | int | Star rating 0–5 (0 = no star). |
| login | text | Client login credential. |
| phone | text | Client phone number. |
| email | text | Client email address. |
| contractor_id | int | Associated Base Connect contractor ID. |
| invoice_company | text | Billing company name. |
| invoice_fullname | text | Billing contact name. |
| invoice_address | text | Billing street address. |
| invoice_postcode | text | Billing postal code. |
| invoice_city | text | Billing city. |
| invoice_state | text | Billing state/province. |
| invoice_country_code | text | Billing country code. |
| invoice_tax_id | text | Billing tax ID. |
| delivery_company | text | Shipping company name. |
| delivery_fullname | text | Shipping contact name. |
| delivery_address | text | Shipping street address. |
| delivery_postcode | text | Shipping postal code. |
| delivery_city | text | Shipping city. |
| delivery_state | text | Shipping state/province. |
| delivery_country_code | text | Shipping country code. |

## Example request

```json
{
  "filter_invoice_company": "Example",
  "page": 1
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "clients": [
    {
      "crm_client_id": 42,
      "status_id": 1,
      "star": 0,
      "login": "",
      "phone": "+48123456789",
      "email": "contact@example.com",
      "contractor_id": 0,
      "invoice_company": "Example Company Ltd.",
      "invoice_fullname": "John Doe",
      "invoice_address": "123 Main St",
      "invoice_postcode": "00-001",
      "invoice_city": "Warsaw",
      "invoice_state": "",
      "invoice_country_code": "PL",
      "invoice_tax_id": "1234567890",
      "delivery_company": "",
      "delivery_fullname": "John Doe",
      "delivery_address": "123 Main St",
      "delivery_postcode": "00-001",
      "delivery_city": "Warsaw",
      "delivery_state": "",
      "delivery_country_code": "PL"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "filter_invoice_company": "Example", "page": 1 }';

$apiParams = [
  "method"     => "getCrmClients",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
