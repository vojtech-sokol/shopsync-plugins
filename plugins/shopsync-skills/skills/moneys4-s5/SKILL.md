---
name: moneys4-s5
description: Dev helper for Money S4 / Money S5 ERP (Solitea / Seyfor) integration. Sister systems sharing the same SQL Server schema (CSW_EObchod_* views) and the same XML import mechanism (S5Data envelope) - both are handled by the single lib/moneys4/ library in shopsync. Integration is two-way - READ via ODBC mostly from CSW_EObchod_* / CSW_EObchodPlus_* views (sometimes also from the underlying Artikly_* / Adresar_* / Objednavky_* tables), WRITE by generating S5Data XML and inserting it into the System_XmlExchangeImport queue table (or via file import). Use when user mentions "money s4", "moneys4", "money s5", "moneys5", or works in project containing lib/moneys4/.
user-invocable: true
argument-hint: [topic]
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# Money S4 / Money S5 - Dev Helper

Money S4 and S5 are Czech enterprise ERP systems by **Solitea / Seyfor**. They are sister products that share **the same SQL Server database structure** and **the same XML import/export contract** (`<S5Data>` envelope). In shopsync, **both** are handled by a single library: `lib/moneys4/` (namespace `MoneyS4`) - there is no separate `lib/moneys5/`. Treat the lib folder name as historical; if a project's config says it is a Money S5 install, the same code paths still apply.

ShopSync integration is **two-way and asymmetric**:

1. **READ:** direct ODBC access to the SQL Server DB. Primary source is the `CSW_EObchod_*` and `CSW_EObchodPlus_*` views (the vendor-supplied e-shop integration layer). Some data is not exposed by these views (or is exposed in a less convenient shape) - in those cases the loaders fall back to the underlying base tables (`Artikly_*`, `Adresar_*`, `Objednavky_*`, `Sklady_*`, `Ciselniky_*`, `CSWBA_EShop_*`). Always check whether a view exists first; reach for a base table only when the view does not carry the column you need. DSN in `set_pohoda_db`, credentials via `getSqlUid()` / `getSqlPwd()`.
2. **WRITE:** never writes to business tables via ODBC. Instead generates an `<S5Data>` XML document and **either** (a) inserts a row into `System_XmlExchangeImport` (DB queue - the preferred path in shopsync projects) **or** (b) drops the XML file into Money's watched import folder. Money picks the work up asynchronously.

## References

- [references/db-reference.md](references/db-reference.md) - the `CSW_EObchod_*` and `CSW_EObchodPlus_*` view catalog with column purposes, the underlying `Artikly_*` / `Adresar_*` / `Objednavky_*` / `Ciselniky_*` tables, and the standard `[shop_id]` / `[last]` / `[filter]` template variables used by all loaders
- [references/xml-reference.md](references/xml-reference.md) - the `<S5Data>` envelope, the per-agenda root lists (`FirmaList`, `PoptavkaPrijataList`, `ObjednavkaPrijataList`, `ArtiklList`, ...), required fields per agenda, currency / VAT / Group GUID conventions, `create_guid()` / `xmlStr()` helpers, encoding (`utf2win` → windows-1250)
- [references/library-reference.md](references/library-reference.md) - the `MoneyS4\*` / `MoneyS5\*` PHP class hierarchy in `lib/moneys4/` and `lib/moneys5/`, override pattern in per-project `scripts/` / `scripts_ps81/` / `scripts_ws/` folders, templates folder, config keys
- [references/queue-reference.md](references/queue-reference.md) - the `System_XmlExchangeImport` DB queue table - columns, the fixed `Create_ID` GUID (`880C4CD2-5A95-4851-8607-67604587CAEF`), per-agenda `KodImportu` codes used by shopsync, dedup pattern via `create_guid("xml_ins_<prefix>_<id>")`

