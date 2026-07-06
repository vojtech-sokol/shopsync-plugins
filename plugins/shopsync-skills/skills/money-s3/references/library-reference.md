# Money S3 — PHP library reference

All code lives under `lib/moneys3/` in the `MoneyS3` namespace. Project-specific logic lives in `scripts/*.php` as subclasses. Do **not** edit `lib/moneys3/` for project-specific behaviour — extend it from `scripts/` instead.

## Files in `lib/moneys3/`

### `inc.php` — process runner + OSS VAT bootstrap

```php
namespace MoneyS3;

$url_rates = "https://shopsync.cz/vatrates_s3.json";
$GLOBALS["eu_vat_rates"] = json_decode(downloadString($url_rates), true);
$GLOBALS["eu_vat_rates"]["GR"] = $GLOBALS["eu_vat_rates"]["EL"];

function CallImport($file, $profile = "I_O+P+N") {
    // Run `Money S3.exe /XML /eXXXML /fc<profile> /ftD /fw- /a<agenda> /r<year> /ff<file> /p<pass>`
    // via WScript.Shell COM, blocking.
}

function CallExport($file, $profile = "E_ZAS") { ... }
```

- Including this file triggers the VAT-rate download — do it early in scripts that will render OSS-aware templates.
- `CallImport` / `CallExport` both `sleep(2)` before running and pass `(hidden, wait=true)` to `WScript.Shell::Run`, so the PHP script blocks until Money finishes.
- Nothing here surfaces errors — if the import fails you find out by reading Money's log.

### `products.php` — `MoneyS3\Products`

Reads a Money stock-export XML (expected at `temp_dir/zasoby_money.xml`) and produces a flat `$data` array plus a populated `sync_storecards` sqlite table.

Public surface:

| Property | Default | Purpose |
|----------|---------|---------|
| `$xml` | `DOMDocument` loaded from `temp_dir/zasoby_money.xml` | the parsed source |
| `$xpath` | set inside `load()` | `DOMXPath` bound to `$xml` |
| `$variants` | `false` | whether to unfold variants |
| `$price_rounding` | `4` | decimal places |
| `$item` | `[]` | data of currently-processed card |
| `$data` | `[]` | data of all processed cards |
| `$pair_field` | `"UzivCode"` | which `KmKarta/<X>` field to treat as the pair key |
| `$sqlite` | `SQLite3` on `temp_dir/money.sqlite` | opened by constructor |

Override hooks (in declaration order of `load()`):

- `preLoad()` — runs once before iteration
- `loadStoreCard()` — id, code, EAN, producer, weight, GUID, warehouse fields
- `loadDescriptions()` — name, `WWWPopis`, `WWWPopis2`
- `loadPrices()` — reads `PC/Cena1/Cena` per `Hladina`, respects `PC/SDPH` for gross/net, maps to `set_pricegroup1..6`
- `loadStock()` — `StavZasoby/Zasoba` minus `StavZasoby/Rezervace`, clamped to 0
- `loadCategories()` — reads `eshop/eSkup/ID` (konektor mode — absent in classic exports)
- `loadParameters()` — reads `SeznamParametruKarty/ParametrKarty`, respects leading `_` to suppress variant-detection
- `loadRelated()` — reads `SeznamPrislusenstvi/Prislusenstvi`
- `postLoad()` — runs once after iteration and sqlite refill

After iteration the method deletes `sync_storecards` and reinserts one row per collected item — so every product run is a full resync of the pair cache.

### `settings_gen.php`

Generates `temp/<profile>_settings_template.json` used by the shopsync settings UI. Keys relevant to Money S3 sit in group `"1. Objednávky"` — `ceny_s_dani`, `stredisko`, `zakazka`, `nulove_polozky`, `import_zakazniku`, `rada_objednavek`, `vychozi_cena`, `sklad_dle_importu`, etc. Extend here when a project needs a new settings field.

### Templates — `lib/moneys3/templates/`

These are PHP files rendered by the callers (typically via `ob_start()` + `include` + `ob_get_clean()`) to produce import XML. They expect a `$data` array in scope.

| Template | Renders | Consumes | Key behaviour |
|----------|---------|----------|---------------|
| `orders.php` | `<MoneyData ExpZkratka="_O+P+N">` with `SeznamObjPrij/ObjPrij` | `$data` = array of orders | Looks up `sync_storecards` by `$item["code"]`; emits `<KmKarta>+<Sklad>` on match, `<NesklPolozka>` otherwise. Applies OSS override. Customer GUID = `create_guid(ic + "_" + email)`. |
| `invoices.php` | `<MoneyData ExpZkratka="_FP+FV">` with `SeznamFaktVyd/FaktVyd` | `$data` = array of invoices | Same pair-cache lookup, but wraps `KmKarta+Sklad` inside `<SklPolozka>`. Invoice GUID = `create_guid(id_prefix + "_" + id)`. Optional extended partner GUID when `moneys3_rozsirene_parovani_zakazniku==1`. |
| `addressbook.php` | `<MoneyData ExpZkratka="_ADR">` with `SeznamFirem/Firma` | `$data` = array of contacts | Same GUID convention as orders' `DodOdb`. |
| `products_export.php` | `<MoneyData ExpZkratka="_ZAS">` with `SeznamKmKarta` + `SeznamZasoba` | `$data` = array of products | Writes card + stock rows, copies images from `img_dir`, uses `set_vat` / `set_stockcode` / `set_stockname` / `set_groupcode` / `set_groupname`. |

