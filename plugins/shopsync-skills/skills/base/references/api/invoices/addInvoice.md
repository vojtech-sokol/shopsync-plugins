# addInvoice

**Category:** Invoices
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInvoice&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInvoice>

## Description

The method allows to issue an order invoice.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order identifier from BaseLinker order manager. |
| series_id | int | Yes | Series numbering identifier. |
| vat_rate | text | No | VAT rate. Accepted values: `DEFAULT` — according to the numbering series (default), `ITEM` — use the rate assigned to the item of the order, `EXPT` / `ZW` — exempt from VAT, `NP` — annotation NP, `OO` — VAT reverse charge, or a numeric value in range 0–100. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| invoice_id | int | ID of the added invoice. |

## Example request

```json
{
  "order_id": 4553562,
  "series_id": 1
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "invoice_id": 123456
}
```

## PHP example

```php
<?php
$methodParams = '{
  "order_id": 4553562,
  "series_id": 1
}';

$apiParams = [
  "method"     => "addInvoice",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
