# getInventoryIntegrations

**Category:** Inventory — other
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryIntegrations&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryIntegrations>

## Description

This method retrieves a list of integrations where catalog text values can be modified, including connected accounts and supported languages for each integration.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | Yes | Catalog ID. The list of identifiers can be retrieved by the `getInventories` method (`inventory_id` field). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |
| integrations | array | A list containing information about the integrations, where the code of the integration is the key. |

### `integrations[]` fields

| Field | Type | Description |
|-------|------|-------------|
| langs | array | An array of two-letter codes for the languages supported by a given integration. |
| accounts | array | List of connected accounts of a given integration, where the key is the account identifier and the value is the account name. |

## Example request

```json
{
  "inventory_id": 307
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "integrations": [
    {
      "ebay": {
        "langs": ["pl", "en", "de"],
        "accounts": { "301": "eBay account, ID 301" }
      }
    },
    {
      "amazon": {
        "langs": ["en", "de"],
        "accounts": {
          "402": "Amazon account, ID 402",
          "401": "Amazon account, ID 401"
        }
      }
    },
    {
      "emag": {
        "langs": ["pl"],
        "accounts": { "101": "emag account, ID 301" }
      }
    },
    {
      "custom_422": {
        "langs": ["en", "de"],
        "accounts": { "422": "My custom channel" }
      }
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "inventory_id": 307 }';

$apiParams = [
  "method"     => "getInventoryIntegrations",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
