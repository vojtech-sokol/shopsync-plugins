# Pohoda XML Reference

All XML communication with Pohoda goes through a single **command-line import interface**: write an XML file, write an `.ini` pointing to it, run `Pohoda.exe /XML <user> <pass> <ini>`, then read the response XML. The XML contract is defined by ~66 XSDs at `C:\Users\Vojtech Sokol\Documents\share\podklady\pohoda\xml_schema\*.xsd`.

## The `.ini` file

Created by `Pohoda\GenerateIni($xml_path, $pohoda_db, $check_duplicity)`:

```ini
[XML]
input_xml=c:\path\to\request.xml
response_xml=c:\path\to\request_response.xml
database='98765432_2025'
check_duplicity=1
format_output=0
```

- `input_xml` / `response_xml` - **must be backslashed absolute paths** (templates call `str_replace("/", "\\", ...)`).
- `database` - accounting-year DB name from `set_dbfile`, **quoted with single quotes**.
- `check_duplicity` - when 1, Pohoda dedupes by the XSD-defined identity keys (`numberRequested`, `extId`, etc.).
- `format_output` - 0 = compact, 1 = pretty-printed response.

Bundled `.ini` templates live in `lib/pohoda/cfg_files/` (`xml_kategorie.ini`, `xml_zasoby.ini`, `xml_objednavky.ini`, `xml_parametry.ini`, plus `_import` variants). Pass `$dont_generate_ini = true` to `CallImport` to reuse them.

## Command-line invocation

```
Pohoda.exe /XML "<sw_user>" "<sw_pass>" "<path to ini>"
```

Launched via `new COM("WScript.Shell")->Run($cmd, 0, false)` (window-state=0 hidden, wait=false). `Pohoda\CallImport` then polls `tasklist` for the new PID and `taskkill /F /T /PID …` on timeout.

Exit is **non-indicative** — Pohoda almost always exits 0. The only reliable success/failure signal is parsing `response_xml` and checking `<rsp:responsePackItem state="…">` attributes.

## dataPack envelope

Every import XML has this shape:

```xml
<?xml version="1.0" encoding="Windows-1250"?>
<dat:dataPack
    id="obj"
    ico="12345678"
    application="ShopSync"
    version="2.0"
    note="Import Objednávky"
    xmlns:dat="http://www.stormware.cz/schema/version_2/data.xsd"
    xmlns:typ="http://www.stormware.cz/schema/version_2/type.xsd"
    xmlns:ord="http://www.stormware.cz/schema/version_2/order.xsd"
    xmlns:inv="http://www.stormware.cz/schema/version_2/invoice.xsd"
    xmlns:adb="http://www.stormware.cz/schema/version_2/addressbook.xsd"
    xmlns:ftr="http://www.stormware.cz/schema/version_2/filter.xsd">
    <dat:dataPackItem id="unique-10-char" version="2.0">
        <ord:order version="2.0">
            ...
        </ord:order>
    </dat:dataPackItem>
</dat:dataPack>
```

