# Money S4 / S5 - DB Reference

SQL Server. Most shopsync queries go through the `CSW_EObchod_*` and `CSW_EObchodPlus_*` **views** - they are the vendor-supplied e-shop integration layer and the safest read surface. The views don't cover everything though - in practice the loaders also pull from underlying base tables (`Artikly_*`, `Adresar_*`, `Objednavky_*`, `Sklady_*`, `Ciselniky_*`, `CSWBA_EShop_*`) whenever a column isn't exposed by a view. Reach for a base table only when a view doesn't carry what you need.

> Reference dump: `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys4_s5\db_schema.sql` (~11.5k lines, **UTF-16** SQL Server dump). **Curated subset**, not the full schema - it contains the important e-shop-integration views and the tables the integration touches, but a live Money DB has many more objects. If you need a table that isn't in the file, query the live DB (`sp_columns <name>` / `INFORMATION_SCHEMA.COLUMNS`) or ask the user. The vendor functional / implementation specs in the same folder describe each view and column.

All queries qualify with `[<set_dbfile>].[dbo].<name>`. Every loader's `$select` accepts these placeholders:

- `[last]` → `getSQLDate(strtotime($this->last_update))` for incremental sync
- `[shop_id]` → `$this->shop_id` (GUID of the `CSW_EObchod_Obchod` row representing this e-shop)
- `[filter]` → `and (<expr>)` when `$this->filter` is set, otherwise empty

## The `CSW_EObchod_*` view catalog

Standard (base) e-shop integration views.

### Products / catalog

| View | Purpose | Key columns |
|---|---|---|
| `CSW_EObchod_Artikl` | Product / store-card master | `ID`, `Katalog`, `Kod`, `Nazev`, `Zkratka20`, `CarovyKod` (EAN), `NadrazenyArtikl_ID` (variant parent), `Vyrobce_Firma_ID`, `VlastniHmotnost`, `Delka`/`Sirka`/`Vyska`, `Create_Date`/`Modify_Date`, `Deleted`/`Hidden` |
| `CSW_EObchod_ObchodArtikl` | Which products belong to which e-shop instance | `Artikl_ID`, `Parent_ID` (= `Obchod.ID` = your `$shop_id`) |
| `CSW_EObchod_Obchod` | The e-shop instance records | `ID` (this is the GUID you put into `$shop_id`) |
| `CSW_EObchod_Vyrobce` | Manufacturers (joined to `CSW_EObchod_Artikl.Vyrobce_Firma_ID`) | `ID`, `Nazev` |
| `CSW_EObchod_Kategorie` | Category tree | `ID`, `Kod`, `Nazev`, `NadrazenaKategorie_ID` (parent ID = root the tree) |
| `CSW_EObchod_ArtiklKategorie` | Product ↔ category linking | `Parent_ID` (= `Artikl.ID`), `Kategorie_ID` |
| `CSW_EObchod_Parametr` | Parameter definitions (visible name) | `ID`, `Kod`, `Nazev` |
| `CSW_EObchod_KategorieParametr` | Which parameters belong to which category | `Parent_ID`, `Parametr_ID` |
| `CSW_EObchod_HodnotaParametru` | List-of-values parameter values | `Parent_ID`, `Nazev` |
| `CSW_EObchod_ArtiklParametr` | Product ↔ parameter ↔ value | `Parent_ID` (= `Artikl.ID`), `Parametr_ID`, `TextovaHodnota` |
| `CSW_EObchod_ArtiklJednotka` | Units (ks/kg/...) per product | `Parent_ID`, `Jednotka` |
| `CSW_EObchod_ArtiklAlternativa` | Alternatives | `Parent_ID`, `Artikl_ID` |
| `CSW_EObchod_ArtiklPrislusenstvi` | Accessories | `Celek_ID`, `Prvek_ID` |
| `CSW_EObchod_ArtiklSlozeni` | Bundles / kits | `Celek_ID`, `Prvek_ID`, `PocetPrvek` |
| `CSW_EObchod_StavArtiklu` | Product state (active / new / clearance / ...) | `Parent_ID`, `Stav_ID` |
| `CSW_EObchod_ArtiklStavArtiklu` | Product ↔ state link | `Parent_ID`, `StavArtiklu_ID` |
| `CSW_EObchod_ArtiklDPH` | VAT rate per product | `Parent_ID`, `Sazba` |
| `CSW_EObchod_Ident` | Identification codes / OKEČ / Intrastat / ... | `Parent_ID` |
| `CSW_EObchod_PolozkaCeniku` | Price-list rows (per product per pricelist) | `Artikl_ID`, `Cenik_ID`, `Cena`, `Mena_ID`, `Modify_Date` |
| `CSW_EObchod_PolozkaCenikuMnozstevniSleva` | Quantity discounts per pricelist row | `Parent_ID`, `Mnozstvi`, `Sleva` |
| `CSW_EObchod_PolozkaCenikuCenovaHladina` | Pricelist row ↔ customer price level | `Parent_ID`, `CenovaHladina_ID` |
| `CSW_EObchod_Cenik` | Pricelist headers | `ID`, `Kod`, `Nazev`, `Mena_ID`, `TypCeniku_ID` |
| `CSW_EObchod_TypCeniku` | Pricelist types (`Standardni`, `Akcni`, ...) | `ID`, `Kod` |
| `CSW_EObchod_CenovaHladina` | Customer price levels (B2B groups) | `ID`, `Kod`, `Nazev` |
| `CSW_EObchod_CenovaHladinaMnozstevniSleva` | Volume discount on a price level | `Parent_ID`, `Mnozstvi`, `Sleva` |

