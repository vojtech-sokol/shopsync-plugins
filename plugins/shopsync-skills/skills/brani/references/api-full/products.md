# Products (snapshots, single product CRUD)

Brani API module tag: "Brani sprava produktu". Base URL `https://api.brani.cz`, Bearer auth.

## POST /products/snapshots/import
**Import snapshotu produktu**

Importuje snapshot produktů z gzipped JSONL souboru. Tento endpoint přijímá soubor obsahující seznam produktů ve formátu gzipped JSONL, kde každý produkt musí odpovídat schématu `ProductSchema` (stejný jako u endpointu `upsert_product`). Funkce provádí validaci každého záznamu a v případě nalezení chyb vrací seznam problémových řádků s podrobnými informacemi o chybách. Pokud je soubor validní a neobsahuje žádné chyby, je nahrán na vzdálené úložiště a následně je vytvořen nový synchronizační úkol (snapshot job), který bude asynchronně zpracováván. Po přidání tohoto úkolu do fronty můžete stav aktuálního zpracování sledovat pomocí endpointu `GET /snapshots/`.

Request body (multipart/form-data): **Body_import_snapshot_products_snapshots_import_post** — see Schemas below

## GET /products/snapshots
**Seznam snapshot jobů**

Response 200: **array of SnapshotJob**

## GET /products/snapshots/download/{id}
**Stáhnout snapshot**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `id` | path | string | yes |  |

## DELETE /products/{guid}
**Smazat produkt dle GUID**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `guid` | path | string | yes |  |

## GET /products/{guid}
**Detail produktu**

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `guid` | path | string | yes |  |

Response 200: **brani_async__infra_jobs__public_api__schemas__products__Product-Output | shoptet_schemas__product__Product**

## POST /products/
**Vytvořit/editovat produkt**

Request body (application/json): **Product-Input** — see Schemas below

## GET /products/list
**Seznam produktů**

Vrátí seznam produktů s jejich GUID a vnořenou strukturou kódů.

---

## Schemas

### ActionPrice
Cena v akci.

| Field | Type | Req | Notes |
|---|---|---|---|
| `price` | number | yes |  |
| `fromDate` | string \| null |  |  |
| `toDate` | string \| null |  |  |

### AvailabilityShort
Krátká informace o dostupnosti.

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes |  |
| `name` | string | yes |  |

### Body_import_snapshot_products_snapshots_import_post

| Field | Type | Req | Notes |
|---|---|---|---|
| `file` | string | yes |  |

### Brand

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string \| null |  |  |
| `name` | string \| null |  |  |

### BrandNamed
Značka produktu.

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes |  |
| `name` | string | yes |  |

### Category
Kategorie produktu.

| Field | Type | Req | Notes |
|---|---|---|---|
| `guid` | string \| null |  |  |
| `name` | string | yes |  |
| `parentGuid` | string \| null |  |  |

### DefaultCategory
Výchozí kategorie produktu.

| Field | Type | Req | Notes |
|---|---|---|---|
| `guid` | string \| null |  |  |
| `name` | string \| null |  |  |
| `visible` | boolean \| null |  |  |

### DescriptiveParameter
Popisný parametr.

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string | yes |  |
| `value` | string \| null |  |  |
| `description` | string \| null |  |  |
| `priority` | integer \| null |  |  |

### FilteringParameter
Filtrovací parametr.

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes |  |
| `name` | string | yes |  |
| `displayName` | string \| null |  |  |
| `description` | string \| null |  |  |
| `priority` | integer \| null |  |  |
| `googleMapping` | GoogleMappingType \| null |  |  |
| `values` | array of FilteringParameterValue | yes |  |

### FilteringParameterValue
Hodnota filtrovacího parametru.

| Field | Type | Req | Notes |
|---|---|---|---|
| `valueIndex` | string \| null |  |  |
| `name` | string | yes |  |
| `priority` | integer \| null |  |  |
| `color` | string \| null |  |  |
| `image` | string \| null |  |  |

