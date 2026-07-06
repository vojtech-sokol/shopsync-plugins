# Autoorder / nákupní seznamy

Brani API module tag: "Nákupní seznamy". Base URL `https://api.brani.cz`, Bearer auth.

## GET /autoorder/product/info/{eshop_product_code}
**Get Product Info**

Deprecated, please use the v2 variant below

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `eshop_product_code` | path | string | yes |  |

Response 200: **array of brani_async__infra_jobs__public_api__routers__schema__ShoplistItem**

## GET /autoorder/product/info
**Get Product Info (v2)**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `code` | query | string | yes |  |

Response 200: **array of brani_async__infra_jobs__public_api__routers__schema__ShoplistItem**

## GET /autoorder/order/info/{order_id}
**Get Order Info**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_id` | path | string | yes |  |

Response 200: **array of brani_async__infra_jobs__public_api__routers__schema__ShoplistItem**

## GET /autoorder/shoplist/list
**Get Shoplists**

Response 200: **array of brani_async__infra_jobs__public_api__schemas__autoorder__Shoplist**

## GET /autoorder/shoplist/items/{shoplist_id}
**Get Shoplist Items**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `shoplist_id` | path | integer | yes |  |

Response 200: **array of brani_async__infra_jobs__public_api__schemas__autoorder__ShoplistItem**

## POST /autoorder/shoplist
**Upsert Shoplist**

Pokud je zadán shoplist_id, upravuje se existující nákupní seznam, jinak se vytváří nový

Request body (application/json): **ShoplistData** — see Schemas below

## POST /autoorder/shoplist_item
**Upsert Shoplist Items**

Pokud je zadán shoplist_item_id, upravuje se existující položka nákupního seznamu, jinak se vytváří nová

Request body (application/json): **UpsertShoplistItemData** — see Schemas below

## DELETE /autoorder/shoplist_item
**Delete Shoplist Items**

Request body (application/json): **MultipleShoplistItemIDsData** — see Schemas below

## GET /autoorder/{autoorder_id}/suppliers
**Get Suppliers Public**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `autoorder_id` | path | integer | yes |  |

Response 200: **array of SupplierPublic**

## POST /autoorder/autoorder_order
**Add Autoorder Order Public**

Request body (application/json): **AutoorderOrderPostData** — see Schemas below

## DELETE /autoorder/autoorder_order
**Delete Autoorder Order Public**

Request body (application/json): **DeleteAutoorderOrderPostData** — see Schemas below

---

## Schemas

### AutoorderOrderPostData

| Field | Type | Req | Notes |
|---|---|---|---|
| `order_id` | string | yes | Order Id |
| `autoorder_id` | integer | yes | Autoorder Id |

### DeleteAutoorderOrderPostData

| Field | Type | Req | Notes |
|---|---|---|---|
| `order_id` | string | yes | Order Id |
| `autoorder_id` | integer | yes | Autoorder Id |
| `delete_items` | boolean \| null |  | default `false` — Delete Items |

### MultipleShoplistItemIDsData

| Field | Type | Req | Notes |
|---|---|---|---|
| `shoplist_item_ids` | array of integer | yes | Seznam ID položek nákupního seznamu — e.g. `[1521, 1526, 1527]` |

### ShoplistComment

| Field | Type | Req | Notes |
|---|---|---|---|
| `client_name` | string | yes | Client Name — e.g. `"John Doe"` |
| `client_email` | string | yes | Client Email — e.g. `"doe@jo.hn"` |
| `client_id` | integer | yes | Client Id — e.g. `123` |
| `body` | string | yes | e.g. `"This is a comment"` |

### ShoplistData

| Field | Type | Req | Notes |
|---|---|---|---|
| `autoorder_id` | integer | yes | Autoorder Id |
| `shoplist_id` | integer \| null |  | Pokud je zadáno, upravuje se existující shoplist, jinak se vytváří nový |
| `shoplist_name` | string | yes | Shoplist Name |
| `shoplist_state` | string \| null |  | default `"new"` — Shoplist State |
| `shoplist_note` | string \| null |  | Shoplist Note |
| `document_id` | string \| null |  | Document Id |
| `estimated_delivery` | string \| null |  | Estimated Delivery |

### SupplierPublic

| Field | Type | Req | Notes |
|---|---|---|---|
| `supplier_id` | integer | yes | Supplier Id — e.g. `5275` |
| `supplier_name` | string | yes | Supplier Name — e.g. `"Dodavatel"` |

### UpsertShoplistItemData

| Field | Type | Req | Notes |
|---|---|---|---|
| `autoorder_id` | integer | yes | Autoorder Id |
| `shoplist_id` | integer \| null |  | Shoplist Id |
| `shoplist_item_id` | integer \| null |  | Pokud je zadáno, upravuje se existující shoplist item, jinak se vytváří nový |
| `product_name` | string | yes | Product Name |
| `eshop_product_code` | string | yes | Eshop Product Code |
| `product_code` | string \| null |  | Product Code |
| `ean` | string \| null |  |  |
| `amount` | integer \| null |  | default `0` |
| `amount_read` | integer \| null |  | default `0` — Amount Read |
| `price` | number \| null |  | default `0` |
| `supplier_id` | integer \| null |  | Supplier Id |
| `order_id` | string \| null |  | Order Id |
| `note` | string \| null |  |  |
| `url` | string \| null |  |  |
| `image` | string \| null |  |  |
| `eshop_id` | integer \| null |  | Eshop Id |
| `requires_sync` | integer \| null |  | default `0` — Requires Sync |

### brani_async__infra_jobs__public_api__routers__schema__Shoplist

| Field | Type | Req | Notes |
|---|---|---|---|
| `shoplist_name` | string | yes | Name of the shoplist |
| `shoplist_date` | string | yes | Creation date |
| `shoplist_archived` | integer | yes | Archive status |
| `shoplist_note` | string \| null |  | Additional notes |
| `shoplist_state` | string |  | default `"new"` — Current state |
| `estimated_delivery` | string \| null |  | Estimated delivery date/time |
| `document_id` | string \| null |  | Associated document ID |

### brani_async__infra_jobs__public_api__routers__schema__ShoplistItem

| Field | Type | Req | Notes |
|---|---|---|---|
| `shoplist` | brani_async__infra_jobs__public_api__routers__schema__Shoplist \| null |  |  |
| `supplier` | brani_async__infra_jobs__public_api__routers__schema__Supplier \| null |  |  |
| `order_id` | string \| null |  | Associated order ID |
| `product_code` | string \| null |  | Product code |
| `eshop_product_code` | string | yes | Product code in e-shop |
| `ean` | string \| null |  | EAN code |
| `url` | string \| null |  | Product URL |
| `product_name` | string | yes | Product name |
| `note` | string \| null |  | Additional notes |
| `amount` | integer | yes | Quantity |
| `amount_read` | integer |  | default `0` — Read quantity |
| `price` | number |  | default `0.0` — Product price |
| `in_stock` | boolean |  | default `false` — Stock status |
| `in_cart` | boolean |  | default `false` — Cart status |
| `date` | string | yes | Creation date |
| `image` | string \| null |  | Product image URL |
| `switch_history` | array of any \| null |  | History of switches |
| `hash` | string | yes | Item hash |
| `in_stock_date` | string \| null |  | Stock status change date |
| `in_cart_date` | string \| null |  | Cart status change date |

### brani_async__infra_jobs__public_api__routers__schema__Supplier

| Field | Type | Req | Notes |
|---|---|---|---|
| `supplier_name` | string | yes |  |
| `week_settings` | array of any | yes |  |

### brani_async__infra_jobs__public_api__schemas__autoorder__Shoplist

| Field | Type | Req | Notes |
|---|---|---|---|
| `shoplist_id` | integer | yes | Shoplist Id — e.g. `30860` |
| `autoorder_id` | integer | yes | Autoorder Id — e.g. `22` |
| `shoplist_name` | string | yes | Shoplist Name — e.g. `"Objednavka EVG"` |
| `shoplist_date` | string | yes | Shoplist Date — e.g. `"2022-01-26T14:28:03"` |
| `estimated_delivery` | string \| null |  | Estimated Delivery — e.g. `"2022-04-29"` |
| `shoplist_archived` | boolean \| null |  | default `false` — Shoplist Archived |
| `shoplist_note` | string \| null |  | Shoplist Note — e.g. `"Overdue, deliver ASAP"` |
| `shoplist_state` | string | yes | enum: new, error, waiting, stocked, ordered, ready-to-be-stocked, custom1, custom2, custom3, custom4, custom5, custom6 — Shoplist State — e.g. `"ordered"` |
| `document_id` | string \| null |  | Document Id — e.g. `"ADFGE-123456"` |
| `item_count` | integer | yes | Item Count — e.g. `1496` |
| `total_quantity` | integer | yes | Total Quantity — e.g. `69049` |
| `comments` | array of ShoplistComment \| null |  | e.g. `[{"body": "This is a comment", "client_email": "doe@jo.hn", "client_id": 123, "c` |

### brani_async__infra_jobs__public_api__schemas__autoorder__ShoplistItem

| Field | Type | Req | Notes |
|---|---|---|---|
| `autoorder_id` | integer | yes | Autoorder Id — e.g. `22` |
| `shoplist_item_id` | integer | yes | Shoplist Item Id — e.g. `3375201` |
| `shoplist_id` | integer \| null |  | Shoplist Id — e.g. `102039` |
| `product_name` | string | yes | Product Name — e.g. `"Odolný Outdoorový Stůl s Vestavěným Grilem na Propane a Přenosným Solárním Pane` |
| `image` | string \| null |  | e.g. `"https://brani.myshoptet.com/user/shop/detail/1916-4_branity-produkty-rodinka-a-` |
| `product_code` | string \| null |  | Product Code — e.g. `"WLLION"` |
| `eshop_product_code` | string | yes | Eshop Product Code — e.g. `"WLLION"` |
| `ean` | string \| null |  | e.g. `"133439905"` |
| `order_id` | string \| null |  | Order Id — e.g. `"2022132106"` |
| `note` | string \| null |  | e.g. `"This is a note"` |
| `hash` | string | yes | e.g. `"b7fc3e08a8fef2fa26ef5825a3a2c665"` |
| `price` | number | yes | e.g. `426.4` |
| `amount` | integer | yes | e.g. `6` |
| `amount_read` | integer | yes | Amount Read — e.g. `0` |
| `url` | string \| null |  | e.g. `"https://brani.myshoptet.com/lev-na-zed/"` |
| `eshop_id` | integer \| null |  | Eshop Id — e.g. `42` |
| `date` | string | yes | e.g. `"2024-01-16T06:05:42"` |
| `url_and_image_set` | boolean | yes | Url And Image Set — e.g. `true` |
| `requires_sync` | boolean \| null |  | default `false` — Requires Sync — e.g. `true` |
| `in_stock` | boolean \| null |  | default `false` — In Stock — e.g. `true` |
| `in_cart` | boolean \| null |  | default `false` — In Cart — e.g. `false` |
| `switch_history` | array of string \| null |  | Switch History — e.g. `["stock_one:-1:3", "incart_one:-1:3"]` |
| `supplier_id` | integer \| null |  | Supplier Id — e.g. `5275` |
| `supplier` | brani_async__infra_jobs__public_api__schemas__autoorder__Supplier \| null |  | e.g. `{"autoorder_id": 22, "shoplist": true, "supplier_class": "AddToCartBots.Dummy", ` |

### brani_async__infra_jobs__public_api__schemas__autoorder__Supplier

| Field | Type | Req | Notes |
|---|---|---|---|
| `autoorder_id` | integer | yes | Autoorder Id — e.g. `22` |
| `supplier_class` | string | yes | Supplier Class — e.g. `"AddToCartBots.Dummy"` |
| `supplier_user` | string | yes | Supplier User — e.g. `"test"` |
| `week_settings` | array of string | yes | Week Settings — e.g. `["12:00", "12:00", "12:00", "12:00", "12:00", "12:00", "12:00"]` |
| `supplier_id` | integer | yes | Supplier Id — e.g. `5275` |
| `supplier_name` | string | yes | Supplier Name — e.g. `"puun"` |
| `shoplist` | boolean | yes | e.g. `true` |
| `supplier_pass` | string | yes | Supplier Pass — e.g. `"test"` |
