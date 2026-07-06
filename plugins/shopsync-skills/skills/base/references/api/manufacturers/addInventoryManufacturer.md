# addInventoryManufacturer

**Category:** Manufacturers
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryManufacturer&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryManufacturer>

## Description

The method allows you to add a manufacturer to the BaseLinker catalog. Adding a manufacturer with the same identifier again, updates the previously saved manufacturer.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| manufacturer_id | int | No | Manufacturer ID for updates; leave blank when creating new. |
| name | varchar(200) | No | Manufacturer name (deprecated, use `manufacturer_name` instead). |
| manufacturer_name | varchar(200) | Yes | Manufacturer name. |
| manufacturer_photo | text | No | Manufacturer photo (e.g. a logo). You can submit a photo in binary format, or a link to an external photo — use `data:` prefix for base64 or `url:` for external links; empty string deletes photo. |
| manufacturer_url | varchar(200) | No | Manufacturer URL address. |
| manufacturer_street | varchar(200) | No | Manufacturer street. |
| manufacturer_postcode | varchar(20) | No | Manufacturer postal code. |
| manufacturer_city | varchar(80) | No | Manufacturer city. |
| manufacturer_state | varchar(35) | No | Manufacturer state. |
| manufacturer_country_code | varchar(2) | No | Manufacturer country code (2-letter ISO code, e.g. `PL`, `DE`). |
| manufacturer_email | varchar(100) | No | Manufacturer e-mail. |
| manufacturer_phone | varchar(40) | No | Manufacturer phone number. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| manufacturer_id | int | ID of created or updated manufacturer. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "manufacturer_name": "Test manufacturer 2",
  "manufacturer_photo": "url:https://example.com/logo.png",
  "manufacturer_url": "https://example.com",
  "manufacturer_street": "Example Street 1",
  "manufacturer_postcode": "00-001",
  "manufacturer_city": "Warsaw",
  "manufacturer_state": "Mazowieckie",
  "manufacturer_country_code": "PL",
  "manufacturer_email": "contact@example.com",
  "manufacturer_phone": "+48123456789"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "manufacturer_id": 8
}
```

## PHP example

```php
<?php
$methodParams = '{"manufacturer_name": "Test manufacturer 2", "manufacturer_photo": "url:https://example.com/logo.png", "manufacturer_url": "https://example.com", "manufacturer_street": "Example Street 1", "manufacturer_postcode": "00-001", "manufacturer_city": "Warsaw", "manufacturer_state": "Mazowieckie", "manufacturer_country_code": "PL", "manufacturer_email": "contact@example.com", "manufacturer_phone": "+48123456789"}';

$apiParams = [
  "method"     => "addInventoryManufacturer",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
