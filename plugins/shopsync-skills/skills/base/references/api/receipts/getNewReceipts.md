# getNewReceipts

**Category:** Receipts
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getNewReceipts&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getNewReceipts>

## Description

The method allows you to retrieve receipts waiting to be issued. This method should be used in creating integration with a fiscal printer. Receipts should be polled every approximately 10 seconds. After printing, receipts must be confirmed via `setOrderReceipt` to remove them from the waiting list.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| series_id | int | No | The numbering series ID allows filtering by the receipt numbering series. Useful for systems with multiple fiscal printers. |
| id_from | int | No | ID from which logs are to be retrieved. [default=0] |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| orders | array | Receipt objects — see fields below. |

### `orders[]` fields

| Field | Type | Description |
|-------|------|-------------|
| receipt_id | int | The receipt ID, used in the `setOrderReceipt` method to return the receipt as printed. |
| series_id | int | Receipt numbering series identifier. |
| receipt_full_nr | varchar(30) | The number assigned by BaseLinker when creating the receipt. Example: `123/10/2018/P`. Format depends on settings (monthly, annual, or continuous). |
| order_id | int | Order identifier from BaseLinker order manager. |
| date_add | int | Date of order creation (in unix time format). |
| payment_method | varchar(30) | Payment type name. |
| nip | varchar(30) | Payers details — VAT Reg No. May contain special characters: letters (prefix), hyphens and spaces. |
| products | array | Array of product objects — see fields below. |

### `products[]` fields

| Field | Type | Description |
|-------|------|-------------|
| name | varchar | Product name. |
| price_brutto | float | Single item gross price. |
| tax_rate | float | VAT tax rate e.g. `23` (range 0–100). Special values: `-1` for `EXPT`/`ZW` exempt from VAT, `-0.02` for `NP` annotation, `-0.03` for `OO` VAT reverse charge. |
| quantity | int | Quantity of pieces. |
| sku | varchar | Product SKU number. |
| ean | varchar | Product EAN number. |

## Example request

```json
{
  "series_id": 0,
  "id_from": 1
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "orders": [
    {
      "receipt_id": 15384,
      "receipt_full_nr": "123/10/2018/P",
      "order_id": 1630473,
      "date_add": 1407841161,
      "payment_method": "PayPal",
      "sku": "LU4235",
      "ean": "1597368451236"
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "series_id": 0, "id_from": 1 }';

$apiParams = [
  "method"     => "getNewReceipts",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