### Flag
Příznak produktu.

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes |  |
| `title` | string | yes |  |
| `dateFrom` | string \| null |  |  |
| `dateTo` | string \| null |  |  |

### GoogleMappingType
Mapování pro Google.

| Field | Type | Req | Notes |
|---|---|---|---|
| `value` | string | yes |  |
| `description` | string \| null |  |  |

### Image-Input

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string | yes | Název souboru — e.g. `"69671-3.jpg"` |
| `url` | string | yes | URL obrázku — e.g. `"https://cdn.myshoptet.com/usr/brani.myshoptet.com/user/shop/big/37_37-kos-odpad` |
| `description` | string \| null |  | Popis obrázku |

### MeasureUnit
Měrná jednotka.

| Field | Type | Req | Notes |
|---|---|---|---|
| `packagingUnitId` | integer \| null |  |  |
| `packagingUnitName` | string \| null |  |  |
| `packagingAmount` | string \| null |  |  |
| `measureUnitId` | integer \| null |  |  |
| `measureUnitName` | string \| null |  |  |
| `measureAmount` | string \| null |  |  |
| `measurePrice` | string \| null |  |  |

### PerPricelistPrice
Ceny dle ceníků.

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes |  |
| `currencyCode` | string | yes |  |
| `includingVat` | boolean | yes |  |
| `vatRate` | string | yes |  |
| `price` | shoptet_schemas__product__VariantPrice | yes |  |
| `sales` | PriceSales | yes |  |
| `orderableAmount` | ProductOrderableAmount | yes |  |
| `pricelistId` | integer | yes |  |

### PerStockAmount
Množství na skladu.

| Field | Type | Req | Notes |
|---|---|---|---|
| `stockId` | integer | yes |  |
| `amount` | string \| null |  |  |
| `claim` | string \| null |  |  |
| `location` | string \| null |  |  |
| `lastAmountUpdate` | string \| null |  |  |

### PriceSales
Prodejní nastavení ceny.

| Field | Type | Req | Notes |
|---|---|---|---|
| `minPriceRatio` | string | yes |  |
| `freeShipping` | boolean | yes |  |
| `freeBilling` | boolean | yes |  |
| `loyaltyDiscount` | boolean | yes |  |
| `volumeDiscount` | boolean | yes |  |
| `quantityDiscount` | boolean | yes |  |
| `discountCoupon` | boolean | yes |  |

### Product-Input

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string | yes | Název produktu — e.g. `"Chytré Hodinky"` |
| `guid` | string | yes | Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" |
| `creationTime` | string | yes | Datum vytvoření produktu — e.g. `"2024-02-15T12:00:00+01:00"` |
| `changeTime` | string |  | Datum poslední změny produktu — e.g. `"2024-02-15T15:30:00+01:00"` |
| `brand` | Brand \| null |  |  |
| `additionalName` | string \| null |  |  |
| `visibility` | string | yes |  |
| `type` | ProductType \| null |  |  |
| `internalNote` | string \| null |  |  |
| `images` | array of Image-Input \| null |  |  |
| `setItems` | array of SetItem-Input \| null |  |  |
| `variants` | array of Variant-Input | yes |  |

### ProductConsumptionTax
Spotřební daň produktu.

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes |  |
| `name` | string | yes |  |
| `price` | string | yes |  |
| `currency` | string | yes |  |

### ProductGift
Dárek k produktu.

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes |  |
| `priority` | integer | yes |  |

### ProductOrderableAmount
Objednatelné množství.

| Field | Type | Req | Notes |
|---|---|---|---|
| `minimumAmount` | string \| null |  |  |
| `maximumAmount` | string \| null |  |  |

### ProductSurchargeParameter
Příplatkový parametr.

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes |  |
| `name` | string | yes |  |
| `displayName` | string \| null |  |  |
| `description` | string \| null |  |  |
| `priority` | integer \| null |  |  |
| `required` | boolean | yes |  |
| `currency` | string | yes |  |
| `includingVat` | boolean | yes |  |
| `values` | array of ProductSurchargeParameterValue | yes |  |

