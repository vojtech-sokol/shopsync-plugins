# Brani Balič (packing)

Brani API module tag: "Brani Balič". Base URL `https://api.brani.cz`, Bearer auth.

## GET /balic/storage_locations
**Seznam storage pozic**

Vrátí seznam všech storage pozic, na kterých jsou uloženy vypickované produkty objednávek pro daný eshop

Response 200: **array of StorageLocationInfo**

## POST /balic/store_items_to_location
**Uložení položek objednávky na storage pozici**

Uloží vybrané položky objednávky na storage pozici. Pokud položky ještě nebyly vypickované, automaticky je vypickuje. Pokud již byly vypickované (ale ještě neuložené na pozici), pouze je přiřadí k storage pozici. Umožňuje ukládat objednávku po částech na různé pozice.

Request body (application/json): **StoreItemsToLocationRequest** — see Schemas below

## GET /balic/consumables
**Seznam spotřebního materiálu**

Vrátí seznam kódů produktů nastavených jako spotřební materiál pro organizaci eshopu

Response 200: **ConsumablesResponse**

## POST /balic/consumables
**Přidat spotřební materiál**

Přidá produkty do per-org katalogu spotřebního materiálu

Request body (application/json): **ConsumableProducts** — see Schemas below

Response 200: **ConsumablesModifyResponse**

## DELETE /balic/consumables
**Odebrat spotřební materiál**

Odebere produkty z per-org katalogu spotřebního materiálu

Request body (application/json): **ConsumableProducts** — see Schemas below

Response 200: **ConsumablesRemoveResponse**

---

## Schemas

### ConsumableProducts

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_codes` | array of string | yes | Kódy produktů — e.g. `["TAPE-01", "BOX-02"]` |

### ConsumablesModifyResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `added` | array of string |  | Přidané produkty |
| `skipped` | array of string |  | Přeskočené (již existující) |
| `not_found` | array of string |  | Nenalezené ve skladu |

### ConsumablesRemoveResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `removed` | array of string |  | Odebrané produkty |
| `skipped` | array of string |  | Přeskočené (nebyly v seznamu) |

### ConsumablesResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `consumables` | array of string | yes | Seznam kódů spotřebního materiálu |

### StorageLocationInfo

| Field | Type | Req | Notes |
|---|---|---|---|
| `location_id` | integer | yes | ID storage pozice — e.g. `42` |
| `location_name` | string | yes | Název pozice — e.g. `"STOR-01"` |
| `eshop_id` | integer | yes | ID eshopu — e.g. `1` |
| `order_code` | string | yes | Kód objednávky — e.g. `"2024001234"` |
| `product_count` | integer | yes | Počet různých produktů — e.g. `3` |
| `items_count` | number | yes | Celkové množství kusů — e.g. `12.0` |

### StoreItemToLocationProduct

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | Kód produktu — e.g. `"PROD-123"` |
| `amount` | number | yes | Množství — e.g. `5.0` |
| `location` | string \| null |  | Název pozice na skladě (nepovinné) — e.g. `"A-01-02"` |
| `sarze_id` | integer \| null |  | ID šarže (nepovinné) — e.g. `123` |

### StoreItemsToLocationRequest

| Field | Type | Req | Notes |
|---|---|---|---|
| `order_code` | string | yes | Kód objednávky — e.g. `"2024001234"` |
| `storage_location` | string | yes | Název storage pozice — e.g. `"STOR-01"` |
| `products` | array of StoreItemToLocationProduct | yes | Seznam produktů k uložení |
