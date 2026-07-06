# getOrders

**Category:** Orders
**HTTP:** `POST https://api.baselinker.com/connector.php`
**Body:** `method=getOrders&parameters=<json>`
**Source:** <https://api.baselinker.com/index.php?method=getOrders>

## Description

The method allows you to download orders from a specific date from the BaseLinker order manager. The order list can be limited using the filters described in the method parameters. A maximum of 100 orders are returned at a time.

It is recommended to download only confirmed orders, as unconfirmed orders may be incomplete. Pagination should use the `date_confirmed` field.

## Input Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| order_id | int | No | Individual order identifier. |
| date_confirmed_from | int | No | Date of order confirmation from which orders are to be collected. Format unix time stamp. |
| date_from | int | No | The order date from which orders are to be collected. Format unix time stamp. |
| id_from | int | No | The order ID number from which subsequent orders are to be collected. |
| get_unconfirmed_orders | bool | No | Download unconfirmed orders as well (this is e.g. an order from Allegro to which the customer has not yet completed the delivery form). Default is false. |
| status_id | int | No | Filter by order status identifier. |
| filter_email | varchar(50) | No | Filtering of order lists by e-mail address (displays only orders with the given e-mail address). |
| filter_order_source | varchar(20) | No | Filter by order source like `ebay` or `amazon`. |
| filter_order_source_id | int | No | Filter by specific order source identifier. |
| filter_shop_order_id | int | No | Shop Order identifier. Completing this field will download information about specific orders. |
| filter_external_order_id | varchar(50) | No | External order identifier. Allows filtering orders by the original order ID assigned by the marketplace or online store. |
| include_custom_extra_fields | bool | No | Download custom additional fields values. |
| include_commissions | bool | No | Download orders with commissions information. If set to true, the response will contain additional `commissions` field. |
| include_connect_data | bool | No | Include Base Connect and contractor data. |

## Response

| Field | Type | Description |
|-------|------|-------------|
| status | varchar(30) | `SUCCESS` or `ERROR`. |
| orders | array | An array of information about the orders found — see fields below. |

### `orders[]` fields

| Field | Type | Description |
|-------|------|-------------|
| order_id | int | Order Identifier from BaseLinker order manager. |
| shop_order_id | int | Order ID given by the store. |
| external_order_id | varchar(50) | An order identifier taken from an external source. |
| order_source | varchar(20) | Order source — available values: `shop`, `personal`, `order_return` or `marketplace_code`. |
| order_source_id | int | Source ID (e.g. internal allegro account ID, internal shop ID, etc.). |
| order_source_info | varchar(200) | Description of the order source — e.g. shop address or eBay seller nickname (field currently unavailable!). |
| order_status_id | int | Order status identifier. |
| date_add | int | Date of order creation (in unix time format). |
| date_confirmed | int | Order confirmation date if confirmed (unix time format). |
| date_in_status | int | Date from which the order is in current status (unix time format). |
| confirmed | bool | Flag indicating if the order is confirmed. |
| user_login | varchar(100) | Allegro or eBay user login. |
| currency | char(3) | 3-letter currency symbol (e.g. EUR, PLN). |
| payment_method | varchar(100) | Payment method name. |
| payment_method_cod | varchar(1) | Flag indicating whether the type of payment is COD: `1` - yes, `0` - no. |
| payment_done | float | Amount paid. |
| user_comments | varchar(1000) | Buyer comments. |
| admin_comments | varchar(200) | Seller comments. |
| email | varchar(150) | Buyer e-mail address. |
| phone | varchar(100) | Buyer phone number. |
| delivery_method_id | int | Delivery method identifier. |
| delivery_method | varchar(100) | Delivery method name. |
| delivery_price | float | Gross delivery price. |
| delivery_package_module | varchar(20) | Courier name (if the shipment was created). |
| delivery_package_nr | varchar(40) | Shipping number (if the shipment was created). |
| delivery_fullname | varchar(100) | Delivery address — name and surname. |
| delivery_company | varchar(100) | Delivery address — company. |
| delivery_address | varchar(156) | Delivery address — street and number. |
| delivery_postcode | varchar(100) | Delivery address — postcode. |
| delivery_city | varchar(100) | Delivery address — city. |
| delivery_state | varchar(35) | Delivery address — state/province. |
| delivery_country | varchar(50) | Delivery address — country. |
| delivery_country_code | char(2) | Delivery address — country code (two-letter, e.g. EN). |
| delivery_point_id | varchar(40) | Pick-up point delivery — pick-up point identifier. |
| delivery_point_name | varchar(100) | Pick-up point delivery — pick-up point name. |
| delivery_point_address | varchar(100) | Pick-up point delivery — pick-up point address. |
| delivery_point_postcode | varchar(100) | Pick-up point delivery — pick-up point postcode. |
| delivery_point_city | varchar(100) | Pick-up point delivery — pick-up point city. |
| invoice_fullname | varchar(200) | Billing details — name and surname. |
| invoice_company | varchar(200) | Billing details — company. |
| invoice_nip | varchar(100) | Billing details — Vat Reg. no./tax number. |
| invoice_address | varchar(250) | Billing details — street and house number. |
| invoice_postcode | varchar(20) | Billing details — postcode. |
| invoice_city | varchar(100) | Billing details — city. |
| invoice_state | varchar(35) | Billing details — state/province. |
| invoice_country | varchar(50) | Billing details — country. |
| invoice_country_code | char(2) | Billing details — country code (two-letter, e.g. EN). |
| want_invoice | varchar(1) | Flag indicating whether the customer wants an invoice: `1` - yes, `0` - no. |
| extra_field_1 | varchar(50) | Value of the 'extra field 1'. |
| extra_field_2 | varchar(50) | Value of the 'extra field 2'. |
| custom_extra_fields | array | A list containing order custom extra fields returned only if the input parameter `include_custom_extra_fields` is set to true. |
| order_page | varchar(150) | Order information page address. |
| pick_state | int | Flag indicating the status of the order products collection (1 - all products have been collected, 0 - not all products have been collected). |
| pack_state | int | Flag indicating the status of the order products packing (1 - all products have been packed, 0 - not all products have been packed). |
| star | int | Order star type. Values from 0 to 5. 0 means no star. |
| crm_client_id | int | CRM client ID associated with the order (0 if none). |
| commissions | array | The commissions that the marketplace charges for an order — see fields below. |
| connect_data | array | Data from Base Connect linked to the order — see fields below. |
| products | array | An array of order products — see fields below. |

