# getCrmClientData

**Category:** CRM Clients
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getCrmClientData&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getCrmClientData>

## Description

The method allows you to retrieve detailed data of a specific CRM client, including notes.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| crm_client_id | int | Yes | ID of the CRM client to retrieve. |
| include_custom_extra_fields | bool | No | Download values of custom additional fields. Default `false`. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR` with `error_message` and `error_code` on failure. |
| crm_client_id | int | CRM client ID. |
| status_id | int | Client status ID. |
| star | int | Star rating 0–5 (0 = no star). |
| login | text | Client login. |
| phone | text | Client phone. |
| email | text | Client email. |
| notes | text | Client notes. |
| contractor_id | int | Base Connect contractor ID (0 if none). |
| invoice_company | text | Invoice company name. |
| invoice_fullname | text | Invoice full name. |
| invoice_address | text | Invoice address. |
| invoice_postcode | text | Invoice postcode. |
| invoice_city | text | Invoice city. |
| invoice_state | text | Invoice state/province. |
| invoice_country_code | text | Invoice country code. |
| invoice_tax_id | text | Invoice tax ID. |
| delivery_company | text | Delivery company name. |
| delivery_fullname | text | Delivery full name. |
| delivery_address | text | Delivery address. |
| delivery_postcode | text | Delivery postcode. |
| delivery_city | text | Delivery city. |
| delivery_state | text | Delivery state/province. |
| delivery_country_code | text | Delivery country code. |
| custom_extra_fields | array | CRM client custom extra fields (returned only if `include_custom_extra_fields=true`). For files: `{"title": "filename", "url": "https://..."}`. |

## Example request

```json
{
  "crm_client_id": 42
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "crm_client_id": 42,
  "status_id": 1,
  "star": 0,
  "login": "",
  "phone": "+48123456789",
  "email": "contact@example.com",
  "notes": "Important client, requires special handling.",
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
```

## PHP example

```php
<?php
$methodParams = '{ "crm_client_id": 42 }';

$apiParams = [
  "method"     => "getCrmClientData",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
