# `lib/mrpks` Library Reference

Namespace `MRPKS`. Canonical copy: `C:\lib\mrpks` (Dave). Every project carries its own copy in `<project>\lib\mrpks` and they **drift** — a survey of 63 projects found 23 variants of `products.php`, 14 of `inc.php`, 12 of `pictures.php`, 8 of `templates/orders.php`. Always read the project's own copy before changing behaviour; never assume it equals `C:\lib`.

Classes implement the global ShopSync reader interfaces (`\ProductsReader`, `\CategoriesReader`, `\InvoicesReader`, `\PicturesReader`) and produce the ShopSync neutral data model consumed by the e-shop libraries (`lib/shoptet_api`, `lib/woocommerce*`, `lib/prestashop81`, `lib/upgates`, `lib/baselinker`, `lib/creativesites`, …).

## Files

| File | Content |
|---|---|
| `inc.php` | `sendRequest`, `CallImport`, `CallExport`, `GenerateIni`, `SaveFile`, `flatArray`, `asArray`, `simpleXmlToArray`, `GetPDFInvoice` |
| `products.php` | `MRPKS\Products` — EXPEO1 reader, fills sqlite card map |
| `categories.php` | `MRPKS\Categories` — catalog tree from EXPEO1 `katalog` |
| `pictures.php` | `MRPKS\Pictures` — image files from `velobr` names / per-card EXPEO0 download, FTP upload |
| `invoices.php` | `MRPKS\Invoices` — parses `temp_dir/mrpks_invoices.xml` (EXPFAKVY output) |
| `lists.php` | `MRPKS\Lists` — codebooks for MCP (only VAT rates from config) |
| `mcp.php`, `mcp_manifest.json`, `mcp_instructions.txt`, `system.json` | MCP layer (newer lib only, 2 of 63 projects) |
| `settings_gen.php` | generates `temp/<profile>_settings_template.json` for the ShopSync settings UI |
| `templates/orders.php` | IMPEO0 request template (order → MRP) |
| `templates/invoices.php` | XML 2.0 `IssuedInvoices` template (e-shop invoice → MRP via IMPFAKVY) |
| `cfg_files/import_faktur.xml` | command-line template for `IMPFAKVY` (`[sw_user]`, `[sw_pass]`, `[temp_dir]` placeholders) |
| `orders.php` (38 project libs, **not** in `C:\lib`) | a complete orders *script* (CreativeSites → MRP) mistakenly living in lib — see `project-patterns.md` |

## Config constants (`config.php` / profile)

| Constant | Profile field | Meaning for MRP |
|---|---|---|
| `set_sw` | `sw` | **7 = MRP K/S** (used by the ShopSync client to pick the ERP) |
| `set_apppath` | `sw_exe` ("Cesta k .exe" in the UI) | **HTTP API address `host:port`** — e.g. `localhost:801`, `localhost:110`, `192.168.x.y:120`. No `http://`, no spaces. Also used as the exe path by `CallImport`/`CallExport` (conflict). |
| `set_dbfile` | `dbfile` ("Připojovací řetězec") | path to `DATA00nn.MRP` — used only by `GenerateIni` (command line) |
| `set_pohoda_db` | `set_pohoda_db` | reused by projects as the **Firebird connection string** `host/3050:D:\MRPKS\DATA\DATA0120.MRP` for `ibase_connect` |
| `sw_user`, `sw_pass` | | MRP login (command line; Firebird in many `order_states.php`) |
| `set_vat`, `set_vatlow`, `set_vatthird` | | VAT rates used to bucket invoice sums |
| `set_homecurrency` | | `CZK` / `EUR` (most MRP clients are Slovak — EUR) |
| `set_pricegroup1..6` | | MRP price number (1..5) feeding e-shop price list N |
| `set_shoppergroup1..6` | | e-shop customer group / price list id for that price |
| `temp_dir`, `img_dir`, `img_ftp_dir`, `ftp_*` | | work dirs, images, FTP |

Settings (`getCfg(group, name)`) — groups as created by `settings_gen.php` plus common per-project additions:

