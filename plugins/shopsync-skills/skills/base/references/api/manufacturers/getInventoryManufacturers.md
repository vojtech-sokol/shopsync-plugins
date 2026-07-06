# getInventoryManufacturers

**Category:** Manufacturers
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryManufacturers&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryManufacturers>

## Description

This method retrieves manufacturers from a BaseLinker catalog with optional pagination support. The API returns up to 1000 manufacturers per page when the `page` parameter is specified, or all manufacturers if omitted.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| page | int | No | Results paging (1000 manufacturers per page). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| manufacturers | array | Array of manufacturer objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `manufacturers[]` fields

| Field | Type | Description |
|-------|------|-------------|
| manufacturer_id | int | Manufacturer identifier. |
| name | varchar(200) | Manufacturer name. |
| manufacturer_name | varchar(200) | Manufacturer name. |
| manufacturer_photo | text | Manufacturer photo URL. |
| manufacturer_url | varchar(200) | Manufacturer URL address. |
| manufacturer_street | varchar(200) | Manufacturer street. |
| manufacturer_postcode | varchar(20) | Manufacturer postal code. |
| manufacturer_city | varchar(80) | Manufacturer city. |
| manufacturer_state | varchar(35) | Manufacturer state. |
| manufacturer_country_code | varchar(2) | Manufacturer country code. |
| manufacturer_email | varchar(100) | Manufacturer e-mail. |
| manufacturer_phone | varchar(40) | Manufacturer phone number. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "manufacturers": [
    {
      "manufacturer_id": 7,
      "name": "Test manufacturer",
      "manufacturer_name": "Test manufacturer",
      "manufacturer_photo": "https://cdn.baselinker.com/man/12345/abc123.jpg",
      "manufacturer_url": "https://example.com",
      "manufacturer_street": "Example Street 1",
      "manufacturer_postcode": "00-001",
      "manufacturer_city": "Warsaw",
      "manufacturer_state": "Mazowieckie",
      "manufacturer_country_code": "PL",
      "manufacturer_email": "contact@example.com",
      "manufacturer_phone": "+48123456789"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getInventoryManufacturers",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