### Stock

| View | Purpose | Key columns |
|---|---|---|
| `CSW_EObchod_Zasoba` | Stock per product per warehouse | `Artikl_ID`, `Sklad_ID`, `ZustatekMnozstvi`, `Rezervovano`, `PredpokladaneMnozstvi`, `Modify_Date` |
| `CSW_EObchod_Sklad` | Warehouses | `ID`, `Kod`, `Nazev` |

### Customers / address book

| View | Purpose | Key columns |
|---|---|---|
| `CSW_EObchod_Zakaznik` | E-shop customers (b2c + b2b) | `ID`, `Email`, `IC`, `DIC` |
| `CSW_EObchod_ZakaznikOsoba` | Contact persons | `Parent_ID`, `Jmeno`, `Prijmeni` |
| `CSW_EObchod_ZakaznikCenovaHladina` | Which price level a customer is in | `Parent_ID`, `CenovaHladina_ID` |
| `CSW_EObchod_ZakaznikCenik` | Which pricelist a customer sees | `Parent_ID`, `Cenik_ID` |
| `CSW_EObchod_ZakaznikAdresniKlic` | Customer ↔ address linking | `Parent_ID`, `AdresniKlic_ID` |
| `CSW_EObchod_AdresniKlic` | Address records | `ID`, `Nazev`, `Ulice`, `Misto`, `KodPsc`, `Stat_ID` |
| `CSW_EObchod_OsobaAdresniKlic` | Person ↔ address linking | `Parent_ID`, `AdresniKlic_ID` |
| `CSW_EObchod_Spojeni` | Contacts (email / phone / ...) | `Parent_ID`, `SpojeniCislo`, `TypSpojeni_ID` |

### Documents

| View | Purpose | Key columns |
|---|---|---|
| `CSW_EObchod_Objednavka` | Received order (header) | `ID`, `Odkaz` (your shop reference), `Faze`, `Stav`, `Storno`, `Mena_ID`, `Group_ID` |
| `CSW_EObchod_ObjednavkaPolozka` | Order lines | `Parent_ID` (= `Objednavka.ID`), `Artikl_ID`, `Mnozstvi`, `JednCena`, `JednCenaCM`, `Sleva` |
| `CSW_EObchod_Faktura` | Issued / received invoice | `ID`, `Odkaz`, `DatumVystaveni` |
| `CSW_EObchod_FakturaPolozka` | Invoice lines | mirrors `ObjednavkaPolozka` |
| `CSW_EObchod_StavDokladu` | Document phase / state catalog | `ID`, `Kod`, `Nazev` |

### Reference / catalog data

| View | Purpose |
|---|---|
| `CSW_EObchod_Mena` | Currencies (`Kod` = `CZK` / `EUR` / `USD` / ...) - join target for `Mena_ID` |
| `CSW_EObchod_PevnyKurz` | Fixed exchange rates per pricelist |
| `CSW_EObchod_ZpusobDopravy` | Shipping methods |
| `CSW_EObchod_ZpusobPlatby` | Payment methods |
| `CSW_EObchod_Stredisko` | Cost centers (`stredisko` config key) |
| `CSW_EObchod_Cinnost` | Activities (`cinnost` config key) |
| `CSW_EObchod_Zakazka` | Jobs / orders for cost tracking (`zakazka` config key) |
| `CSW_EObchod_Skupiny` | Group hierarchy used by `Group_ID` everywhere |