- **1. Objednávky**: `ceny_s_dani` (1 in 54/59 profiles), `stredisko`, `cinnost`, `zakazka`, `nulove_polozky`, `import_zakazniku`, `rada_objednavek`, `vychozi_cena`, `sklad_dle_importu`, `vychozi_sklad`, `automaticky_zalohovku`, `automaticky_fakturu`, `automaticky_mazat`, `rada_faktury`, `oss` (1 in 54/59), `oss_hlavni_zeme` (SK 44×, CZ 15×), `oss_prepis_pravidel`, `rozpad_kompletu`, `zaokrouhleni_domaci`, `zaokrouhleni_cizi`, `zaokrouhleni_polozek`, `id_prefix` (requestId prefix), `objednavka_text`, `faktura_text`, `kod_dph` (41), `kod_dph_oss` (40/54), `registrace_dph_v_eu`, `typ_dph`, `typ_dph_platci`, `predkontace`, `predkontace_platci`, `bank_ucet`, `vlastni_prefix_faktury`, `pole_ic`, `pole_dic`, `pole_ic_dph` (WooCommerce meta keys), `typ_dokladu`
- **2. Způsoby platby**: e-shop name (substring or `*` pattern via `matchMethod()`) → MRP `formaUhrady` text, e.g. `Bankovním převodem → převodem`, `dobír → dobírka`, `prevod → p.p.`
- **3. Způsoby dopravy**: e-shop carrier → MRP `zpusobDopravy` text (`DPD → kuriérom`, `GLS → GLS Slovak`, `Slovak parcel service → SPS`)
- **4. Produkty**: `kompletni_prenos_vzdy`, `kompletni_prenos_denne` + `_od`/`_do` (hour window for the daily full sync), `ceny_s_dani_na_eshopu`, `scitat_sklady` (setting exists, no code reads it), `pole_ean`
- **7. Importy**: `importovat_kategorie`, `importovat_obrazky`, `importovat_parametry`, `importovat_nakupni_ceny`, `importovat_ceny_s_dph`, `importovat_zmeny_produktu`, `id_skladu_k_importu`
- **8. Ostatní**: `debug` (≥1 verbose, ≥2 logs raw requests in `sendRequest`), e-shop API credentials, `czk_kurz`
- MCP only: `1.mrpks_exe` (exe path for invoice export), `1.mrpks_firebird` (default `localhost/3050`)

## `inc.php`

```php
MRPKS\sendRequest($url, $request): array   // [http_code, body]
```
POST `http://$url`, `Content-Type: text/plain`, no timeout set, **`die()` on any non-200** (kills the whole transfer — `mcp.php` has a non-dying `mcpSendRequest()` with timeouts). Does **not** look at `<error>`.

```php
MRPKS\simpleXmlToArray($xml)   // json_decode(json_encode(simplexml_load_string($xml)), true)
MRPKS\flatArray($v)            // empty element (array) -> "", ["x"] -> "x", scalar -> scalar
MRPKS\asArray($v)              // single row (assoc) -> [row]; list -> list
MRPKS\GetPDFInvoice($inv_number, $fn)  // EXPFVPDF -> base64_decode(FileContent) -> $fn
MRPKS\CallExport($file, $export_name = "export", $filter = "", $cmd = "EXPFAKVY", $firebird = "localhost/3050")
MRPKS\CallImport($file, $import_name = "import")
MRPKS\GenerateIni($xml_file_path, $filter, $firebird)   // MRPKSCmdLineData with EXPFAKVY
```
See `cmdline-mode.md` §5 and `known-issues.md` for their pitfalls.

## `MRPKS\Products`

Public properties:

| Property | Default | Meaning |
|---|---|---|
| `$request` | EXPEO1 with `SKKAR.UPD_DATE >[last]\|null` | `[last]` replaced by `date("j.n.Y H:i", strtotime($last))`; if `$last` < 50000 s (= 1970) `\|null` is appended again |
| `$pair_field` | `"cislo"` | which `karty` field becomes the product `code`: `cislo` (card no.), `kod` (EAN), `kod1`, `kod2`, `kod3`, `usrfld*`… The ShopSync guide says "pairing by EAN by default" — the **code default is `cislo`**; projects override (BB-TECHNIK `kod2`). |
| `$pair_field_rounding` | 2 | `number_format` decimals when pairing by `cislo` (`"1925.00"`) |
| `$only_on_stock` | false | skip `count <= 0` |
| `$only_in_categories` | false | skip cards without `ciskat` |
| `$variants` | false | unused in the base class |
| `$price_rounding` | 4 | unused in the base class |
| `$karta`, `$stav` | | raw `karty` row / matching `stavy` row of the current card |
| `$stavy`, `$nahrady`, `$doplnky`, `$category_tree_parent` | | indexes built from the datasets |
| `$active_codes` | | filled by `loadActiveCodes()` (full EXPEO1, codes of cards with stock if `only_on_stock`) — e-shop libs use it to hide deleted products |
| `$sqlite` | `temp_dir/mrpks.sqlite` | WAL mode |

