# getExternalStorageProductsData

**Category:** External Storage
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getExternalStorageProductsData&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getExternalStorageProductsData>

## Description

The method allows to retrieve detailed data of selected products from an external storage (shop/wholesaler) connected to BaseLinker.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| storage_id | varchar(30) | Yes | Storage identifier in format `[type:shop\|warehouse]_[id:int]` (e.g. `shop_2445`). |
| products | array | Yes | Collection of product ID numbers to retrieve. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` (request executed correctly) or `ERROR` (with `error_message` and `error_code` fields). |
| storage_id | varchar(30) | Echo of the requested storage identifier. |
| products | array | Collection of product objects, keyed by `product_id`. |

### `products[]` fields

| Field | Type | Description |
|-------|------|-------------|
| product_id | varchar(30) | Primary product identifier. |
| sku | varchar(32) | Product SKU number. It can be filled with e.g. an external system product number. |
| ean | varchar(32) | Product EAN code. |
| asin | varchar(50) | Product ASIN identifier. |
| name | varchar(200) | Product title. |
| quantity | int | Stock level. |
| price_netto | float | Net price value. |
| price_brutto | float | Gross price value. |
| price_wholesale_netto | float | Wholesale net pricing. |
| tax_rate | float | VAT tax rate e.g. `23` (value from range 0–100, EXCEPTION values: `-1` for EXPT/ZW exempt from VAT, `-0.02` for NP annotation, `-0.03` for OO VAT reverse charge). |
| weight | float | Mass in kilograms. |
| description | text | Primary product details. |
| description_extra1 | text | Supplementary product description field. |
| description_extra2 | text | Additional product description field. |
| man_name | varchar(50) | Manufacturer designation. |
| man_image | varchar(100) | Manufacturer logo URL. |
| category_id | int | Product category reference. |
| images | array | Product photograph URLs. |
| features | array | Array of product features in the form of a list. Each element of the array is also an array containing two elements: `0` (varchar) — parameter name e.g. `resolution`, `1` (varchar) — parameter value e.g. `Full HD`. |
| variants | array | Available product variants. |

### `variants[]` fields

| Field | Type | Description |
|-------|------|-------------|
| variant_id | varchar | Variant identifier. |
| name | varchar | Variant name. |
| price | float | Variant price. |
| quantity | int | Variant stock quantity. |
| sku | varchar | Variant SKU. |
| ean | varchar | Variant EAN. |
| asin | varchar | Variant ASIN. |

## Example request

```json
{
  "storage_id": "shop_2445",
  "products": [524, 734]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "storage_id": "shop_2445",
  "products": {
    "524": {
      "product_id": 524,
      "price_wholesale_netto": "0",
      "price_netto": "902.48",
      "price_brutto": "1110.05",
      "tax_rate": "23",
      "name": "Adidas SG53 shoes",
      "quantity": "0",
      "category_id": "26356",
      "weight": "3.2",
      "sku": null,
      "ean": "6115181635",
      "asin": "B07EXAMPLE1",
      "description": "product description",
      "description_extra1": "",
      "description_extra2": "",
      "man_name": "0",
      "images": ["http://upload.cdn.baselinker.com/products/23/484608.jpg"],
      "features": {
        "Material": "Poliester",
        "Laces lgth": "70cm"
      },
      "variants": [
        {
          "variant_id": "17",
          "name": "size 41",
          "price": "0",
          "quantity": "4",
          "sku": "AGH-41",
          "ean": "5697482359144",
          "asin": "B07VARIANT1"
        },
        {
          "variant_id": "18",
          "name": "size 42",
          "price": "0",
          "quantity": "2",
          "sku": "AGH-42",
          "ean": "5697482359144",
          "asin": "B07VARIANT2"
        }
      ]
    },
    "734": {
      "product_id": 734,
      "price_wholesale_netto": 0,
      "price_netto": 503.05,
      "tax_rate": 23,
      "name": "Nike M34 shoes",
      "quantity": 2,
      "category_id": "26356",
      "weight": "1",
      "sku": null,
      "ean": "589423131845",
      "asin": "B07EXAMPLE2",
      "description": "product description",
      "description_extra1": "",
      "description_extra2": "",
      "man_name": "0",
      "images": ["http://upload.cdn.baselinker.com/products/23/484609.jpg"]
    }
  }
}
```

## PHP example

```php
<?php
$methodParams = '{ "storage_id": "shop_2445", "products": [ 524, 734 ] }';

$apiParams = [
  "method"     => "getExternalStorageProductsData",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