External source material (local, vendor docs):
- `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys4_s5\db_schema.sql` - DB DDL extract (~11.5k lines, **UTF-16** SQL Server dump). **Curated subset, not the whole schema** - it covers the important views and tables the e-shop integration touches, but a real Money DB has many more. If you need a table that is not in this file, query the live DB (`sp_columns <name>` / `INFORMATION_SCHEMA.COLUMNS`) or ask the user.
- `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys4_s5\EObchod - F specifikacia.doc` - functional specification for the e-shop integration layer (`CSW_EObchod_*` views)
- `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys4_s5\EObchod - I specifikacia.doc` / `.xls` - implementation specification (column-level reference for each view)
- `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys4_s5\priklad databaze\` - sample database

## Key files in a shopsync project

### Core library - `lib/moneys4/`  (used for both S4 and S5)

- `products.php` - `MoneyS4\Products`. Reads from `CSW_EObchod_Artikl` (+ `Artikly_Artikl`, `CSW_EObchod_ObchodArtikl`, `CSW_EObchod_Vyrobce`). Per-row dispatcher calls `loadStoreCard` / `loadDescriptions` / `loadPrices` / `loadStock` / `loadCategories` / `loadParameters` / `loadRelated`. Variants handled via `NadrazenyArtikl_ID` and the `parent_*` aliases in `$select`.
- `categories.php` - `MoneyS4\Categories` - tree from `CSW_EObchod_Kategorie` (paired by `NadrazenaKategorie_ID`).
- `customers.php` - `MoneyS4\Customers` - reads `CSW_EObchod_Zakaznik` (+ `Adresar_*` base tables for addresses / `Spojeni` for email/phone - one of the cases where the views don't cover everything).
- `parameters.php` - `MoneyS4\Parameters` - reads parameter definitions from `CSW_EObchod_Parametr` (+ `Artikly_ParametrArtiklu` for the variant flag, which is not exposed by the view).
- `images.php` / `pictures.php` - product images and attachments.
- `settings_gen.php` - generates `settings_template.json` for the shopsync settings UI (defines the keys the UI lets the user fill in).
- `templates/*.php` - PHP-rendered XML templates that produce `<S5Data>` documents (e.g. `orders.php` for `ObjednavkaPrijataList`, `categories.php` for `KategorieArtikluList`).

### Per-project overrides - `scripts/`, `scripts_ps81/`, `scripts_ws/`

Per the user's convention, project-specific code lives in `scripts*` folders. Each project typically contains:

- `scripts*/products.php` - extends `MoneyS4\Products`, overrides `loadStoreCard` / `loadDescriptions` / `loadPrices` etc. to add per-eshop field mappings.
- `scripts*/orders.php` - loads orders from the **e-shop** side (PrestaShop / WooCommerce / Shoptet / ...), renders an XML template, inserts the result into `System_XmlExchangeImport`.
- `scripts*/inquiries.php`, `scripts*/change_state.php`, `scripts*/products_server.php`, ... - other per-project syncs.
- `scripts*/templates/` - project-specific overrides when the base template in `lib/moneys4/templates/` is not enough.

## Script bootstrap pattern - reading from Money

```php
include "./config.php";
include "./lib/functions.php";
include "./lib/moneys4/products.php";   // or categories / customers / parameters / ...
include "./bridge/client.php";
init();

class CustProducts extends MoneyS4\Products {
    public $pair_field        = "Katalog";          // CSW_EObchod_Artikl.Katalog by default
    public $parent_pair_field = "parent_katalog";   // alias in the parent $select
    public $variants          = true;
    public $shop_id           = "131B991D-...";     // CSW_EObchod_Obchod.ID - the e-shop record GUID
    // override loadStoreCard / loadPrices / ...
}

$p = new CustProducts($lastUpdate);
$p->load();
```

## Script bootstrap pattern - writing to Money (the queue path)

```php
$con = odbc_connect(set_pohoda_db, getSqlUid(), getSqlPwd()) or die("Chyba pripojeni");

