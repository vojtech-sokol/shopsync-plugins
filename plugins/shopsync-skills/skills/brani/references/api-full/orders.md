# Orders (upsert, invoices, tags, priority, customs)

Brani API module tag: "Objednávky". Base URL `https://api.brani.cz`, Bearer auth.

## GET /order/org-tags
**Získání všech tagů pro organizaci**

Response 200: **OrgTagsResponse**

## GET /order/order-tags/{order_code}
**Získání tagů objednávky**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_code` | path | string | yes |  |

Response 200: **OrgTagsResponse**

## POST /order/order-tags
**Nastavení jedného tagu objednávek pro aktuální e-shop**

Request body (application/json): **OrderTagsRequest** — see Schemas below

Response 200: **AddOrderTagsResponse**

## DELETE /order/order-tags
**Smaže tagy objednávek pro aktuální e-shop**

Request body (application/json): **OrderTagsRequest** — see Schemas below

Response 200: **RemoveOrderTagsResponse**

## POST /order/upsert
**Prida nebo aktualizuje objednavku**

Request body (application/json): **orderModel | newShoptetOrderModel** — see Schemas below

## DELETE /order/delete
**Smaže objednávku na základě jejího kódu**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_code` | query | string | yes |  |

## POST /order/customs
**Změní data se clem na základě kódu objednávky**

Request body (application/json): **Body_Data_pro_clo_order_customs_post** — see Schemas below

## GET /order/invoice
**Stáhnutí faktury k objednávce**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_code` | query | string | yes |  |

## POST /order/invoice
**Nahrání faktury k objednávce**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_code` | query | string | yes |  |

Request body (multipart/form-data): **Body_Nahr_n__faktury_k_objend_vce_order_invoice_post** — see Schemas below

## DELETE /order/invoice
**Smazání faktury k objednávce**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `order_code` | query | string | yes |  |

## POST /order/priority
**Změní prioritu objednávky**

Nastaví prioritu objednávek. Priorita může být 0 (žádná), 1 (nízká), 2 (střední) nebo 3 (vysoká).

Request body (application/json): **OrderPrioritiesRequest** — see Schemas below

## POST /order/ordering
**Hromadné nastavení řazení objednávek**

Nastaví číslo pro řazení (`ordering_number`) pro seznam objednávek. Objednávky s nižším číslem se v Baliči zobrazují dříve. Objednávky s prioritou (`priority > 0`) mají vždy přednost před řazením podle `ordering_number`. Hodnota `0` znamená, že řazení není nastaveno.

Request body (application/json): **OrderOrderingRequest** — see Schemas below

---

## Schemas

### AddOrderTagsResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `added_order_tags` | brani_async__infra_jobs__public_api__routers__schema__OrderTag | yes | Seznam objednávek s přidanými tagy |
| `warnings` | array of string \| null |  | Seznam varování při změně tagů |
| `errors` | array of string \| null |  | Seznam chyb při změně tagů |

### Address

| Field | Type | Req | Notes |
|---|---|---|---|
| `fullName` | string | yes | Jméno a příjmení — e.g. `"Jan Novák"` |
| `company` | string \| null |  | Název společnosti — e.g. `"Společnost s.r.o."` |
| `street` | string \| null |  | Ulice — e.g. `"Příčná"` |
| `houseNumber` | string \| null |  | Číslo domu — e.g. `"21.00"` |
| `city` | string \| null |  | Město — e.g. `"Brno"` |
| `district` | string \| null |  | Kraj/okres — e.g. `"null"` |
| `additional` | string \| null |  | Doplňková informace k adrese — e.g. `"2. patro"` |
| `zip` | string \| null |  | PSČ — e.g. `"111 00"` |
| `countryCode` | string \| null |  | ve formátu ISO 3166 alpha-2 — e.g. `"CZ"` |
| `regionName` | string \| null |  | Region — e.g. `"null"` |

### BillingAddress

| Field | Type | Req | Notes |
|---|---|---|---|
| `fullName` | string | yes | Jméno a příjmení — e.g. `"Jan Novák"` |
| `company` | string \| null |  | Název společnosti — e.g. `"Společnost s.r.o."` |
| `street` | string | yes | Ulice — e.g. `"Příčná"` |
| `houseNumber` | string \| null |  | Číslo domu — e.g. `"21.00"` |
| `city` | string | yes | Město — e.g. `"Brno"` |
| `district` | string \| null |  | Kraj/okres — e.g. `"null"` |
| `additional` | string \| null |  | Doplňková informace k adrese — e.g. `"2. patro"` |
| `zip` | string | yes | PSČ — e.g. `"111 00"` |
| `countryCode` | string | yes | ve formátu ISO 3166 alpha-2 — e.g. `"CZ"` |
| `regionName` | string \| null |  | Region — e.g. `"null"` |
| `companyId` | string \| null |  | Identifikační číslo společnosti (IČ) — e.g. `"123456"` |
| `vatId` | string \| null |  | VAT ID (DIČ) — e.g. `"CZ123456789"` |
| `taxId` | string \| null |  | TAX ID (IČ DPH) — e.g. `"123456"` |

