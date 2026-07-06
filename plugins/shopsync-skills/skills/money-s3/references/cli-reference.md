# Money S3 — command-line reference

The classic Money S3 integration has no network API — every import and every export is a child-process call to `Money S3.exe` with the `/XML` flag. On Windows shopsync runs this via COM:

```php
$command = new \COM("WScript.Shell");
$command->Run("\"" . set_apppath . "\" /XML /eXXXML /fc" . $profile . " /ftD /fw- "
    . "/a" . set_agenda . " /r" . set_year
    . " /ff" . str_replace("/", "\\", $file) . " /p" . sw_pass, 0, true);
```

(See `lib/moneys3/inc.php` — `MoneyS3\CallImport()` / `MoneyS3\CallExport()`.)

## Flags used

| Flag | Meaning | Notes |
|------|---------|-------|
| `/XML` | Enter XML-transfer mode | mandatory; everything below only applies in this mode |
| `/eXXXML` | Target engine: XML | |
| `/fc<profile>` | Transfer profile (configuration) name | must exist in Money; `I_...` = import profile, `E_...` = export profile (convention) |
| `/ftD` | File type: data (the business payload) | |
| `/fw-` | Warnings off (don't show modal dialogs) | use `/fw+` when you want the log popup |
| `/a<agenda>` | Target agenda (client company) | e.g. `/aFIRMA_2026` |
| `/r<year>` | Accounting year | e.g. `/r2026` |
| `/ff<file>` | Full path to the XML file | **backslashes only** — `str_replace("/", "\\", $file)` |
| `/p<password>` | Login password | username is the currently-active Money user |

Third argument of `Run(cmd, 0, true)` = `(..., WindowStyle, WaitOnReturn)`. Shopsync passes `0` (hidden) and `true` (synchronous) so the PHP script blocks until the import finishes.

## CallImport / CallExport in our library

```php
namespace MoneyS3;

function CallImport($file, $profile = "I_O+P+N") { ... }
function CallExport($file, $profile = "E_ZAS")  { ... }
```

Both functions:
1. `sleep(2)` to let any prior Money instance finish.
2. `echo` the full command line (visible in logs — useful when debugging mis-set profiles).
3. `Run(..., 0, true)`.
4. Log completion.

**Neither function parses the return code.** Money writes a log file (location depends on Money install) but errors are not surfaced into PHP. The XML file and the echoed command are the primary debug artefacts.

## Profile naming convention

| Profile name | Purpose | ExpZkratka it handles |
|--------------|---------|-----------------------|
| `I_O+P+N`    | **Import** of received orders, enquiries, offers | `_O+P+N` |
| `I_FP+FV`    | **Import** of issued / received invoices | `_FP+FV` |
| `I_ADR`      | **Import** of address book | `_ADR` |
| `I_ZAS`      | **Import** of stock cards (ceník / zásoby) | `_ZAS` |
| `I_S`        | **Import** of stock documents (prijemky, vydejky, ...) | `_S` |
| `E_ZAS`      | **Export** of stock cards | `_ZAS` |
| `E_O+P+N`    | **Export** of received orders | `_O+P+N` |
| `E_FP+FV`    | **Export** of invoices | `_FP+FV` |
| `E_ADR`      | **Export** of address book | `_ADR` |
| `E_eShopEZas`| **Export** of stock via E-shop konektor | `_eShopEZas` |

Profiles are configured **inside Money S3** (Nastavení → XML přenosy) — they must exist on the target Money instance before our scripts call them. When a new shopsync project is onboarded, whoever sets up Money on the customer's machine must create matching profiles with the right Key/Mode config.

## Import control — `_Import.xsd`

Money also supports a separate **Import instruction XML** that sits alongside the data XML and controls how records are matched and merged. Schema: `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys3\Schemas\_Import.xsd`.

Relevant structure:

```xml
<Import>
  <Entity name="Zasoba">
    <StandAlone>
      <Key auto="0" description="match by user code">
        <Field name="UzivCode"/>
      </Key>
      <Mode newValue="Append" existingValue="Update" noValue="Error"/>
    </StandAlone>
  </Entity>
</Import>
```

- `Key` — list of `<Field name="..."/>` entries defining the pairing key. `auto="1"` lets Money pick the key automatically (not recommended for sync work). Typical keys:
  - Stock cards — `UzivCode`, `Katalog`, `Zkrat`, or `BarCode` (classic mode) / `GUID` (konektor mode)
  - Orders — `Doklad` or `CObjednavk`
  - Invoices — `Doklad`
  - Partners — `KodPartn` or `ICO`
- `Mode/newValue` — what to do when no matching record exists: `Append` (insert), `NoAction` (skip), `Error`.
- `Mode/existingValue` — what to do when a match is found: `Append` (insert alongside), `Update`, `NoAction`, `Delete`, `Auto`, `Error`.
- `Mode/noValue` — what to do when the key field is missing in the incoming record: `Append`, `NoAction`, `Error`.

These instructions are stored inside the profile in Money's UI, not in our PHP code. Our side only picks the **profile name** via `/fc<profile>`; the profile itself carries the Key/Mode.

## Debugging failed imports

1. Confirm the echoed command line is sane (right agenda, year, profile, file).
2. Open the written XML file and validate it against its XSD in `Schemas\`.
3. Check Money's own log (`Nastavení → Protokoly → Přenosy`).
4. Temporarily switch `/fw-` to `/fw+` in `lib/moneys3/inc.php` so Money surfaces dialogs.
5. Verify the pairing key: the XML's key field must match the profile's `Key` in Money, and the value must exist (classic mode) or have a valid GUID (konektor mode).

## Export flow — what Money leaves on disk

When `CallExport()` runs, Money writes the XML to the path we passed in `/ff<file>`, encoded in **windows-1250**. Our side then reads it with `DOMDocument::load()` (PHP converts it to UTF-8 internally through the XML declaration). Example: `MoneyS3\Products::__construct` loads `temp_dir/zasoby_money.xml`.

`MoneyS3\CallExport()` in `lib/moneys3/inc.php` currently prints *"Import do MoneyS3 dokoncen"* even after an export — it's a cosmetic bug; the call itself is correct.