### ProductSurchargeParameterValue
Hodnota příplatkového parametru.

| Field | Type | Req | Notes |
|---|---|---|---|
| `valueIndex` | string | yes |  |
| `description` | string | yes |  |
| `price` | string \| null |  |  |
| `priority` | integer \| null |  |  |
| `visible` | boolean | yes |  |

### ProductType
Enum: `product`, `bazar`, `service`, `gift-certificate`, `product-set`

### RecyclingFeeCategory
Kategorie recyklačního poplatku.

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes |  |
| `category` | string | yes |  |
| `fee` | string | yes |  |
| `unit` | string | yes | enum: pcs, kg |
| `currency` | string | yes |  |

### RelatedFile
Související soubor.

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string \| null |  |  |
| `url` | string | yes |  |
| `size` | integer \| null |  |  |

### RelatedProduct
Související produkt.

| Field | Type | Req | Notes |
|---|---|---|---|
| `guid` | string | yes |  |
| `priority` | integer | yes |  |
| `visibility` | string | yes |  |
| `linkType` | string | yes |  |

### RelatedVideo
Související video.

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes |  |
| `title` | string \| null |  |  |
| `type` | string | yes | enum: youtube, youtube-short |

### SetItem-Input

| Field | Type | Req | Notes |
|---|---|---|---|
| `guid` | string | yes | Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" |
| `code` | string | yes | Kód produktu v sadě — e.g. `"0001"` |
| `amount` | string | yes | pattern `^\d+\.\d{3}$` — String representing a number with exactly three decimal places — e.g. `"3.000"` |

### SnapshotJob

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes |  |
| `status` | string | yes |  |
| `added_at` | string | yes | Added At |
| `started_at` | string \| null |  | Started At |
| `completed_at` | string \| null |  | Completed At |
| `log` | object \| null |  |  |

### Variant-Input

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes | Kód produktu — e.g. `"0001"` |
| `name` | string \| null |  | Název varianty — e.g. `"Chytré Hodinky 44mm"` |
| `weight` | string | yes | pattern `^\d+\.\d{3}$` — String representing a number with exactly three decimal places — e.g. `"0.459"` |
| `minStockSupply` | string \| null |  | Množství minimální zásoby, pod kterou by se produkt neměl dostat. — e.g. `"1.000"` |
| `visible` | boolean |  | default `true` — Varianta viditelná na eshopu |
| `manufacturerCode` | string \| null |  | Unikátní identifikátor výrobce, použitelný zejména ve vnitřních informačních systémech. |
| `pluCode` | string \| null |  | PLU kód je určen především jako další identifikace výrobku v interních informačních systémech, při prodeji nebo ke skladovým účelům a inventurám. Tento kód se také používá pro ty výrobky které ještě EAN kód nemají přidělený. |
| `ean` | string \| null |  | EAN kód je jednotný mezinárodní identifikátor kódu spotřebního zboží. |
| `isbn` | string \| null |  | ISBN kód je číselný kód určený pro jednoznačnou identifikaci knižních vydání. |
| `serialNo` | string \| null |  | Unikátní identifikátor produktu, použitelný zejména ve vnitřních informačních systémech. |
| `mpn` | string \| null |  | Číslo dílu výrobce (MPN) |
| `negativeStockAllowed` | string |  | default `"no"` — Povolen nákup do mínusu — e.g. `"yes"` |
| `image` | string \| null |  | URL obrázku varianty. Musí být uveden i v seznamu obrázku celého produktu — e.g. `"https://cdn.myshoptet.com/usr/brani.myshoptet.com/user/shop/big/37_37-kos-odpad` |
| `amountDecimalPlaces` | integer \| null |  | default `0` — Položky, které jsou prodávány typicky v jiných jednotkách než ks, jako jsou např. metry, mohou být nakoupeny i v necelém množství. Zde definujete počet možných desetinných míst. |
| `price` | VariantPrice-Input \| null |  |  |