### BillingMethodCode
Enum: `1`, `2`, `3`, `4`

### Body_Data_pro_clo_order_customs_post

| Field | Type | Req | Notes |
|---|---|---|---|
| `customs` | array of CustomsData | yes |  |
| `order_code` | string | yes | Order Code |

### Body_Nahr_n__faktury_k_objend_vce_order_invoice_post

| Field | Type | Req | Notes |
|---|---|---|---|
| `invoice` | string | yes |  |

### CustomsData

| Field | Type | Req | Notes |
|---|---|---|---|
| `product_code` | string | yes | Kód produktu — e.g. `"2017000092"` |
| `content_name_en` | string \| null |  | Content Name En |
| `content_country` | string \| null |  | Content Country |
| `content_customs_code` | string \| null |  | Content Customs Code |
| `content_description` | string \| null |  | Content Description |

### Data2

| Field | Type | Req | Notes |
|---|---|---|---|
| `creationTime` | string | yes | Datum musí bý v minulosti — e.g. `"2017-12-12T22:08:01+0100"` |
| `email` | string | yes | Email zákazníka — e.g. `"customer@someemail.com"` |
| `code` | string | yes | Unikátní kód/číslo objednávky — e.g. `"5426578"` |
| `phone` | string | yes | Telefonní číslo zákazníka — e.g. `"+420604600444"` |
| `shippingDetails` | ShippingDetails \| null |  | Doplňkové informace k doručení |
| `billingMethodCode` | BillingMethodCode \| null |  | Povolené typy jsou: 1 = Dobírka, 2 = Převodem, 3 = Hotově, 4 = Kartou |
| `paymentMethodGuid` | string \| null |  | GUID musí odpovídat platebním metodám zaslaných přes endpoint /eshop/info Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" — e.g. `"b57f91bb-e920-11e0-baa3-7dc668b75ca8"` |
| `shippingGuid` | string \| null |  | GUID musí odpovídat přepravním metodám zaslaných přes endpoint /eshop/info Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" — e.g. `"2ec88ea7-3fb0-11e2-a723-705ab6a2ba75"` |
| `paid` | boolean \| null |  | default `false` — Příznak zde je objednávka zaplacena — e.g. `"true"` |
| `deliveryAddress` | Address | yes | Doručovací adresa |
| `cashDeskOrder` | boolean \| null |  | default `false` — Příznak, zda byla objednávka vytvořena na pokladně — e.g. `"false"` |
| `addressesEqual` | boolean \| null |  | Shoda adres |
| `notes` | Notes | yes | Doplńkové data k objednávce |
| `status` | brani_async__infra_jobs__public_api__orderSchema__Status \| null |  | default `{"id": 0}` — Stav objednávky |
| `billingAddress` | BillingAddress | yes | Fakturační adresa |
| `price` | Price | yes | Cena objednávky |
| `adminUrl` | string \| null |  | Odkaz, kterým lze prokliknout do administrace objednávky — e.g. `"https://brani.myshoptet.com/admin/objednavky-detail?id=5426578"` |
| `items` | array of Item | yes | Položky objednávky |
| `vs` | string \| null |  | Variabilní symbol — e.g. `"123456"` |
| `externalCode` | string \| null |  | Volitelný externí identifikátor objednávky (např. číslo objednávky z BaseLinker nebo jiného systému) — e.g. `"BL-123456"` |

### Item

