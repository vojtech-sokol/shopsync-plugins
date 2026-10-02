# Patterns from Real ShopSync MRP K/S Projects

Survey of 63 project folders with `lib/mrpks` in `C:\NEXTCLOUD\shopsync_dir2\` and `shopsync_dir3\` (Oct 2026). Project folder names follow `<eshop>_<erp>_<scope>_<client>`:
- `<eshop>`: `shoptet`, `presta`/`prestashop`/`presta81`, `woo`, `upgates`, `baselinker`/`base`, `creativesites`, `virtuemart`, `rocketoo`
- `<erp>`: `mrpks` (MRP K/S), `mrpvs` (MRP VS — Vizuální účetní systém, uses the same API family; note the XML-2.0 docs mark some fields "VS only"), `mrp`
- `<scope>`: `objsklad` (orders + stock), `obj` (orders), `fa`/`faktury` (invoices only), none = full
- Examples: `shoptet_mrp_bbtechnik`, `shoptet_mrpks_objsklad_pullmann`, `presta_mrpks_faktury_gigant`, `woo_mrpks_babica`, `shoptet_mrpks_bwd` (CZ + SK profile: `scripts/` and `scripts_sk/`)

Some `pohoda`/`premier` projects also ship `lib/mrpks` just because the whole `lib/` was copied — ignore those.

## 1. Project layout

```
<project>/
  config.php              constants (template; real values come from profiles)
  settings.json, settingsset.json
  profiles/<profile>.json sw=7 for MRP, sw_exe=host:port, customsettings[] (groups 1..8)
  lib/                    copied libraries (lib/mrpks, lib/shoptet_api, lib/functions.php, ...)
  scripts/                project overrides — THE place for client-specific code
    products.php  categories.php  pictures.php  customers.php
    orders.php    order_states.php  invoices.php
    templates/orders.php  templates/invoices.php  templates/vydejka.php  templates/invoice.php
  scripts_sk/             second profile (e.g. .sk shop) with its own overrides
  debug/                  debug scripts and saved request XMLs (objednavky_mrpks_<n>.xml)
  shopsync_temp/ or temp/ temp_dir: test.xml (last EXPEO1 answer), mrpks.sqlite, *_last.txt, generated XML
  mrpauto.bat             starts MRPKS.EXE -A -F<n> -Y<user>,<pass> on the client PC
  bridge/ phpruntime/     ShopSync client runtime
```

Bootstrap used by every script:

```php
include "./config.php";
include "./lib/functions.php";
include "./lib/mrpks/inc.php";
include "./lib/mrpks/products.php";      // or categories/pictures
include "./lib/shoptet_api/inc.php";     // target e-shop lib
include "./lib/shoptet_api/products.php";
init();                                  // loads profile customsettings into getCfg()
```

## 2. Products (`scripts/products.php`)

```php
class CustProducts extends MRPKS\Products {
    public $pair_field = "kod1";        // what the e-shop code is
    public $only_on_stock = false;
    public $request = "...EXPEO1 ... <fltvalue name=\"SKKAR.UPD_DATE\">&gt;[last]|null</fltvalue> ...";

