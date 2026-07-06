# addCrmClient

**Category:** CRM Clients
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addCrmClient&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addCrmClient>

## Description

The method allows you to add a new CRM client. Adding a client with the same `crm_client_id` again will update the previously saved client (only the provided fields will be changed).

## Input Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| crm_client_id | int | CRM client ID for updates; omit or use 0 for new clients. |
| status_id | int | CRM client status ID. |
| star | int | Star rating 0–5 (0 = no star). |
| contractor_id | int | Base Connect contractor ID reference. |
| login | varchar(156) | Client login name. |
| phone | varchar(156) | Client phone number. |
| email | varchar(220) | Client email address. |
| notes | text | Client notes. |
| invoice_company | varchar(500) | Invoice company name. |
| invoice_fullname | varchar(500) | Invoice full name. |
| invoice_address | varchar(500) | Invoice address. |
| invoice_postcode | varchar(20) | Invoice postcode. |
| invoice_city | varchar(100) | Invoice city. |
| invoice_state | varchar(35) | Invoice state/province. |
| invoice_country_code | varchar(2) | ISO 3166-1 alpha-2 country code. |
| invoice_tax_id | varchar(50) | Tax ID (whitespace/dashes auto-removed). |
| delivery_company | varchar(500) | Delivery company name. |
| delivery_fullname | varchar(500) | Delivery full name. |
| delivery_address | varchar(500) | Delivery address. |
| delivery_postcode | varchar(20) | Delivery postcode. |
| delivery_city | varchar(100) | Delivery city. |
| delivery_state | varchar(35) | Delivery state/province. |
| delivery_country_code | varchar(2) | ISO 3166-1 alpha-2 country code. |
| custom_extra_fields | array | Key-value pairs where key = field ID, value = field content; empty string removes fields; file format: `{"title": "filename.pdf", "file": "base64-encoded data (max 2MB)"}`. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| crm_client_id | int | ID of created/updated client. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "invoice_company": "Example Company Ltd.",
  "invoice_tax_id": "123-456-78-90",
  "email": "contact@example.com",
  "phone": "+48123456789",
  "custom_extra_fields": {
    "135": "B2B",
    "149": "1646913115",
    "196": {
      "title": "agreement.pdf",
      "file": "data:JVBERi0xLjQKJ[...]"
    }
  }
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "crm_client_id": 42
}
```

## PHP example

```php
<?php
$methodParams = '{
  "invoice_company": "Example Company Ltd.",
  "invoice_tax_id": "123-456-78-90",
  "email": "contact@example.com",
  "phone": "+48123456789",
  "custom_extra_fields": {
    "135": "B2B",
    "149": "1646913115",
    "196": {
      "title": "agreement.pdf",
      "file": "data:JVBERi0xLjQKJ[...]"
    }
  }
}';

$apiParams = [
  "method"     => "addCrmClient",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
