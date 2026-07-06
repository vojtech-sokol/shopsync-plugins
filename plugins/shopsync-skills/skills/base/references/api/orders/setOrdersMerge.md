# setOrdersMerge

**Category:** Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=setOrdersMerge&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=setOrdersMerge>

## Description

Merges multiple orders into one, based on the selected merge mode.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| main_order_id | int | Yes | ID of the main order (its shipping and invoice data will be retained). |
| order_ids_to_merge | array | Yes | List of other order IDs to merge. Must not include `main_order_id`. |
| merge_mode | text | Yes | Merge mode options: `technical_merge` (creates a new technical order without changing the originals) or `into_main_order` (moves items into the main order and deletes the others). |
| sum_delivery_costs | bool | No | Whether to sum delivery costs: `true` (add up all shipping costs from merged orders) or `false` (keep only the main order's shipping cost). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| merged_order_id | int | ID of the merged order. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

## Example request

```json
{
  "main_order_id": 1234567,
  "order_ids_to_merge": [2345678, 3456789, 4567890],
  "merge_mode": "technical_merge",
  "sum_delivery_costs": true
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "merged_order_id": 12345678
}
```

## PHP example

```php
<?php
$methodParams = '{
  "main_order_id": 1234567,
  "order_ids_to_merge": [2345678, 3456789, 4567890],
  "merge_mode": "technical_merge",
  "sum_delivery_costs": true
}';

$apiParams = [
  "method"     => "setOrdersMerge",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