### `commissions[]` fields

| Field | Description |
|-------|-------------|
| commission_name | Name of the commission. |
| commission_type | Type classification (e.g., `sale`, `payment`). |
| cost_netto | Net cost value. |
| cost_brutto | Gross cost value. |
| cost_currency | Currency code. |

### `connect_data` fields

| Field | Type | Description |
|-------|------|-------------|
| connect_integration_id | int | Integration identifier. |
| connect_contractor_id | int | Contractor identifier. |
| connect_sale_id | int | Sale identifier. |

### `products[]` fields

| Field | Type | Description |
|-------|------|-------------|
| storage | varchar | Storage location type. |
| storage_id | int | Storage identifier. |
| order_product_id | int | Order product identifier. |
| product_id | varchar | Product identifier. |
| variant_id | int | Product variant identifier. |
| name | varchar | Product name. |
| attributes | varchar | Product attributes description. |
| sku | varchar | Stock keeping unit. |
| ean | varchar | European article number. |
| location | varchar | Warehouse location. |
| auction_id | varchar | Auction identifier. |
| price_brutto | float | Gross product price. |
| tax_rate | float | Tax percentage rate. |
| quantity | int | Product quantity. |
| weight | float | Product weight. |
| bundle_id | int | Bundle identifier. |

## Example request

```json
{
  "date_confirmed_from": 1407341754,
  "get_unconfirmed_orders": false
}
```

## Example response

```json
{
  "status": "SUCCESS",
  "orders": [
    {
      "order_id": 1630473,
      "shop_order_id": 2824,
      "external_order_id": "534534234",
      "order_source": "amazon",
      "order_source_id": 2598,
      "order_source_info": "-",
      "order_status_id": 6624,
      "date_add": 1407841161,
      "date_confirmed": 1407841256,
      "date_in_status": 1407841256,
      "user_login": "nick123",
      "phone": "693123123",
      "email": "test@test.com",
      "user_comments": "User comment",
      "admin_comments": "Seller test comments",
      "currency": "GBP",
      "payment_method": "PayPal",
      "payment_method_cod": "0",
      "payment_done": "50",
      "delivery_method": "Expedited shipping",
      "delivery_price": 10,
      "delivery_package_module": "other",
      "delivery_package_nr": "0042348723648234",
      "delivery_fullname": "John Doe",
      "delivery_company": "Company",
      "delivery_address": "Long Str 12",
      "delivery_city": "London",
      "delivery_state": "",
      "delivery_postcode": "E2 8HQ",
      "delivery_country": "Great Britain",
      "delivery_point_id": "",
      "delivery_point_name": "",
      "delivery_point_address": "",
      "delivery_point_postcode": "",
      "delivery_point_city": "",
      "invoice_fullname": "John Doe",
      "invoice_company": "Company",
      "invoice_nip": "GB8943245",
      "invoice_address": "Long Str 12",
      "invoice_city": "London",
      "invoice_state": "",
      "invoice_postcode": "E2 8HQ",
      "invoice_country": "Great Britain",
      "want_invoice": "0",
      "extra_field_1": "",
      "extra_field_2": "",
      "custom_extra_fields": {
        "135": "B2B",
        "172": "1646913115"
      },
      "order_page": "https://klient.baselinker.com/1630473/4ceca0d940/",
      "pick_status": "1",
      "pack_status": "0",
      "star": 2,
      "commissions": [
        {
          "commission_name": "Sales commission",
          "commission_type": "sale",
          "cost_netto": 12.5,
          "cost_brutto": 15.38,
          "cost_currency": "USD"
        },
        {
          "commission_name": "Payment commission",
          "commission_type": "payment",
          "cost_netto": 0.5,
          "cost_brutto": 0.62,
          "cost_currency": "USD"
        }
      ],
      "connect_data": {
        "connect_integration_id": 1,
        "connect_contractor_id": 34,
        "connect_sale_id": 18452
      },
      "products": [
        {
          "storage": "shop",
          "storage_id": 1,
          "order_product_id": 154904741,
          "product_id": "5434",
          "variant_id": 52124,
          "name": "Harry Potter and the Chamber of Secrets",
          "attributes": "Colour: green",
          "sku": "LU4235",
          "ean": "1597368451236",
          "location": "A1-13-7",
          "auction_id": "0",
          "price_brutto": 20,
          "tax_rate": 23,
          "quantity": 2,
          "weight": 1,
          "bundle_id": 0
        }
      ]
    }
  ]
}
```

## PHP example

```php
<?php
$methodParams = '{ "date_confirmed_from": 1407341754, "get_unconfirmed_orders": false }';

$apiParams = [
  "method"     => "getOrders",
  "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
```
