# getCourierDocument

**Category:** Courier Labels & Protocols
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getCourierDocument&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getCourierDocument>

## Description

The method allows you to download a parcel document.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| courier_code | varchar(20) | Yes | Courier code. |
| document_type | varchar(10) | Yes | Types: `manifest`, `protocol`, `label`. |
| account_id | int | No | Courier API account id for the courier accounts retrieved from the request `getCourierAccounts`. |
| package_ids | array | No | Array of shipments ID. |
| package_numbers | array | No | Array of shipments number (consignment number). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| extension | varchar(4) | Document file extension (`pdf`, `zpl`, `epl`, `html`, etc.). |
| document | text | Document encoded with base64 algorithm. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "courier_code": "flipkartshipping",
  "document_type": "manifest",
  "account_id": 16
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "extension": "pdf",
  "document": "JVBERi0xLjQKJeLjz9MKNiAwIG9iago8PC9Db2xvclNwYWNlW.........FIvU2l6ZSAyNT4+CnN0YXJ0eHJlZgo3NjIyNgolJUVPRgo="
}
```

## PHP example

```php
<?php
$methodParams = '{ "courier_code": "flipkartshipping", "document_type": "manifest", "account_id": 16 }';

$apiParams = [
  "method"     => "getCourierDocument",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
