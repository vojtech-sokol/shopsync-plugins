# getLabel

**Category:** Courier Labels & Protocols
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getLabel&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getLabel>

## Description

The method allows you to download a shipping label (consignment) for a selected shipment.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| courier_code | varchar(20) | Yes | Courier code. |
| package_id | int | No | Shipment ID (optional if `package_number` provided). |
| package_number | varchar(40) | No | Shipping number / consignment number (optional if `package_id` provided). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| extension | varchar(4) | Label file extension: `pdf`, `html`, `gif`, `png`, `epl`, `zpl`, `dpl`. |
| label | text | Label encoded with base64 algorithm. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "courier_code": "dhl",
  "package_id": 7323859
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "extension": "pdf",
  "label": "JVBERi0xLjQKJeLjz9MKNiAwIG9iago8PC9Db2xvclNwYWNlW.........FIvU2l6ZSAyNT4+CnN0YXJ0eHJlZgo3NjIyNgolJUVPRgo="
}
```

## PHP example

```php
<?php
$methodParams = '{ "courier_code": "dhl", "package_id": 7323859 }';

$apiParams = [
  "method"     => "getLabel",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
