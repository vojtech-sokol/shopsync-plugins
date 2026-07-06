# addInventoryProduct

**Category:** Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=addInventoryProduct&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=addInventoryProduct>

## Description

The method allows you to add a new product to BaseLinker catalog. Entering the product with the ID updates previously saved product.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | Yes | Catalog ID. The list of identifiers can be retrieved using the method `getInventories`. |
| product_id | int | No | Main product identifier, given only during the update. Should be left blank when creating a new product. |
| parent_id | int | No | Product parent ID for variant products. |
| is_bundle | bool | No | Indicates if product is part of a bundle. |
| sku | varchar(50) | No | Product SKU number. |
| ean | varchar(32) | No | Product EAN number. |
| ean_additional | array | No | List of EAN numbers with quantities. See fields below. |
| asin | varchar(50) | No | Product ASIN number. |
| tags | array | No | Tag names list; omitting tags preserves existing; empty list removes all. |
| tax_rate | float | No | VAT tax rate e.g. `23` (value from range 0-100). EXCEPTION values: `-1` for `EXPT`/`ZW` exempt from VAT. |
| weight | decimal(10,2) | No | Weight in kilograms. |
| height | decimal(10,2) | No | Product height. |
| width | decimal(10,2) | No | Product width. |
| length | decimal(10,2) | No | Product length. |
| average_cost | decimal(10,2) | No | Product average cost. If storage documents are turned off, this field sets product average cost. |
| star | int | No | Product star type. It takes from 0 to 5 values. 0 means no starring. |
| manufacturer_id | int | No | Product manufacturer ID from `getInventoryManufacturers`. |
| category_id | int | No | Product category ID (category must be previously created with `addInventoryCategory` method). |
| prices | array | No | Product prices keyed by price group ID with gross price values. |
| stock | array | No | Product stocks keyed by warehouse ID, format `bl_[id:int]`. Stocks cannot be assigned to warehouses created for external stocks. |
| locations | array | No | Product locations keyed by warehouse ID, format `[type:bl\|shop\|warehouse]_[id:int]`, e.g. `A-5-2`. Multiple locations separated by semicolon. |
| text_fields | array | No | Field text values keyed by field ID. Supports `name`, `description`, `features`, `description_extra1-4`, `extra_field_[ID]`; supports language codes and integration IDs. |
| images | array | No | A list of product images (maximum 16). Include only images to add/modify. Delete via empty string at position. |
| links | array | No | Product links to external warehouses (shops, wholesalers). Key format: `[type:shop\|warehouse]_[id:int]`. Contains `product_id` and optional `variant_id`. |
| bundle_products | array | No | List of products included in bundle (key: product ID, value: quantity). Only if `is_bundle = true`. |

### `ean_additional[]` fields

| Field | Type | Description |
|-------|------|-------------|
| ean | string | Additional EAN code. |
| quantity | int | Quantity associated with this EAN. |

### `text_fields` keys

- `name`, `description`, `features`, `description_extra1`, `description_extra2`, `description_extra3`, `description_extra4`, `extra_field_[ID]`.
- Format: `[field]|[lang]|[source_id]` — language is a two-letter code (default if omitted), source ID is `[type:varchar]_[id:int]` or `0` for all integrations.
- `features` value is an object with parameter names as keys and values.

### `links[<warehouse_key>]` fields

| Field | Type | Description |
|-------|------|-------------|
| product_id | int/varchar | External warehouse product ID. |
| variant_id | int | Variant identifier (optional). |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| product_id | int | The number of an added or updated product in the BaseLinker inventory. |
| warnings | array | Object with notes on adding a product (e.g. image errors or others that do not interrupt the request). |

## Example request

```json
{
  "inventory_id": 307,
  "product_id": 2685,
  "is_bundle": false,
  "sku": "EPL-432",
  "ean": "983628103943",
  "ean_additional": [
    {"ean": "983628103944", "quantity": 4},
    {"ean": "983628103945", "quantity": 8}
  ],
  "asin": "B07EXAMPLE1",
  "tags": ["Summer", "Winter"],
  "tax_rate": 23,
  "weight": 0.25,
  "height": 0.3,
  "width": 0.2,
  "length": 0.05,
  "average_cost": 120.98,
  "star": 2,
  "manufacturer_id": 5,
  "category_id": 3,
  "prices": {"105": 20.99, "106": 23.99},
  "stock": {"bl_206": 5, "bl_207": 7},
  "locations": {"bl_206": "A-5-2", "bl_207": "B-1-5"},
  "text_fields": {
    "name": "Harry Potter and the Chamber of Secrets",
    "description": "Basic book description",
    "description_extra1": "Additional description, e.g. of the entire product category",
    "description_extra2": "Second additional description - e.g. IMG tags with photos from an external server",
    "features": {"Cover": "Hardcover", "Pages": "300", "Language": "English"},
    "name|de": "Harry Potter und die Kammer des Schreckens"
  },
  "images": {
    "0": "url:http://placehold.it/250x250/image.jpg",
    "3": "url:http://placehold.it/250x250/image2.jpg",
    "5": "url:http://placehold.it/350x350/image34.jpg"
  },
  "links": {
    "shop_23": {"product_id": 8, "variant_id": 3}
  }
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "product_id": 2685
}
```

## PHP example

```php
<?php
$methodParams = '{
  "inventory_id": 307,
  "product_id": 2685,
  "is_bundle": false,
  "sku": "EPL-432",
  "ean": "983628103943",
  "ean_additional": [
    {"ean": "983628103944", "quantity": 4},
    {"ean": "983628103945", "quantity": 8}
  ],
  "asin": "B07EXAMPLE1",
  "tags": ["Summer", "Winter"],
  "tax_rate": 23,
  "weight": 0.25,
  "height": 0.3,
  "width": 0.2,
  "length": 0.05,
  "average_cost": 120.98,
  "star": 2,
  "manufacturer_id": 5,
  "category_id": 3,
  "prices": {"105": 20.99, "106": 23.99},
  "stock": {"bl_206": 5, "bl_207": 7},
  "locations": {"bl_206": "A-5-2", "bl_207": "B-1-5"},
  "text_fields": {
    "name": "Harry Potter and the Chamber of Secrets",
    "description": "Basic book description",
    "description_extra1": "Additional description, e.g. of the entire product category",
    "description_extra2": "Second additional description - e.g. IMG tags with photos from an external server",
    "features": {"Cover": "Hardcover", "Pages": "300", "Language": "English"},
    "name|de": "Harry Potter und die Kammer des Schreckens"
  },
  "images": {
    "0": "url:http://placehold.it/250x250/image.jpg",
    "3": "url:http://placehold.it/250x250/image2.jpg",
    "5": "url:http://placehold.it/350x350/image34.jpg"
  },
  "links": {
    "shop_23": {"product_id": 8, "variant_id": 3}
  }
}';

$apiParams = [
  "method"     => "addInventoryProduct",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