    public function loadStoreCard() { parent::loadStoreCard(); /* tweak code/id */ }
    public function loadPrices()    { parent::loadPrices();    /* price levels, min price */ }
    public function loadStock()     { parent::loadStock();     /* sums, coefficients */ }
}
$p = new CustProducts();
$p->load(getLastUpd("products", "file"));
// then the e-shop library's writer consumes $p->data
```

`$pair_field` in the projects: `cislo` 28×, `kod1` 17×, `kod`, `kod2`, `kod3`, `nazev` 1× each (`IDS`/`PLU`/`VPrgroupid` hits are Pohoda copies). So pairing by card number or user code 1 dominates — ask before assuming EAN.

Request filters seen: `SKKAR.UPD_DATE` (incremental), `malObraz`/`velObraz` = F, `poleDetail2` = T (second description), `SKKAR.KOD3` = `ANO` (e-shop flag in user code 3), `SKKAR.USRFLD4/5`, `SKKARSTA.POCETMJ`, `cisloSkladu`, `mena`. **Watch out:** many scripts carry leftover debug ranges like `SKKAR.CISLO 1925..1926` next to the request string — if one ends up inside the active `$request`, production syncs only those cards.

Price mapping: MRP has 5 selling prices (+ stock price 0). Base e-shop price = `cena`/`cenasdph` (= price chosen by `cisloCeny`, default 1, or the profile). Extra price lists via `set_pricegroupN` (MRP price number) → `set_shoppergroupN` (e-shop customer group/pricelist id). Foreign-currency prices: `mena`/`meny` filter → `zahrceny` dataset (slavicek, karavanypro variants).

### BB-TECHNIK (`shoptet_mrp_bbtechnik`) — unit coefficients and price levels

Reference implementation for "MRP sells per 100 pcs, e-shop per 1 pc":
- `$pair_field = "kod2"`; `id` forced to end with `.00`/`.01`.
- Stock is **summed across all cards sharing the same `kod2`** (first pass over `karty`), then multiplied by the coefficient.
- Coefficient from **user field 1** (`usrfld1`, e.g. `100`): e-shop price = MRP price / coefficient, e-shop quantity = MRP quantity × coefficient. Coefficients cached in `temp_dir/koeficienty.json` for the order direction.
- Orders back to MRP: `price × coefficient`, `count / coefficient` (customer buys 1 pc → MRP line 0.01).
- Minimum price `$min_price = 0.01`; price 5 → main Shoptet price list, prices 1–4 → further price lists.
- Shipping line mapped to a card by code (`DPD` → `DOPRAVA`).
- Debug helpers: `debug_mrp_data.php`, `debug_price_one.php`, `debug_resync_one.php`, `debug_invoices.php`.

## 3. Orders e-shop → MRP (`scripts/orders.php`)

Standard flow:

```php
$orders = new CustOrders();                       // extends <Eshop>\Orders, map payment/carrier/company
$orders->load(filter_ord, getLastUpd("orders", "file"));
$sqlite = new SQLite3(temp_dir . "/mrpks.sqlite");
$sqlite->exec("create table if not exists sync_orders (number text primary key, response text)");
foreach ($orders->data as $d) {
    if (already in sync_orders) continue;
    $xml = applyTemplate($d, "./scripts/templates/orders.php", temp_dir . "/objednavky_mrpks_" . $d["number"] . ".xml");
    $r = MRPKS\sendRequest(set_apppath, $xml);
    // GOOD variant (pullmann): preg_match('/<cislo>(.*?)<\/cislo>/') -> store MRP number
    // BAD variant (most): if ($r[0] == "200") insert ... -> errors are marked as done (known-issues A1)
}
setLastUpd("orders", "file");
```

- Shoptet projects first check webhooks (`Shoptet\getHooks("order", $last)`) and reload the full window when the hour changed.
- Order states that must not reserve stock are excluded in `load()` (BB: `["-4"]`).
- The rendered XML is kept as `temp_dir/objednavky_mrpks_<number>.xml` — replayable with command-line `IMPEO_XML` or the probe script (`scripts/mrpks_probe.php host:port file.xml` — mind `requestId` replay).

### Order → stock issue → invoice chain (pullmann, lemitas, bukovy, slavicek, quadroflex, babica, 123kolo)

When the e-shop issues the invoice, MRP should create the issue and invoice from its own order:

1. `IMPEO0` → store `<cislo>` (MRP order number) in `sync_orders(number=<eshop no>, response=<cislo>)`.
2. On the e-shop invoice: `OP2SV0` with `<paramvalue name="cislo">` = MRP order number → `<scislo>` (e.g. `001V000000340`) stored as `sync_orders(number="vyd_<eshop no>")`.
3. `SV2FV0` with `WarehouseDocumentNumber` = scislo → `<DocumentNumber>` stored as `"fa_<eshop no>"`.
Templates `scripts/templates/vydejka.php` and `invoice.php` are 10-line request envelopes with `requestId = <id_prefix>_<number>`.

## 4. Order states / invoice PDFs MRP → e-shop (`scripts/order_states.php`)

Most projects read Firebird directly (≈ 50 scripts):

```php
$db = ibase_connect(set_pohoda_db, sw_user, sw_pass, "NONE", 0);   // set_pohoda_db = "host/3050:D:\MRPKS\DATA\DATA0120.MRP"; charset "NONE" as in BB-TECHNIK - data are cp1250, convert with autoUTF()
$sql = "SELECT FAKVY.IDFAK AS ID, FAKVY.CISLO AS FACISLO, OBJPR.CISLO AS OBJCISLO,
               OBJPR.ORIGCISLO AS ORIGCISLO, FAKVY.DATVYSTAVE
        FROM OBJPR JOIN FAKVY ON FAKVY.CISLOOBJED = OBJPR.CISLO
        WHERE FAKVY.DATVYSTAVE > '" . date("Y-m-d", strtotime("-3 days")) . "'";
