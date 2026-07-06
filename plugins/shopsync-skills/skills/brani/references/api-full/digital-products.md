# Digital products

Brani API module tag: "Digitální produkty". Base URL `https://api.brani.cz`, Bearer auth.

## GET /digital-products/orders/{order_code}
**Stav zpracování digitálních produktů pro objednávku**

Vrací informaci, zda byla objednávka zpracována systémem digitálních produktů. Pokud ano, vrací datum zpracování, e-mail příjemce a seznam odeslaných produktů včetně klíčů, URL a dalších detailů.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_code` | path | string | yes | Kód objednávky |

Response 200: **DigitalOrderStatusResponse**

---

## Schemas

### DigitalOrderStatusResponse
Response pro dotaz na stav zpracování digitálních produktů pro objednávku.

| Field | Type | Req | Notes |
|---|---|---|---|
| `processed` | boolean | yes | Zda byla objednávka zpracována systémem digitálních produktů |
| `processed_at` | string \| null |  | Datum a čas zpracování objednávky |
| `order_code` | string | yes | Kód objednávky |
| `order_email` | string \| null |  | E-mail zákazníka, na který byly produkty odeslány |
| `products` | array of DigitalProductEntitlementSchema |  | Seznam digitálních produktů a jejich klíčů/URL odeslaných v rámci objednávky |

### DigitalProductEntitlementSchema
Detail jednoho digitálního produktu/oprávnění v objednávce.

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string \| null |  | Kód produktu |
| `product_name` | string \| null |  | Název produktu |
| `type` | string \| null |  | Typ produktu: 'single' nebo 'multiple' |
| `value` | string \| null |  | Klíč, kód nebo URL - u 'single' produktů statická hodnota, u 'multiple' hodnota z přiřazeného seznamu |
| `download_url` | string \| null |  | URL pro stažení (s unikátním hash) |
| `valid_until` | string \| null |  | Datum platnosti (např. u slevových kupónů) |
