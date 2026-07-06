# Eshop info

Brani API module tag: "Eshop info". Base URL `https://api.brani.cz`, Bearer auth.

## GET /eshop/info
**Ziska informace o eshope**

<p>Endpoint umožňuje získat&nbsp;<strong>stavy objedn&aacute;vek</strong>, <strong>dopravy </strong>a <strong>platebn&iacute; metody</strong>.</p> <ul> <li><strong>Stavy objedn&aacute;vek</strong> <ul> <li>ID stavu, na kter&yacute; se n&aacute;sledně bude odkazovat v objedn&aacute;vk&aacute;ch a při přep&iacute;n&aacute;n&iacute; stavů</li> <li>N&aacute;zev stavu pro zobrazen&iacute; v syst&eacute;mu</li> </ul> </li> <li><strong>Metody dopravy</strong> <ul> <li>Jsou rozděleny na velkoobchod (wholesale)&nbsp;a maloobchod (retail)</li> <li>Každ&aacute; doprava mus&iacute; obsahovat GUID a jej&iacute; n&aacute;zev</li> <li>GUID je unik&aacute;tn&iacute; identifik&aacute;tor dopravy</li> <li>Slouž&iacute; ke generov&aacute;n&iacute; přepravn&iacute;ch &scaron;t&iacute;tků a filtrov&aacute;n&iacute; objedn&aacute;vek</li> </ul> </li> <li><strong>Metody plateb</strong> <ul> <li>Jsou rozděleny na velkoobchod (wholesale)&nbsp;a maloobchod (retail)</li> <li>Každ&yacute; typ platby mus&iacute; obsahovat GUID a jej&iacute; n&aacute;zev</li> <li>GUID je unik&aacute;tn&iacute; identifik&aacute;tor platby</li> <li>Slouž&iacute; k filtrov&aacute;n&iacute; objedn&aacute;vek</li> </ul>

Response 200: **eshopInfoResponse**

## POST /eshop/info
**Aktualizuje informace o eshope**

<p>Endpoint umožňuje aktualizovat&nbsp;<strong>stavy objedn&aacute;vek</strong>, <strong>dopravy </strong>a <strong>platebn&iacute; metody</strong>.</p> <ul> <li><strong>Stavy objedn&aacute;vek</strong> <ul> <li>ID stavu, na kter&yacute; se n&aacute;sledně bude odkazovat v objedn&aacute;vk&aacute;ch a při přep&iacute;n&aacute;n&iacute; stavů</li> <li>N&aacute;zev stavu pro zobrazen&iacute; v syst&eacute;mu</li> </ul> </li> <li><strong>Metody dopravy</strong> <ul> <li>Jsou rozděleny na velkoobchod (wholesale)&nbsp;a maloobchod (retail)</li> <li>Každ&aacute; doprava mus&iacute; obsahovat GUID a jej&iacute; n&aacute;zev</li> <li>GUID je unik&aacute;tn&iacute; identifik&aacute;tor dopravy</li> <li>Slouž&iacute; ke generov&aacute;n&iacute; přepravn&iacute;ch &scaron;t&iacute;tků a filtrov&aacute;n&iacute; objedn&aacute;vek</li> </ul> </li> <li><strong>Metody plateb</strong> <ul> <li>Jsou rozděleny na velkoobchod (wholesale)&nbsp;a maloobchod (retail)</li> <li>Každ&yacute; typ platby mus&iacute; obsahovat GUID a jej&iacute; n&aacute;zev</li> <li>GUID je unik&aacute;tn&iacute; identifik&aacute;tor platby</li> <li>Slouž&iacute; k filtrov&aacute;n&iacute; objedn&aacute;vek</li> </ul>

Request body (application/json): **eshopModel** — see Schemas below

---

## Schemas

### Data-Output

| Field | Type | Req | Notes |
|---|---|---|---|
| `orderStatuses` | OrderStatuses-Output | yes | Stavy objednávek |
| `shippingMethods` | ShippingMethods-Output | yes | Metody doprav |
| `paymentMethods` | PaymentMethods-Output | yes | Metody plateb |

### OrderStatuses-Input

| Field | Type | Req | Notes |
|---|---|---|---|
| `statuses` | array of brani_async__infra_jobs__public_api__eshopInfoSchema__Status | yes | Dostupné stavy na eshopu — e.g. `[{"id": -1, "name": "Zabaleno"}, {"id": -2, "name": "K expedici"}]` |

### OrderStatuses-Output

| Field | Type | Req | Notes |
|---|---|---|---|
| `statuses` | array of Status-Output | yes | Dostupné stavy na eshopu — e.g. `[{"id": -1, "name": "Zabaleno"}, {"id": -2, "name": "K expedici"}]` |

### PaymentMethod

| Field | Type | Req | Notes |
|---|---|---|---|
| `guid` | string | yes | Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" |
| `name` | string | yes | Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" |

### PaymentMethods-Input

| Field | Type | Req | Notes |
|---|---|---|---|
| `retail` | RetailPayment | yes | Pro maloobchod |
| `wholesale` | WholesalPayment | yes | Pro velkoobchod |

### PaymentMethods-Output

| Field | Type | Req | Notes |
|---|---|---|---|
| `retail` | RetailPayment | yes | Pro maloobchod |
| `wholesale` | WholesalPayment | yes | Pro velkoobchod |

### ResponseEshop
Base model for eshop in API response