| Field | Type | Req | Notes |
|---|---|---|---|
| `itemId` | integer \| null |  | Musí být unikátní mezi položkami objednávky; pokud není zadáno, vygeneruje se automaticky. — e.g. `19` |
| `stockLocation` | string \| null |  | Skladová pozice produktu — e.g. `"S1-03"` |
| `itemType` | ItemType | yes | Povolené typy jsou: product, second-had, service, gift — e.g. `"product"` |
| `code` | string | yes | Kód produktu/varianty — e.g. `"2017000092"` |
| `vatRate` | string \| null |  | V procentech — e.g. `"21"` |
| `itemPriceWithVat` | string \| null |  | Celková cena s DPH — e.g. `"99.00"` |
| `name` | string | yes | Název produktu — e.g. `"Medvídek na zeď"` |
| `variantName` | string \| null |  | Název varianty produktu — e.g. `"Bílý"` |
| `brand` | string \| null |  | Značka produktu — e.g. `"Medvídkárna"` |
| `supplierName` | string \| null |  | Název dodavatele — e.g. `"Dodavatel s.r.o"` |
| `productGuid` | string \| null | yes | Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" — e.g. `"747fb32d-73bc-11e8-8216-002590dad85e"` |
| `remark` | string \| null |  | Poznámka eshopu u položky — e.g. `"Položka je křehká"` |
| `additionalField` | string \| null |  | Doplňkové informace k produktu — e.g. `"Určen pro děti i dospělé"` |
| `amount` | string | yes | Množství — e.g. `"1"` |
| `amountUnit` | string | yes | Jednotka množství — e.g. `"kg"` |
| `weight` | string | yes | V kg — e.g. `"0.434"` |
| `status` | brani_async__infra_jobs__public_api__orderSchema__Status \| null |  | Stav položky |
| `ean` | string \| null |  | EAN produktu — e.g. `"5523678544"` |
| `image` | string \| null |  | URL obrázku produktu — e.g. `"https://uploads-ssl.webflow.com/60f6bd04b4e345bfc4e15a14/620faf85284b9dafda2bee` |
| `buyPrice` | object \| null |  | Nákupní cena |
| `surchargeParameters` | array of SurchargeParameter \| null |  | Příplatkové parametry |
| `adminUrl` | string \| null |  | Odkaz, kterým lze prokliknout do administrace produktu — e.g. `"https://brani.myshoptet.com/admin/produkty-detail/?id=2017000092"` |
| `content_name_en` | string \| null |  | Content Name En |
| `content_country` | string \| null |  | Content Country |
| `content_customs_code` | string \| null |  | Content Customs Code |
| `content_description` | string \| null |  | Content Description |

### ItemType
Enum: `product`, `second-hand`, `service`, `gift`, `product-set`

### Notes

| Field | Type | Req | Notes |
|---|---|---|---|
| `trackingNumber` | string \| null |  | Trasovací číslo zásilky — e.g. `"DR123456"` |
| `eshopRemark` | string \| null |  | Poznámka eshopu — e.g. `"Důležitá objednávka"` |
| `customerRemark` | string \| null |  | Poznámka zákazníka — e.g. `"Spěchá"` |

### OrderOrderingItem

| Field | Type | Req | Notes |
|---|---|---|---|
| `order_code` | string | yes | Kód objednávky |
| `ordering_number` | integer | yes | Číslo pro řazení objednávky v Baliči (0 = nenastaveno). |

### OrderOrderingRequest

| Field | Type | Req | Notes |
|---|---|---|---|
| `orders` | array of OrderOrderingItem | yes | Seznam objednávek a jejich čísel pro řazení |

### OrderPrioritiesRequest

| Field | Type | Req | Notes |
|---|---|---|---|
| `order_code` | string \| array of string | yes | Kód objednávky |
| `priority` | integer | yes | Priorita objednávky |

### OrderTagsRequest

| Field | Type | Req | Notes |
|---|---|---|---|
| `order_code` | string \| array of string | yes | Kód objednávky nebo seznam kódů objednávek |
| `tag_id` | integer | yes | Id tagu |

### OrgTag

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | Unikátní ID tagu |
| `name` | string | yes | Název tagu |
| `color` | string \| null |  | Barva tagu v hex formátu |

### OrgTagsResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `tags` | array of OrgTag | yes | Seznam tagů organizace |

### Price

| Field | Type | Req | Notes |
|---|---|---|---|
| `toPay` | string | yes | Cena k zaplacení - v případě dobírky se jedná o dobírkovou částku — e.g. `"100.90"` |
| `withVat` | string | yes | Celková cena objednávky s DPH - propisuje se jako hodnota k pojištění zásilky — e.g. `"100.90"` |
| `currencyCode` | string | yes | Například CZK — e.g. `"CZK"` |

### RemoveOrderTagsResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `removed_order_tags` | brani_async__infra_jobs__public_api__routers__schema__OrderTag | yes | Seznam objednávek s odebranými tagy |
| `warnings` | array of string \| null |  | Seznam varování při změně tagů |
| `errors` | array of string \| null |  | Seznam chyb při změně tagů |

### ShippingDetails

