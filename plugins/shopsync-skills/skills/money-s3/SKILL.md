---
name: moneys3
description: Dev helper for Money S3 (Seyfor/Solitea) ERP integration via classic XML + COM — NOT the GraphQL S3 API (that is the separate `moneys3-api` skill). Money S3 is driven by `Money S3.exe /XML /eXXXML ...` command-line calls that import/export windows-1250 XML files wrapped in `<MoneyData>`. Two communication modes — classic (pair by `UzivCode` / `Katalog` / `Zkrat` / `BarCode` / document number) and E-shop konektor module (pair by GUID only, different ExpZkratka codes, extra `eshop`/`eSkup` blocks). Use when user mentions "money s3", "moneys3", "eshop konektor", "eShopEZas", or works in a project containing `lib/moneys3/` (classic — NOT `lib/moneys3_api/`).
user-invocable: true
argument-hint: [topic]
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# Money S3 (classic XML + COM) — Dev Helper

> **Not the GraphQL S3 API.** If the project contains `lib/moneys3_api/` use the `moneys3-api` skill instead. This skill covers the **classic** integration that drives `Money S3.exe` from the command line and exchanges `windows-1250` XML files. The PHP library lives in `lib/moneys3/` under the `MoneyS3` namespace.

## References

- [references/xml-reference.md](references/xml-reference.md) — `<MoneyData>` envelope, `ExpZkratka` codes, per-entity field layouts (Zasoba, ObjPrij, FaktVyd, Firma), VAT/OSS/currency conventions, `xmlStr` / `create_guid` / `md53` helpers
- [references/cli-reference.md](references/cli-reference.md) — `Money S3.exe /XML` flag reference, `CallImport` / `CallExport`, import-profile `.ini`, `_Import.xsd` Key/Mode pairing instructions
- [references/konektor-vs-classic.md](references/konektor-vs-classic.md) — **critical**: the two communication modes, how pairing keys differ, which ExpZkratka / profile each mode uses
- [references/library-reference.md](references/library-reference.md) — `MoneyS3` PHP classes, templates folder, `scripts/*.php` extension pattern, `money.sqlite` pair-cache table, config keys

External source material:
- `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys3\` — vendor docs and samples:
  - `Money S3 E-shop konektor - prirucka pro vyvojare.pdf` — authoritative konektor-mode guide (PDF)
  - `Faktury.xml` — real invoice export sample
  - `Zasoby - vystup z eshop konektoru.xml` — konektor-mode stock export (`ExpZkratka="_eShopEZas"`)
  - `zasoby_money.xml` — classic-mode stock export (`ExpZkratka="_ZAS"`)
  - `prikaz_radek.pdf` — command-line reference
  - `Schemas\*.xsd` — 27 XSDs defining every XML agenda (stock, orders, invoices, address book, stock docs, payments, internal docs, inventory, production, contracts, employees)

## Two communication modes — the one thing to always check first

Money S3 can be run with or without the optional **E-shop konektor** module. This changes both the XML and the pairing key. Decide up front which mode this project uses before touching any template.

| | **Classic** (no konektor) | **E-shop konektor** |
|---|---|---|
| Stock export `ExpZkratka` | `_ZAS` | `_eShopEZas` |
| Primary pairing key | **external field** — `UzivCode`, `Katalog`, `Zkrat`, `BarCode`/EAN, or `Doklad`/`CObjednavk` for documents | **GUID everywhere** |
| `<eshop>` / `<eSkup>` blocks in `Zasoba` | absent | present (IN_Export, IN_Changed, eSkup tree, eKategorie) |
| Category/parameter exports | not provided | `SeznamKategorii` + `SeznamParametru` included in the same file |
| Stored in our DB as | GUID (we persist the GUID even though Money matches on something else) | GUID |
| Import `.ini` Key field | usually `UzivCode` or `Katalog` | `GUID` |

Our system always stores GUIDs internally (in `temp_dir/money.sqlite::sync_storecards.guid`) regardless of which mode Money is using — the mode only affects what we put in the XML for Money to match against.

Full detail in [references/konektor-vs-classic.md](references/konektor-vs-classic.md).

## Key files in shopsync projects

### Core library — `lib/moneys3/`

- `inc.php` — `MoneyS3\CallImport($file, $profile="I_O+P+N")` and `MoneyS3\CallExport($file, $profile="E_ZAS")`. Both launch `Money S3.exe` via `COM("WScript.Shell")->Run(...)`. Also preloads `$GLOBALS["eu_vat_rates"]` from `https://shopsync.cz/vatrates_s3.json` for OSS.
- `products.php` — `MoneyS3\Products` class. Loads `temp_dir/zasoby_money.xml` (exported from Money) via `DOMDocument` + `DOMXPath`, iterates `SeznamZasoba/Zasoba`, calls `loadStoreCard` / `loadDescriptions` / `loadPrices` / `loadStock` / `loadCategories` / `loadParameters` / `loadRelated` per item, writes results into `temp_dir/money.sqlite::sync_storecards`.
- `settings_gen.php` — generates `settings_template.json` that drives the shopsync settings UI.
- `templates/orders.php` — import template for `_O+P+N` (received orders); reads `money.sqlite` to fill `<KmKarta>` + `<Sklad>` per line.
- `templates/invoices.php` — import template for `_FP+FV` (issued invoices); wraps `KmKarta` + `Sklad` in `<SklPolozka>`.
- `templates/addressbook.php` — import template for `_ADR` (address book / `Firma`).
- `templates/products_export.php` — template that WE generate for Money to import products back (store-card + stock rows).

