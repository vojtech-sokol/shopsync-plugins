# getPackageDetails

**Category:** Courier Packages
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getPackageDetails&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getPackageDetails>

## Description

This method allows to get detailed information about a package. If the package contains multiple subpackages, information about all of them is included in the response.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| package_id | int | Yes | Shipment ID. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| package_details | array | List of shipments details — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `package_details[]` fields

| Field | Type | Description |
|-------|------|-------------|
| weight | float | Package weight. |
| weight_unit | text | `kg`, `g`, `lb`, `oz`, or empty string. |
| length | float | Package length. |
| width | float | Package width. |
| height | float | Package height. |
| size_unit | text | `cm`, `in`, or empty string. |
| size_template | varchar(255) | Size template identifier if used, otherwise empty. |
| is_custom | bool | True if custom dimensions, false otherwise. |
| cod_value | float | Cash on delivery value. |
| cod_currency | varchar(3) | COD currency code. |
| insurance_value | float | Insurance value. |
| insurance_currency | varchar(3) | Insurance currency code. |
| cost_value | float | Shipping cost declared. |
| cost_currency | varchar(3) | Shipping cost currency. |
| type | text | `package`, `dox`, `pallet`, or empty string. |
| pickup_date | int | Dispatch date in unix time format. |

## Example request

```json
{
  "package_id": 7323859
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "package_details": [
    {
      "weight": 30.52,
      "weight_unit": "kg",
      "length": 10.12,
      "width": 12,
      "height": 15.4,
      "size_unit": "cm",
      "size_template": "",
      "is_custom": false,
      "cod_value": 500.54,
      "cod_currency": "PLN",
      "insurance_value": 116.41,
      "insurance_currency": "EUR",
      "cost_value": 5.12,
      "cost_currency": "USD",
      "type": "package",
      "pickup_date": 0
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"package_id": 7323859}';

$apiParams = [
  "method"     => "getPackageDetails",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