| Field | Type | Req | Notes |
|---|---|---|---|
| `branchId` | string \| null |  | ID výdejního místa, kam má být objednávka doručena — e.g. `"62"` |
| `carrierId` | string \| null |  | ID koncového přepravce, který do výdejního místa doručuje — e.g. `"62"` |

### SurchargeParameter

| Field | Type | Req | Notes |
|---|---|---|---|
| `parameterName` | SurchargeParameterName | yes |  |
| `parameterValue` | SurchargeParameterValue | yes |  |

### SurchargeParameterName

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes | Kód parametru — e.g. `"priplatek"` |
| `name` | string | yes | Název parametru — e.g. `"Příplatek"` |

### SurchargeParameterValue

| Field | Type | Req | Notes |
|---|---|---|---|
| `valueIndex` | string | yes | Index hodnoty parametru — e.g. `"fotka-s-ni"` |
| `description` | string | yes | Popis hodnoty parametru — e.g. `"Fotka s ní"` |
| `price` | string | yes | Cena příplatku — e.g. `"1000.00"` |

### brani_async__infra_jobs__public_api__orderSchema__Data

| Field | Type | Req | Notes |
|---|---|---|---|
| `creationTime` | string | yes | Datum musí bý v minulosti — e.g. `"2017-12-12T22:08:01+0100"` |
| `email` | string | yes | Email zákazníka — e.g. `"customer@someemail.com"` |
| `code` | string | yes | Unikátní kód/číslo objednávky — e.g. `"5426578"` |
| `phone` | string | yes | Telefonní číslo zákazníka — e.g. `"+420604600444"` |
| `shippingDetails` | ShippingDetails \| null |  | Doplňkové informace k doručení |
| `billingMethodCode` | BillingMethodCode \| null |  | Povolené typy jsou: 1 = Dobírka, 2 = Převodem, 3 = Hotově, 4 = Kartou |
| `paymentMethodGuid` | string \| null |  | GUID musí odpovídat platebním metodám zaslaných přes endpoint /eshop/info Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" — e.g. `"b57f91bb-e920-11e0-baa3-7dc668b75ca8"` |
| `shippingGuid` | string \| null |  | GUID musí odpovídat přepravním metodám zaslaných přes endpoint /eshop/info Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" — e.g. `"2ec88ea7-3fb0-11e2-a723-705ab6a2ba75"` |
| `paid` | boolean \| null |  | default `false` — Příznak zde je objednávka zaplacena — e.g. `"true"` |
| `companyId` | string \| null |  | Identifikační číslo společnosti (IČ) — e.g. `"123456"` |
| `vatId` | string \| null |  | VAT ID (DIČ) — e.g. `"CZ123456789"` |
| `taxId` | string \| null |  | TAX ID (IČ DPH) — e.g. `"123456"` |
| `deliveryAddress` | Address | yes | Doručovací adresa |
| `cashDeskOrder` | boolean \| null |  | default `false` — Příznak, zda byla objednávka vytvořena na pokladně — e.g. `"false"` |
| `notes` | Notes | yes | Doplńkové data k objednávce |
| `status` | brani_async__infra_jobs__public_api__orderSchema__Status \| null |  | default `{"id": 0}` — Stav objednávky |
| `billingAddress` | BillingAddress \| null | yes | Fakturační adresa |
| `price` | Price | yes | Cena objednávky |
| `adminUrl` | string \| null |  | Odkaz, kterým lze prokliknout do administrace objednávky — e.g. `"https://brani.myshoptet.com/admin/objednavky-detail?id=5426578"` |
| `items` | array of Item | yes | Položky objednávky |
| `vs` | string \| null |  | Variabilní symbol — e.g. `"123456"` |
| `externalCode` | string \| null |  | Volitelný externí identifikátor objednávky (např. číslo objednávky z BaseLinker nebo jiného systému) — e.g. `"BL-123456"` |

### brani_async__infra_jobs__public_api__orderSchema__Status

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID musí odpovídat stavům, které nám zašlete v endpointu eshop/info — e.g. `12` |

### brani_async__infra_jobs__public_api__routers__schema__OrderTag

| Field | Type | Req | Notes |
|---|---|---|---|
| `order_codes` | array of string | yes | Kód objednávky |
| `tag_id` | integer | yes | Id tagu přirazeného k objednávkam |

### newShoptetOrderModel

| Field | Type | Req | Notes |
|---|---|---|---|
| `data` | Data2 | yes | Objednávka |

### orderModel

| Field | Type | Req | Notes |
|---|---|---|---|
| `data` | brani_async__infra_jobs__public_api__orderSchema__Data | yes | Objednávka |
