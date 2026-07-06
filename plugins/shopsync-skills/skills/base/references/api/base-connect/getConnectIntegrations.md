# getConnectIntegrations

**Category:** Base Connect — Integrations
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getConnectIntegrations&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getConnectIntegrations>

## Description

The method allows you to retrieve a list of all Base Connect integrations on this account.

## Input Parameters

_None._

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` (request executed correctly) or `ERROR` (with `error_message` and `error_code` fields). |
| integrations | array | Contains `own_integrations` (integrations created on the current account) and `connected_integrations` (integrations the account has connected to). |

### Integration object fields

| Field | Type | Description |
|-------|------|-------------|
| connect_integration_id | int | The unique integration identifier. |
| name | varchar(100) | The integration's display name. |
| settings | array | Integration configuration options. |

## Example request

```json
[]
```

## Example response

```json
{
  "status": "SUCCESS",
  "integrations": {
    "own_integrations": [
      {
        "connect_integration_id": 1,
        "name": "Integration name",
        "settings": []
      }
    ],
    "connected_integrations": [
      {
        "connect_integration_id": 2,
        "name": "Connected integration name",
        "settings": []
      },
      {
        "connect_integration_id": 4,
        "name": "Connected integration name 4",
        "settings": []
      }
    ]
  }
}
```

## PHP example

```php
<?php
$methodParams = '[]';

$apiParams = [
  "method"     => "getConnectIntegrations",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
