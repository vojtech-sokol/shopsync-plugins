---
name: mrp-ks
description: Dev helper for MRP K/S (MRP-Informatics) ERP integration. Covers the autonomous mode HTTP API (mrpEnvelope XML - EXPEO0/EXPEO1/EXPEO2 store cards, CENEO0 prices, IMPEO0 order import, EXPOP0/EXPOP1 order states, OP2SV0/SV2FV0 issue and invoice from order, EXPFV0-4/EXPFVPDF invoices and PDFs, ADREO0 addresses, codebooks, encryption), the command-line mode (mrpks.exe /c, MRPKSCmdLineData, EXPFAKVY/IMPFAKVY), the XML MRP-K/S 2.0 document format, direct Firebird reads, and the ShopSync PHP library lib/mrpks with its templates, known bugs and project patterns. Use when user mentions "mrp", "mrp ks", "mrp k/s", "mrpks", "autonomni rezim", "autonomní režim", an MRP command code like IMPEO0 or EXPEO1, or works in a project containing lib/mrpks/ or a folder name with mrpks/mrpvs.
user-invocable: true
argument-hint: [topic]
metadata:
  author: davehornik
  version: 1.0.0
---

# MRP K/S — Dev Helper

MRP K/S is a Czech/Slovak accounting + ERP system by **MRP-Informatics** (mrp.cz / mrp.sk) on a **Firebird** database (code page **Windows-1250**). Most ShopSync MRP clients are Slovak (home currency EUR, OSS main country SK).

ShopSync talks to it in three ways:

1. **Autonomous mode (HTTP API) — the main channel.** `MRPKS.EXE -A -F<company> -Y<user>,<pass>` runs as an HTTP server on a TCP port. ShopSync POSTs `<mrpEnvelope>` XML to `http://<set_apppath>` (`set_apppath` = `host:port`). Products, categories, pictures, order import, invoice PDFs.
2. **Command-line mode.** `mrpks.exe /c<full path to MRPKSCmdLineData.xml>` — batch invoice export (`EXPFAKVY`) and import (`IMPFAKVY`).
3. **Direct Firebird reads** (`ibase_connect`) in project `order_states.php` scripts — invoice ↔ order pairing, order states. Read-only.

PHP library: `lib/mrpks/` (namespace `MRPKS`), canonical copy `C:\lib\mrpks`; every project has its own drifting copy — **read the project's copy first**.

## References

- [references/autonomous-api.md](references/autonomous-api.md) — envelope, `requestId` idempotency, errors, filter syntax, paging, encryption, **every command** with filters, response datasets and field lists, IMPEO0 attribute limits and address matching, OP2SV0 error codes, troubleshooting
- [references/xml-2-0-reference.md](references/xml-2-0-reference.md) — `MRPKSData` format: CalcParams, TaxCode/VatRegime/OSS, CZ vs SK VAT ids, issued/received invoice, order, store card, stock movement, address and codebook fields
- [references/cmdline-mode.md](references/cmdline-mode.md) — `MRPKSCmdLineData`, `ResultsFileName` result codes, profiles, all command-line commands and filters, how `CallImport`/`CallExport` use it
- [references/library-reference.md](references/library-reference.md) — `lib/mrpks` files, config constants, settings groups, `Products`/`Categories`/`Pictures`/`Invoices`/MCP classes, produced data model, templates
- [references/known-issues.md](references/known-issues.md) — **read before changing or debugging anything**: bugs in the library/templates with fixes, doc discrepancies, unused API capabilities, security notes
- [references/project-patterns.md](references/project-patterns.md) — how the 63 real projects are built: products overrides, BB-TECHNIK coefficients, order flow, order → issue → invoice chain, Firebird tables/columns, customers/B2B prices, new-install checklist