## The `CSW_EObchodPlus_*` view catalog

Extended e-shop views (the "Plus" pack). These cover features that the base e-shop layer doesn't expose - flags, cross-sell, attachments, language mutations, and so on. They are defined `WITH (NOLOCK)` - reads are dirty.

| View | Purpose | Key columns |
|---|---|---|
| `CSW_EObchodPlus_Artikl` | Extended product view (joins extra Plus attributes onto the base `CSW_EObchod_Artikl`) | superset of `CSW_EObchod_Artikl` |
| `CSW_EObchodPlus_ArtiklPriznak` | **Product flags** (Novinka / Doporuceno / Akce / Vyprodej / custom flags) | `Parent_ID` (= `Artikl.ID`), `Kod` (flag code), `Nazev` (flag label), `Poradi`, `DatovyTyp`, `ViewHodnota` (display value), `RawHodnotaBool`, `RawHodnotaDatum`, `RawHodnotaDecimal`, `RawHodnotaGuid`, `RawHodnotaInt`, `RawHodnotaText`, `Deleted`/`Hidden` |
| `CSW_EObchodPlus_ArtiklCrossSell` | Cross-sell links | `Parent_ID`, `Artikl_ID` |
| `CSW_EObchodPlus_ArtiklDarek` | "Free gift" links | `Parent_ID`, `Artikl_ID` |
| `CSW_EObchodPlus_ArtiklDoplnkovaSluzba` | Additional services attached to a product | `Parent_ID`, `Artikl_ID` |
| `CSW_EObchodPlus_ArtiklDokument` | Product attachments / documents | `Parent_ID`, file refs |
| `CSW_EObchodPlus_ArtiklObrazek` | Product images | `Parent_ID`, blob/file refs |
| `CSW_EObchodPlus_ArtiklKategorieObrazek` | Category-of-product images | `Parent_ID`, `Kategorie_ID` |
| `CSW_EObchodPlus_ArtiklSouvisejici` | "Related products" (separate from accessories) | `Parent_ID`, `Artikl_ID` |
| `CSW_EObchodPlus_ArtiklZpusobDopravy` | Per-product shipping availability | `Parent_ID`, `ZpusobDopravy_ID` |
| `CSW_EObchodPlus_ArtiklMutacePopisu` | Language mutation - product description | `Parent_ID`, `Jazyk_ID`, `Popis` |
| `CSW_EObchodPlus_ArtiklMutaceDoplnujicihoPopisu` | Language mutation - extended description | `Parent_ID`, `Jazyk_ID`, `Popis` |
| `CSW_EObchodPlus_ArtiklMutaceTextu` | Language mutation - generic texts | `Parent_ID`, `Jazyk_ID`, `Typ`, `Text` |
| `CSW_EObchodPlus_MutaceTextuArtikluTrvalyOdkaz` | Permalinks per language | `Parent_ID`, `Jazyk_ID`, `Odkaz` |
| `CSW_EObchodPlus_KategorieArtikluMutaceNazvu` | Category name translations | `Parent_ID`, `Jazyk_ID`, `Nazev` |
| `CSW_EObchodPlus_KategorieArtikluMutacePopisu` | Category description translations | `Parent_ID`, `Jazyk_ID`, `Popis` |
| `CSW_EObchodPlus_HodnotaParametruArtikluMutaceHodnoty` | Parameter value translations | `Parent_ID`, `Jazyk_ID`, `Hodnota` |
| `CSW_EObchodPlus_ParametrArtikluMutaceTextu` | Parameter name translations | `Parent_ID`, `Jazyk_ID`, `Nazev` |
| `CSW_EObchodPlus_ObchodJazykMutace` | Languages enabled for a given e-shop instance | `Parent_ID` (= `Obchod.ID`), `Jazyk_ID`, `Kod` |
| `CSW_EObchodPlus_StatZpusobuDopravy` | Per-country shipping availability | `Parent_ID`, `Stat_ID` |
| `CSW_EObchodPlus_ObchodStatyZpusobyPlatbyADopravy` | Allowed (country, payment, shipping) tuples per e-shop | composite |
| `CSW_EObchodPlus_ZpusobDopravyMutaceTextu` | Shipping method name translations | `Parent_ID`, `Jazyk_ID`, `Nazev` |
| `CSW_EObchodPlus_ZpusobPlatbyMutaceTextu` | Payment method name translations | `Parent_ID`, `Jazyk_ID`, `Nazev` |
| `CSW_EObchodPlus_StavProduktu` | Product-state catalog (Plus version) | `ID`, `Kod`, `Nazev` |
| `CSW_EObchodPlus_TypProduktu` | Product-type catalog (Plus version) | `ID`, `Kod`, `Nazev` |
| `CSW_EObchodPlus_ZobrazovanaDostupnostProduktu` | "Availability shown on e-shop" enum | `Parent_ID`, `Kod` |

