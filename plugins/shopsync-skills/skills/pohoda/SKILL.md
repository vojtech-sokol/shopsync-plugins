---
name: pohoda
description: Dev helper for Pohoda (Stormware) ERP integration. Use when working on shopsync projects integrating with Pohoda - products, categories, customers, parameters, orders, invoices, stock. Integration uses a TWO-WAY pattern - READ directly from Pohoda DB via ODBC (MS Access .mdb or SQL Server), WRITE by generating XML and running `Pohoda.exe /XML` from command line. Use when user mentions "pohoda", or works in project containing `lib/pohoda/`.
user-invocable: true
argument-hint: [topic]
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# Pohoda - Dev Helper

Pohoda is a Czech accounting/ERP system by **Stormware** (stormware.cz). ShopSync integration is **two-way and asymmetric**:

1. **READ:** direct ODBC access to Pohoda's DB — MS Access `.mdb` when `set_sw == 0`, MS SQL Server otherwise. Classes in `lib/pohoda/` under the `Pohoda` namespace.
2. **WRITE:** never writes via ODBC (except a few specific cases like categories/parameters in `db_write.php`). Instead generates XML (Windows-1250, dataPack envelope), writes a `.ini` file, and launches `Pohoda.exe /XML <user> <pass> <ini>` via COM `WScript.Shell`.

For DB tables, columns, and common SQL patterns, see [references/db-reference.md](references/db-reference.md).
For XML namespaces, dataPack envelope, `.ini` format, and the import loop, see [references/xml-reference.md](references/xml-reference.md).
For PHP library class methods, pair fields, and templates folder, see [references/library-reference.md](references/library-reference.md).

External source material (local):
- `C:\Users\Vojtech Sokol\Documents\share\podklady\pohoda\xml_schema\*.xsd` - 66 XSD schemas (the authoritative contract for every XML agenda)
- `C:\Users\Vojtech Sokol\Documents\share\podklady\pohoda\db_schema.sql` - full DB DDL (~21 k lines, SQL Server, UTF-16)
- `C:\Users\Vojtech Sokol\Documents\share\podklady\pohoda\98765432_2017.mdb` - sample Access DB
- `C:\Users\Vojtech Sokol\Documents\share\podklady\pohoda\Import a export dat.html` - Stormware's HTML docs for XML communication

## Key Files

### Core (`lib/pohoda/`)
- `inc.php` - `Pohoda\CallImport()`, `GenerateIni()`, `SaveFile()`, `GenerateXml()` (print), `vatRateText()`, `getRefVal()`, ODBC connect helpers
- `products.php` - `Pohoda\Products` - load store cards (`SKz`) with prices, stock, categories, parameters, variants (via `NazevRP` parent pair field)
- `categories.php` - `Pohoda\Categories` - load category tree from `SkKat`
- `customers.php` - `Pohoda\Customers` - load address book (`AD`)
- `parameters.php` - `Pohoda\Parameters` - load product parameters (`SkParam`) incl. list-type variant attributes
- `invoices.php` - `Pohoda\Invoices` - parse issued-invoice XML exported from Pohoda
- `int_doc.php` - `Pohoda\IntDocs` - parse internal-document XML
- `images.php` - `Pohoda\Images` - list product images/attachments (`SkRefObraz`, `SkRefSvazany`)
- `pictures.php` - older/alternate image loader
- `db_write.php` - `Pohoda\DbWrite` - the few things we DO write via ODBC: categories (`SkKat`), parameters (`SkParam`). Uses `SET IDENTITY_INSERT`.
- `settings_gen.php` - generates `settings_template.json` for the shopsync settings UI
- `cfg_files/*.ini` - bundled `.ini` templates for `CallImport` (kategorie, zasoby, objednavky, parametry, ...)
- `templates/*.php` - PHP-rendered XML templates (orders, invoices, credit_notes, prijemky, advance_invoices, products_export, intdoc, enquiries, ...)

### Per-project overrides (`scripts/`)
Every project extends the base `Pohoda\*` classes — that is where project-specific field mappings live. Also contains project-level XML templates in `scripts/templates/` that the bootstrap passes to `applyTemplate()`.

- `scripts/products.php` - extends `Pohoda\Products`, customizes `loadStoreCard` / `loadDescriptions` / `loadPrices` / ...
- `scripts/orders.php` - loads orders from the **e-shop**, applies a template to produce `objednavky_pohoda.xml`, then calls `Pohoda\CallImport()`
- `scripts/inc_pohoda.php` - legacy helper (predecessor of `lib/pohoda/inc.php`, kept for a few projects)

## Script Bootstrap Pattern