Scripts (standalone PHP, no ShopSync dependency):
- [scripts/mrpks_codec.php](scripts/mrpks_codec.php) — `mrpksParseResponse()` (detects `status/error`), `mrpksDatasetRows()`, `mrpksEncodeRequest()`/`mrpksDecodeResponse()` for encrypted/compressed communication. `php mrpks_codec.php` = self-test against the official MRP test vectors (all pass).
- [scripts/mrpks_probe.php](scripts/mrpks_probe.php) — `php mrpks_probe.php host:port [request.xml|COMMAND] [--key=..] [--zlib] [--out=..]`: connectivity check, run a saved request, dump codebooks (`EXPUHRADY`, `EXPDOPRAVA`, …), pretty-print datasets and errors.

Request templates (copy and adapt): [assets/requests/](assets/requests/) — `expeo1_products_incremental.xml`, `expeo1_stock_only.xml`, `expeo0_card_large_image.xml`, `expeo1_attachments.xml`, `expeo2_stockcards_xml20_paged.xml`, `ceneo0_price_group.xml`, `impeo0_order_full.xml` (every attribute with limits), `expop0_order_states.xml`, `expop1_orders_xml20.xml`, `op2sv0_issue_from_order.xml`, `sv2fv0_invoice_from_issue.xml`, `expfv1_invoices_with_payments.xml`, `expfvpdf_invoice_pdf.xml`, `impfv0_invoice.xml`, `adreo0_addresses.xml`, `codebook_payment_types.xml`, `cmdline_expfakvy.xml`, `cmdline_impfakvy.xml`.

Official sources: FAQ 483 autonomous mode https://faq.mrp.cz/faqcz/FaqAnswer.aspx?cislo=483 · FAQ 403 command line https://faq.mrp.cz/faqcz/FaqAnswer.aspx?cislo=403 · FAQ 392 XML 2.0 field lists + samples https://faq.mrp.cz/faqcz/FaqAnswer.aspx?cislo=392. Local copy (Dave's PC): `C:\Temp\mrpks_podklady\` (`faq_*.html`, `docs\*.txt` in cp1250, sample `*.XML`). Internal setup guide: `C:\shopsync_docs\docs\navody\erp\mrpks\`.

## Which command for what

| Task | Autonomous mode (HTTP) | Notes |
|---|---|---|
| Products, stock, prices, catalog | `EXPEO1` (`lib/mrpks` default), `EXPEO2` (XML 2.0, paged, per-warehouse) | incremental via `SKKAR.UPD_DATE`; prices are not in UPD_DATE |
| Stock/prices only | `EXPEO1` + `stavy=T` | |
| One card's image | `EXPEO0` + `SKKAR.CISLO` + `velObraz=T` | never images for the whole catalog |
| Customer price groups | `ADREO0` (`censkup`) + `CENEO0` | |
| Order e-shop → MRP | `IMPEO0` | answer `<cislo>` = MRP order number |
| Order state MRP → e-shop | `EXPOP0` (or Firebird `OBJPR.VYBAVENE`) | |
| Issue + invoice from order | `OP2SV0` → `SV2FV0` | |
| Invoices MRP → e-shop (+ payments) | `EXPFV1` (HTTP) or command-line `EXPFAKVY` (`lib/mrpks`) | |
| Invoice PDF | `EXPFVPDF` (render now), `EXPFV2` (stored PDF) | |
| Invoice e-shop → MRP | `IMPFV0` (one per request) or command-line `IMPFAKVY` | |
| Codebooks for settings mapping | `EXPUHRADY`, `EXPDOPRAVA`, `EXPTYPYDPH`, `EXPCISRAD0`, `EXPSKLADY`, `EXPCENSKUP` | |

Every command must be **enabled** in the MRP autonomous-mode *Profily*; the profile can also force filters (warehouse, price number, card range).

## Script bootstrap

