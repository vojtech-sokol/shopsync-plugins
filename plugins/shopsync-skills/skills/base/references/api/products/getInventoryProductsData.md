# getInventoryProductsData

**Category:** Products
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getInventoryProductsData&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getInventoryProductsData>

## Description

The method allows you to retrieve detailed data for selected products from the BaseLinker inventory.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| inventory_id | int | Yes | Catalog ID retrievable via `getInventories` method. |
| products | array | Yes | Array of product ID numbers to download. |
| include_erp_units | bool | No | Include ERP units in the response. Only available for inventories with purchase cost calculations system different than AVCO. |
| include_wms_units | bool | No | Include WMS units in the response. Only available for inventories with enabled advanced warehouse management system. |
| include_additional_eans | bool | No | Include additional EANs in response. User can set additional EANs for product, to work with products cases (4-pack etc.) or different regional codes for the same product. |
| include_suppliers | bool | No | Include suppliers data in the response. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR` (with `error_message` and `error_code` on failure). |
| products | array | Keyed by product ID — see fields below. |

### `products[<product_id>]` fields

| Field | Type | Description |
|-------|------|-------------|
| is_bundle | bool | Indicates if product is a bundle. |
| parent_id | int | `0` for main products, main product ID for variants. |
| sku | varchar(32) | Product SKU number. |
| ean | varchar(32) | Primary EAN number. |
| ean_additional | array | List of objects with `ean` (string) and `quantity` (int). |
| asin | varchar(50) | Primary ASIN number. |
| tags | array | List of product tags. |
| tax_rate | float | VAT rate (0-100), or `-1` `EXPT`/`ZW`, `-0.02` `NP`, `-0.03` `OO`. |
| weight | float | Kilograms. |
| height | float | Centimeters. |
| width | float | Centimeters. |
| length | float | Centimeters. |
| star | int | Star type assignment. |
| category_id | int | Product category ID. |
| manufacturer_id | int | Manufacturer ID. |
| prices | array | Keyed by price group ID; values are gross prices. |
| stock | array | Keyed by warehouse ID (format `[type:bl\|shop\|warehouse]_[id:int]`); values are quantities. |
| reservations | array | Reserved quantities keyed by warehouse ID. |
| thresholds | array | Stock reorder points keyed by warehouse ID. |
| incoming | array | Incoming stock (supplier orders) keyed by warehouse ID. |
| locations | array | Storage locations (e.g. `A-5-2`) keyed by warehouse ID. |
| average_cost | float | Main account currency. |
| average_landed_cost | float | Main account currency. |
| text_fields | array | Keyed by field identifiers — see notes below. |
| images | array | Keyed by position (1-16); values are URLs. |
| links | array | Keyed by external warehouse ID (format `[type:shop\|warehouse]_[id:int]`). See fields below. |
| bundle_products | array | Present if `is_bundle` true; keyed by product ID, values are quantities. |
| variants | array | Keyed by variant identifier — see fields below. |
| stock_erp_units | array | Conditional; keyed by warehouse ID, each contains arrays of unit records — see fields below. |
| stock_wms_units | array | Conditional; keyed by warehouse ID, each contains arrays of unit records — see fields below. |
| suppliers | array | Conditional — see fields below. |

### `text_fields` keys

- Format: `[field]|[lang]|[source_id]`.
- Field names: `name`, `description`, `features`, `description_extra1-4`, `extra_field_[ID]`.
- Language: two-letter codes (default if omitted).
- Source ID: `[type:varchar]_[id:int]` or `0` for all integrations.
- For name/short additional fields: objects with parameter names as keys and values.
- For files: object with `title` (varchar 40) and `url`.

### `links[<warehouse_key>]` fields

| Field | Type | Description |
|-------|------|-------------|
| product_id | varchar | External warehouse product ID. |
| variant_id | varchar | Variant identifier (`0` for main product). |

### `variants[<variant_id>]` fields

| Field | Type | Description |
|-------|------|-------------|
| name | varchar | Full variant name. |
| sku | varchar | Variant SKU. |
| ean | varchar | Variant EAN. |
| asin | varchar | Variant ASIN. |
| prices | array | Keyed by price group ID. |
| stock | array | Keyed by warehouse ID. |
| locations | array | Keyed by warehouse ID. |

### `stock_erp_units[<warehouse_id>][]` fields

| Field | Type | Description |
|-------|------|-------------|
| quantity | int | Quantity in this unit record. |
| purchase_cost | float | Purchase cost. |
| expiry_date | varchar | Expiry date. |

### `stock_wms_units[<warehouse_id>][]` fields

| Field | Type | Description |
|-------|------|-------------|
| quantity | int | Quantity in this unit record. |
| location | varchar | Storage location. |
| expiry_date | varchar | Expiry date. |
| batch | varchar | Batch number. |
| serial_no | varchar | Serial number. |

### `suppliers[]` fields

| Field | Type | Description |
|-------|------|-------------|
| id | int | Supplier ID. |
| product_code | varchar | Supplier product code. |
| cost | float | Purchase price. |

## Example request

```json
{
  "inventory_id": 307,
  "products": [2685]
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "products": {
    "2685": {
      "is_bundle": false,
      "sku": "EPL-432",
      "ean": "983628103943",
      "asin": "B07EXAMPLE1",
      "tags": ["Summer", "Winter"],
      "tax_rate": 23,
      "weight": 0.25,
      "height": 0.3,
      "width": 0.2,
      "length": 0.05,
      "star": 2,
      "category_id": 3,
      "manufacturer_id": 7,
      "prices": {
        "105": 20.99,
        "106": 23.99
      },
      "stock": {
        "bl_206": 5,
        "bl_207": 7
      },
      "reservations": {
        "bl_206": 2,
        "bl_207": 0
      },
      "thresholds": {
        "bl_206": 10,
        "bl_207": 5
      },
      "incoming": {
        "bl_206": 20,
        "bl_207": 0
      },
      "locations": {
        "bl_206": "A-5-2",
        "bl_207": "B-1-5"
      },
      "text_fields": {
        "name": "Harry Potter and the Chamber of Secrets",
        "description": "Basic book description",
        "description_extra1": "Additional description",
        "features": {
          "Cover": "Hardcover",
          "Pages": "300",
          "Language": "English"
        },
        "name|de": "Harry Potter und die Kammer des Schreckens"
      },
      "average_cost": 120.98,
      "average_landed_cost": 1.2,
      "images": {
        "1": "http://placehold.it/250x250/image.jpg",
        "2": "http://placehold.it/250x250/image2.jpg"
      },
      "links": {
        "shop_23": {
          "product_id": "8",
          "variant_id": "3"
        }
      },
      "variants": {
        "2686": {
          "name": "Variant name",
          "sku": "EPL-432-V1",
          "ean": "983628103999",
          "asin": "B07EXAMPLE2",
          "prices": {
            "105": 21.99
          },
          "stock": {
            "bl_206": 3
          },
          "locations": {
            "bl_206": "A-5-2"
          }
        }
      }
    }
  }
}
```

## PHP example

```php
<?php
$methodParams = '{ "inventory_id": 307, "products": [ 2685 ] }';

$apiParams = [
  "method"     => "getInventoryProductsData",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
