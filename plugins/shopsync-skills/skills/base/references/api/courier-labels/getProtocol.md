# getProtocol

**Category:** Courier Labels & Protocols
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getProtocol&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getProtocol>

## Description

The method allows you to download a parcel protocol for selected shipments if the protocol is available for chosen courier.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| courier_code | varchar(20) | Yes | Courier code. |
| package_ids | array | No | Array of shipments ID (optional if `package_numbers` provided). |
| package_numbers | array | No | Array of shipments number / consignment number (optional if `package_ids` provided). |
| account_id | int | Yes | Courier API account id from `getCourierAccounts` request. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| extension | varchar(4) | Protocol file extension (`pdf`, `html`). |
| protocol | text | Protocol encoded with base64 algorithm. |
| error_message | text | Present on `ERROR` status. |
| error_code | int | Present on `ERROR` status. |

## Example request

```json
{
  "courier_code": "raben",
  "package_ids": [7323859, 8421839]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "extension": "pdf",
  "protocol": "JVBERi0xLjQKJeLjz9MKNiAwIG9iago8PC9Db2xvclNwYWNlW.........FIvU2l6ZSAyNT4+CnN0YXJ0eHJlZgo3NjIyNgolJUVPRgo="
}
```

## PHP example

```php
<?php
$methodParams = '{ "courier_code": "raben", "package_ids": [7323859, 8421839] }';

$apiParams = [
  "method"     => "getProtocol",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
