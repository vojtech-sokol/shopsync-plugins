# getCouriersList

**Category:** Courier Info
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getCouriersList&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getCouriersList>

## Description

The method allows you to retrieve a list of available couriers.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| couriers | array | An array containing courier objects — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `couriers[]` fields

| Field | Type | Description |
|-------|------|-------------|
| code | varchar(20) | Courier code. |
| name | varchar(30) | Courier name. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "couriers": [
    {"code": "dhl", "name": "DHL PL"},
    {"code": "dpd", "name": "DPD PL"},
    {"code": "fedexpl", "name": "FedEx.pl"},
    {"code": "globkurier", "name": "GlobKurier"},
    {"code": "gls", "name": "GLS PL"},
    {"code": "inpostkurier", "name": "InPost Kurier"},
    {"code": "paczkomaty", "name": "InPost Paczkomaty"},
    {"code": "ups", "name": "UPS"},
    {"code": "pocztapolska", "name": "Poczta Polska"},
    {"code": "qlink", "name": "Qlink"},
    {"code": "ruch", "name": "ORLEN Paczka"}
  ]
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getCouriersList",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
