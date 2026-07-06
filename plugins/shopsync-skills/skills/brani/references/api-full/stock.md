# Brani sklad (stock, movement documents, inventura, purchase orders)

Brani API module tag: "Brani sklad". Base URL `https://api.brani.cz`, Bearer auth.

## GET /stock/sectors
**Seznam sektorů**

Získá seznam sektorů s nastavením

Response 200: **array of Sector**

## GET /stock/movements
**Pohyby**

Seznam pohybů z Brani skladu

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `dateFrom` | query | string |  |  |
| `dateUntil` | query | string |  |  |
| `fromId` | query | integer |  |  |
| `clientId` | query | integer |  |  |
| `source` | query | string |  |  |
| `movement_document_id` | query | integer |  |  |

Response 200: **array of StockChange**

## GET /stock/supplies
**Skladové zásoby**

Vrátí seznam skladových zásob buď pro celý sklad nebo pro určitou pozici

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `location_name` | query | string |  |  |
| `product_code` | query | array of string |  |  |

Response 200: **array of StockSupply**

## GET /stock/locations
**Pozice a sektory**

Vrátí seznam všech pozic a sektorů na skladě

Response 200: **array of StockLocation**

## GET /stock/claims
**Skladové nároky**

Vrátí seznam nároků skladě

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `code` | query | string \| null |  |  |
| `return_all_products` | query | boolean \| null |  | default `false` |
| `stock_id` | query | integer \| null |  | default `0` |
| `group_from_all_stock_ids` | query | boolean \| null |  | default `false` |

Response 200: **array of StockAtEshop**

## POST /stock/set_eshop_amounts
**Nastavení množství a pozice produktu v eshopu a Brani skladu**