If a project needs different XML (extra fields, different pairing), **copy the template into `scripts/templates/`** and include that one from the project script instead of editing the library template.

## Per-project extension pattern — `scripts/`

Every shopsync project that talks to Money S3 contains the same handful of scripts:

- `scripts/products.php` — subclasses `MoneyS3\Products` and adjusts `load()` / `loadStoreCard` / `loadDescriptions` / `loadPrices` / `loadCategories`. Common tweaks:
  - Filter cards by a user-defined field (e.g. `if ($this->getItemVal('UzivatelskaPole/S3SH_Eshop') != "Ano") continue;`).
  - Change `$this->pair_field` to `Katalog` / `Zkrat` when the Money profile uses a different key.
  - Override `loadPrices()` to read a non-standard `<Hladina>`.
- `scripts/orders.php` — subclasses the **e-shop side's** orders class (e.g. `Opencart\Orders`, `Woocommerce\Orders`), builds `$data`, renders `lib/moneys3/templates/orders.php`, calls `MoneyS3\CallImport($file, "I_O+P+N")`. Per-project tweaks live in `loadOrder()` / `modifyOrder()`.
- `scripts/products_server.php` — pushes e-shop product data back into Money via `products_export.php`.
- `scripts/change_state.php` — watches Money order-status changes and propagates them to the e-shop.
- `scripts/templates/` — project-specific XML overrides where the base template isn't enough.

All these scripts begin with the same bootstrap:

```php
include "./config.php";
include "./lib/functions.php";
include "./lib/moneys3/products.php";   // or orders.php / invoices.php / inc.php
include "./bridge/client.php";
init();
```

## `temp_dir/money.sqlite`

Single pair-cache database, written by `MoneyS3\Products::load()` and read by the order/invoice templates:

```sql
CREATE TABLE sync_storecards (
    id          INTEGER PRIMARY KEY,
    code        TEXT,   -- value of $pair_field from KmKarta (UzivCode by default)
    guid        TEXT,   -- KmKarta/GUID
    storage_guid TEXT,  -- Sklad/GUID
    storage_code TEXT,  -- Sklad/KodSkladu
    storage_name TEXT,  -- Sklad/Nazev
    last_price  REAL,   -- last known net price
    last_stock  REAL    -- last known quantity on hand
);
PRAGMA journal_mode = wal;
PRAGMA synchronous = NORMAL;
```

`code` is the lookup column used by templates — `WHERE code = '$item["code"]'`, optionally `AND (storage_code = ? OR storage_name = ?)` when `getCfg(1,"vychozi_sklad")` is set.

A stock card that lives in several warehouses produces several rows in this table (one per warehouse). When `vychozi_sklad` is empty the first match wins — override in `scripts/products.php::postLoad` if the project needs deterministic warehouse selection.

## Config keys consumed by the library + templates

### Section 1 — "Objednávky" (orders, invoices)

- `ceny_s_dani` — prices arriving from the e-shop are gross (1) or net (0)
- `stredisko`, `zakazka` — Money centre/contract codes, emitted when non-empty
- `typ_dph` — default `<KodDPH>` on invoices
- `typ_skladoveho_dokladu` — optional `<ZkratkaTyp>` / `<Typ>` on invoices
- `bank_ucet` (default `"BAN"`), `predkontace` (default `"F001"`)
- `vychozi_sklad` — restricts the `sync_storecards` pair lookup to one warehouse
- `vychozi_cena` — default price level when none matches
- `objednavka_text`, `faktura_text` — description templates, support `[url]` substitution
- `id_prefix` — prefix fed into `create_guid()` for invoice GUIDs so multiple profiles on the same machine don't collide
- `moneys3_rozsirene_parovani_zakazniku` — extends the partner GUID/`KodPartn` hash to include name+company+street+postcode
- `oss`, `oss_hlavni_zeme` — OSS routing switch and home country
- `rada_objednavek`, `nulove_polozky`, `import_zakazniku`, `sklad_dle_importu` — additional behavioural flags (see `settings_gen.php`)

### Section 0 / `set_*` constants

Resolved by the shopsync profile loader into PHP `define()`s:

- `set_apppath` — absolute path to `Money S3.exe`
- `set_agenda` — `/a<agenda>` argument
- `set_year` — `/r<year>` argument
- `sw_user`, `sw_pass` — Money login (`sw_pass` goes into `/p<pass>`)
- `set_homecurrency`, `set_vat`
- `set_stockcode`, `set_stockname`, `set_groupcode`, `set_groupname` — defaults written into product exports
- `set_pricegroup1..6` — Money `Hladina/Zkrat` shortcuts
- `set_shoppergroup1..6` — e-shop customer-group IDs that each price level maps to

## Don'ts

- **Don't write to Money's DB directly.** There is no supported direct-DB path like Pohoda has — everything goes through `Money S3.exe /XML`.
- **Don't skip the `{...}` braces** around GUIDs in XML we send back to Money — some fields accept bare UUIDs but many reject them.
- **Don't hard-code warehouse codes in the library.** Use `set_stockcode` / `getCfg(1,"vychozi_sklad")`.
- **Don't remove the `sleep(2)`** in `CallImport` / `CallExport` — Money needs a moment to release its single-instance lock between consecutive calls.
