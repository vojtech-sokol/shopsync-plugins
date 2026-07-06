# deleteInventorySupplier

**Category:** Suppliers
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=deleteInventorySupplier&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=deleteInventorySupplier>

## Description

The method allows you to remove a supplier from BaseLinker storage.

## Input Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| supplier_id | int | Supplier identifier. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. On error, returns additional `error_message` and `error_code` fields. |

## Example request

```json
{
  "supplier_id": 1
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
$methodParams = '{ "supplier_id": 1 }';

$apiParams = [
  "method"     => "deleteInventorySupplier",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
