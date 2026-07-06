# deleteCrmClient

**Category:** CRM Clients
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteCrmClient&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteCrmClient>

## Description

The method allows you to remove a CRM client. Orders previously associated with the deleted client are not affected.

## Input Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| crm_client_id | int | ID of the CRM client to delete. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` indicates proper execution; `ERROR` indicates failure with additional `error_message` and `error_code` fields. |

## Example request

```json
{
  "crm_client_id": 42
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
$methodParams = '{ "crm_client_id": 42 }';

$apiParams = [
  "method"     => "deleteCrmClient",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
