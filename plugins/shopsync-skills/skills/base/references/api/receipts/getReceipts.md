# getReceipts

**Category:** Receipts
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getReceipts&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getReceipts>

## Description

This endpoint retrieves issued receipts with a maximum of 100 per request. For fiscal printer integration, the `getNewReceipts` method is recommended instead.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| series_id | int | No | Filters results by receipt numbering series ID. |
| id_from | int | No | Starting receipt ID (inclusive) for retrieving subsequent receipts. |
| date_from | int | No | Unix timestamp marking the beginning of the date range. |
| date_to | int | No | Unix timestamp marking the end of the date range. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| receipts | array | Collection of receipt objects — see fields below. |

### `receipts[]` fields

| Field | Type | Description |
|-------|------|-------------|
| receipt_id | int | Unique identifier. |
| series_id | int | Numbering series identifier. |
| receipt_full_nr | varchar | BaseLinker-assigned receipt number. |
| order_id | int | Associated order identifier. |
| date_add | int | Unix timestamp of creation. |
| payment_method | varchar | Payment type designation. |
| nip | varchar | VAT registration number (may contain letters, hyphens, spaces). |
| products | array | Line items — see fields below. |

### `products[]` fields

| Field | Type | Description |
|-------|------|-------------|
| name | varchar | Item description. |
| price_brutto | float | Gross unit price. |
| tax_rate | float | VAT percentage (0–100). Special values: `-1` exempt, `-0.02` `NP`, `-0.03` reverse charge. |
| quantity | int | Unit count. |
| sku | varchar | Stock keeping unit. |
| ean | varchar | European article number. |

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
  "receipts": [
    {
      "receipt_id": 15384,
      "receipt_full_nr": "123/10/2018/P",
      "order_id": 1630473,
      "date_add": 1407841161,
      "payment_method": "PayPal",
      "products": [
        {
          "name": "Produkt",
          "price_brutto": 10,
          "tax_rate": 23,
          "quantity": 2,
          "sku": "",
          "ean": ""
        }
      ]
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"series_id": 0, "id_from": 1}';

$apiParams = [
  "method"     => "getReceipts",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
