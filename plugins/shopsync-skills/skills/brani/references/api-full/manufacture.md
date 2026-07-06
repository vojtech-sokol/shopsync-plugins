# Manufacture (recipes, orders, log)

Brani API module tag: "Brani výroba". Base URL `https://api.brani.cz`, Bearer auth.

## GET /manufacture/recipes
**Seznam receptur**

Vrátí stránkovaný seznam aktivních (nearchivovaných) receptur pro daný eshop.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `recipe_types` | query | string \| null |  | Typy receptur oddělené čárkou (assembly, split, customization) |
| `sort` | query | string |  | default `"created_at_desc"` — Způsob řazení. Možnosti: `created_at_desc`, `created_at_asc`, `updated_at_desc`, `updated_at_asc`. |
| `page` | query | integer |  | default `1` — Číslo stránky |
| `items_per_page` | query | integer |  | default `50` — Počet položek na stránku |

Response 200: **RecipesListResponse**

## POST /manufacture/recipes
**Vytvoření receptury**

Vytvoří novou recepturu. Viz typy receptur: assembly (smíchání), split (rozdělení), customization (personalizace).

Request body (application/json): **RecipeCreate** — see Schemas below

Response 200: **RecipeDetail**

## GET /manufacture/recipes/{recipe_id}
**Detail receptury**

Vrátí detail konkrétní receptury včetně vstupů, výstupů, zbytků a doplněných informací o produktech.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `recipe_id` | path | integer | yes |  |

Response 200: **RecipeDetail**

## PATCH /manufacture/recipes/{recipe_id}
**Úprava receptury**

Upraví existující recepturu. Typ receptury nelze změnit.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `recipe_id` | path | integer | yes |  |

Request body (application/json): **RecipeUpdate** — see Schemas below

Response 200: **RecipeDetail**

## GET /manufacture/orders
**Seznam výrobních příkazů**

Vrátí stránkovaný seznam výrobních příkazů. Bez filtru statusu jsou vráceny jen aktivní (waiting + in_progress).

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `statuses` | query | string \| null |  | Statusy oddělené čárkou (waiting, in_progress, completed, cancelled) |
| `priorities` | query | string \| null |  | Priority oddělené čárkou (low, normal, high, urgent) |
| `assigned_to_client_ids` | query | string \| null |  | ID přiřazených klientů oddělená čárkou |
| `with_closed` | query | boolean |  | default `false` — Zahrnout ukončené příkazy |
| `sort` | query | string |  | default `"created_at_desc"` — Způsob řazení. Možnosti: `created_at_desc`, `created_at_asc`, `deadline_asc`, `deadline_desc`, `priority_desc` (urgent > high > normal > low), `priority_asc`. |
| `page` | query | integer |  | default `1` — Číslo stránky |
| `items_per_page` | query | integer |  | default `50` — Počet položek na stránku |

Response 200: **OrdersListResponse**

## POST /manufacture/orders
**Vytvoření výrobního příkazu**

Vytvoří nový výrobní příkaz pro danou recepturu. Created_by bude nastaven na -1 (public API).

Request body (application/json): **OrderCreate** — see Schemas below

Response 200: **OrderDetail**

## GET /manufacture/orders/{order_id}
**Detail výrobního příkazu**

Vrátí detail konkrétního výrobního příkazu včetně navázané receptury.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_id` | path | integer | yes |  |

Response 200: **OrderDetail**

## PATCH /manufacture/orders/{order_id}
**Úprava výrobního příkazu**

Upraví výrobní příkaz. Povoleno jen pro příkazy ve stavu waiting nebo in_progress.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_id` | path | integer | yes |  |

Request body (application/json): **OrderUpdate** — see Schemas below

Response 200: **OrderDetail**

## GET /manufacture/log
**Seznam záznamů výroby**