Nastaví skladové množství a pozici produktu v eshopu a volitelně také v Brani skladu. Tento endpoint umožňuje: 1. Nastavit skladová množství produktu (dostupné množství, fyzické množství, nárok) 2. Nastavit pozici produktu na skladě 3. Volitelně synchronizovat změny do Brani skladu Použití: - Pro nastavení pouze skladových množství v eshopu stačí zadat kód produktu a příslušná množství - Pro synchronizaci do Brani skladu nastavte sync_to_brani=True - V CHAOS módu Brani skladu je pozice produktu povinná - V BASIC módu se pozice produktu nastaví i bez synchronizace do Brani skladu Parametry: code: str Kód produktu, pro který se mají nastavit množství nebo pozice claim: int, volitelný Skladový nárok - množství již zarezervované zákazníky amount: int, volitelný Množství dostupné k objednání real_amount: int, volitelný Skutečné fyzické množství produktu na skladě position: str, volitelný Pozice produktu na skladě. V CHAOS módu Brani skladu povinné. sync_to_brani: bool, výchozí False Určuje, zda se mají změny promítnout i do Brani skladu create_position_if_not_exist: bool, výchozí False Pokud je zapnuta synchronizace do Brani a zadaná pozice neexistuje, automaticky ji vytvoří ve výchozím sektoru. Pokud ani výchozí sektor neexistuje, vytvoří i ten. Návratová hodnota: { "errors": list[str] # Seznam případných chyb nebo varování } Možné chyby: 400: - "Nutno zadat alespoň jeden z: claim, amount, real_amount, position" - "Brani sklad není nakonfigurován" - "V CHAOS módu je pozice povinn

Request body (application/json): **Body_set_eshop_amounts_stock_set_eshop_amounts_post** — see Schemas below

## POST /stock/inventory
**Naskladnění / nastavení skladové zásoby na pozici v Brani skladu**

Nastaví nebo přičte skladovou zásobu produktu na zadané pozici v Brani skladu. Režimy: - `mode="set"`: nastaví zásobu produktu na pozici na zadanou hodnotu (přepíše). - `mode="add"`: přičte zadané množství k aktuální zásobě. Pravidla: - Produkt musí mít založenou produktovou kartu, jinak ho do skladu nezakládáme. - Pozice musí existovat – pozice ani sektory se nevytváří, jinak vrátí chybu. - V režimu BASIC může být produkt jen na jedné pozici; pokus o naskladnění na jinou pozici skončí chybou. - Šarži (`batch`) lze zadat jen v režimu CHAOS a vyžaduje aktivní doplněk Šarže. Když neuvedete `name`, použije se jako název datum expirace. - `eshop_sync` určuje, zda se pohyb synchronizuje do e-shopu. Možné chyby: produkt bez produktové karty, neexistující pozice, šarže mimo CHAOS / bez doplňku, nedostatek zásoby při snižování, nebo produkt už na jiné pozici v režimu BASIC (HTTP 400/403).

Request body (application/json): **StockInRequest** — see Schemas below

## POST /stock/inicializace_skladu
**Inicializovat sklad z csv**

Pozor! Smaze vsechny pozice, produkty, skladovosti a znovu inicializuje sklad z excelu. CSV musi obsahovat sloupce code, location (nazev pozice), amount (mnozstvi na pozici). Encoding utf-8, delimiter `;`

Request body (multipart/form-data): **Body_inicializace_skladu_stock_inicializace_skladu_post** — see Schemas below

## GET /stock/document_types
**Seznam typů dokladů**

Vrátí seznam typů dokladů.

Response 200: **array of MovementDocumentType**

## GET /stock/movement_documents
**Seznam dokladů**

Vrátí seznam dokladů.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `document_type_id` | query | integer \| null |  | Filtrovat dle ID typu dokladu |
| `date_from` | query | string \| null |  | Filtrovat od data (včetně) |
| `date_until` | query | string \| null |  | Filtrovat do data (včetně) |
| `document_number` | query | string \| null |  | Filtrovat dle čísla dokladu |
| `order_number` | query | string \| null |  | Filtrovat dle čísla objednávky |
| `package_number` | query | string \| null |  | Filtrovat dle čísla balíku |
| `status` | query | string \| null |  | Filtrovat dle stavu dokladu |
| `include_archived` | query | boolean |  | default `false` — Zahrnout archivované doklady |
| `page` | query | integer |  | default `1` — Číslo stránky (počínaje 1) |
| `items_per_page` | query | integer |  | default `50` — Počet dokladů na stránku |

Response 200: **MovementDocumentResponse**

## POST /stock/movement_documents
**Vytvoření nového dokladu**

Vytvoří nový doklad s volitelnými produkty.

Request body (application/json): **MovementDocumentCreate** — see Schemas below

Response 200: **MovementDocumentCreateResponse**

## GET /stock/movement_documents/{document_id}
**Konkrétní doklad**

Vrátí konkrétní doklad včetně jeho produktů a přiložených souborů.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `document_id` | path | integer | yes |  |

Response 200: **SingleMovementDocument**

## PUT /stock/movement_documents/{document_id}
**Editace existujícího dokladu**

Upraví existující doklad podle ID. Umožňuje změnit všechna pole dokladu i jeho produkty a ceny. Pokud jsou v requestu zadány produkty, stávající produkty a jejich ceny budou smazány a nahrazeny novými. Pro každý produkt lze zadat množství (amount) a/nebo cenu (standard_price): - Pouze množství: vytvoří se záznam očekávaného produktu - Pouze cena: vytvoří se záznam nákupní ceny (pouze u příjemek) - Obojí: vytvoří se oba záznamy

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `document_id` | path | integer | yes |  |

Request body (application/json): **MovementDocumentEdit** — see Schemas below

Response 200: **MovementDocumentEditResponse**

## POST /stock/movement_documents/{document_id}/products
**Přidání produktů a cen k existujícímu dokladu**

Přidá produkty a/nebo jejich ceny k existujícímu dokladu. Pokud již k dokladu produkty nebo ceny existují, budou smazány a nahrazeny novým seznamem. Pro každý produkt lze zadat množství (amount) a/nebo cenu (standard_price): - Pouze množství: vytvoří se záznam očekávaného produktu - Pouze cena: vytvoří se záznam nákupní ceny (pouze u příjemek) - Obojí: vytvoří se oba záznamy

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `document_id` | path | integer | yes |  |

Request body (application/json): **array of MovementDocumentProductReq** — see Schemas below

## POST /stock/movement_documents/{document_id}/upload
**Nahrání souboru**

Nahraje soubor k dokladu.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `document_id` | path | integer | yes |  |

Request body (multipart/form-data): **Body_upload_file_stock_movement_documents__document_id__upload_post** — see Schemas below

## GET /stock/movement_documents/{document_id}/download/{file_id}
**Stažení souboru**

Stáhne soubor připojený k dokladu.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `document_id` | path | integer | yes |  |
| `file_id` | path | integer | yes |  |

## GET /stock/movement_documents/{document_id}/download-all
**Stáhnout všechny soubory pro doklad jako ZIP**

Stáhne všechny soubory z dokladu jako ZIP archiv.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `document_id` | path | integer | yes |  |

## DELETE /stock/movement_documents/{document_id}/delete/{file_id}
**Smazání souboru**

Smaže soubor připojený k dokladu.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `document_id` | path | integer | yes |  |
| `file_id` | path | integer | yes |  |

## GET /stock/inventura
**Seznam inventur**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `page` | query | integer |  | default `1` |
| `per_page` | query | integer |  | default `50` |

## GET /stock/inventura/{inventura_id}
**Detail inventury**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `inventura_id` | path | integer | yes |  |

## GET /stock/order/{order_code}/picked-items
**Informace o vyskladněných položkách objednávky**

Získá informace o vyskladněných produktech, z jakých pozic a jaké šarže šly pro určitou objednávku.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_code` | path | string | yes |  |

Response 200: **array of PickedProductInfo**

## GET /stock/order/{order_code}/awaiting-stock
**Chybějící produkty objednávky**

Vrátí seznam produktů, které chybí pro danou objednávku po zpracování automatizací Objednávky k expedici, spolu s informací, ze které vydané objednávky bude chybějící množství pokryto.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_code` | path | string | yes |  |

Response 200: **OrderAwaitingStockResponse**

## GET /stock/picked-orders-by-product-batch
**Informace o objednávkách s vyskladněným produktem a šarží**

Získá informace o eshopech a objednávkách, které obsahují daný produkt a šarži ve vyskladněných položkách.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `product_code` | query | string | yes | Kód produktu |
| `batch_id` | query | integer \| null |  | ID šarže (volitelné) |
| `batch_name` | query | string \| null |  | Název šarže (volitelné) |

Response 200: **array of PickedOrderInfo**

## GET /stock/purchase_orders
**Seznam vydaných objednávek**

Získá seznam vydaných objednávek (nákupních objednávek) s možností filtrování podle stavu a dodavatele

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `status_ids` | query | string \| null |  | Seznam ID stavů pro filtrování (oddělené čárkou) |
| `supplier_ids` | query | string \| null |  | Seznam ID dodavatelů pro filtrování (oddělené čárkou) |
| `sort` | query | PurchaseOrderSortOption |  | default `"created_at_desc"` — Způsob řazení objednávek |
| `with_closed` | query | boolean |  | default `false` — Zahrnout uzavřené objednávky |
| `page` | query | integer |  | default `1` — Číslo stránky (počínaje 1) |
| `items_per_page` | query | integer |  | default `50` — Počet objednávek na stránku |

Response 200: **PurchaseOrdersResponse**

## POST /stock/purchase_orders
**Vytvoření vydané objednávky**

Vytvoří vydanou objednávku (nákupní objednávku).

Request body (application/json): **PurchaseOrderCreate** — see Schemas below

## GET /stock/purchase_orders/statuses
**Seznam stavů vydaných objednávek**

Získá seznam všech stavů pro vydané objednávky (systémové i vlastní)

Response 200: **array of PurchaseOrderStatus**

## GET /stock/purchase_orders/suppliers
**Seznam dodavatelů**

Získá seznam všech dodavatelů pro vydané objednávky

Response 200: **array of PurchaseOrderSupplier**

## GET /stock/purchase_orders/{purchase_order_id}
**Detail vydané objednávky**

Získá detail vydané objednávky včetně seznamu produktů s cenami a obrázky

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `purchase_order_id` | path | integer | yes |  |

Response 200: **PurchaseOrderDetail**

## PATCH /stock/purchase_orders/{purchase_order_id}
**Úprava vydané objednávky**

Aktualizuje údaje vydané objednávky (název, stav, dodavatel, čísla dokladů, komentář, datum dodání)

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `purchase_order_id` | path | integer | yes |  |

Request body (application/json): **PurchaseOrderUpdate** — see Schemas below

## POST /stock/purchase_orders/{purchase_order_id}/products
**Přidání produktů do vydané objednávky**

Přidá produkty do vydané objednávky. Pokud produkt v objednávce už existuje, množství se přičte.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `purchase_order_id` | path | integer | yes |  |

Request body (application/json): **PurchaseOrderProductsRequest** — see Schemas below

## PATCH /stock/purchase_orders/{purchase_order_id}/products
**Úprava produktu ve vydané objednávce**

Upraví množství nebo poznámku produktu ve vydané objednávce.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `purchase_order_id` | path | integer | yes |  |

Request body (application/json): **PurchaseOrderProductUpdate** — see Schemas below

## DELETE /stock/purchase_orders/{purchase_order_id}/products
**Odebrání produktu z vydané objednávky**

Odebere produkt z vydané objednávky.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `purchase_order_id` | path | integer | yes |  |

Request body (application/json): **PurchaseOrderProductRef** — see Schemas below

## POST /stock/purchase_orders/{purchase_order_id}/link_to_receipt/{document_id}
**Připojit objednávku k příjemce**

Připojí vydanou objednávku k příjemce (dokladu). Produkty z objednávky budou automaticky přidány do příjemky.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `purchase_order_id` | path | integer | yes |  |
| `document_id` | path | integer | yes |  |

Response 200: **SetLinkedPurchaseOrdersResponse**

## POST /stock/purchase_orders/{purchase_order_id}/unlink_from_receipt/{document_id}
**Odpojit objednávku od příjemky**

Odpojí vydanou objednávku od příjemky (dokladu). Produkty z objednávky budou automaticky odebrány z příjemky.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `purchase_order_id` | path | integer | yes |  |
| `document_id` | path | integer | yes |  |

Response 200: **SetLinkedPurchaseOrdersResponse**

---

## Schemas

### AwaitingStockCoverageItem

| Field | Type | Req | Notes |
|---|---|---|---|
| `purchase_order` | PurchaseOrder | yes | Detail vydané objednávky |
| `covered_amount` | integer | yes | Pokryté množství z této vydané objednávky |

### AwaitingStockProduct

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | Kód produktu |
| `missing_amount` | integer | yes | Celkové chybějící množství |
| `uncovered_amount` | integer | yes | Část chybějícího množství, která není pokryta žádnou vydanou objednávkou. |
| `purchase_order_coverage` | array of AwaitingStockCoverageItem | yes | Seznam vydaných objednávek a množství, která z nich budou dodána. |

### Body_inicializace_skladu_stock_inicializace_skladu_post

| Field | Type | Req | Notes |
|---|---|---|---|
| `file` | string | yes |  |

### Body_set_eshop_amounts_stock_set_eshop_amounts_post

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes | Kód produktu |
| `claim` | integer \| null |  | Skladový nárok |
| `amount` | integer \| null |  | Množství dostupné k objednání |
| `real_amount` | integer \| null |  | Fyzické množství na skladě |
| `position` | string \| null |  | Pozice na skladě |
| `sync_to_brani` | boolean \| null |  | default `false` — Synchronizovat do Brani skladu |
| `create_position_if_not_exist` | boolean \| null |  | default `false` — Pokud je zapnuta synchronizace do Brani (sync_to_brani=True) a zadaná pozice neexistuje, automaticky ji vytvoří ve výchozím sektoru. Pokud ani výchozí sektor neexistuje, vytvoří i ten. |
| `mark_movement_to_sync` | boolean \| null |  | default `false` — Oznacit pohyby vytvorene v brani skladu pro synchronizaci do shoptetu |

### Body_upload_file_stock_movement_documents__document_id__upload_post

| Field | Type | Req | Notes |
|---|---|---|---|
| `file` | string | yes |  |

### LinkedPurchaseOrder

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID objednávky — e.g. `1` |
| `name` | string | yes | Název objednávky — e.g. `"Objednávka leden 2024"` |
| `status_name` | string | yes | Název stavu objednávky — e.g. `"Nová"` |
| `status_color` | string | yes | Hexadecimální kód barvy stavu — e.g. `"#4CAF50"` |

### ManufactureOrderRef

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID výrobního příkazu — e.g. `42` |
| `status` | string | yes | waiting, in_progress, completed nebo cancelled — e.g. `"waiting"` |
| `batch_count` | integer | yes | Počet dávek — e.g. `5` |
| `recipe_id` | integer | yes | ID receptury — e.g. `1` |
| `recipe_name` | string | yes | Název receptury — e.g. `"Smíchání čaje 100g"` |
| `output_amount` | integer \| null |  | Počet kusů produktu vyrobených z jedné dávky — e.g. `10` |

### MovementDocument

| Field | Type | Req | Notes |
|---|---|---|---|
| `document_id` | integer | yes | ID dokladu — e.g. `123` |
| `document_type_id` | integer | yes | ID typu dokladu — e.g. `1` |
| `document_number` | string \| null | yes | Číslo dokladu — e.g. `"Doc_123"` |
| `order_number` | string \| null | yes | Číslo objednávky — e.g. `"#1234"` |
| `package_number` | string \| null | yes | Číslo balíku — e.g. `"A4321"` |
| `comment` | string \| null |  | Komentář — e.g. `"První dodávka"` |
| `status` | string | yes | enum: open, closed, error — Stav dokladu — e.g. `"open"` |
| `date` | string | yes | Datum vytvoření — e.g. `"2024-01-01T12:00:00Z"` |
| `archived` | string \| null |  | Datum archivace — e.g. `"2024-01-01T12:00:00Z"` |
| `shipping_cost` | number \| null |  | Náklady na dopravu — e.g. `150.0` |
| `customs_cost` | number \| null |  | Náklady na clo — e.g. `50.0` |
| `currency` | string \| null |  | Měna (ISO 4217) — e.g. `"CZK"` |

### MovementDocumentCreate

| Field | Type | Req | Notes |
|---|---|---|---|
| `document_type_id` | integer | yes | ID typu dokladu — e.g. `1` |
| `document_number` | string \| null |  | Číslo dokladu — e.g. `"Doc_123"` |
| `order_number` | string \| null |  | Číslo objednávky — e.g. `"#1234"` |
| `package_number` | string \| null |  | Číslo balíku — e.g. `"A4321"` |
| `comment` | string \| null |  | Komentář — e.g. `"První dodávka"` |
| `status` | string |  | enum: open, closed, error — default `"open"` — Stav dokladu — e.g. `"open"` |
| `shipping_cost` | number \| null |  | Náklady na dopravu — e.g. `150.0` |
| `customs_cost` | number \| null |  | Náklady na clo — e.g. `50.0` |
| `currency` | string \| null |  | Třípísmenný kód měny dle ISO 4217 (např. CZK, EUR, USD) — e.g. `"CZK"` |
| `products` | array of MovementDocumentProductReq \| null |  | Seznam produktů s množstvím a/nebo cenami. Pro každý produkt musí být zadáno množství (amount) a/nebo cena (standard_price). Množství vytvoří záznam očekávaného produktu, cena vytvoří záznam nákupní ceny (pouze u příjemek). — e.g. `[{"amount": 10, "product_code": "0001"}, {"amount": 5, "discount_percent": 10.0,` |

### MovementDocumentCreateResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `message` | string | yes | Zpráva o výsledku — e.g. `"Doklad byl úspěšně vytvořen"` |
| `document` | SingleMovementDocument | yes | Detail vytvořeného dokladu |

### MovementDocumentEdit

| Field | Type | Req | Notes |
|---|---|---|---|
| `document_number` | string \| null |  | Číslo dokladu — e.g. `"Doc_123"` |
| `order_number` | string \| null |  | Číslo objednávky — e.g. `"#1234"` |
| `package_number` | string \| null |  | Číslo balíku — e.g. `"A4321"` |
| `comment` | string \| null |  | Komentář — e.g. `"První dodávka"` |
| `status` | string \| null |  | enum: open, closed, error — Stav dokladu — e.g. `"open"` |
| `shipping_cost` | number \| null |  | Náklady na dopravu — e.g. `150.0` |
| `customs_cost` | number \| null |  | Náklady na clo — e.g. `50.0` |
| `currency` | string \| null |  | Třípísmenný kód měny dle ISO 4217 (např. CZK, EUR, USD) — e.g. `"CZK"` |
| `products` | array of MovementDocumentProductReq \| null |  | Seznam produktů s množstvím a/nebo cenami. Pokud je zadáno, nahradí stávající produkty a ceny. Pro každý produkt musí být zadáno množství (amount) a/nebo cena (standard_price). Množství vytvoří záznam očekávaného produktu, cena vytvoří záznam nákupní ceny (pouze u příjemek). — e.g. `[{"amount": 10, "product_code": "0001"}, {"amount": 5, "discount_percent": 10.0,` |

### MovementDocumentEditResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `message` | string | yes | Zpráva o výsledku — e.g. `"Doklad byl úspěšně upraven"` |
| `document` | SingleMovementDocument | yes | Detail upraveného dokladu |

### MovementDocumentFile

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID souboru — e.g. `1` |
| `client_name` | string | yes | Uživatel, který soubor nahrál — e.g. `"Jan Novák"` |
| `file_name` | string | yes | Název souboru — e.g. `"doklad1.pdf"` |
| `uploaded_at` | string | yes | Datum nahrání — e.g. `"2024-01-01T10:00:00"` |
| `comment` | string \| null |  | Komentář k souboru — e.g. `"Faktura leden"` |

### MovementDocumentMovement

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | Kód produktu — e.g. `"PR/BAV/BIL/140/S"` |
| `location_id` | integer \| null |  | ID pozice |
| `location_name` | string \| null |  | Název pozice — e.g. `"A1-1-1"` |
| `sector_id` | integer \| null |  | ID sektoru |
| `sector_name` | string \| null |  | Název sektoru — e.g. `"A1"` |
| `zone_id` | integer \| null |  | ID zóny |
| `zone_name` | string \| null |  | Název zóny — e.g. `"Hlavní sklad"` |
| `sarze_id` | integer \| null |  | ID šarže |
| `sarze_name` | string \| null |  | Název šarže |
| `sarze_expires_at` | string \| null |  | Expirace šarže |
| `amount_change` | integer | yes | Součet amount_change pro danou kombinaci produkt+pozice+šarže. Kladné číslo = naskladněno, záporné = vyskladněno. — e.g. `5` |

### MovementDocumentProduct

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | Kód produktu — e.g. `"0001"` |
| `amount_expected` | integer | yes | Očekávané množství — e.g. `10` |
| `amount_processed` | integer | yes | Zpracované množství — e.g. `5` |
| `amount_queued` | integer | yes | Množství evidované jako „přijaté“, které ještě nebylo reálně naskladněno do zásob. Je nenulové pouze u příjemek (document_type='receipt'). — e.g. `3` |
| `product_name` | string \| null |  | Název produktu — e.g. `"Produkt1"` |
| `variant_name` | string \| null |  | Název varianty — e.g. `"Varianta1"` |
| `image` | string \| null |  | Obrázek produktu — e.g. `"https://example.com/image.jpg"` |

### MovementDocumentProductPrice

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | Kód produktu — e.g. `"0001"` |
| `standard_price` | number | yes | Standardní cena — e.g. `100.0` |
| `discount_percent` | number \| null |  | Sleva v procentech — e.g. `10.0` |
| `price` | number | yes | Cena po slevě — e.g. `90.0` |
| `vat_rate` | number \| null |  | Sazba DPH — e.g. `21.0` |

### MovementDocumentProductReq
Položka produktu pro vytvoření/úpravu dokladu. Musí být zadáno množství (amount) a/nebo cena (standard_price). - Pokud je zadáno pouze množství: vytvoří se záznam očekávaného produktu. - Pokud je zadána pouze cena: vytvoří se záznam ceny produktu (pouze u příjemek). - Pokud je zadáno obojí: vytvoří se oba záznamy.

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | Kód produktu — e.g. `"0001"` |
| `amount` | integer \| null |  | Očekávané množství produktu. Pokud je zadáno, vytvoří se záznam očekávaného produktu. — e.g. `10` |
| `standard_price` | number \| null |  | Nákupní cena produktu. Pokud je zadána, vytvoří se záznam ceny (pouze u příjemek). — e.g. `100.0` |
| `discount_percent` | number \| null |  | Sleva z ceny v procentech. — e.g. `10.0` |
| `vat_rate` | number \| null |  | Sazba DPH — e.g. `21.0` |

### MovementDocumentResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `documents` | array of MovementDocument | yes | Seznam dokladů |
| `page` | integer | yes | Číslo stránky — e.g. `1` |
| `items_per_page` | integer | yes | Počet dokladů na stránku — e.g. `50` |
| `total_items` | integer | yes | Celkový počet dokladů — e.g. `200` |

### MovementDocumentType

| Field | Type | Req | Notes |
|---|---|---|---|
| `document_id` | integer | yes | ID typu dokladu — e.g. `1` |
| `document_name` | string | yes | Název typu dokladu — e.g. `"Příjemka"` |
| `document_type` | string | yes | enum: receipt, issue — Typ dokladu — e.g. `"receipt"` |
| `eshop_sync` | boolean | yes | Synchronizace s e-shopem — e.g. `true` |
| `queue_receipt` | boolean | yes | Nenaskladňovat přímo (fronta příjmu) — e.g. `false` |

### OrderAwaitingStockResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `order_code` | string | yes | Kód objednávky |
| `missing_products` | array of AwaitingStockProduct | yes | Produkty, které chybí pro tuto objednávku po zpracování automatizací Objednávky k expedici. Prázdný seznam znamená, že objednávka nečeká na sklad. |

### PickedOrderInfo

| Field | Type | Req | Notes |
|---|---|---|---|
| `eshop_id` | integer | yes | Eshop Id |
| `eshop_name` | string | yes | Eshop Name |
| `eshop_url` | string \| null | yes | Eshop Url |
| `order_code` | string | yes | Order Code |

### PickedProductInfo

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | Product Code |
| `location_name` | string \| null |  | Location Name |
| `location_id` | integer \| null |  | Location Id |
| `batch_name` | string \| null |  | Batch Name |
| `batch_id` | integer \| null |  | Batch Id |
| `picked_amount` | string | yes | pattern `^(?!^[-+.]*$)[+-]?0*\d*\.?\d*$` — Picked Amount |
| `picked_item_datetime` | string | yes | Picked Item Datetime |

### ProductRecipeRef

| Field | Type | Req | Notes |
|---|---|---|---|
| `recipe_id` | integer | yes | ID receptury — e.g. `1` |
| `recipe_name` | string | yes | Název receptury — e.g. `"Smíchání čaje 100g"` |
| `output_amount` | integer | yes | Počet kusů produktu vyrobených z jedné dávky — e.g. `10` |
| `recipe_type` | string | yes | assembly, split nebo customization — e.g. `"assembly"` |

### PurchaseOrder

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID objednávky — e.g. `1` |
| `name` | string | yes | Název objednávky — e.g. `"Objednávka leden 2024"` |
| `status` | PurchaseOrderStatus | yes | Stav objednávky |
| `supplier` | PurchaseOrderSupplier | yes | Dodavatel |
| `document_number` | string \| null |  | Interní číslo dokladu — e.g. `"DOC-2024-001"` |
| `order_number` | string \| null |  | Interní číslo objednávky — e.g. `"ORD-12345"` |
| `comment` | string \| null |  | Komentář — e.g. `"Urgentní dodávka"` |
| `created_at` | string | yes | Datum vytvoření — e.g. `"2024-01-10T14:30:00"` |
| `estimated_delivery_at` | string \| null |  | Odhadované datum dodání — e.g. `"2024-01-20"` |
| `movement_document` | PurchaseOrderLinkedDocument \| null |  | Navázaný doklad |
| `products_count` | integer |  | default `0` — Počet různých SKU v objednávce — e.g. `15` |
| `total_pieces` | integer |  | default `0` — Celkové množství všech produktů — e.g. `250` |
| `order_value` | number \| null |  | Celková hodnota objednávky v nákupních cenách — e.g. `15750.5` |
| `order_currency` | string \| null |  | Měna objednávky — e.g. `"CZK"` |
| `order_value_supplier` | number \| null |  | Order Value Supplier |
| `received_pieces` | integer \| null |  | Počet kusů již naskladněných na navázané příjemce. None, pokud VO není napojená na příjemku. — e.g. `120` |

### PurchaseOrderCreate

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string | yes |  |
| `status_id` | integer | yes | Status Id |
| `supplier_id` | integer | yes | Supplier Id |
| `document_number` | string \| null | yes | Document Number |
| `order_number` | string \| null | yes | Order Number |
| `comment` | string \| null | yes |  |
| `estimated_delivery_at` | string \| null | yes | Estimated Delivery At |

### PurchaseOrderDetail

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID objednávky — e.g. `1` |
| `name` | string | yes | Název objednávky — e.g. `"Objednávka leden 2024"` |
| `status` | PurchaseOrderStatus | yes | Stav objednávky |
| `supplier` | PurchaseOrderSupplier | yes | Dodavatel |
| `document_number` | string \| null |  | Interní číslo dokladu — e.g. `"DOC-2024-001"` |
| `order_number` | string \| null |  | Interní číslo objednávky — e.g. `"ORD-12345"` |
| `comment` | string \| null |  | Komentář — e.g. `"Urgentní dodávka"` |
| `created_at` | string | yes | Datum vytvoření — e.g. `"2024-01-10T14:30:00"` |
| `estimated_delivery_at` | string \| null |  | Odhadované datum dodání — e.g. `"2024-01-20"` |
| `movement_document` | PurchaseOrderLinkedDocument \| null |  | Navázaný doklad |
| `products_count` | integer |  | default `0` — Počet různých SKU v objednávce — e.g. `15` |
| `total_pieces` | integer |  | default `0` — Celkové množství všech produktů — e.g. `250` |
| `order_value` | number \| null |  | Celková hodnota objednávky v nákupních cenách — e.g. `15750.5` |
| `order_currency` | string \| null |  | Měna objednávky — e.g. `"CZK"` |
| `order_value_supplier` | number \| null |  | Order Value Supplier |
| `received_pieces` | integer \| null |  | Počet kusů již naskladněných na navázané příjemce. None, pokud VO není napojená na příjemku. — e.g. `120` |
| `products` | array of PurchaseOrderProduct | yes | Seznam všech produktů v objednávce s cenami a množstvím |
| `total_received_pieces` | integer \| null |  | Součet již naskladněných kusů přes všechny položky. None, pokud VO není napojená na příjemku. — e.g. `120` |

### PurchaseOrderLinkedDocument

| Field | Type | Req | Notes |
|---|---|---|---|
| `document_id` | integer | yes | ID dokladu — e.g. `123` |
| `status` | string | yes | Stav dokladu — e.g. `"open"` |
| `archived` | string \| null |  | Datum archivace — e.g. `"2024-01-15T10:30:00"` |

### PurchaseOrderProduct

| Field | Type | Req | Notes |
|---|---|---|---|
| `sku` | string | yes | Kód produktu/varianty — e.g. `"PROD-001-RED-L"` |
| `name` | string \| null |  | Název produktu — e.g. `"Tričko bavlněné"` |
| `variant_name` | string \| null |  | Název varianty — e.g. `"Červená / L"` |
| `image` | string \| null |  | URL obrázku — e.g. `"https://cdn.example.com/products/prod-001.jpg"` |
| `amount` | integer | yes | Objednané množství kusů — e.g. `50` |
| `received_amount` | integer \| null |  | Počet kusů této položky již naskladněných na navázané příjemce. None, pokud VO není napojená na příjemku. — e.g. `30` |
| `note` | string \| null |  | Poznámka k položce objednávky — e.g. `"Doobjednat prioritně"` |
| `purchase_price` | number \| null |  | Nákupní cena za kus — e.g. `125.5` |
| `purchase_currency` | string \| null |  | Měna nákupní ceny — e.g. `"CZK"` |
| `purchase_price_supplier` | number \| null |  | Purchase Price Supplier |
| `ean` | string \| null |  |  |
| `plu_code` | string \| null |  | PLU kód |
| `isbn` | string \| null |  |  |
| `serial_no` | string \| null |  | Sériové číslo |
| `manufacturer_code` | string \| null |  | Kód výrobce |
| `brand_code` | string \| null |  | Kód značky |
| `internal_note` | string \| null |  | Interní poznámka |
| `url` | string \| null |  | URL produktu |
| `line_value` | number \| null |  | Celková hodnota řádku (množství × cena) — e.g. `6275.0` |
| `recipes` | array of ProductRecipeRef |  | Seznam receptur, přes které lze tuto položku vyrobit (prázdné, pokud výroba není dostupná) |
| `manufacture_order` | ManufactureOrderRef \| null |  | Navázaný výrobní příkaz, pokud je položka ve výrobě |
| `awaiting_covered_amount` | integer |  | default `0` — Počet kusů této položky, které pokrývají čekající objednávky (auto-expedice) — e.g. `8` |
| `awaiting_extra_amount` | integer |  | default `0` — Počet kusů této položky, které nejsou přiřazeny žádné čekající objednávce — e.g. `2` |
| `awaiting_orders` | array of PurchaseOrderProductAwaitingOrder |  | Seznam objednávek, do kterých kusy této položky míří, s počtem kusů |

### PurchaseOrderProductAwaitingOrder

| Field | Type | Req | Notes |
|---|---|---|---|
| `eshop_id` | integer | yes | ID e-shopu objednávky — e.g. `123` |
| `eshop_name` | string \| null |  | Název e-shopu objednávky — e.g. `"Můj e-shop"` |
| `order_code` | string | yes | Kód objednávky — e.g. `"ORD-2024-0042"` |
| `covered_amount` | integer | yes | Počet kusů pro tuto objednávku — e.g. `5` |

### PurchaseOrderProductItem

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes |  |
| `amount` | integer | yes |  |
| `note` | string \| null |  |  |

### PurchaseOrderProductRef

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | Product Code |

### PurchaseOrderProductUpdate

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | Product Code |
| `amount` | integer \| null |  |  |
| `note` | string \| null |  |  |

### PurchaseOrderProductsRequest

| Field | Type | Req | Notes |
|---|---|---|---|
| `items` | array of PurchaseOrderProductItem | yes |  |

### PurchaseOrderSortOption
Enum: `created_at_desc`, `created_at_asc`, `estimated_delivery_at_desc`, `estimated_delivery_at_asc`

### PurchaseOrderStatus

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID stavu — e.g. `1` |
| `name` | string | yes | Název stavu — e.g. `"Nová"` |
| `color` | string | yes | Hexadecimální kód barvy — e.g. `"#4CAF50"` |
| `sort_order` | integer \| null |  | Pořadí řazení — e.g. `1` |

### PurchaseOrderSupplier

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID dodavatele — e.g. `1` |
| `name` | string | yes | Název dodavatele — e.g. `"ABC Trading s.r.o."` |
| `ico` | string \| null |  | IČO dodavatele — e.g. `"12345678"` |
| `currency` | string \| null |  |  |
| `delivery_days` | integer \| null |  | Počet dní na dodání — e.g. `7` |
| `eshop_supplier_guids` | array of string |  | Napárovaní dodavatelé v eshopu |

### PurchaseOrderUpdate

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string \| null |  | Název objednávky — e.g. `"Objednávka leden 2024 - upraveno"` |
| `status_id` | integer \| null |  | ID nového stavu objednávky — e.g. `2` |
| `supplier_id` | integer \| null |  | ID dodavatele — e.g. `1` |
| `document_number` | string \| null |  | Interní číslo dokladu — e.g. `"DOC-2024-001"` |
| `order_number` | string \| null |  | Interní číslo objednávky — e.g. `"ORD-12345"` |
| `comment` | string \| null |  | Komentář — e.g. `"Urgentní dodávka - potvrzeno dodavatelem"` |
| `estimated_delivery_at` | string \| null |  | Odhadované datum dodání — e.g. `"2024-01-22"` |

### PurchaseOrdersResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `orders` | array of PurchaseOrder | yes | Seznam objednávek |
| `page` | integer \| null |  | Číslo stránky — e.g. `1` |
| `items_per_page` | integer \| null |  | Počet objednávek na stránku — e.g. `50` |
| `total_items` | integer | yes | Celkový počet objednávek — e.g. `200` |

### Sector

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | Unikátní identifikátor sektoru |
| `sector_name` | string \| null |  | Název sektoru |
| `order` | integer \| null |  | Pořadí sektoru |
| `disabled_picking` | boolean \| null |  | Indikuje, zda je zakázáno pickování z pozic tohoto sektoru |
| `neskladovy` | boolean \| null |  | Indikuje, zda je sektor neskladový |
| `shoptet_stock_id` | integer \| null |  | ID skladu v Shoptetu pro tento sektor (NULL = hlavní sklad) |
| `povolit_na_jedne_pozici_vice_sarzi` | boolean \| null |  | Povoluje více šarží na jedné pozici |
| `color` | string \| null |  | Barva |
| `stock_locations_mode` | string \| null |  | enum: basic, chaos — Režim sektoru - 'basic' = produkt může být pouze na jedné pozici v tomto sektoru |
| `is_handling_units_sector` | boolean \| null |  | Is Handling Units Sector |

### SetLinkedPurchaseOrdersResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `linked_ids` | array of integer | yes | ID objednávek, které byly připojeny k dokladu — e.g. `[1, 2]` |
| `unlinked_ids` | array of integer | yes | ID objednávek, které byly odpojeny od dokladu — e.g. `[3]` |
| `totals_added` | object | yes | Souhrnné množství přidaných produktů z objednávek (SKU: množství) — e.g. `{"PROD-001": 10, "PROD-002": 5}` |
| `totals_removed` | object | yes | Souhrnné množství odebraných produktů z objednávek (SKU: množství) — e.g. `{"PROD-003": 8}` |

### SingleMovementDocument

| Field | Type | Req | Notes |
|---|---|---|---|
| `document_id` | integer | yes | ID dokladu — e.g. `123` |
| `document_type_id` | integer | yes | ID typu dokladu — e.g. `1` |
| `document_number` | string \| null | yes | Číslo dokladu — e.g. `"Doc_123"` |
| `order_number` | string \| null | yes | Číslo objednávky — e.g. `"#1234"` |
| `package_number` | string \| null | yes | Číslo balíku — e.g. `"A4321"` |
| `comment` | string \| null |  | Komentář — e.g. `"První dodávka"` |
| `status` | string | yes | enum: open, closed, error — Stav dokladu — e.g. `"open"` |
| `date` | string | yes | Datum vytvoření — e.g. `"2024-01-01T12:00:00Z"` |
| `archived` | string \| null |  | Datum archivace — e.g. `"2024-01-01T12:00:00Z"` |
| `shipping_cost` | number \| null |  | Náklady na dopravu — e.g. `150.0` |
| `customs_cost` | number \| null |  | Náklady na clo — e.g. `50.0` |
| `currency` | string \| null |  | Měna (ISO 4217) — e.g. `"CZK"` |
| `products` | array of MovementDocumentProduct | yes | Produkty |
| `product_prices` | array of MovementDocumentProductPrice | yes | Ceny produktů |
| `files` | array of MovementDocumentFile | yes | Soubory |
| `purchase_orders` | array of LinkedPurchaseOrder | yes | Seznam vydaných objednávek připojených k tomuto dokladu |
| `movements` | array of MovementDocumentMovement | yes | Agregované pohyby pro tento doklad seskupené podle produktu, pozice a šarže. Umožňuje dohledat, co konkrétně se kam naskladnilo nebo odkud vyskladnilo. |
| `total_expected_price` | number \| null |  | Celková cena očekávaných produktů včetně nákladů na dopravu a clo — e.g. `1000.0` |
| `total_received_price` | number \| null |  | Celková cena přijatých produktů včetně nákladů na dopravu a clo — e.g. `1500.0` |

### StockAtEshop

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes | Kód produktu |
| `claim` | number | yes | Skladový nárok |
| `amount` | number | yes | Skladem na eshopu |

### StockBatch

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string | yes | Název šarže |
| `expires_at` | string \| null |  | Datum expirace šarže |
| `amount` | integer | yes | Množství šarže na pozici |

### StockChange

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | Unikatni ID pohybu — e.g. `6232195` |
| `product_code` | string | yes | Kód produktu — e.g. `"PR/BAV/BIL/140/S"` |
| `date` | string | yes | Datum pohybu — e.g. `"2022-11-09T09:11:03"` |
| `location_name_before` | string \| null |  | Název původní pozice — e.g. `"A1-1-1"` |
| `location_name_after` | string | yes | Název nové pozice — e.g. `"A1-1-1"` |
| `amount_before` | integer \| null |  | Množství před — e.g. `10` |
| `amount_after` | integer | yes | Množství po — e.g. `8` |
| `source` | string \| null |  | Nejčastější možnosti:<br><br>inventura<br>picking - Picking produktu v Brani Baliči<br>Nákupní seznam <ID seznamu> - Naskladňování z nákupního seznamu dodavatele<br>pokladna - Pohyby, které vznikly novou objednávku v kamenných prodejnách a neprošly by tak standardním procesem skladového systému (s n — e.g. `"picking"` |
| `comment` | string \| null |  | Komentář |
| `order_code` | string \| null |  | Kód objednávky — e.g. `"2022000038"` |
| `order_eshop_url` | string \| null |  | Eshop objednávky — e.g. `"https://www.brani.cz"` |
| `shoptet_sync` | integer | yes | -1: zakazana synchr.<br> 0: Nesynchronizovano<br> 1: Prave se synchronizuje<br> 2: Synchronizovano<br> -128: Chyba synchronizace |
| `shoptet_sync_date` | string \| null |  | Datum symchronizace do Shoptetu — e.g. `"2022-11-09T09:11:05"` |
| `shoptet_movement_id` | integer \| null |  | ID pohybu v Shoptetu — e.g. `11419` |
| `client_id` | integer \| null | yes | ID uživatele |
| `client_name` | string \| null | yes | Jméno uživatele |
| `ao_shoplist_id` | integer \| null |  | ID nákupního seznamu |
| `ao_shoplist_name` | string \| null |  | Nazev nákupního seznamu |
| `movement_document_id` | integer \| null | yes | ID dokladu |
| `batch_id` | integer \| null | yes | ID šarže |
| `batch_name` | string \| null | yes | Název šarže |
| `batch_expires_at` | string \| null | yes | Datum expirace šarže |

### StockInBatch

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string \| null |  | Název šarže (když chybí, použije se datum expirace) |
| `expires_at` | string | yes | Datum expirace šarže |

### StockInRequest

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes | Kód produktu |
| `amount` | integer | yes | Množství |
| `position` | string | yes | Název pozice (musí existovat) |
| `mode` | string | yes | enum: set, add — Režim: set = nastavit (přepsat), add = přičíst |
| `batch` | StockInBatch \| null |  | Šarže (jen v režimu CHAOS, vyžaduje doplněk Šarže) |
| `eshop_sync` | boolean |  | default `true` — Synchronizovat pohyb do e-shopu |

### StockLocation

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string | yes | Název pozice |
| `sector` | string | yes | Název sektoru |

### StockSupply

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes | Kód produkty — e.g. `"PR/BAV/BIL/140/S"` |
| `location_name` | string | yes | Název pozice — e.g. `"A1-1-1"` |
| `amount` | integer | yes | Po4et kus; na pozici — e.g. `16` |
| `batches` | array of StockBatch |  | Šarže na pozici |