- `encoding="Windows-1250"` is mandatory. Pohoda rejects UTF-8 inputs; helpers `utf2win()` / `xmlStr()` / `xmlSafe()` in `lib/functions.php` handle conversion + escaping.
- `ico=` must equal `set_ico` (the accounting unit's IČO). Mismatch = silent rejection.
- `<dat:dataPackItem id="...">` IDs must be unique **within one dataPack**. Common pattern: `substr(md52(serialize($d)."salt"), 0, 10)`.
- Pack many items (orders, invoices, stock cards) into **one** dataPack — single import call is far faster than one-per-item.

## Namespaces (all `http://www.stormware.cz/schema/version_2/<name>.xsd`)

### Core
| Prefix | XSD | Purpose |
|--------|-----|---------|
| `dat` | `data.xsd` / `data-package.xsd` | dataPack envelope |
| `typ` | `type.xsd` | Shared types: `numberRequested`, `extId`, `address`, `amount`, `currency`, `classificationVAT` |
| `ftr` | `filter.xsd` | `<ftr:filter>` - identify existing records for update/delete |
| `rsp` | `response.xsd` | Response pack (wrapped in `responsePack` / `responsePackItem`) |
| `lst` | `list.xsd` | Query/list operations |
| `lck` | `lock.xsd` | Locking / concurrency |

### Documents (the main business XSDs)
| Prefix | XSD | Import target |
|--------|-----|--------------|
| `inv` | `invoice.xsd` | Issued & received invoices, credit notes, advance invoices |
| `ord` | `order.xsd` | Received / issued orders |
| `enq` | `enquiry.xsd` | Enquiries |
| `ofr` | `offer.xsd` | Offers |
| `stk` | `stock.xsd` | Store cards (products) |
| `prm` | `parameter.xsd` | Product parameters (attribute definitions) |
| `ctg` | `category.xsd` | Categories (limited write support) |
| `adb` | `addressbook.xsd` | Address book (customers/suppliers) |
| `pri` | `prijemka.xsd` | Stock receipts |
| `vyd` | `vydejka.xsd` | Stock issues |
| `pre` | `prevodka.xsd` | Stock transfers |
| `pro` | `prodejka.xsd` | POS receipts |
| `idc` | `intDoc.xsd` | Internal documents |
| `bnk` | `bank.xsd` | Bank statements |
| `pay` | `payment.xsd` | Payments |
| `vch` | `voucher.xsd` | Accounting vouchers |
| `mov` | `movement.xsd` | Accounting movements |
| `sup` | `supplier.xsd` | Supplier prices |
| `str` | `store.xsd` | Store/depot definitions |
| `stg` | `storage.xsd` | Storage locations |
| `act` | `actionPrice.xsd` | Action prices |
| `dsc` | `discount.xsd` | Discounts |
| `ipm` | `individualPrice.xsd` | Per-customer prices |
| `gst` | `groupStocks.xsd` | Stock groups |
| `con` | `contract.xsd` | Contracts |
| `cen` | `centre.xsd` | Cost centres |
| `act` | `activity.xsd` | Activities |
| `rcc` | `recyclingContrib.xsd` | Recycling fees (OEEZ) |
| `rnb` | `registrationNumber.xsd` | Registration numbers |
| `est` | `establishment.xsd` | Establishments |
| `mks` | `mKasa.xsd` | mKasa POS |
| `svr` | `accountingSalesVouchers.xsd` | Sales vouchers |
| `vyr` | `vyroba.xsd` | Manufacturing |
| `nsr` | `numericalSeries.xsd` | Document numbering series |
| `isd` | `isdoc.xsd` | ISDOC e-invoicing |
| `prn` | `print.xsd` | **PDF print / export** (used by `Pohoda\GeneratePdf`) |

### List / codebook operations
`list.xsd`, `list_activity.xsd`, `list_addBook.xsd`, `list_centre.xsd`, `list_contract.xsd`, `list_stock.xsd` - for **reading** codebooks back out of Pohoda via XML rather than ODBC. Use sparingly; ODBC is faster.

### Special
- `documentresponse.xsd` - response wrapper used when requesting document confirmations.
- `automaticLiquidation.xsd` / `liquidationWithoutLink.xsd` - automatic invoice-payment pairing.
- `rulesPairing.xsd` - pairing rules.
- `sendEET.xsd` - EET (electronic sales records) sending.
- `GDPR.xsd` - GDPR consent records.

## Record actions (`<actionType>`)

Every document has an `actionType` block at the top of its body — tells Pohoda whether to create, update, or delete:

```xml
<stk:actionType>
    <stk:add/>                        <!-- create new -->
</stk:actionType>
```
```xml
<stk:actionType>
    <stk:update>
        <ftr:filter>
            <ftr:id>12345</ftr:id>    <!-- or <ftr:code>, <ftr:numberRequested>, … -->
        </ftr:filter>
    </stk:update>
</stk:actionType>
```
```xml
<stk:actionType>
    <stk:delete>
        <ftr:filter>…</ftr:filter>
    </stk:delete>
</stk:actionType>
```

Pattern in our templates: look up the Pohoda ID by the pair field **first via ODBC**, then emit `<add>` when no row exists, `<update>` with the found ID otherwise. This is why every template opens its own `odbc_connect()`.

## Filter types (`<ftr:filter>`)

- `<ftr:id>12345</ftr:id>` - Pohoda PK
- `<ftr:code>PROD-001</ftr:code>` - `IDS`-style business code
- `<ftr:numberRequested>ORD-123</ftr:numberRequested>` - document number
- `<ftr:extId><typ:ids>…</typ:ids><typ:exSystemName>ShopSync</typ:exSystemName></ftr:extId>` - external-system ID
- `<ftr:lastChanges>2026-01-01T00:00:00</ftr:lastChanges>` - used with list queries

## Identity (`<typ:extId>`)

Every record we create should carry an `extId` so the next sync can update it by our own key instead of relying on Pohoda's auto-assigned `ID`:

```xml
<typ:extId>
    <typ:ids>abc1234567</typ:ids>
    <typ:exSystemName>ShopSync</typ:exSystemName>
</typ:extId>
```

Combined with `check_duplicity=1` in the `.ini`, this prevents duplicate inserts on retry.

## Response file

`response_xml` contains `<rsp:responsePack>` wrapping one `<rsp:responsePackItem>` per input item:

```xml
<rsp:responsePack version="2.0" id="obj" ico="12345678" application="Pohoda" ...>
    <rsp:responsePackItem version="2.0" id="abc1234567" state="ok" >
        <ord:orderResponse version="2.0">
            <rsp:producedDetails>
                <rsp:number>OBJ-2026-0001</rsp:number>
                <rsp:id>456</rsp:id>
            </rsp:producedDetails>
        </ord:orderResponse>
    </rsp:responsePackItem>
    <rsp:responsePackItem id="xyz9876543" state="err">
        <rsp:state>error</rsp:state>
        <rsp:note>Some validation message</rsp:note>
    </rsp:responsePackItem>
</rsp:responsePack>
```

**Always parse the response.** A per-item `state="err"` means that single item was rejected; the rest of the pack still went through. Log the `<rsp:note>` text — it's the only hint about what failed.

## Windows-1250 & XML escaping

Use these helpers from `lib/functions.php` when filling templates:

- `utf2win($s)` - UTF-8 → CP1250 byte conversion
- `xmlSafe($s)` - `htmlspecialchars` + UTF-8→CP1250
- `xmlStr($s, $maxlen)` - `xmlSafe` + `maxLen` truncation to XSD limit
- `win2utf($s)` / `convertRes($val)` - reverse direction for data read back from ODBC or response XML

Never `echo` UTF-8 strings directly into a template that declares `Windows-1250` — Pohoda's XML parser chokes on the first non-ASCII byte.

## PDF print

`<prn:print>` is a special read-operation document: tells Pohoda to render an existing record (by filter) to a PDF file. `Pohoda\GeneratePdf` batches 10 at a time:

```xml
<prn:print version="1.0">
    <prn:record agenda="vydane_faktury">
        <ftr:filter><ftr:id>123</ftr:id></ftr:filter>
    </prn:record>
    <prn:printerSettings>
        <prn:report>
            <prn:id>87</prn:id>      <!-- Pohoda report template ID -->
        </prn:report>
        <prn:pdf>
            <prn:fileName>c:\out\fa123.pdf</prn:fileName>
        </prn:pdf>
    </prn:printerSettings>
</prn:print>
```

Agenda names (as used in `agenda="…"`): `vydane_faktury`, `prijate_faktury`, `prijate_objednavky`, `vydane_objednavky`, `prijemky`, `vydejky`, `prevodky`, `pokladna`, `interni_doklady`, `prodejky`, `sklady`, …

## What XSD file answers what question

- "What elements are allowed inside `<ord:order>`?" → `xml_schema/order.xsd`
- "What's the max length of `<typ:company>`?" → `xml_schema/type.xsd`, search for `company`
- "Can I set X on an invoice?" → `xml_schema/invoice.xsd`
- "What response shapes exist?" → `xml_schema/response.xsd` + the per-document `*Response` types in each agenda XSD

The XSDs are the authoritative contract; Stormware's HTML docs (`Import a export dat.html`) are a friendlier but sometimes out-of-date view.