`load($last = "1970-01-01")`:
1. `sendRequest(set_apppath, $request)`; raw body saved to `temp_dir/test.xml` (handy for debugging, overwritten every run).
2. `katalog` → `$category_tree_parent[ciskat] = uciskat`.
3. `stavy` → `$this->stavy[cislo] = row` (**one row per card — last warehouse wins**), `nahrady`, `doplnky`.
4. For each `karty` row: `loadStoreCard()`, `loadDescriptions()`, `loadPrices()`, `loadStock()`, `loadCategories()`, `loadParameters()`, `loadRelated()`, then `modifyData()` hook (newer lib) → `$this->data[]`.
5. Upsert into sqlite `sync_storecards(code, storecard, last_price, last_stock)` — the **card map used by the order template** to turn e-shop codes into `cisloKarty`.
6. `validateData("Product", ...)` if available (warn-only schema check, newer lib).

Item array produced (ShopSync product model):

| Key | Source |
|---|---|
| `id` | `number_format(cislo, 2)` |
| `code`, `option` | `karty[$pair_field]` (formatted if `cislo`) |
| `producer` | "" |
| `weight` | `hmotnost` |
| `name` | `nazev` |
| `desc1`, `desc2` | `malpopis`, `velpopis` |
| `price`, `price_novat` | `stav.cenasdph`, `stav.cena` (price selected by `cisloCeny`, default 1) |
| `defprice` | = `price_novat` |
| `pricegroup[shoppergroupN]`, `pricegroup_inclvat[...]` | `stav.cena<set_pricegroupN>` / `...sdph` for N=1..6 when the constant is set and price ≠ 0 |
| `vat` | `karty.sazbadph` |
| `count` | `stav.pocetmj − stav.pocrezmj`, floored at 0 |
| `categories` | `ciskat` + `ciskatlist` split by `\|` (the duplicate check is a no-op — `ciskat` appears twice) |
| `params`, `params2`, `related`, `related2` | empty arrays (override to fill) |

Override pattern (see `project-patterns.md`): extend in `scripts/products.php`, override `loadStoreCard/loadPrices/loadStock/...` or the whole `load()`; change `$request` to add filters (`cisloSkladu`, `SKKAR.KOD3`, `SKKAR.USRFLD5`, …).

## `MRPKS\Categories`

`$request` = EXPEO1 with `malObraz=F`, `velObraz=F` (**no UPD_DATE filter → downloads the whole card list just to get the catalog**; `EXPKATZBOZI` would be lighter). `load()` → `loadTree()` (ids, parent map, names) → `loadCategory()` per `katalog` row:
`id = ciskat`, `name = popis`, `description = ""`, `active = 1`, `sequence = poradi`, `picture = null`, `parent = uciskat or 0`, `path = "Root/Child/..."` built from names. Hook `modifyData()`.

## `MRPKS\Pictures`

`load($last, $bycode = false)` — EXPEO1 without filters (the `[last]` replacement has no placeholder to replace → always full). For each card **with `ciskat`**:
- image base name = card code (`$bycode`) or `velobr` file name without extension;
- if `img_dir/<name>.jpg|png|gif` does not exist and `$do_not_export` is false → EXPEO0 for that card with `velObraz=T`, decode `velobraz` → detect type with `exif_imagetype` → save;
- gallery = `<name>.jpg` (cover) + `<name>_0..9.jpg` / `<name>_00..09.jpg` from `img_dir` (files put there by the customer);
- `upload()` → FTP `ftp_main_dir`, de-dup via sqlite `pictures.sqlite/sync_pictures`.
Images are downloaded only once per name; a changed image in MRP is not re-downloaded unless the local file is deleted.

## `MRPKS\Invoices`

Constructor loads `temp_dir/mrpks_invoices.xml` (produced by `CallExport` → `EXPFAKVY`). `load()` walks `IssuedInvoices/Invoice` (XPath relative to the document element `MRPKSData`) via `getItemVal()`; hooks `preLoad()`, `postLoad()`, `modifyData()`.

