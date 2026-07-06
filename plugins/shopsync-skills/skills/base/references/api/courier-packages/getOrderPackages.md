# getOrderPackages

**Category:** Courier Packages
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrderPackages&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrderPackages>

## Description

The method allows you to download shipments previously created for the selected order.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | Yes | Order identifier. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| packages | array | Collection of shipment records — see fields below. |
| error_message | varchar | Present on `ERROR` status. |
| error_code | varchar | Present on `ERROR` status. |

### `packages[]` fields

| Field | Type | Description |
|-------|------|-------------|
| package_id | int | Shipment identifier. |
| courier_package_nr | varchar(40) | Shipping / consignment number. |
| courier_inner_number | varchar(40) | Courier internal reference number. |
| courier_code | varchar(20) | Courier service code. |
| courier_other_name | varchar(20) | Broker-specific courier designation. |
| account_id | int | Courier account identifier. |
| tracking_status_date | int | Unix timestamp of latest tracking update. |
| tracking_delivery_days | int | Days from Shipped to Delivered status (excluding weekends). |
| tracking_status | int | Status code: `0` Unknown, `1` Label Created, `2` Shipped, `3` Not Delivered, `4` Out for Delivery, `5` Delivered, `6` Return, `7` Aviso, `8` Waiting at Point, `9` Lost, `10` Canceled, `11` On the Way. |
| package_type | int | Type code: `0` Standard, `1` Return, `2` Sent at Point, `3` Return at Point. |
| tracking_url | varchar(255) | Shipment tracking link. |
| is_return | bool | Return shipment indicator. |

## Example request

```json
{
  "order_id": 6910995
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "packages": [
    {
      "package_id": 7323858,
      "courier_package_nr": "0000081265020U",
      "courier_inner_number": "33893480912",
      "courier_code": "dpd",
      "courier_other_name": "",
      "account_id": 58381,
      "tracking_status_date": 1511796910,
      "tracking_delivery_days": 0,
      "tracking_status": 4,
      "is_return": false
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{"order_id": 6910995}';

$apiParams = [
  "method"     => "getOrderPackages",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
