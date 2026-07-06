# getConnectIntegrationContractors

**Category:** Base Connect — Integrations
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getConnectIntegrationContractors&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getConnectIntegrationContractors>

## Description

This endpoint retrieves a list of contractors connected to the selected Base Connect integration.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| connect_integration_id | int | Yes | Connect integration ID. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` (request executed correctly) or `ERROR` (with `error_message` and `error_code` fields). |
| contractors | array | List of Base Connect contractors for the selected Base Connect integration. |

### `contractors[]` fields

| Field | Type | Description |
|-------|------|-------------|
| connect_contractor_id | int | Contractor ID. |
| name | text | Contractor name. |
| credit_data | array | Contractor credit summary data. |
| settings | array | Contractor options. |

## Example request

```json
{ "connect_integration_id": 1 }
```

## Example response

```json
{
  "status": "SUCCESS",
  "contractors": {
    "1": {
      "connect_contractor_id": 1,
      "name": "Contractor name",
      "credit_data": [],
      "settings": []
    },
    "12": {
      "connect_contractor_id": 34,
      "name": "Contractor name 34",
      "credit_data": [],
      "settings": []
    }
  }
}
```

## PHP example

```php
<?php
$methodParams = '{ "connect_integration_id": 1 }';

$apiParams = [
  "method"     => "getConnectIntegrationContractors",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
