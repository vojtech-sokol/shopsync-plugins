# Carriers (dopravci)

Brani API module tag: "Dopravci". Base URL `https://api.brani.cz`, Bearer auth.

## GET /carriers/list-attributes
**Seznam atributů služeb**

Vrací seznam atributů služeb, které jsou dostupné pro nastavení v objednávkách. Pro nastavení atributů objednávky použijte endpoint `/carriers/order-attributes/`. Pro `attribute_code` v ednpointu `/carriers/order-attributes/` použijte hodnoty "attribute" z v tohoto seznamu.

Response 200: **ServiceAttributeResponse**

## POST /carriers/order-attributes
**Nastaveni atributu sluzby pro objednavku**

Nastaví hodnotu atributu pro objednávku. Atribut se použije místo výchozí hodnoty v případě, že je atribut podporován danou službou.

Request body (application/json): **OrderAttribute** — see Schemas below

Response 200: **SetAttrResponse**

## GET /carriers/order-attributes/{order_code}
**Seznam atributů služby pro objednávku**

Vrací seznam atributů služby pro objednávku. Používá se pro zobrazení aktuálních hodnot atributů objednávky.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_code` | path | string | yes |  |

Response 200: **OrderAttributesListResponse**

## DELETE /carriers/order-attributes/{order_code}/{attribute_code}
**Smazání atributu služby pro objednávku**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_code` | path | string | yes |  |
| `attribute_code` | path | string | yes |  |

## POST /carriers/track-order
**Sledování zásilky podle kódu objednávky**

Sledování zásilky podle kódu objednávky. Endpoint automaticky najde přiřazené tracking číslo k objednávce a vrátí aktuální stav zásilky od dopravce. ## Response Format Odpověď obsahuje tracking informace ve dvou formátech: ### `brani_tracking` (unified format) Standardizovaný formát pro všechny dopravce: - `name`: Popis stavu v češtině - `date`: Datum a čas stavu (YYYY-MM-DD HH:MM:SS) - `status_id`: Interní ID stavu (legacy) - `status_id_v2`: Standardizované ID stavů (array or single value) ### Dopravce-specifický format Originální data od konkrétního dopravce (např. `balikobot_tracking`, `zasilkovna_tracking`) ## Status ID v2 Meanings Standardizované identifikátory stavů zásilek: ### Základní stavy: - `-1`: Objednáno - `0.1`: Chyba u dopravce - `0.2`: Chyba na straně příjemce - `0.3`: Chyba na straně odesilatele ### Úspěšné doručení: - `1.1`: Vyzvednutí zásilky na výdejním místě - `1.2`: Doručeno na adresu ### Zpracování zásilky: - `2.1`: Vyzvednuta u odesilatele - `2.2`: Transit (na cestě) - `2.3`: Připravena k vyzvednutí - `2.4`: Zpět na cestě k odesilateli - `2.5`: Předána koncovému dopravci ### Stornování: - `3.1`: Storno ze strany dopravce - `3.2`: Storno ze strany příjemce - `3.3`: Storno ze strany odesilatele ### Speciální stavy: - `4`: Doručena zpět odesilateli - `5`: Dobírka byla připsána na účet odesilatele

Request body (application/json): **TrackOrderRequest** — see Schemas below

---

## Schemas

### OrderAttribute

| Field | Type | Req | Notes |
|---|---|---|---|
| `order_code` | string | yes | Kód objednávky |
| `attribute_code` | string | yes | ID atributu služby |
| `value` | string \| object \| array of any \| integer \| number |  | Hodnota atributu služby. Hodnota může být typu object(dict) jedině pokud je atribut spojen s produktem (pouze balílkobot) |

### OrderAttributesListResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `order_attributes` | object | yes | Seznam atributů služby pro objednávku, kde každý atribut je slovník s kódem a hodnotou |

### ServiceAttribute

| Field | Type | Req | Notes |
|---|---|---|---|
| `attribute` | string | yes | Kód atributu |
| `name` | string | yes | Název atributu |
| `product_attribute` | boolean |  | default `false` — Je-li atribut spojen s produktem (pouze balílkobot) |

### ServiceAttributeResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `service_attributes` | object | yes | Seznam atributů služby, kde klíčem je kód služby a hodnotou seznam atributů — e.g. `{"balikobot": [{"attribute": "weight", "name": "Váha (kg)", "product_attribute":` |

### SetAttrResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `status` | string | yes | Status operace — e.g. `"success"` |
| `message` | string | yes | Human readable status — e.g. `"Nastavená hodnota atributu služby pro objednávku"` |

### TrackOrderRequest

| Field | Type | Req | Notes |
|---|---|---|---|
| `order_code` | string | yes | Order Code |