```php
include "./config.php";
include "./lib/functions.php";
include "./lib/pohoda/inc.php";
include "./lib/pohoda/products.php";   // or categories / customers / parameters / ...
include "./bridge/client.php";
init();

class CustProducts extends Pohoda\Products {
    public $pair_field = "IDS";        // SKz.IDS = product code; SKz.NazevRP = variant parent code
    // override loadStoreCard(), loadPrices(), etc. here
}

$p = new CustProducts($lastUpdate);
$p->load();

// Write side: render template → CallImport
applyTemplate($data, "./scripts/templates/orders.php", temp_dir."/objednavky_pohoda.xml");
Pohoda\CallImport(temp_dir."/objednavky_pohoda.xml", "import_obj");
```

## Two DB Connection Modes

```php
if (set_sw == 0) {
    // MS Access .mdb
    $con = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=".set_pohoda_db, "", "");
} else {
    // SQL Server (DSN in set_pohoda_db; uid/pwd via getSqlUid()/getSqlPwd())
    $con = odbc_connect(set_pohoda_db, getSqlUid(), getSqlPwd());
    odbc_exec($con, "set dateformat ymd");
    odbc_exec($con, "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED");
}
```

**Never assume one mode.** Always branch on `set_sw`. Both drivers return rows via `odbc_fetch_row`/`odbc_result`.

## Import Loop (`Pohoda\CallImport`)

`CallImport($xml_file, $import_name, $dont_generate_ini = false, $timeout_minutes = 5)`:

1. If not skipped, writes `temp_dir/<import_name>.ini` (see xml-reference.md for format).
2. Snapshots current PIDs of `Pohoda.exe` from `tasklist`.
3. Launches `Pohoda.exe /XML "<sw_user>" "<sw_pass>" "<ini>"` via `new \COM("WScript.Shell")->Run(...)` (non-blocking).
4. Polls `tasklist` every 3 s for the **new** PID; `taskkill /F /T` on timeout.
5. After the process exits, the response XML is at `temp_dir/<basename>_response.xml`.

Windows-only — relies on `COM`, `tasklist`, `taskkill`. Logging via `logln()`.

## Config Constants

| Constant | Meaning |
|----------|---------|
| `set_sw` | 0 = MS Access .mdb, otherwise SQL Server |
| `set_pohoda_db` | Access file path OR SQL Server ODBC DSN |
| `set_apppath` | Full path to `Pohoda.exe` |
| `set_dbfile` | Database name written into `.ini` (`database=`) - the Pohoda accounting-year DB like `'98765432_2025'` |
| `sw_user`, `sw_pass` | Pohoda login (passed on `/XML` command line) |
| `set_ico` | IČO of the accounting unit — required `ico="..."` attribute on `<dat:dataPack>` |
| `temp_dir` | Where generated XML + .ini + response files live |
| `filter_stock` | Semicolon- or comma-separated `sSklad.IDS` codes to restrict loads |
| `set_vat`, `set_vatlow`, `set_vatthird` | VAT percent values → mapped to `high`/`low`/`third`/`none` via `vatRateText()` |
| `set_homecurrency` | Default currency code (usually `CZK`) |
| `getSqlUid()`, `getSqlPwd()` | SQL Server credentials (from `sw_` config section) |

## Important Conventions

- **Encoding:** Pohoda stores and expects Windows-1250. Use `utf2win()` before writing strings to the DB or into XML literals; use `convertRes()` around `odbc_result()` when reading. XML files themselves declare `encoding="Windows-1250"` in the templates.
- **Pair fields:**
  - Products: `SKz.IDS` (length 64) = product code. `SKz.NazevRP` (length 24) = parent code for variants (children share the parent's `NazevRP` = parent's `IDS`).
  - Categories: `SkKat.IDS` = category name (unique).
  - Customers: `AD.ICO` / `AD.Email` primarily; some projects use `AD.IDS`.
- **Incremental sync:** `[last]` placeholder in the `$select` string is replaced with `getSQLDate(strtotime($lastUpdate))`. Track via `getLastUpd` / `setLastUpd`.
- **VAT mapping (`vatRateText`):** returns `high` / `low` / `third` / `none`; when OSS is active and delivery country has its own EU rate, returns `historyHigh` / `historyLow` / `historyThird`.
- **String length limits matter.** Pohoda silently rejects dataPackItems whose fields are over the XSD `maxLength`. Templates use `xmlStr($value, $maxlen)` to truncate. Common limits: company 255, name 64, street 64, city 45, zip 10 (Pohoda DB column widths).
- **Response XML is not optional.** Every import writes `<name>_response.xml`. Production code should parse it and flag `state="err"` dataPackItems — the import process itself exits 0 even on per-item rejections.
- **Do NOT write to `SKz`, `AD`, `FV`, `OBJ` via ODBC.** Use XML. `db_write.php` is a deliberate exception for categories/parameters only.
- **Templates are PHP files** rendered with `applyTemplate($data, $template_path, $output_xml_path)` from `lib/functions.php`. Inside they `<?php foreach ($data as $d) { ?> ... <?php } ?>` and echo XML fragments.
