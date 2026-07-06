# setOrderReceipt

**Category:** Receipts
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrderReceipt&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrderReceipt>

## Description

The method allows you to mark orders with a receipt already issued.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| receipt_id | int | Yes | `receipt_id` number received in the `getNewReceipts` method. |
| receipt_nr | varchar(20) | No | The number of the issued receipt (may be blank if the printer does not return the number). |
| date | int | Yes | Receipt printing date (unixtime format). |
| printer_error | bool | Yes | Flag indicating whether an error occurred during receipt printing (false by default). |
| printer_name | varchar(50) | No | Printer name. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |

## Example request

```json
{
  "receipt_id": 153845,
  "receipt_nr": "FP 23212",
  "date": 1407341754,
  "printer_error": false,
  "printer_name": "Fiscal123"
}
```

## Example response

```json
{
  "status": "SUCCESS"
}
```

## PHP example

```php
<?php
$methodParams = '{
  "receipt_id": 153845,
  "receipt_nr": "FP 23212",
  "date": 1407341754,
  "printer_error": false,
  "printer_name": "Fiscal123"
}';

$apiParams = [
  "method"     => "setOrderReceipt",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