// per row: MRPKS\GetPDFInvoice(FACISLO, temp_dir/faktury/<file>.pdf) -> ftp_upload -> e-shop note / document link
```

- PDF file names include a hash (`md53("FA " . db_pass . " " . ID)`) so the public URL is not guessable.
- BB-TECHNIK keeps processed pairs in sqlite `invoiced_orders(doc_number, shoptet_number, processed_at)` and registers the PDF in Shoptet (history comment, `[FAKTURA:]` tag, per-customer JSON).
- State sync: `SELECT CISLO, ORIGCISLO, VYBAVENE, DATUM, USRLOCK FROM OBJPR WHERE DATUM > ...` — `VYBAVENE = 0` → fulfilled → change e-shop status.
- HTTP-only alternative (no Firebird credentials needed): `EXPOP0` for states and `EXPFV1` filter `OriginalOrderNumber` + `EXPFVPDF` for PDFs.

### Firebird tables/columns seen in projects

MRP K/S runs on Firebird; column names are mostly Slovak-derived (`NAZOV`, `CIASTKA`, `ULICA`, `MENO`, `OZNACENIE`).

| Table | Columns used | Meaning |
|---|---|---|
| `OBJPR` | `CISLO`, `ORIGCISLO`, `DATUM`, `VYBAVENE`, `USRLOCK`, `ICO` | received orders (`ORIGCISLO` = e-shop number) |
| `FAKVY` | `IDFAK`, `CISLO`, `CISLOOBJED`, `DATVYSTAVE`, `DATSPLATNO`, `CELKEM`, `VARSYMB`, `ICO`, `DOBROPIS_PRO` | issued invoices (`CISLOOBJED` → `OBJPR.CISLO`; `DOBROPIS_PRO` = credit note for) |
| `FAKVYUHR` | `IDFAK`, `CIASTKA`, `DATUM` | payments of issued invoices |
| `ADRES` | `ID`, `ICO`, `EMAIL`, `FIRMA` | address book |
| `SKKAR` | `CISLO`, `KOD1`, `NAZOV` | store cards |
| `SKPOH` | `IDPOH`, `CISLOPOH`, `CIASTKA`, `DATUM`, `DRUHPOHYBU`, `ICO` | stock movements |
| `SKKARKUS` | `CISLOKAR`, `IDPOH`, `OZNACENIE`, `DATUMPOH` | serial numbers / batches per movement |
| `KURZY` | `MENA`, `DATUM` | exchange rates (`... fetch first 1 rows only`) |

Rules: **read-only** (never write to MRP tables directly — use the API), Firebird SQL dialect (`ROWS n`, `FIRST n`, `fetch first n rows only`), string comparisons on CHAR columns need `TRIM()`. Default `SYSDBA/masterkey` must not be hard-coded (known-issues H).

## 5. Customers and B2B prices (`scripts/customers.php`)

- `ADREO0` (optionally filtered by `ico`, `ADRES.FAKSTRED`, `ADRES.USRFLD1`) → e-shop customer accounts. Rows with `/` in `ico` are delivery sub-addresses (created by IMPEO0 matching) → attach as delivery address of the main IČO. Only rows with `id` (came from the e-shop) and e-mail are synced in bwd/boty_prestige/lemitas.
- `censkup` → customer group; `CENEO0` per `cenovaSkupina` (`cenySDPH=F`) → group price list (lemitas).

## 6. Invoices e-shop → MRP (`faktury`/`fa` projects)

`scripts/invoices.php`: e-shop invoices (and credit notes via `templates/creditnote.php`) → `applyTemplate(..., temp_dir/mrpks_faktury.xml)` (XML 2.0 `IssuedInvoices`). The `MRPKS\CallImport(...)` line is usually commented out — the import runs through a separately prepared command-line file (`IMPFAKVY` + profile `FVIMPPROF`) or manually from MRP. The HTTP alternative is `IMPFV0` (one invoice per request, returns `DocumentNumber` + `UUID`).

## 7. Pictures

- Default: `velobr` file name from MRP → file looked up in `img_dir` (customer copies images there) or downloaded once via EXPEO0 `velObraz=T`; gallery via `<name>_0..9.jpg`.
- `vodila`: card attachments via `prilohy=T` (`docname` like `OBR-<code>.URL`, `doctext` = UNC path to the image on the client's server).

## 8. New installation checklist

1. Client PC: MRP K/S client with a **dedicated licence** for the autonomous mode; start `MRPKS.EXE -A -F<company> -Y<user>,<pass>` automatically after boot (scheduled task / startup).
2. *Nastavení režimu služby*: Http server + TCP port; encryption only if required (then implement `mrpks_codec.php` encoding).
3. *Profily*: enable `EXPEO0`, `EXPEO1`, `IMPEO0` (+ `ADREO0`, `CENEO0`, `EXPFVPDF`, `EXPFV1`, `EXPOP0`, `OP2SV0`, `SV2FV0`, codebooks as needed); set warehouse, price number, *Vždy přidat omezující podmínky*, series/středisko/zakázka for IMPEO0.
4. ShopSync profile: `sw=7`, `sw_exe = host:port` (no scheme, no space), VAT rates, home currency, temp/img dirs; group 2/3 mappings must use MRP codebook texts (≤ 10 chars) — read them with `php scripts/mrpks_probe.php host:port EXPUHRADY` / `EXPDOPRAVA`.
5. Probe: `php scripts/mrpks_probe.php host:port` → `OK`. Then full product sync (fills `sync_storecards`), check `temp_dir/test.xml`.
6. One test order → check the answer has `<cislo>`, check in MRP: address (IČO/`id`), card numbers on all lines, payment/delivery text, VAT, rounding.
7. Only then enable automatic transfers.
