# getCourierFields

**Category:** Courier Info
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getCourierFields&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getCourierFields>

## Description

The method retrieves form fields required for creating shipments with a specified courier service.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| courier_code | varchar(20) | Yes | Courier code. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| multi_packages | bool | Does the courier support multiple shipments (0/1). |
| fields | array | Shipment creation fields — see fields below. |
| package_fields | array | Package-specific fields for `createPackage` submission — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `fields[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | varchar(50) | The field ID. |
| name | varchar(50) | The field name. |
| type | varchar(10) | Field type (available `select`, `checkbox`, `text`, `date`). |
| desc | text | Additional field description. |
| options | array | List of selectable options (key = option id, value = option name). |
| show_field | array | List of additional fields that are available for the selected option. |
| value | varchar(50) | Default value for a field. |
| function | varchar(20) | Indicates dynamic options requiring `getCourierServices` call. |

### `package_fields[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | varchar(50) | The field ID. |
| name | varchar(50) | The field name. |
| type | varchar(10) | Field type. |

## Example request

```json
{
  "courier_code": "dhl"
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "multi_packages": false,
  "fields": [
    {
      "id": "courier",
      "name": "Courier",
      "type": "select",
      "desc": "",
      "options": {
        "2": "KEX",
        "4": "GLS",
        "5": "FedEx",
        "6": "InPost Paczkomaty",
        "8": "DHL",
        "10": "FedEx Lotniczy",
        "11": "Paczka w ruchu",
        "12": "InPost Kurier",
        "13": "Delta city",
        "30": "UPS Express Saver",
        "31": "UPS Standard"
      }
    },
    {
      "id": "package_type",
      "name": "Type",
      "type": "select",
      "options": {
        "paczka": "parcel",
        "paleta": "palette",
        "koperta": "envelope"
      },
      "show_field": {
        "paleta": ["before_delivery_notification"]
      }
    },
    {
      "id": "pickup_date",
      "name": "Dispatch date",
      "type": "date",
      "desc": "Order pickup for specific day",
      "value": 1487085753
    },
    {
      "id": "cod",
      "name": "Cash on delivery",
      "type": "text"
    },
    {
      "id": "insurance",
      "name": "Insurance",
      "type": "text"
    },
    {
      "id": "package_description",
      "name": "Content description",
      "type": "text"
    },
    {
      "id": "before_delivery_notification",
      "name": "Notification before delivery",
      "type": "checkbox",
      "desc": "Available only for DHL Palette",
      "options": {
        "1": "Yes"
      }
    }
  ],
  "package_fields": [
    {"id": "weight", "name": "Weight", "type": "text"},
    {"id": "size_length", "name": "Length", "type": "text"},
    {"id": "size_width", "name": "Width", "type": "text"},
    {"id": "size_height", "name": "Height", "type": "text"},
    {
      "id": "size_custom",
      "name": "Custom",
      "type": "checkbox",
      "options": {"1": "Unusual shape"},
      "default": "0"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "courier_code": "dhl" }';

$apiParams = [
  "method"     => "getCourierFields",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