### `CSW_EObchodPlus_ArtiklPriznak` - product flags in detail

The view joins three underlying tables:
- `CSWBA_EShop_PriznakArtiklu` - the link row (product ↔ flag definition ↔ value)
- `CSWBA_EShop_DefinicePriznakuArtiklu` - the flag definition (`Kod`, `Nazev`, `Poradi`, `DatovyTyp`)
- `CSWBA_EShop_VariantHodnotaPriznakuArtiklu` - the typed value (the `RawHodnota*` columns)

Typical usage - load all flags for a product:

```php
$res = odbc_exec($con, "
    select Kod, Nazev, DatovyTyp, ViewHodnota,
           RawHodnotaBool, RawHodnotaDatum, RawHodnotaDecimal,
           RawHodnotaGuid, RawHodnotaInt, RawHodnotaText
    from   [" . set_dbfile . "].[dbo].[CSW_EObchodPlus_ArtiklPriznak]
    where  Parent_ID = '" . $item["id"] . "'
       and Deleted = 0 and Hidden = 0
    order by Poradi");
```

`Kod` is what you pair on (the flag's stable code), `Nazev` is the human label, `DatovyTyp` tells you which `RawHodnota*` column carries the value (typically `1`=bool / `2`=int / `3`=decimal / `4`=text / `5`=datum / `6`=guid - confirm against the vendor spec if it matters), and `ViewHodnota` is the formatted display string Money would show in the UI.

Common shopsync flags by `Kod`: `Novinka` (new), `Doporuceno` (recommended), `Akce` (sale / promotion), `Vyprodej` (clearance) - but the set is configurable per Money installation, so always read `Kod` rather than hard-coding row positions.

## When views are not enough - falling back to base tables

The `CSW_EObchod_*` views are the primary surface but they leave out some columns - and in particular they **never expose `_UserData` custom fields**. Whenever you need a column the view doesn't carry, query the base table directly.

### `_UserData` fields - the custom-field convention

Money S4 / S5 lets each customer add **custom user fields** to any business table. By convention these columns are suffixed `_UserData`, for example:

- `Objednavky_ObjednavkaPrijata.Uhrazeno_UserData` - "paid" flag we set after the e-shop reports a paid order
- `Artikly_Artikl.S3SH_Eshop_UserData`, `Vlastnost_UserData`, ... - per-product custom attributes
- ... and arbitrary per-implementation extensions

**These are not in the views.** Always read and write `_UserData` columns directly on the base table:

```sql
-- read (in a per-project SELECT that joins the base table next to the view)
select v.*, a.MyFlag_UserData
from   CSW_EObchod_Artikl as v
join   Artikly_Artikl     as a on a.ID = v.ID

-- write
update Objednavky_ObjednavkaPrijata
set    Uhrazeno_UserData = 1
where  Odkaz = '<shop-ref>'
```

The set of `_UserData` columns is **per Money installation** - what exists in one project may not exist in another. Don't assume; check the live DB or ask the user before referencing one in shared code.

### Common base tables (catalog)

| Base table | Why we reach for it |
|---|---|
| `Artikly_Artikl` | Product master. The view (`CSW_EObchod_Artikl`) covers most e-shop columns but the loader still joins `Artikly_Artikl` for `PLU`, `Zkratka20`, custom `_UserData` fields, and other internal columns. |
| `Artikly_ProduktovyKlic` / `Artikly_ArtiklProduktovyKlic` | Product keys (sub-codes, alternate identifiers) attached to a product. |
| `Artikly_ParametrArtiklu` | Per-parameter `Variantni` flag (whether a parameter defines a variant). |
| `Artikly_ArtiklHodnotaParametru` | Per-product parameter value rows (the writable shape behind `CSW_EObchod_ArtiklParametr`). |
| `Artikly_ArtiklJednotka` / `Artikly_ArtiklBaleni` | Per-product unit definitions and packaging variants. |
| `Artikly_ArtiklElektronickyObchod` | Per-product e-shop flags (visibility, ordering, ...) beyond what the view shows. |
| `Artikly_ArtiklDPH` | VAT rates per product. |
| `Artikly_ArtiklDodavatel` | Per-product supplier records. |
| `Artikly_KategorieArtiklu` | Categories (writable base for the category tree). |
| `Artikly_ArtiklAlternativa` | Alternative products (writable base). |
| `Artikl_ArtiklPrislusenstvi` | Accessories (note: singular `Artikl_` prefix). |
| `Artikl_ArtiklSlozeni` | Bundles / kit composition (`Celek_ID`, `Prvek_ID`, `PocetPrvek`). |
| `Artikl_ArtiklRozmer` | Physical dimensions extras. |
| `Sklady_Zasoba` | Raw stock rows when the view's aggregation doesn't match what we need (e.g. for the `ArtiklSlozeni` bundle availability sum). |
| `Sklady_StavZasoby` | Stock-state snapshot rows (history-driven aggregates). |
| `Sklady_Sklad` | Warehouse definitions. |
| `Ceniky_Cenik` / `Ceniky_PolozkaCeniku` | Pricelists and their rows (writable base for `CSW_EObchod_Cenik` / `CSW_EObchod_PolozkaCeniku`). |
| `Ceniky_CenovaHladina` | Customer price levels (writable base). |
| `Ceniky_MnozstevniHranice` / `Ceniky_MnozstevniSleva` | Quantity-discount tiers per pricelist / price level. |
| `Meny_Mena` | Currency code list (base behind `CSW_EObchod_Mena`). |
| `Meny_KurzListek` / `Meny_KurzListekPolozka` | Currency exchange rates - read latest `ValutyStred` for FX-converted document totals (no view exposes rates). |
| `EconomicBase_SazbaDPH` | VAT rate catalog. |
| `Adresar_Firma` | Address-book company record (writable base behind `CSW_EObchod_Zakaznik`). |
| `Adresar_Osoba` | Contact persons. |
| `Adresar_AdresniKlic` / `Adresar_FirmaAdresniKlic` / `Adresar_OsobaAdresniKlic` | Address records + linking from companies / persons. |
| `Adresar_Spojeni` | Contact rows (email / phone). |
| `Adresar_FirmaCenovaHladina` / `Adresar_FirmaCenik` | Per-company price level / pricelist assignments. |
| `Adresar_FirmaCinnost` / `Adresar_SkupinaCinnost` | Per-company activity assignments. |
| `Adresar_TypSpojeni` | Contact-type code list (Email / Telefon / ...) needed when writing `<SeznamSpojeni>` blocks. |
| `Ciselniky_Stat` | Country code list - join target for ISO code → GUID translation in `<Stat ID="...">`. |
| `Ciselniky_Jednotka` | Unit catalog (ks/kg/...). |
| `Ciselniky_Stredisko` / `Ciselniky_Zakazka` / `Ciselniky_Cinnost` | Cost-center / job / activity catalogs (referenced by `getCfg(1, "stredisko"/"zakazka"/"cinnost")`). |
| `Objednavky_ObjednavkaPrijata` | Received order header - used for dedup checks (`select top 1 ID ... where Odkaz='<shop-ref>'`) and for setting `Uhrazeno_UserData` after payment. |
| `Objednavky_PolozkaObjednavkyPrijate` | Received order lines. |
| `Objednavky_PoptavkaPrijata` / `Objednavky_PolozkaPoptavkyPrijate` | Received inquiry header + lines - same dedup pattern as orders. |
| `Objednavky_ObjednavkaVydana` / `Objednavky_PolozkaObjednavkyVydane` | Issued (purchase) orders. |
| `Objednavky_NabidkaPrijata` / `Objednavky_PolozkaNabidkyPrijate` | Received quotations. |
| `Objednavky_NabidkaVydana` / `Objednavky_PolozkaNabidkyVydane` | Issued quotations. |
| `Objednavky_PoptavkaVydana` / `Objednavky_PolozkaPoptavkyVydane` | Issued (outbound) inquiries. |
| `Dane_DanovaRegistrace` | Tax registrations (per-country VAT IDs - needed for OSS scenarios). |
| `System_Groups` | The `Group_ID` / `Root_ID` tree referenced by every business row. |
| `System_Attachment` | Generic attachment storage (PDFs, images at the row level). |
| `CSWBA_EShop_*` | Underlying tables for the `CSW_EObchodPlus_*` views. Don't read these directly unless you have a reason - go through the Plus view. |
| `System_XmlExchangeImport` | The XML write queue - **always** written directly (this is how you trigger imports). See [queue-reference.md](queue-reference.md). |

Rule of thumb: if a `CSW_EObchod_*` view exposes the column, use the view. Otherwise the base table name follows a predictable pattern - `Artikly_*` / `Artikl_*` for products, `Adresar_*` for the address book, `Objednavky_*` for received orders/inquiries/quotations, `Sklady_*` for stock, `Ceniky_*` for pricelists, `Meny_*` for currency, `Ciselniky_*` for code lists, `Dane_*` for tax, `EconomicBase_*` for core economic catalogs, `System_*` for cross-cutting infrastructure. Confirm column names against `db_schema.sql` (if listed) or `sp_columns` on the live DB - and always reach for the base table when the column is a `_UserData` custom field.

## Reading the schema dump

The vendor dump is **UTF-16 LE** with byte-order mark. ripgrep happens to match through it for plain-ASCII patterns, but anything you copy out will be space-padded (e.g. `C R E A T E   V I E W`). To extract a single CREATE for editing, transcode first:

```powershell
Get-Content -Encoding Unicode "db_schema.sql" | Set-Content -Encoding utf8 "db_schema_utf8.sql"
```

or in PHP `mb_convert_encoding(file_get_contents(...), "UTF-8", "UTF-16LE")`. Don't blindly trust ripgrep line numbers when copying ranges out of the original file - they line up with the file but the surrounding bytes are wide.

## Common patterns

### Variant pairing

`CSW_EObchod_Artikl.NadrazenyArtikl_ID` points to the parent product. The standard loader `$select` left-joins the parent as `parent` and aliases the columns (`parent.Katalog as parent_katalog`, `parent.Kod as parent_kod`, `parent.Nazev as parent_name`, ...) so a variant row exposes both its own code (`Katalog`) and its parent's (`parent_katalog`). The pair logic in `Products::loadStoreCard` uses `parent_pair_field` when `$variants && parent_katalog != ""`.

### Active-only / not-hidden

Every business row has both `Deleted` (logical delete) and `Hidden`. Almost all shopsync `$select`s filter `Deleted=0 and Hidden=0`. Some of the Plus views relax this - check the view definition before assuming.

### Modification-driven incremental

The standard product `$select` ORs three modification windows:

```sql
where p.Create_Date>[last]
   or p.Modify_Date>[last]
   or (select top 1 Modify_Date from CSW_EObchod_Zasoba         where Artikl_ID=p.ID order by Modify_Date desc)>[last]
   or (select top 1 Modify_Date from CSW_EObchod_PolozkaCeniku  where Artikl_ID=p.ID order by Modify_Date desc)>[last]
```

This catches stock-only and price-only changes that don't touch `Artikl.Modify_Date`. If you add another time-driven dependency (e.g. flags), add a fourth subquery in the same shape against `CSW_EObchodPlus_ArtiklPriznak.Modify_Date`.

### Group GUIDs

Customer / pricelist / order routing in Money is often done by `Group_ID` referencing `CSW_EObchod_Skupiny` (or by `CenovaHladina_ID`). The shopsync templates hard-code the relevant GUID per group (e.g. CZK customers vs EUR customers) - see `templates/inquiries.php` for the pattern. Don't invent group GUIDs - they must already exist in Money or the import will be rejected.

### `Mena_ID` ↔ currency code

Every document carries `Mena_ID`. Map to ISO code by joining `CSW_EObchod_Mena` on `ID` and reading `Kod`. The same view is used to look up the home currency GUID in templates (so `<Mena>` can use the right ID).