### VariantParameter
Parametr varianty.

| Field | Type | Req | Notes |
|---|---|---|---|
| `paramName` | string \| null |  |  |
| `paramIndex` | string | yes |  |
| `paramValue` | string | yes |  |
| `displayName` | string \| null |  |  |
| `rawValue` | string \| null |  |  |
| `color` | string \| null |  |  |
| `image` | string \| null |  |  |
| `valuePriority` | integer | yes |  |

### VariantPrice-Input

| Field | Type | Req | Notes |
|---|---|---|---|
| `vatRate` | number \| string \| null |  | Sazba DPH v procentech (např. 21.0) — e.g. `21.0` |
| `price` | number \| string \| null |  | Prodejní cena s DPH — e.g. `1299.9` |
| `commonPrice` | number \| string \| null |  | Běžná/doporučená prodejní cena — e.g. `1499.0` |
| `buyPrice` | number \| string \| null |  | Nákupní cena bez DPH — e.g. `899.0` |

### Warranty
Záruka.

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes |  |
| `inMonths` | integer \| null |  |  |
| `description` | string | yes |  |

### ZboziCZ
Nastavení pro Zboží.cz.

| Field | Type | Req | Notes |
|---|---|---|---|
| `maximalCPC` | string \| null |  |  |
| `maximalSearchCPC` | string \| null |  |  |
| `hidden` | boolean \| null |  |  |

### brani_async__infra_jobs__public_api__schemas__products__Image

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string | yes | Název souboru — e.g. `"69671-3.jpg"` |
| `url` | string | yes | URL obrázku — e.g. `"https://cdn.myshoptet.com/usr/brani.myshoptet.com/user/shop/big/37_37-kos-odpad` |
| `description` | string \| null |  | Popis obrázku |

### brani_async__infra_jobs__public_api__schemas__products__Product-Output

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string | yes | Název produktu — e.g. `"Chytré Hodinky"` |
| `guid` | string | yes | Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" |
| `creationTime` | string | yes | Datum vytvoření produktu — e.g. `"2024-02-15T12:00:00+01:00"` |
| `changeTime` | string |  | Datum poslední změny produktu — e.g. `"2024-02-15T15:30:00+01:00"` |
| `brand` | Brand \| null |  |  |
| `additionalName` | string \| null |  |  |
| `visibility` | string | yes |  |
| `type` | ProductType \| null |  |  |
| `internalNote` | string \| null |  |  |
| `images` | array of brani_async__infra_jobs__public_api__schemas__products__Image \| null |  |  |
| `setItems` | array of brani_async__infra_jobs__public_api__schemas__products__Product__SetItem \| null |  |  |
| `variants` | array of brani_async__infra_jobs__public_api__schemas__products__Variant-Output | yes |  |

### brani_async__infra_jobs__public_api__schemas__products__Product__SetItem

| Field | Type | Req | Notes |
|---|---|---|---|
| `guid` | string | yes | Může být buď UUID řetězec nebo číselné ID (které bude převedeno na UUID formát doplněný nulami zleva). Příklad: "12345" bude převedeno na "00000000-0000-0000-0000-000000012345" |
| `code` | string | yes | Kód produktu v sadě — e.g. `"0001"` |
| `amount` | string | yes | pattern `^\d+\.\d{3}$` — String representing a number with exactly three decimal places — e.g. `"3.000"` |

