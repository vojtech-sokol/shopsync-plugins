# createPackage

**Category:** Courier Packages
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=createPackage&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=createPackage>

## Description

The method allows you to create a shipment in the system of the selected courier.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order identifier. |
| courier_code | varchar(20) | Yes | Courier code. |
| account_id | int | No | Courier API account id for the courier accounts retrieved from the request `getCourierAccounts`. If blank, the first account will be used. |
| fields | array | Yes | List of form fields retrieved from the request `getCourierFields`. For checkbox with multiple selection, the information should be sent in separate arrays. |
| packages | array | Yes | Array of shipments list, weight of at least one shipment required. Height, length, width should be sent in centimeters. Weight should be sent in kilograms. |

### `fields[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | varchar(50) | The field ID. |
| value | text | Option ID (required for checkbox, select field types) or value (required for text, date field types). Date — format unix time. |

### `packages[]` fields

| Field | Type | Description |
|-------|------|-------------|
| weight | numeric | Weight in kilograms (required for at least one package). |
| height | numeric | Height in centimeters. |
| length | numeric | Length in centimeters. |
| width | numeric | Width in centimeters. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| package_id | int | Shipment ID. |
| package_number | varchar(40) | Shipping number (consignment number). |
| courier_inner_number | varchar(40) | Courier internal number. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "order_id": 6910995,
  "courier_code": "dhl",
  "account_id": 33,
  "fields": [
    {
      "id": "service",
      "value": "dhl"
    },
    {
      "id": "cod",
      "value": "101"
    },
    {
      "id": "insurance",
      "value": "55"
    },
    {
      "id": "package_description",
      "value": "Shipment description"
    }
  ],
  "packages": [
    {
      "length": 11,
      "height": 12,
      "width": 13,
      "weight": 4,
      "size_custom": 1
    }
  ]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "package_id": 77014696,
  "package_number": "622222044730624327700198",
  "courier_inner_number": "12387890"
}
```

## PHP example

```php
<?php
$methodParams = '{
  "order_id": 6910995,
  "courier_code": "dhl",
  "account_id": 33,
  "fields": [
    {
      "id": "service",
      "value": "dhl"
    },
    {
      "id": "cod",
      "value": "101"
    },
    {
      "id": "insurance",
      "value": "55"
    },
    {
      "id": "package_description",
      "value": "Shipment description"
    }
  ],
  "packages": [
    {
      "length": 11,
      "height": 12,
      "width": 13,
      "weight": 4,
      "size_custom": 1
    }
  ]
}';

$apiParams = [
  "method"     => "createPackage",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