| Field | Type | Req | Notes |
|---|---|---|---|
| `eshop_id` | integer | yes | ID eshopu |
| `eshop_name` | string | yes | Název eshopu |
| `eshop_url` | string | yes | URL eshopu |
| `enabled` | boolean | yes | Zda je Balič tohoto eshopu povolen |

### ResponseEshopWithMultiEshop
Model for secondary eshop in API response

| Field | Type | Req | Notes |
|---|---|---|---|
| `eshop_id` | integer | yes | ID eshopu |
| `eshop_name` | string | yes | Název eshopu |
| `eshop_url` | string | yes | URL eshopu |
| `enabled` | boolean | yes | Zda je Balič tohoto eshopu povolen |
| `multieshop_id` | integer \| null |  | ID multieshopu, pokud existuje |
| `is_shoptet` | boolean | yes | Zda je eshop typu Shoptet |

### ResponseEshopWithWarehouse
Model for eshop with warehouse in API response

| Field | Type | Req | Notes |
|---|---|---|---|
| `eshop_id` | integer | yes | ID eshopu |
| `eshop_name` | string | yes | Název eshopu |
| `eshop_url` | string | yes | URL eshopu |
| `enabled` | boolean | yes | Zda je Balič tohoto eshopu povolen |
| `multieshop_id` | integer \| null |  | ID multieshopu, pokud existuje |
| `is_shoptet` | boolean | yes | Zda je eshop typu Shoptet |
| `warehouse` | ResponseWarehouse \| null |  | Konfigurace skladu, pokud existuje |

### ResponseSecondaryMultieshop
Model for multieshop in API response

| Field | Type | Req | Notes |
|---|---|---|---|
| `multieshop_id` | integer | yes | ID multieshopu |
| `eshops` | array of ResponseEshop |  | Seznam eshopů v multieshopu |

### ResponseWarehouse
Model for warehouse in API response

| Field | Type | Req | Notes |
|---|---|---|---|
| `eshop_id` | integer | yes | ID eshopu |
| `eshop_name` | string | yes | Název eshopu |
| `eshop_url` | string | yes | URL eshopu |
| `enabled` | boolean | yes | Zda je Balič tohoto eshopu povolen |
| `activated_at` | string | yes | Datum aktivace skladu |
| `mode` | string | yes | Režim skladu |
| `secondary_eshops` | array of ResponseEshopWithMultiEshop |  | Seznam sekundárních eshopů, které tento sklad obsluhuje |
| `secondary_multieshops` | array of ResponseSecondaryMultieshop |  | Seznam multieshopů, které tento sklad obsluhuje |

### RetailPayment

| Field | Type | Req | Notes |
|---|---|---|---|
| `methods` | array of PaymentMethod | yes | Seznam metod plateb — e.g. `[{"guid": "08962fe8-ea34-4f69-be75-b62ef1dcac2f", "name": "Dobírka"}]` |

### RetailShipping

| Field | Type | Req | Notes |
|---|---|---|---|
| `methods` | array of ShippingMethod | yes | Seznam metod doprav — e.g. `[{"guid": "6d33d5bc-0b65-4284-9c1a-dcd7a4f4d31c", "name": "Česká pošta"}]` |

### ShippingMethod

| Field | Type | Req | Notes |
|---|---|---|---|
| `guid` | string | yes | Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" |
| `name` | string | yes | Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" |

### ShippingMethods-Input

| Field | Type | Req | Notes |
|---|---|---|---|
| `retail` | RetailShipping | yes | Pro maloobchod |
| `wholesale` | WholesalShipping | yes | Pro velkoobchod |

### ShippingMethods-Output

| Field | Type | Req | Notes |
|---|---|---|---|
| `retail` | RetailShipping | yes | Pro maloobchod |
| `wholesale` | WholesalShipping | yes | Pro velkoobchod |

### Status-Output

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID stavu |
| `name` | string | yes | Název stavu |

### WholesalPayment

| Field | Type | Req | Notes |
|---|---|---|---|
| `methods` | array of PaymentMethod | yes | Seznam metod plateb — e.g. `[{"guid": "e8827deb-61c0-42a2-afb2-2efae1cd5dcb", "name": "Kartou"}, {"guid": "4` |

### WholesalShipping

| Field | Type | Req | Notes |
|---|---|---|---|
| `methods` | array of ShippingMethod | yes | Seznam metod doprav — e.g. `[{"guid": "b25900f3-5f0e-46f8-b5ff-114b598d340f", "name": "PPL VO"}]` |

### brani_async__infra_jobs__public_api__eshopInfoSchema__Data-Input

| Field | Type | Req | Notes |
|---|---|---|---|
| `orderStatuses` | OrderStatuses-Input | yes | Stavy objednávek |
| `shippingMethods` | ShippingMethods-Input | yes | Metody doprav |
| `paymentMethods` | PaymentMethods-Input | yes | Metody plateb |

### brani_async__infra_jobs__public_api__eshopInfoSchema__Status

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | ID stavu |
| `name` | string | yes | Název stavu |

### eshopInfoResponse
API response model for eshop info

| Field | Type | Req | Notes |
|---|---|---|---|
| `data` | Data-Output | yes | Info o eshopu |
| `summary` | ResponseEshopWithWarehouse | yes | Obsahuje základní informace o eshopu a případně jeho skladu |

### eshopModel

| Field | Type | Req | Notes |
|---|---|---|---|
| `data` | brani_async__infra_jobs__public_api__eshopInfoSchema__Data-Input | yes | Info o eshopu |
