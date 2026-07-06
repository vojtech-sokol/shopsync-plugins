# Pohoda Library Reference (`lib/pohoda/`)

All classes live under the `Pohoda` namespace. Most follow the same pattern: construct with a `$lastUpdate` string, tweak public properties (pair fields, `$select`, flags), then `load()` which fills `$data` as an array of associative arrays. Extend in `scripts/` for project-specific column mappings.

## `Pohoda\Products` (products.php)

Reads `SKz` (store cards) joined to `sSklad` (storage). Main workhorse.

**Public properties:**
- `$pair_field = "IDS"` - the column used as the product code on the e-shop side. Default `SKz.IDS`. Some projects use `EAN`, `PLU`, a custom `VPr*` field, etc.
- `$parent_pair_field = "NazevRP"` - where the **parent** code for a variant is stored. Children carry their parent's `IDS` in this column.
- `$variants = false` - if true, produces a parent + children structure using `NazevRP` grouping. Option values come from "list"-type parameters (`SkParam`).
- `$alt_var_params = false` - swap primary/secondary variant parameter assignment.
- `$price_rounding = 4` - digits used when rounding prices read from Pohoda.
- `$last_update = "1970-01-01"` - `[last]` placeholder substitution.
- `$active_codes`, `$active_codes_variants` - populated by `loadActiveCodes()` so callers can detect deletions on the e-shop side.
- `$select` - the main SQL. Default filters: `SKz.IObchod=1` (sellable on e-shop), `SKz.Template=0`, optional `sSklad.IDS IN (filter_stock)`, `DatSave > [last]` OR a price-list `DatSave > [last]` OR (for variants) any sibling with the same `NazevRP` changed.

**Methods called per row by `load()`** (override these in a subclass):
- `loadStoreCard()` - id, code, name, EAN/PLU, weight/volume, storage, MJ (unit), user fields
- `loadDescriptions()` - `Popis`, `Popis2`, short/long descriptions
- `loadPrices()` - base price, VAT, currency, foreign prices, price lists, action prices (`SkACn`+`SkACnPol`)
- `loadStock()` - `StavZ`, `StavZV`, `Rezer`, min/max, reorder points
- `loadCategories()` - via the product→category link table (storemenuitemlinks equivalent)
- `loadParameters()` - `SkParam` + values, split between informational `params` and variant-option `params2`
- `loadRelated()` - related / alternative products
- `loadFlags()` - custom boolean flags (`mPohoda`, `VPr*` booleans)

## `Pohoda\Categories` (categories.php)

Reads `SkKat`. Fills:
- `$ids[]` - flat list of category IDs
- `$par[id] = parent_id` - the full parent map (loaded by `loadTree()`)
- `$data[]` - with keys: `id`, `ids` (name), `parent`, `parent_name`, `path`, `depth`, `pict` (`Obrazek`), `desc` (`SText`)

Pair field: `SkKat.IDS` (category name). Important: the Pohoda root must be named exactly `Všechny kategorie` (CZ) or `Všetky kategórie` (SK) — used as `parent_name` for depth-1 categories.

## `Pohoda\Customers` (customers.php)

Reads `AD`. Basic `select * from AD where DatSave>[last]`. Flat key/value dump. Projects typically filter by `RelDruh` (type) or a custom user-flag column.

## `Pohoda\Parameters` (parameters.php)

Reads `SkParam`. Use for two things:
1. **Informational parameters** shown on the product detail page.
2. **Variant option definitions** (when `SkParam.Typ` is `seznam`/list and `SkParamValue` holds the allowed values).

Properties:
- `$variant_parameter_prefix = "_"` - any parameter whose name starts with this prefix is treated as a variant-option definition rather than an informational attribute.
- `$atr_alt_mode = false` - swaps the designation when a project assigns variant params differently.

## `Pohoda\Invoices` (invoices.php)

**Not a reader — a parser.** `loadFromXML($path)` takes an XML file exported from Pohoda and walks each `<inv:invoice>` node into `$data[]` of flat invoice arrays (header, billing/shipping address, payment, currency, lines). Constructor supports `$without_db = true` for pure parsing.

Override `modifyInvoice()` / `modifyItem()` per project.

Parallel class: `Pohoda\IntDocs` (int_doc.php) — same shape, walks `<idc:intdoc>`.

## `Pohoda\Images` (images.php), `Pohoda\Pictures` (pictures.php)

List `SkRefObraz` (images) and `SkRefSvazany` (other attachments) joined to `SKz`. `pictures.php` is the older variant kept for a few projects — prefer `images.php` for new work.

## `Pohoda\DbWrite` (db_write.php)