```php
include "./config.php";
include "./lib/functions.php";
include "./lib/mrpks/inc.php";
include "./lib/mrpks/products.php";
include "./lib/shoptet_api/inc.php";        // target e-shop library
include "./lib/shoptet_api/products.php";
init();

class CustProducts extends MRPKS\Products {
    public $pair_field = "kod1";            // cislo (lib default) | kod (EAN) | kod1 | kod2 | kod3 | usrfldN
    public function loadPrices() { parent::loadPrices(); /* project price logic */ }
}
$p = new CustProducts();
$p->load(getLastUpd("products", "file"));   // fills $p->data + sqlite map sync_storecards
```

Orders: `applyTemplate($order, "./scripts/templates/orders.php", temp_dir . "/objednavky_mrpks_<n>.xml")` → `MRPKS\sendRequest(set_apppath, $xml)` → parse the answer → record in `mrpks.sqlite/sync_orders`.

## Critical rules

1. **HTTP 200 ≠ success.** Errors are in `body/mrpResponse/status/error` (`errorCode`, `errorClass`, `errorMessage`). Parse every answer (`mrpksParseResponse()`); for IMPEO0 require `<cislo>`, for OP2SV0 `<scislo>`, for SV2FV0/IMPFV0 `<DocumentNumber>`.
2. **`requestId` is idempotent for ~12 h.** A repeated id returns the cached answer and does nothing. Retries need a new id; check `EXPOP0` (`OBJPR.ORIGCISLO`) first to avoid duplicates.
3. **Windows-1250 only.** Strip emoji/foreign scripts before sending. Filters use the MRP PC's locale (`d.m.yyyy`, `j.n.Y H:i`).
4. **Length limits** (IMPEO0): `formaUhrady`/`zpusobDopravy` **10** and must exist in the MRP codebooks; `adresa id` 10; `ulice`/`mesto` 30; `jmeno`+`prijmeni` < 30; `polozka text` 50; `poznamkaPolozky` 20. The bundled template violates several of these (known-issues B1, B2, B6).
5. **VAT ids:** `dic` = DIČ (CZ: `CZ12345678`), `ic_dph` only in the **SK** version. XML 2.0: `VatNumber` = DIČ, `VatNumberSK` = IČ DPH (SK only).
6. **Card lookup in orders** goes `cisloKarty` → `eanKarty` → `kodKarty` (the last two only with MRP's uniqueness check on). `lib/mrpks` sends `cisloKarty` from the local `sync_storecards` map → run a product sync before the first order.
7. **Stock**: free = `pocetmj − pocrezmj`; `stavy` has one row per card **per warehouse** — the library keeps only the last row.
8. **Empty XML elements** become arrays after `simpleXmlToArray()` → `MRPKS\flatArray()`; single-row datasets → `MRPKS\asArray()`.
9. **`set_apppath` = `host:port`** without `http://` (the library adds it). It is also (mis)used as the exe path by `CallImport`/`CallExport`.
10. **Never write to Firebird tables.** Reads only (`OBJPR`, `FAKVY`, `FAKVYUHR`, `ADRES`, `SKKAR`, `SKPOH`, `KURZY`); all writes go through IMPEO0/IMPFV0/IMPSP0/OP2SV0/SV2FV0 or command-line imports.
11. **Never send write commands to a production MRP "to test".** Use the probe with read-only commands; test orders only with the client's agreement.
12. **No secrets in code or skills** — MRP/Firebird credentials come from the profile (`sw_user`, `sw_pass`); command-line XML with `UserPwd` lives only in `temp_dir`.

## Debugging quick list

- `php scripts/mrpks_probe.php host:port` → reachability + profile check (EXPEO1 that matches nothing).
- `temp_dir/test.xml` = last raw EXPEO1 answer written by `Products::load()`.
- `temp_dir/objednavky_mrpks_<n>.xml` = last rendered order — validate as XML, check lengths, resend with a **new** `requestId`.
- `getCfg(8, "debug") >= 2` → `sendRequest()` logs the raw request.
- Empty result → profile restriction / disabled command / locale date format / missing `|null` on first sync.
- Item without card in MRP → code missing in `sync_storecards`, or `$storecard` carry-over bug (known-issues B4).
