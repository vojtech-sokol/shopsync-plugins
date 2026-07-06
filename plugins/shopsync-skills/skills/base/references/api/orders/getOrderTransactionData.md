# getOrderTransactionData

**Category:** Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderTransactionData&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderTransactionData>

## Description

The method allows you to retrieve transaction details for a selected order.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order identifier from BaseLinker order manager. |
| include_complex_taxes | bool | No | Whether to include detailed tax breakdown with `order_items` structure (default: false). |
| include_amazon_data | bool | No | Whether to include legacy Amazon fulfillment data (default: true). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR` with `error_message` and `error_code` on failure. |
| currency | char(3) | Order currency code. |
| fulfillment_shipments | array | Amazon fulfillment shipments (`product_sku`, `product_name`, `quantity`, `fba`). |
| fulfillment_center_id | varchar(10) | Amazon fulfillment center identifier (Amazon Vendor only). |
| ship_date_from | int | Ship date from (unix timestamp). |
| ship_date_to | int | Ship date to (unix timestamp). |
| delivery_date_from | int | Delivery date from (unix timestamp). |
| delivery_date_to | int | Delivery date to (unix timestamp). |
| marketplace_transaction_id | varchar(60) | Transaction identifier from marketplace. |
| account_id | int | Marketplace account identifier. |
| transaction_date | int | Transaction date (unix timestamp). |
| order_items | array | Detailed tax breakdown per product when `include_complex_taxes=true` — see fields below. |

### `order_items[]` fields

| Field | Type | Description |
|-------|------|-------------|
| itemId | varchar(50) | Product SKU or identifier. |
| outerItemId | varchar(51) | Additional identifier (`p` + sku). |
| shipping | object | Shipping costs/taxes with `netValue`, `taxValue`, `grossValue`, `currency`, and `taxes` array. |
| taxes | array | Tax objects with `code`, `value`, and `rate`. |

## Example request

```json
{
  "order_id": 143477867,
  "include_complex_taxes": true,
  "include_amazon_data": false
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "currency": "USD",
  "fulfillment_shipments": [],
  "fulfillment_center_id": "WRO1",
  "ship_date_from": "",
  "ship_date_to": "",
  "delivery_date_from": "",
  "delivery_date_to": "",
  "marketplace_transaction_id": "zorp-test",
  "account_id": 23,
  "transaction_date": 1703097600,
  "order_items": [
    {
      "itemId": "BPCABS16949",
      "outerItemId": "pBPCABS16949",
      "shipping": {
        "netValue": 0,
        "taxValue": 0,
        "grossValue": 0,
        "currency": "USD",
        "taxes": [
          {"code": "GST", "value": 0, "rate": 0.05},
          {"code": "HST", "value": 0, "rate": 0.08}
        ]
      },
      "taxes": [
        {"code": "GST", "value": 2.5, "rate": 0.05},
        {"code": "HST", "value": 3.75, "rate": 0.075}
      ]
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"order_id": 143477867, "include_complex_taxes": true, "include_amazon_data": false}';

$apiParams = [
  "method"     => "getOrderTransactionData",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