Mapping: `id` = `number` = `DocumentNumber`, `symvar` = `VariableSymbol`, `payment(_orig)` = `PaymentMeansCode` (remapped through settings group 2), `date` = `IssueDate`, `datetax` = `TaxPointDate`, `datedue` = `PaymentDueDate` **+ 14 days** (bug), `invoice.company` = `Company/Name`, `invoice.name` = `Company/CustomerName`, street/city/postcode/country, `ic` = `CompanyId`, `dic` = `Company/VatNumberSK`, `icdph` = `Company/VatNumber` (see VAT note), `delivery` = copy of `invoice` (DeliveryAddress ignored), `currency_rate` always 1, `total_incl_vat` / `total_excl_vat` from header sums (without `RoundingAmount`), items: `name` = `Description`, `vat` = `TaxPercent/100`, `price` = `UnitPrice` (flagged `withvat` = `ceny_s_dani`), `count` = `Quantity`, `code` = "" (StockCardNumber ignored). `vatsum`/`basesum` recomputed from items. Not mapped: `Payments`/`PaidAmount`, `InvoiceType`, `DocType`, `OriginalOrderNumber`, `UUID`, `SumValues`.

## `templates/orders.php` (IMPEO0)

Rendered by `applyTemplate($order, "./scripts/templates/orders.php" or lib path)`. Key lines:
- `requestId = <id_prefix>_<order id>`
- `<objednavka formaUhrady="substr(payment,0,20)" puvodniCislo="<id>" datum cenySDPH="T|F per ceny_s_dani" zpusobDopravy="xmlStr(carrier, 0, 20)">`
- `<mena kod kurz mnozstvi="1"/>`
- `<adresa id="xmlStr(md53(serialize(email . ' ' . ic)), 10)">` + `<firma nazev ico ic_dph>` + `<osoba jmeno prijmeni>` (if `firstname` set) + `<email>` + up to 2 `<tel>`
- `<adresa_dod id="xmlStr(md53(company.name.street.postcode), 10)">`
- `<rezimDPH kod="2" statDPH=delivery.country/>` when OSS applies and the order has VAT
- one `<polozka cisloKarty text cenaMJ pocetMJ sazbaDPH/>` per item; `cisloKarty` from `sync_storecards` (`code = item.code OR storecard = item.code`, case-insensitive)
- `<poznamka>` = order note (not escaped)

Project copies typically add `<params>` (cisloSkladu/stredisko/cisloZakazky/prefixRadyObj), `dic`/`dic_dph` on `<firma>`, `typPolozky`, explicit shipping/payment lines. Problems: `known-issues.md`.

## `templates/invoices.php` (XML 2.0 IssuedInvoices for IMPFAKVY)

One `<Invoice>` per ShopSync invoice: `DocumentNumber`, `IssueDate`, `CurrencyCode`, `ValuesWithTax=T` (fixed), `TaxCode` (= `taxcode` or setting `kod_dph`/`kod_dph_oss`), `DocType`, header sums from `basesum`/`vatsum` × `currency_rate` (only `set_vatlow` and `set_vat` buckets), `TotalWithTaxCurr`, `TaxPointDate`, `OriginalDocumentNumber` (`number2`), `VatRegime` 2/0 by OSS, `VatCountry`, `CalcParams=UPDP=2;VATRU=0.01;VATRM=0;TRU=0.01;TRM=0;VATCA=0;VATCUPA=0;TRD=0;TRDCA=1;VATFRB=1`, `VariableSymbol`, `ConstantSymbol=0308`, `PaymentDueDate`, `CurrRate`, `InvoiceType=F`, `PaymentMeansCode`, `OrderNumber`, `Company` (`CompanyId`, `Name`, `Street`, `City`, `CountryCode`, `ZipCode`, `VatNumber`=icdph, `VatNumberSK`=dic, `NaturalPerson`), items (`Description`, `RowType=1`, `TaxCode`, `Quantity`, `UnitPrice`, `TaxPercent`, `TaxAmount=price*vat`, `RowSumType`, optional `StockCardNumber` = `sync_id`, `ItemType`).

## MCP layer (`mcp.php`, newer lib)

Classes on top of the global `\McpEntityBase` / `\McpDocumentsBase`:

| Class | Entity | Behaviour |
|---|---|---|
| `McpProducts` | Product | `mcpCheckApi()` probe → `Products::load()` → `store->upsertMany()` |
| `McpCategories` | Category | always full |
| `McpOrders` | Order | `loadSince` not supported; `transportInsert()` = IMPEO0 via `templates/orders.php`; success detection = `stripos("error")`/`stripos("chyba")` heuristic |
| `McpInvoices` | Invoice | `loadSince` = command-line EXPFAKVY with `1.mrpks_exe`; `getPdf()` = EXPFVPDF → `temp_dir/mcp_pdf/faktura_<n>.pdf` |

`mcp_manifest.json` (`"verified_live": false`) and `mcp_instructions.txt` declare several things as impossible that the API does support (order export, codebooks, payments) — see `known-issues.md` §"Capabilities the library does not use".