The **only** writer that goes through ODBC rather than XML. Used for two things where Pohoda's XML interface is missing or awkward:
- `deleteAllCategories()` + `saveCategories($data, $root_name)` / `saveCategories2(...)` - rebuild the category tree in `SkKat`. Uses `SET IDENTITY_INSERT SkKat ON` on SQL Server.
- `saveParameters(...)` / similar - parameter definitions.

Never extend this to write products/orders/invoices — use XML via `CallImport`.

## Core helpers in `inc.php`

| Function | Purpose |
|----------|---------|
| `CallImport($xml, $import_name, $dont_generate_ini=false, $timeout_minutes=5)` | Generate `.ini`, launch `Pohoda.exe /XML`, poll + timeout-kill via `tasklist`/`taskkill` |
| `GenerateIni($xml_path, $pohoda_db, $check_duplicity=0)` | Return the `[XML]` section string (see xml-reference.md) |
| `SaveFile($path, $content)` | `fopen`+`fwrite`+`fclose` wrapper |
| `GeneratePdf($id_sestava, $data, $agenda)` | Batch PDF print via `<prn:print>` — 10 docs per dataPack |
| `GenerateXml($ico, $id_sestava, $agenda, $data)` | Builds a `<prn:print>` dataPack for PDF export |
| `vatRateText($rate, $d)` | Map numeric VAT % to XSD enum `high`/`low`/`third`/`none`. When OSS is active and delivery country differs, returns `historyHigh`/`historyLow`/`historyThird`. |
| `getRefVal($id, $con)` | Look up `sVPULpol.SText` by ID (name of a list value) |
| `getRefVal2($id, $con)` | Look up `sVPULpol.IDS` by ID (code of a list value) |
| `exec_timeout($cmd, $timeout=60)` | Legacy Linux-style runner (not used in production, kept for reference) |
| `exec_timeout2($cmd, $timeout=60)` | Legacy Windows COM runner, superseded by `CallImport` |

## Templates (`lib/pohoda/templates/`)

PHP files that render a single XML `<dat:dataPack>` envelope wrapping an array of `$data` rows. Invoked via `applyTemplate($data, $template, $output_xml)` from `lib/functions.php`. Available:

| Template | Agenda |
|----------|--------|
| `orders.php` / `orders_head.php` / `orders_bezkompletu.php` / `orders_sk.php` | `<ord:order>` — received orders |
| `orders_delete.php` | Order deletion payload |
| `enquiries.php` | `<enq:enquiry>` |
| `invoices.php` / `invoices_sk.php` / `invoices_from_orders.php` | `<inv:invoice>` |
| `advance_invoices.php` / `advance_invoices_from_orders.php` | `<inv:invoice>` with `invoiceType=receivedAdvance` |
| `credit_notes.php` / `credit_notes_sk.php` | `<inv:invoice>` with `invoiceType=issuedCreditNotice` |
| `prijemky.php` / `prijemky2.php` | `<pri:prijemka>` — stock receipts |
| `intdoc.php` | `<idc:intdoc>` — internal documents |
| `parameters.php` | `<prm:parameter>` — attributes |
| `products.php` | `<stk:stock>` — store cards |
| `products_export.php` / `products_export_full.php` / `products_export_update.php` | export-only variants |

Project-specific templates live in the per-project `scripts/templates/` folder and typically shadow these (e.g. `scripts/templates/orders.php`).

## Bundled `.ini` templates (`lib/pohoda/cfg_files/`)

Prebuilt `[XML]` ini files — used by scripts that skip `GenerateIni()` and pass `$dont_generate_ini = true`:

- `xml_kategorie.ini`, `xml_kategorie_import.ini`
- `xml_zasoby.ini`, `xml_zasoby_import.ini`
- `xml_objednavky.ini`
- `xml_parametry.ini`

All share the same 6-line shape (see xml-reference.md).

## Class extension pattern (per project)

Project subclasses live in `scripts/`:

```php
class CustProducts extends Pohoda\Products {
    public $pair_field = "IDS";
    public $variants = false;

    public function loadStoreCard() {
        parent::loadStoreCard();
        // add custom VPr* columns to $this->item
        $this->item["top1"] = odbc_result($this->res, "VPrSeoTop1");
        $this->item["model"] = convertRes(odbc_result($this->res, "VPrHubModel"));
    }

    public function loadPrices() {
        parent::loadPrices();
        // read a B2B action-price row the base class doesn't cover
    }
}
```

Field-name columns starting with `VPr` are Pohoda's user-defined columns ("volitelné parametry") — each installation has its own set; always verify against the project's live DB before referencing them.