### Per-project logic — `scripts/`

Per the user's convention, project-specific changes belong in `scripts*` folders. Each project typically contains:

- `scripts/products.php` — extends `MoneyS3\Products`, overrides `load()` / `loadStoreCard` / `loadDescriptions` to add project-specific filters (e.g. `UzivatelskaPole/S3SH_Eshop == "Ano"` in the current project).
- `scripts/orders.php` — loads e-shop orders (via the other side's library, e.g. `Opencart\Orders`), renders `lib/moneys3/templates/orders.php`, calls `MoneyS3\CallImport($file, "I_O+P+N")`.
- `scripts/change_state.php`, `scripts/products_server.php`, etc. — project-specific syncs.
- `scripts/templates/` — project-specific XML overrides when the base template isn't enough.

## Script bootstrap pattern

```php
<?php
include "./config.php";
include "./lib/functions.php";
include "./lib/moneys3/products.php";
include "./lib/moneys3/inc.php";
include "./bridge/client.php";
init();

class CustProducts extends MoneyS3\Products {
    // override loadStoreCard / loadDescriptions / load / etc.
}
$p = new CustProducts();
$p->load();
```

For imports (orders/invoices/address book) the pattern is reversed:

```php
$data = $externalSource->load();
ob_start();
include "./lib/moneys3/templates/orders.php";
$xml = ob_get_clean();
file_put_contents(temp_dir . "/orders.xml", $xml);
MoneyS3\CallImport(temp_dir . "/orders.xml", "I_O+P+N");
```

## Pair cache — `temp_dir/money.sqlite`

Created on first use by either `MoneyS3\Products::__construct` or the `orders.php` / `invoices.php` templates:

```sql
create table sync_storecards (
    id int primary key,
    code text,
    guid text,
    storage_guid text,
    storage_code text,
    storage_name text,
    last_price real,
    last_stock real
)
```

`MoneyS3\Products::load()` wipes and repopulates this table on every product sync. Order/invoice templates then query it by `code` to fill `<KmKarta>` + `<Sklad>` blocks on each line.

## Config keys

Main section (`1`) keys used by the templates:
- `oss`, `oss_hlavni_zeme` — OSS routing switch and home country
- `typ_dph`, `typ_skladoveho_dokladu`, `bank_ucet`, `predkontace` — invoice header codes
- `vychozi_sklad`, `stredisko`, `zakazka`, `vychozi_cena`
- `objednavka_text`, `faktura_text` — free-form description strings
- `id_prefix` — prefix fed into `create_guid()` for invoice GUIDs
- `moneys3_rozsirene_parovani_zakazniku` — `1` = hash partner GUID from `ic+email+name+company+street+postcode` instead of just `ic+email`

Section 0 / `set_*` constants (from profile settings, resolved via `set_...` defines):
- `set_apppath` — absolute path to `Money S3.exe`
- `set_agenda` — agenda name/id passed as `/a<agenda>`
- `set_year` — accounting year passed as `/r<year>`
- `sw_user`, `sw_pass` — Money login (pass goes into `/p<pass>`)
- `set_homecurrency`, `set_vat`, `set_stockcode`, `set_stockname`, `set_groupcode`, `set_groupname`
- `set_pricegroup1..6` / `set_shoppergroup1..6` — price-level mapping

## Topic index (for the optional `[topic]` argument)

- `xml` / `envelope` — [references/xml-reference.md](references/xml-reference.md)
- `cli` / `command` / `run` / `import` / `export` — [references/cli-reference.md](references/cli-reference.md)
- `konektor` / `eshop` / `eShopEZas` / `pairing` / `modes` — [references/konektor-vs-classic.md](references/konektor-vs-classic.md)
- `library` / `classes` / `templates` / `scripts` — [references/library-reference.md](references/library-reference.md)
- `schema` / `xsd` — the XSD bundle at `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys3\Schemas\`
- `pdf` / `manual` — `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys3\Money S3 E-shop konektor - prirucka pro vyvojare.pdf`