### brani_async__infra_jobs__public_api__schemas__products__Variant-Output

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes | Kód produktu — e.g. `"0001"` |
| `name` | string \| null |  | Název varianty — e.g. `"Chytré Hodinky 44mm"` |
| `weight` | string | yes | pattern `^\d+\.\d{3}$` — String representing a number with exactly three decimal places — e.g. `"0.459"` |
| `minStockSupply` | string \| null |  | Množství minimální zásoby, pod kterou by se produkt neměl dostat. — e.g. `"1.000"` |
| `visible` | boolean |  | default `true` — Varianta viditelná na eshopu |
| `manufacturerCode` | string \| null |  | Unikátní identifikátor výrobce, použitelný zejména ve vnitřních informačních systémech. |
| `pluCode` | string \| null |  | PLU kód je určen především jako další identifikace výrobku v interních informačních systémech, při prodeji nebo ke skladovým účelům a inventurám. Tento kód se také používá pro ty výrobky které ještě EAN kód nemají přidělený. |
| `ean` | string \| null |  | EAN kód je jednotný mezinárodní identifikátor kódu spotřebního zboží. |
| `isbn` | string \| null |  | ISBN kód je číselný kód určený pro jednoznačnou identifikaci knižních vydání. |
| `serialNo` | string \| null |  | Unikátní identifikátor produktu, použitelný zejména ve vnitřních informačních systémech. |
| `mpn` | string \| null |  | Číslo dílu výrobce (MPN) |
| `negativeStockAllowed` | string |  | default `"no"` — Povolen nákup do mínusu — e.g. `"yes"` |
| `image` | string \| null |  | URL obrázku varianty. Musí být uveden i v seznamu obrázku celého produktu — e.g. `"https://cdn.myshoptet.com/usr/brani.myshoptet.com/user/shop/big/37_37-kos-odpad` |
| `amountDecimalPlaces` | integer \| null |  | default `0` — Položky, které jsou prodávány typicky v jiných jednotkách než ks, jako jsou např. metry, mohou být nakoupeny i v necelém množství. Zde definujete počet možných desetinných míst. |
| `price` | brani_async__infra_jobs__public_api__schemas__products__VariantPrice-Output \| null |  |  |

### brani_async__infra_jobs__public_api__schemas__products__VariantPrice-Output

| Field | Type | Req | Notes |
|---|---|---|---|
| `vatRate` | string \| null |  | Sazba DPH v procentech (např. 21.0) — e.g. `21.0` |
| `price` | string \| null |  | Prodejní cena s DPH — e.g. `1299.9` |
| `commonPrice` | string \| null |  | Běžná/doporučená prodejní cena — e.g. `1499.0` |
| `buyPrice` | string \| null |  | Nákupní cena bez DPH — e.g. `899.0` |

### shoptet_schemas__product__Image
Obrázek produktu.

| Field | Type | Req | Notes |
|---|---|---|---|
| `name` | string | yes |  |
| `seoName` | string | yes |  |
| `cdnName` | string | yes |  |
| `priority` | integer \| null |  |  |
| `description` | string \| null |  |  |
| `changeTime` | string \| null |  |  |
| `isMainImage` | boolean | yes |  |

### shoptet_schemas__product__Product
Pydantic schéma pro detail produktu podle OpenAPI specifikace.

| Field | Type | Req | Notes |
|---|---|---|---|
| `guid` | string | yes |  |
| `type` | string | yes |  |
| `name` | string \| null |  |  |
| `brand` | BrandNamed \| null |  |  |
| `supplier` | shoptet_schemas__product__Supplier \| null |  |  |
| `visibility` | string | yes |  |
| `creationTime` | string \| null |  |  |
| `changeTime` | string \| null |  |  |
| `shortDescription` | string \| null |  |  |
| `description` | string \| null |  |  |
| `metaDescription` | string \| null |  |  |
| `url` | string \| null |  |  |
| `conditionGrade` | string \| null |  |  |
| `conditionDescription` | string \| null |  |  |
| `internalNote` | string \| null |  |  |
| `preauthorizationRequired` | boolean | yes |  |
| `defaultCategory` | DefaultCategory | yes |  |
| `categories` | array of Category | yes |  |
| `descriptiveParameters` | array of DescriptiveParameter |  |  |
| `additionalName` | string \| null |  |  |
| `xmlFeedName` | string \| null |  |  |
| `metaTitle` | string | yes |  |
| `adult` | boolean | yes |  |
| `allowIPlatba` | boolean | yes |  |
| `allowOnlinePayments` | boolean | yes |  |
| `sizeIdName` | string \| null |  |  |
| `voteAverageScore` | string \| null |  |  |
| `voteCount` | integer \| null |  |  |
| `isVariant` | boolean | yes |  |
| `variants` | array of shoptet_schemas__product__Variant | yes |  |
| `images` | array of shoptet_schemas__product__Image | yes |  |
| `flags` | array of Flag | yes |  |
| `surchargeParameters` | array of ProductSurchargeParameter |  |  |
| `setItems` | array of shoptet_schemas__product__SetItem \| null |  |  |
| `filteringParameters` | array of FilteringParameter |  |  |
| `warranty` | Warranty \| null |  |  |
| `gifts` | array of ProductGift \| null |  |  |
| `alternativeProducts` | array of RelatedProduct \| null |  |  |
| `relatedProducts` | array of RelatedProduct \| null |  |  |
| `relatedFiles` | array of RelatedFile |  |  |
| `relatedVideos` | array of RelatedVideo |  |  |