Vrátí stránkovaný seznam provedené a zrušené výroby.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_id` | query | integer \| null |  | Filtr dle ID výrobního příkazu |
| `entry_types` | query | string \| null |  | Typy záznamů oddělené čárkou (executed, cancelled) |
| `recipe_types` | query | string \| null |  | Typy receptur oddělené čárkou |
| `executed_by_client_ids` | query | string \| null |  | ID klientů oddělená čárkou |
| `date_from` | query | string \| null |  | Datum od (včetně) |
| `date_to` | query | string \| null |  | Datum do (včetně) |
| `page` | query | integer |  | default `1` — Číslo stránky |
| `items_per_page` | query | integer |  | default `50` — Počet položek na stránku |

Response 200: **ExecutionsListResponse**

## GET /manufacture/log/{execution_id}
**Detail záznamu výroby**

Vrátí detail jednoho záznamu výroby včetně spotřebovaných vstupů, vyrobených výstupů a zbytků.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `execution_id` | path | integer | yes |  |

Response 200: **ExecutionDetailResponse**

---

## Schemas

### ExecutionDetailResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID záznamu výroby — e.g. `101` |
| `order_id` | integer | yes | ID výrobního příkazu — e.g. `42` |
| `recipe_name` | string \| null |  | Název receptury |
| `executed_at` | string \| null |  | Datum a čas provedení |
| `executed_by_name` | string \| null |  | Jméno toho, kdo výrobu provedl |
| `issue_document_id` | integer \| null |  | ID výdejky |
| `receipt_document_id` | integer \| null |  | ID příjemky |
| `consumed_items` | array of ExecutionInputDetail |  | Seznam skutečně spotřebovaných vstupů |
| `produced_items` | array of ExecutionOutputDetail |  | Seznam skutečně vyrobených výstupů |
| `created_remainders` | array of ExecutionRemainderDetail |  | Seznam zbytků vzniklých při této výrobě |

### ExecutionInputDetail

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID položky |
| `product_code` | string | yes | Kód produktu — e.g. `"PROD-001"` |
| `product_name` | string \| null |  | Název produktu |
| `variant_name` | string \| null |  | Název varianty |
| `image_url` | string \| null |  | URL obrázku |
| `ean` | string \| null |  |  |
| `location_name` | string \| null |  | Název skladové pozice — e.g. `"A1-02"` |
| `sarze_id` | integer \| null |  | ID šarže |
| `sarze_name` | string \| null |  | Název šarže |
| `sarze_expires_at` | string \| null |  | Expirace šarže |
| `amount` | string | yes | pattern `^(?!^[-+.]*$)[+-]?0*\d*\.?\d*$` — Množství |
| `unit` | string \| null |  | Jednotka — e.g. `"kg"` |
| `source` | string | yes | location = ze skladové pozice, remainder = ze zbytku z předchozí výroby — e.g. `"location"` |
| `remainder_id` | integer \| null |  | Pokud source=remainder |

### ExecutionListItem

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | Pro provedenou výrobu kladné ID, pro zrušený příkaz záporné (-order_id) — e.g. `101` |
| `order_id` | integer | yes | ID výrobního příkazu — e.g. `42` |
| `entry_type` | string |  | default `"executed"` — Typ záznamu — e.g. `"executed"` |
| `recipe_name` | string \| null |  | Název receptury — e.g. `"Smíchání čaje 100g"` |
| `recipe_type` | string \| null |  | Typ receptury — e.g. `"assembly"` |
| `batch_count` | integer \| null |  | Počet dávek — e.g. `5` |
| `executed_at` | string \| null |  | Datum a čas provedení — e.g. `"2026-04-15T13:45:00"` |
| `executed_by_name` | string \| null |  | Jméno toho, kdo výrobu provedl |
| `started_at` | string \| null |  | Datum zahájení příkazu |
| `cancelled_at` | string \| null |  | Datum zrušení příkazu |
| `output_product_code` | string \| null |  | Kód výstupního produktu |
| `output_product_name` | string \| null |  | Název výstupního produktu |
| `output_variant_name` | string \| null |  | Název varianty výstupu |
| `produced_amount` | integer \| null |  | Skutečně vyrobené množství — e.g. `48` |
| `expected_amount` | integer \| null |  | Očekávané množství dle receptury — e.g. `50` |
| `issue_document_id` | integer \| null |  | ID automaticky vytvořené výdejky — e.g. `1001` |
| `receipt_document_id` | integer \| null |  | ID automaticky vytvořené příjemky — e.g. `1002` |

### ExecutionOutputDetail

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID položky |
| `product_code` | string | yes | Kód produktu — e.g. `"OUT-001"` |
| `product_name` | string \| null |  | Název produktu |
| `variant_name` | string \| null |  | Název varianty |
| `image_url` | string \| null |  | URL obrázku |
| `ean` | string \| null |  |  |
| `location_name` | string \| null |  | Název skladové pozice |
| `sarze_id` | integer \| null |  | ID šarže |
| `sarze_name` | string \| null |  | Název šarže |
| `sarze_expires_at` | string \| null |  | Expirace šarže |
| `amount` | integer | yes | Skutečně vyrobené množství — e.g. `48` |
| `expected_amount` | integer \| null |  | Očekávané množství — e.g. `50` |

### ExecutionRemainderDetail

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID zbytku |
| `product_code` | string | yes | Kód produktu |
| `product_name` | string \| null |  | Název produktu |
| `variant_name` | string \| null |  | Název varianty |
| `image_url` | string \| null |  | URL obrázku |
| `amount` | string | yes | pattern `^(?!^[-+.]*$)[+-]?0*\d*\.?\d*$` — Množství zbytku |
| `unit` | string | yes | Jednotka |
| `sarze_name` | string \| null |  | Název šarže |
| `sarze_expires_at` | string \| null |  | Expirace šarže |

### ExecutionsListResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `items` | array of ExecutionListItem | yes | Záznamy na aktuální stránce (provedené výroby + zrušené příkazy) |
| `page` | integer \| null |  | Číslo stránky — e.g. `1` |
| `items_per_page` | integer \| null |  | Maximum je 100 — e.g. `50` |
| `total_items` | integer | yes | Celkový počet záznamů odpovídajících filtru — e.g. `120` |

### OrderCreate

| Field | Type | Req | Notes |
|---|---|---|---|
| `recipe_id` | integer | yes | ID receptury, ze které se příkaz vytváří — e.g. `1` |
| `batch_count` | integer |  | default `1` — Kolikrát se receptura vyrobí — e.g. `5` |
| `priority` | string |  | enum: low, normal, high, urgent — default `"normal"` — Priorita — e.g. `"high"` |
| `deadline` | string \| null |  | Termín dokončení — e.g. `"2026-05-01T12:00:00"` |
| `order_code` | string \| null |  | Kód objednávky, ke které příkaz patří (povinné pro customization) — e.g. `"ORD-2026-001"` |
| `order_eshop_id` | integer \| null |  | Povinné pro customization — e.g. `219` |
| `notes` | string \| null |  | Poznámky |
| `custom_inputs` | array of OrderCustomInput |  | Vstupní produkty pro tento příkaz (používá se pro customization). Lze zadat více různých produktů z jedné objednávky. |

### OrderCustomInput

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | SKU produktu použitého jako vlastní vstup — e.g. `"PROD-001"` |
| `amount` | integer | yes | Množství — e.g. `5` |

### OrderCustomInputResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | SKU produktu použitého jako vlastní vstup — e.g. `"PROD-001"` |
| `amount` | integer | yes | Množství — e.g. `5` |
| `product_name` | string \| null |  | Název produktu — e.g. `"Tričko bavlněné"` |
| `variant_name` | string \| null |  | Název varianty — e.g. `"Červená / L"` |

### OrderDetail

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID příkazu — e.g. `1` |
| `eshop_id` | integer | yes | ID eshopu — e.g. `219` |
| `recipe_id` | integer | yes | ID receptury — e.g. `1` |
| `recipe_name` | string \| null |  | Název receptury — e.g. `"Smíchání čaje 100g"` |
| `recipe_type` | string \| null |  | Typ receptury — e.g. `"assembly"` |
| `output_product_code` | string \| null |  | Kód výstupního produktu — e.g. `"OUT-001"` |
| `output_product_name` | string \| null |  | Název výstupního produktu |
| `output_amount` | integer \| null |  | Množství na výstup (na dávku) — e.g. `10` |
| `batch_count` | integer | yes | Počet dávek — e.g. `5` |
| `status` | string | yes | e.g. `"waiting"` |
| `priority` | string | yes | enum: low, normal, high, urgent — Priorita — e.g. `"normal"` |
| `deadline` | string \| null |  | Termín |
| `order_code` | string \| null |  | Kód objednávky |
| `order_eshop_id` | integer \| null |  | ID eshopu objednávky |
| `order_eshop_name` | string \| null |  | Název eshopu objednávky |
| `assigned_to_client_id` | integer \| null |  | ID přiřazeného klienta |
| `assigned_to_name` | string \| null |  | Jméno přiřazeného klienta |
| `created_at` | string \| null |  | Datum vytvoření |
| `started_at` | string \| null |  | Datum zahájení |
| `completed_at` | string \| null |  | Datum dokončení |
| `cancelled_at` | string \| null |  | Datum zrušení |
| `created_by_client_id` | integer \| null |  | Pro příkazy vytvořené přes public API bude hodnota -1 — e.g. `-1` |
| `created_by_name` | string \| null |  | Jméno tvůrce |
| `notes` | string \| null |  | Poznámky |
| `custom_inputs` | array of OrderCustomInputResponse |  | Vlastní vstupy |
| `recipe` | RecipeDetail \| null |  | Kompletní data navázané receptury |

### OrderResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID příkazu — e.g. `1` |
| `eshop_id` | integer | yes | ID eshopu — e.g. `219` |
| `recipe_id` | integer | yes | ID receptury — e.g. `1` |
| `recipe_name` | string \| null |  | Název receptury — e.g. `"Smíchání čaje 100g"` |
| `recipe_type` | string \| null |  | Typ receptury — e.g. `"assembly"` |
| `output_product_code` | string \| null |  | Kód výstupního produktu — e.g. `"OUT-001"` |
| `output_product_name` | string \| null |  | Název výstupního produktu |
| `output_amount` | integer \| null |  | Množství na výstup (na dávku) — e.g. `10` |
| `batch_count` | integer | yes | Počet dávek — e.g. `5` |
| `status` | string | yes | e.g. `"waiting"` |
| `priority` | string | yes | enum: low, normal, high, urgent — Priorita — e.g. `"normal"` |
| `deadline` | string \| null |  | Termín |
| `order_code` | string \| null |  | Kód objednávky |
| `order_eshop_id` | integer \| null |  | ID eshopu objednávky |
| `order_eshop_name` | string \| null |  | Název eshopu objednávky |
| `assigned_to_client_id` | integer \| null |  | ID přiřazeného klienta |
| `assigned_to_name` | string \| null |  | Jméno přiřazeného klienta |
| `created_at` | string \| null |  | Datum vytvoření |
| `started_at` | string \| null |  | Datum zahájení |
| `completed_at` | string \| null |  | Datum dokončení |
| `cancelled_at` | string \| null |  | Datum zrušení |
| `created_by_client_id` | integer \| null |  | Pro příkazy vytvořené přes public API bude hodnota -1 — e.g. `-1` |
| `created_by_name` | string \| null |  | Jméno tvůrce |
| `notes` | string \| null |  | Poznámky |
| `custom_inputs` | array of OrderCustomInputResponse |  | Vlastní vstupy |

### OrderUpdate

| Field | Type | Req | Notes |
|---|---|---|---|
| `batch_count` | integer \| null |  | Počet dávek — e.g. `10` |
| `priority` | string \| null |  | enum: low, normal, high, urgent — Priorita — e.g. `"urgent"` |
| `recipe_id` | integer \| null |  | Změna receptury. Lze pouze u příkazu typu personalizace a pouze na jinou personalizaci. — e.g. `2` |
| `order_code` | string \| null |  | Kód objednávky — e.g. `"ORD-2026-002"` |
| `deadline` | string \| null |  | Termín dokončení — e.g. `"2026-05-02T12:00:00"` |
| `notes` | string \| null |  | Poznámky |
| `custom_inputs` | array of OrderCustomInput \| null |  | Pouze pro receptury typu personalizace (customization). Lze zadat více produktů z jedné objednávky. |

### OrdersListResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `items` | array of OrderResponse | yes | Výrobní příkazy na aktuální stránce |
| `page` | integer \| null |  | Číslo stránky — e.g. `1` |
| `items_per_page` | integer \| null |  | Maximum je 100 — e.g. `50` |
| `total_items` | integer | yes | Celkový počet záznamů odpovídajících filtru — e.g. `120` |

### RecipeCreate

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string | yes | Název receptury — e.g. `"Smíchání čaje o hmotnosti 100g"` |
| `recipe_type` | string | yes | assembly = smíchání více vstupů, split = rozdělení vstupu, customization = personalizace — e.g. `"assembly"` |
| `track_remainder` | boolean |  | default `false` — Zapnout evidenci nespotřebovaných vstupů (zbytků) — e.g. `false` |
| `notes` | string \| null |  | Poznámky — e.g. `"Interní poznámka k receptuře"` |
| `receipt_document_type_id` | integer \| null |  | ID typu skladového dokladu pro automatickou příjemku (povinné pro assembly a split) — e.g. `5` |
| `issue_document_type_id` | integer \| null |  | ID typu skladového dokladu pro automatickou výdejku (povinné pro assembly a split) — e.g. `6` |
| `archive_documents` | boolean |  | default `false` — Automaticky archivovat vygenerované skladové doklady po dokončení výroby — e.g. `false` |
| `inputs` | array of RecipeInput |  | Seznam vstupních produktů |
| `outputs` | array of RecipeOutput |  | Seznam výstupních produktů |
| `remainders` | array of RecipeRemainder |  | Seznam sledovaných zbytkových produktů |

### RecipeDetail

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID receptury — e.g. `1` |
| `eshop_id` | integer | yes | ID eshopu — e.g. `219` |
| `name` | string | yes | Název — e.g. `"Smíchání čaje 100g"` |
| `recipe_type` | string | yes | Typ receptury — e.g. `"assembly"` |
| `track_remainder` | boolean | yes | Sledovat zbytky — e.g. `false` |
| `created_at` | string \| null |  | Datum vytvoření — e.g. `"2026-01-10T14:30:00"` |
| `archived_at` | string \| null |  | Datum archivace — e.g. `null` |
| `updated_at` | string \| null |  | Datum poslední úpravy — e.g. `"2026-03-05T09:15:00"` |
| `notes` | string \| null |  | Poznámky |
| `receipt_document_type_id` | integer \| null |  | Typ příjemky — e.g. `5` |
| `issue_document_type_id` | integer \| null |  | Typ výdejky — e.g. `6` |
| `archive_documents` | boolean |  | default `false` — Archivovat doklady |
| `receipt_document_type_name` | string \| null |  | Název typu příjemky — e.g. `"Příjemka výroby"` |
| `issue_document_type_name` | string \| null |  | Název typu výdejky — e.g. `"Výdejka výroby"` |
| `inputs` | array of RecipeInputResponse |  | Vstupy |
| `outputs` | array of RecipeOutputResponse |  | Výstupy |
| `remainders` | array of RecipeRemainderResponse |  | Zbytky |

### RecipeInput

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | SKU vstupního produktu — e.g. `"PROD-001"` |
| `amount` | number \| string | yes | Množství vstupu na jednu dávku výroby — e.g. `2.5` |
| `unit` | string |  | default `"ks"` — Jednotka množství (ks, kg, l, m atd.) — e.g. `"kg"` |

### RecipeInputResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_name` | string \| null |  | Název produktu — e.g. `"Tričko bavlněné"` |
| `variant_name` | string \| null |  | Název varianty — e.g. `"Červená / L"` |
| `image_url` | string \| null |  | URL obrázku — e.g. `"https://cdn.example.com/products/prod-001.jpg"` |
| `ean` | string \| null |  | e.g. `"8594000000017"` |
| `packaging_amount` | string \| null |  | Množství v balení — e.g. `1.0` |
| `packaging_unit` | string \| null |  | Jednotka balení — e.g. `"ks"` |
| `product_code` | string | yes | SKU vstupního produktu — e.g. `"PROD-001"` |
| `amount` | string | yes | pattern `^(?!^[-+.]*$)[+-]?0*\d*\.?\d*$` — Množství vstupu na jednu dávku výroby — e.g. `2.5` |
| `unit` | string |  | default `"ks"` — Jednotka množství (ks, kg, l, m atd.) — e.g. `"kg"` |

