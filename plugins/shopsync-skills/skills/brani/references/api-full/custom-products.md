# Custom products

Brani API module tag: "Custom produkty". Base URL `https://api.brani.cz`, Bearer auth.

## POST /custom-products/upsert
**Vytvoří nebo aktualizuje custom produkt**

Request body (application/json): **CustomProductRequest** — see Schemas below

## GET /custom-products/{product_guid}
**Vrátí detail custom produktu**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `product_guid` | path | string | yes |  |

Response 200: **SingleCustomProductResponse**

## DELETE /custom-products/{product_guid}
**Smaže custom produkt**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `product_guid` | path | string | yes |  |

## GET /custom-products/
**Vrátí seznam custom produktů**

Response 200: **MultipleCustomProductsResponse**

---

## Schemas

### CustomProductRequest

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_name` | string | yes | Název produktu |
| `product_code` | string | yes | Kód produktu |
| `product_ean` | string \| null |  | default `""` — EAN produktu |
| `product_description` | string \| null |  | Popis produktu |
| `product_guid` | string \| null |  | GUID produktu (pokud není zadán, bude vytvořen nový produkt GUID) |
| `image_b64` | string \| null |  | Obrázek produktu - base64 |
| `image_url` | string \| null |  | Obrázek produktu - URL |
| `delete_image` | boolean \| null |  | default `false` — Odstranit obrázek produktu |

### CustomProductResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_name` | string | yes | Název produktu |
| `product_code` | string | yes | Kód produktu |
| `product_ean` | string \| null |  | default `""` — EAN produktu |
| `product_description` | string \| null |  | Popis produktu |
| `product_guid` | string \| null |  | GUID produktu (pokud není zadán, bude vytvořen nový produkt GUID) |
| `image_url` | string \| null |  | Obrázek produktu - URL |
| `created_at` | string \| null | yes | Datum vytvoření produktu |
| `updated_at` | string \| null | yes | Datum poslední aktualizace produktu |

### MultipleCustomProductsResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `products` | array of CustomProductResponse \| null | yes |  |
| `total` | integer | yes |  |

### SingleCustomProductResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `product` | CustomProductResponse | yes |  |