### shoptet_schemas__product__SetItem
Položka v setu.

| Field | Type | Req | Notes |
|---|---|---|---|
| `guid` | string | yes |  |
| `code` | string | yes |  |
| `amount` | string | yes |  |

### shoptet_schemas__product__Supplier
Dodavatel produktu.

| Field | Type | Req | Notes |
|---|---|---|---|
| `guid` | string | yes |  |
| `name` | string | yes |  |

### shoptet_schemas__product__Variant
Varianta produktu.

| Field | Type | Req | Notes |
|---|---|---|---|
| `code` | string | yes |  |
| `ean` | string \| null |  |  |
| `stock` | string \| null |  |  |
| `unit` | string \| null |  |  |
| `weight` | string \| null |  |  |
| `width` | string \| null |  |  |
| `height` | string \| null |  |  |
| `depth` | string \| null |  |  |
| `visible` | boolean | yes |  |
| `price` | string \| null |  |  |
| `commonPrice` | string \| null |  |  |
| `manufacturerCode` | string \| null |  |  |
| `pluCode` | string \| null |  |  |
| `isbn` | string \| null |  |  |
| `serialNo` | string \| null |  |  |
| `mpn` | string \| null |  |  |
| `includingVat` | boolean | yes |  |
| `vatRate` | string | yes |  |
| `currencyCode` | string | yes |  |
| `minStockSupply` | string \| null |  |  |
| `actionPrice` | ActionPrice \| null |  |  |
| `image` | string \| null |  |  |
| `isProductDefaultImage` | boolean | yes |  |
| `name` | string \| null |  |  |
| `amountDecimalPlaces` | integer | yes |  |
| `parameters` | array of VariantParameter \| null |  |  |
| `measureUnit` | MeasureUnit \| null |  |  |
| `availability` | AvailabilityShort \| null |  |  |
| `availabilityWhenSoldOut` | AvailabilityShort \| null |  |  |
| `negativeStockAllowed` | string | yes | enum: yes-global, no-global, yes |
| `recyclingFee` | RecyclingFeeCategory \| null |  |  |
| `consumptionTax` | ProductConsumptionTax \| null |  |  |
| `heurekaCPC` | string \| null |  |  |
| `zboziCZ` | ZboziCZ \| null |  |  |
| `atypicalBilling` | boolean | yes |  |
| `atypicalShipping` | boolean | yes |  |
| `perStockAmounts` | array of PerStockAmount \| null |  |  |
| `perPricelistPrices` | array of PerPricelistPrice \| null |  |  |
| `url` | string \| null |  |  |

### shoptet_schemas__product__VariantPrice
Cena varianty v ceníku.

| Field | Type | Req | Notes |
|---|---|---|---|
| `price` | string \| null |  |  |
| `commonPrice` | string \| null |  |  |
| `buyPrice` | string \| null |  |  |
| `priceRatio` | string | yes |  |
| `actionPrice` | ActionPrice \| null |  |  |