### RecipeOutput

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | SKU výstupního produktu — e.g. `"OUT-001"` |
| `amount` | integer | yes | Počet kusů vyrobených z jedné dávky — e.g. `10` |

### RecipeOutputResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_name` | string \| null |  | Název produktu — e.g. `"Tričko bavlněné"` |
| `variant_name` | string \| null |  | Název varianty — e.g. `"Červená / L"` |
| `image_url` | string \| null |  | URL obrázku — e.g. `"https://cdn.example.com/products/prod-001.jpg"` |
| `ean` | string \| null |  | e.g. `"8594000000017"` |
| `packaging_amount` | string \| null |  | Množství v balení — e.g. `1.0` |
| `packaging_unit` | string \| null |  | Jednotka balení — e.g. `"ks"` |
| `product_code` | string | yes | SKU výstupního produktu — e.g. `"OUT-001"` |
| `amount` | integer | yes | Počet kusů vyrobených z jedné dávky — e.g. `10` |

### RecipeRemainder

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | SKU zbývajícího produktu — e.g. `"REM-001"` |
| `unit` | string | yes | Jednotka zbytku — e.g. `"kg"` |

### RecipeRemainderResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_name` | string \| null |  | Název produktu — e.g. `"Tričko bavlněné"` |
| `variant_name` | string \| null |  | Název varianty — e.g. `"Červená / L"` |
| `image_url` | string \| null |  | URL obrázku — e.g. `"https://cdn.example.com/products/prod-001.jpg"` |
| `ean` | string \| null |  | e.g. `"8594000000017"` |
| `packaging_amount` | string \| null |  | Množství v balení — e.g. `1.0` |
| `packaging_unit` | string \| null |  | Jednotka balení — e.g. `"ks"` |
| `product_code` | string | yes | SKU zbývajícího produktu — e.g. `"REM-001"` |
| `unit` | string | yes | Jednotka zbytku — e.g. `"kg"` |

### RecipeResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID receptury — e.g. `1` |
| `eshop_id` | integer | yes | ID eshopu — e.g. `219` |
| `name` | string | yes | Název — e.g. `"Smíchání čaje 100g"` |
| `recipe_type` | string | yes | Typ receptury — e.g. `"assembly"` |
| `track_remainder` | boolean | yes | Sledovat zbytky — e.g. `false` |
| `created_at` | string \| null |  | Datum vytvoření — e.g. `"2026-01-10T14:30:00"` |
| `archived_at` | string \| null |  | Datum archivace — e.g. `null` |
| `updated_at` | string \| null |  | Datum poslední úpravy — e.g. `"2026-03-05T09:15:00"` |
| `notes` | string \| null |  | Poznámky |
| `receipt_document_type_id` | integer \| null |  | Typ příjemky — e.g. `5` |
| `issue_document_type_id` | integer \| null |  | Typ výdejky — e.g. `6` |
| `archive_documents` | boolean |  | default `false` — Archivovat doklady |

### RecipeUpdate

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string \| null |  | Název receptury — e.g. `"Smíchání čaje o hmotnosti 100g - upraveno"` |
| `recipe_type` | string \| null |  | Pouze pro validaci - typ nelze měnit po vytvoření — e.g. `"assembly"` |
| `track_remainder` | boolean \| null |  | Sledovat zbytky — e.g. `true` |
| `notes` | string \| null |  | Poznámky — e.g. `"Nová poznámka"` |
| `receipt_document_type_id` | integer \| null |  | Typ příjemky — e.g. `5` |
| `issue_document_type_id` | integer \| null |  | Typ výdejky — e.g. `6` |
| `archive_documents` | boolean \| null |  | Archivovat doklady — e.g. `true` |
| `inputs` | array of RecipeInput \| null |  | Vstupy |
| `outputs` | array of RecipeOutput \| null |  | Výstupy |
| `remainders` | array of RecipeRemainder \| null |  | Zbytky |

### RecipesListResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `items` | array of RecipeResponse | yes | Receptury na aktuální stránce (bez archivovaných) |
| `page` | integer \| null |  | Číslo stránky — e.g. `1` |
| `items_per_page` | integer \| null |  | Maximum je 100 — e.g. `50` |
| `total_items` | integer | yes | Celkový počet záznamů odpovídajících filtru — e.g. `120` |
