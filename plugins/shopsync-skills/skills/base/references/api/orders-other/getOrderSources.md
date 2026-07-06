# getOrderSources

**Category:** Orders — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderSources&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderSources>

## Description

This endpoint retrieves order source types and their associated IDs. Sources are categorized by type, matching the `order_source` field from `getOrders`. Categories include `personal`, `shop`, `order_return`, or marketplace codes like `ebay`, `amazon`, `ceneo`, `emag`, `allegro`, etc.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On `ERROR`, additional `error_message` and `error_code` fields are returned. |
| sources | array | Grouped order sources — see fields below. |

### `sources` fields

| Field | Type | Description |
|-------|------|-------------|
| personal | array | User-created custom sources; key is source ID, value is source name. |
| shop | array | Connected shops; key is shop ID, value is shop name. |
| blconnect | array | Base Connect tokens; key is token ID, value is token name. |
| allegro | array | Allegro accounts; key is account ID, value is account name. |
| ebay | array | eBay accounts; key is account ID, value is account name. |
| amazon | array | Amazon accounts; key is account ID, value is account name. |
| amazon_vendor | array | Amazon Vendor accounts; key is account ID, value is account name. |
| order_return | array | Return-based orders; key is return ID. |
| [marketplace_code] | array | Other marketplace accounts; key is account ID, value is account name. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "sources": {
    "personal": {
      "0": "In person / by phone",
      "1621": "stationary shop"
    },
    "shop": {
      "8235": "Shop 1",
      "4626": "Shop 2"
    },
    "ebay": {
      "1522": "eBay Account 1",
      "1634": "eBay Account 2"
    },
    "amazon": {
      "7245": "Amazon Account 1",
      "7342": "Amazon Account 2"
    },
    "order_return": ["Order return"]
  }
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getOrderSources",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