foreach ($data2 as $d) {
    $xml    = applyTemplate([0 => $d], "./scripts_ps81/templates/orders.php");
    $xml_id = create_guid("xml_ins_obj_" . $d["id"]);   // dedup key

    $resx = odbc_exec($con, "select ID from [" . set_dbfile . "].[dbo].[System_XmlExchangeImport] where ID='" . $xml_id . "'");
    if (odbc_fetch_row($resx)) { continue; }            // already queued

    odbc_exec($con, "insert into [" . set_dbfile . "].[dbo].[System_XmlExchangeImport]
        (ID, Create_ID, Create_Date, KodImportu, VstupniXML, Kod, Nazev)
        values
        ('" . $xml_id . "',
         '880C4CD2-5A95-4851-8607-67604587CAEF', getdate(),
         'obj2_test',
         '" . utf2win($xml) . "',
         '" . $d["number"] . "',
         '" . maxLen(sqlSafe(utf2win($d["invoice"]["name"])), 30) . "')");
}
```

Money S4 / S5 polls `System_XmlExchangeImport`, picks new rows, parses `VstupniXML`, and writes results back into the same row (status + response). See [references/queue-reference.md](references/queue-reference.md) for the column meanings and the standard `KodImportu` codes.

## DB connection

Always SQL Server (unlike Pohoda - Money S4/S5 does not have an Access-file mode):

```php
$con = odbc_connect(set_pohoda_db, getSqlUid(), getSqlPwd()) or die("Chyba pripojeni k databazi");
// (the shopsync config key is named `set_pohoda_db` for historical reasons - it points to the Money DSN)
```

## Config constants

| Constant | Meaning |
|----------|---------|
| `set_pohoda_db` | SQL Server ODBC DSN for the Money database (name kept for legacy reasons) |
| `set_dbfile` | Database name used as a `[<dbname>].[dbo].<table>` qualifier in every query |
| `getSqlUid()` / `getSqlPwd()` | SQL Server credentials (from the `sw_` config block) |
| `set_homecurrency` | Default currency code (usually `CZK`) |
| `set_vat`, `set_vatlow`, `set_vatthird` | VAT percent values |
| `set_url` | E-shop URL - referenced in note/description fields |
| Config section `1` keys | Header defaults: `stredisko`, `cinnost`, `zakazka`, `vychozi_sklad`, `id_prefix`, `vychozi_cena`, `vychozi_skupina_zakazniku`, ... |
| Config section `4` / `8` keys | Product-side toggles: `typ_slevy`, `importovat_nizsi_ceniky`, `debug`, ... |

## Important conventions

- **Encoding.** Money stores text as Windows-1250. Always `utf2win()` strings going into XML/SQL, and `convertRes()` (or `autoutf()`) strings coming out of `odbc_result()`. XML templates declare `encoding="utf-8"` in the prolog but the **payload column** `System_XmlExchangeImport.VstupniXML` must contain windows-1250 bytes - that's why `utf2win($xml)` wraps the whole document at insert time.
- **Pair fields.** Products are normally paired by `CSW_EObchod_Artikl.Katalog` (override via `$this->pair_field`). Variants share the parent's `Katalog` (or `Kod`/`PLU`) - the loader exposes it as `parent_katalog` / `parent_kod` via the `$select` joins.
- **GUIDs.** Money uses uppercase GUIDs everywhere (`ID`, `Parent_ID`, `Vyrobce_Firma_ID`, `Sklad_ID`, ...). Internal cross-references in shopsync use `create_guid($seed)` (md5-based deterministic GUID) so the same logical record always lands on the same Money row across reruns.
- **Incremental sync.** `[last]` placeholder in `$select` is replaced with `getSQLDate(strtotime($this->last_update))`. Loaders also OR-in checks against `CSW_EObchod_Zasoba.Modify_Date` and `CSW_EObchod_PolozkaCeniku.Modify_Date` so price/stock-only changes still trigger a re-sync.
- **`[shop_id]` placeholder.** Replaced with `$this->shop_id` - the GUID of the `CSW_EObchod_Obchod` row that represents this particular e-shop instance in Money. The `CSW_EObchod_ObchodArtikl` join filters to "products that belong to this e-shop". **Always set this per project.**
- **`[filter]` placeholder.** Replaced with `and (<expr>)` when `$this->filter` is set, otherwise stripped. Use this to scope a sync to a category, a warehouse, etc.
- **No-lock reads.** All `CSW_EObchodPlus_*` views are defined `WITH (NOLOCK)`. Treat the data as dirty reads - don't make decisions that depend on transactional consistency.
- **`_UserData` fields are NOT in views.** Money lets each installation define custom user fields and names them with the `_UserData` suffix (e.g. `Uhrazeno_UserData`, `S3SH_Eshop_UserData`). The `CSW_EObchod_*` views never expose them - always read/write `_UserData` columns directly on the base table (`Artikly_Artikl`, `Objednavky_ObjednavkaPrijata`, ...). Since the set of `_UserData` fields differs per installation, don't assume one exists - check the live DB or ask first.
- **Dedup queue inserts.** Always `create_guid("xml_ins_<agenda>_<source_id>")` and SELECT-first against `System_XmlExchangeImport.ID`. Money does **not** reject duplicates - inserting the same XML twice will import the same document twice.
- **`Create_ID` is the same GUID everywhere.** `880C4CD2-5A95-4851-8607-67604587CAEF` - the shopsync user/integration identity registered inside Money. Don't randomize it.

## Topic index (for the optional `[topic]` argument)

- `db`, `views`, `schema`, `tables`, `priznak`, `flags` → [references/db-reference.md](references/db-reference.md)
- `xml`, `envelope`, `S5Data`, `template` → [references/xml-reference.md](references/xml-reference.md)
- `lib`, `library`, `classes`, `scripts`, `override` → [references/library-reference.md](references/library-reference.md)
- `queue`, `XmlExchange`, `import`, `KodImportu` → [references/queue-reference.md](references/queue-reference.md)
- `vendor docs` → `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys4_s5\` (db_schema.sql is UTF-16)
