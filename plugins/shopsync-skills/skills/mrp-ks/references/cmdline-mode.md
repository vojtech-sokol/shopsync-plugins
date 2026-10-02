# MRP K/S Command-Line Mode Reference

Source: MRP FAQ 403 "API - Command line režim" (https://faq.mrp.cz/faqcz/FaqAnswer.aspx?cislo=403, revision 9.1.2018 + later additions).

Use it when a command exists only here (`EXPFAKVY` bulk export to a file, `IMPFAKVY` batch import with a profile, `EXPSKKAROBRAT`, `EXPORTKARET`, `EXPORTSKPOH`, `IMPEO_DBF`) or when no autonomous-mode licence is available. For anything the HTTP API offers (`EXPFV1`, `IMPFV0`, `EXPEO*`, `IMPEO0`), prefer the API: it is synchronous, returns errors per request and needs no exe on the integration machine.

## 1. Invocation

```
"C:\Program Files (x86)\MRP\MRPKS\mrpks.exe" /cC:\full\path\command.xml
```

- No space after `/c`. Always a **full path** (do not rely on the working directory).
- MRP does not care how it is started (Task Scheduler, PHP `COM("WScript.Shell")->Run(..., 0, true)` as in `lib/mrpks`, …).
- The run connects to the database exactly like an interactive client → it **consumes a licence**; when all licences are in use the commands are refused.
- The MRP user must have **"Plný přístup"** for every command: *Nastavení – Správce – Uživatelé – (user) – Adresy a nastavení – Nastavení – Command line režim*.
- Log of every run is local to the workstation: *Nastavení – Program – CommandLine režim – Profily a nastavení – Zobrazit log* (shows the log path).

## 2. Command file `MRPKSCmdLineData`

```xml
<?xml version="1.0" encoding="UTF-8"?>
<MRPKSCmdLineData>
  <ConnectionInfo>
    <ServerIPAddress>localhost/3050</ServerIPAddress>     <!-- Firebird host/port -->
    <DatabasePath>C:\MRPKS_DATA\DATACZ25</DatabasePath>   <!-- data dir (new layout) or ...\DATA\DATA0023.MRP (old layout) -->
    <UserName>MRPDBA</UserName>
    <UserPwd>***</UserPwd>
    <FirNumber>102</FirNumber>                            <!-- company number -->
    <DebugMode>1</DebugMode>                              <!-- optional -->
    <ResultsFileName>C:\temp\mrpks_cmdline_results.xml</ResultsFileName>
  </ConnectionInfo>
  <CommandList>
    <Command>
      <CommandCode>EXPFAKVY</CommandCode>
      <ProfCode>...</ProfCode>      <!-- profile "Kód/Označení"; must exist if given -->
      <Path>C:\temp\out.xml</Path>  <!-- file, or mask C:\in\*.xml for imports -->
      <FileType>csv</FileType>      <!-- some exports -->
      <CashRegisterIdentif>PK001</CashRegisterIdentif> <!-- IMPPOKDOK* -->
      <Filter> <DocumentNumber>21*</DocumentNumber> ... </Filter>
    </Command>
    <!-- more <Command> elements run sequentially -->
  </CommandList>
</MRPKSCmdLineData>
```

Notes:
- Filters are **elements** (`<Filter><IssueDate>01.03.2023..31.03.2023</IssueDate></Filter>`), not `fltvalue` as in the HTTP API. Same expression syntax (see `autonomous-api.md` §3).
- Do not run two exports in a row to the same output file — the second overwrites the first.
- Content must fit Windows-1250 (database code page).
- The command file contains the MRP password in clear text — generate it into `temp_dir` per run and delete it afterwards; never commit it.

### Results file

With `<ResultsFileName>` MRP re-saves the command XML there and adds to every `<Command>`:

```xml
<Results>
  <Result>1</Result>
  <Message>Příkaz vykonán bez chyb</Message>
  <MessageDetail></MessageDetail>
  <Count>1</Count>
  <Data> <MRPKSData ...> <IncomingInvoices><Invoice><DocumentNumber>WFW00011</DocumentNumber><UUID>...</UUID></Invoice></IncomingInvoices></MRPKSData> </Data>
</Results>
```

| Result | Meaning |
|---|---|
| 0 | not specified |
| 1 | executed without errors |
| 2 | bad command |
| 3 | insufficient rights |
| 4 | command is paused (double-click the panel under the command list in the MRP settings to pause/resume) |
| 5 | profile not given |
| 6 | bad profile |
| 7 | bad parameter file — profile with this code not found |
| 8 | paid add-on module required |
| 9 | error loading the parameter file |
| 10 | bad filter conditions |
| 11 | file error (path/file missing, read/write error) |
| 12 | executed partially, some errors |
| 13 | execution error (e.g. `MessageDetail`: document with UUID … already exists) |
| 14 | bad/missing `CashRegisterIdentif` |

`lib/mrpks` does **not** use `ResultsFileName` — it only checks that the output file exists. Add it for any new command-line code and parse `Result`.

## 3. Profiles

*Nastavení – Program – CommandLine režim – Profily a nastavení*. Left: command list (`<CommandCode>`); right: profiles of the selected command, column *Označení* = `<ProfCode>`. Profiles hold defaults for data missing in the file (e.g. IMPFAKVY: "Profil pro import daňových dokladů", "Profil pro import předfaktur"). Not mandatory for every command, but if `ProfCode` is given it must exist. ShopSync convention: `FVIMPPROF` for invoice import.

## 4. Commands

### Invoices, receivables, payables

| Code | Purpose / notes |
|---|---|
| `IMPFAKVY` | import issued invoices (XML 2.0) from one or more files (`*.xml` mask). **Files are deleted afterwards regardless of success.** |
| `IMPFAKVY1` | import ONE issued invoice; `Results/Data` returns its `UUID` + `DocumentNumber` |
| `EXPFAKVY` | export issued invoices (XML 2.0) — what `lib/mrpks` uses for invoice sync |
| `EXPFAKVYPDF` | export ONE invoice with generated PDF in `Attachments` (filter `DocumentNumber` or `UUID`, single value; FastReport template from the mandatory profile; the template must not show dialogs) |
| `IMPFAKPR` / `IMPFAKPR1` | import received invoices / one received invoice |
| `EXPFAKPR` | export received invoices (filters as EXPFAKVY minus `OriginalOrderNumber`) |
| `IMPOSPOH1` / `IMPOSZAV1` | import one other receivable / payable |

`EXPFAKVY` filters: `DocumentNumber`, `UUID` (one value only), `CompanyId`, `PaymentState` (0 all, 1 all with payments to `PaymentsToDate`, 2 paid, 3 unpaid, 4 overpaid, 5 underpaid, 6 paid+overpaid), `PaymentsToDate` (single date), `IssueDate`, `TaxPointDate`, `PaymentDueDate`, `CostCentre`, `ContractNumber`, `OrderNumber`, `OriginalOrderNumber`.

### Accounting journal, cash desk, codebooks

| Code | Notes |
|---|---|
| `IMPUCDE` / `EXPUCDE` | journal; EXPUCDE filters `SourceDocument`, `CostCentre`, `ContractNumber`, `Activity`, `Date`, `PairingSymbol`, `DocumentNumber`, `Text`, `Archive` (1 all, **2 current period = default**, 3 archive), `AccountsFilter` |
| `IMPPOKDOK` / `IMPPOKDOK1` | cash vouchers; `<CashRegisterIdentif>` mandatory |
| `EXPOSNOVA` / `IMPOSNOVA` | chart of accounts |
| `EXPCISRAD`, `EXPCISPOKL`, `EXPSTREDISKA`, `EXPZAKAZKY`, `EXPTYPYDPH`, `EXPDOPRAVA`, `EXPUHRADA`, `EXPTYPYPOL`, `EXPTYPYPLN`, `EXPCINNOSTI`, `EXPKONTAKTY`, `EXPCENSKUP`, `EXPPREDKONT`, `EXPSKLADY`, `EXPSKUPZBOZI`, `EXPKATZBOZI`, `EXPPDPOHYBY` | codebooks in XML 2.0 (note the different codes vs. the HTTP API: `EXPUHRADA` here, `EXPUHRADY` there; `EXPSTREDISKA` vs `EXPSTR0`, …) |
| `EXPADRES20` | addresses XML 2.0; filters `CompanyId`, `VatNumber`, `VatNumberSK`, `Name`, `CustomerName`, `City`, `ZipCode`, `CountryCode`, `NaturalPerson`, `AddressFormationDate`, `UserField1..5` |
| `IMPORTADRCSV` | (paid) import addresses from CSV; header row with exact field names (ICO, FIRMA, FIRMA2, JMENO/MENO, ULICE/ULICA, MESTO, KODSTAT, PSC, DIC, IC_DPH, ICOPRIJ, TELEFON*, EMAIL, FYZOSOB, CENSKUP, ID (50, external id), SPLATNOST, FORMAUHRAD, SPOSOBDOPR, FAKSTRED, KODADR, USRFLD1..5, …) |

### Stock

| Code | Notes |
|---|---|
| `EXPSKKAROBRAT` | cards with turnover for a period; `<FileType>` csv (default) / xls / xlsx / ods / dbf. Columns: CardNumber, EAN, Code1..3, GroupCode, Name, Name2, SupplID, SupplName, UnitCode, ItemType, Note, UsrFld1..5, SaleQuant, SaleAmnt, PurchQuant, PurchAmnt, DateFrom, DateTo. Filters: WarehouseNumber, WarehouseTransactionType (P normal, V retail, M transfer, I inventory; default `P\|V`), WarehouseTransactionType2, CompanyId, Date, CostCentre, ContractNumber, StockCardNumber, ItemType, Name |
| `EXPORTKARET` | cards via a user-defined export profile of the card list (format from the profile; the extension of `<Path>` is changed accordingly). Filters: WarehouseNumber, StockCardNumber, ItemType, Name, EAN, Code1..3, GroupCode, Quantity, Catalog, Note, Memo, Used, UsrFld1..5, Active, Location, UnitCode |
| `EXPORTSKPOH` | (paid) movements via a movement export profile. Filters: WarehouseNumber, Date, LogDate, DocumentNumber, WarehouseIncomeDocument (T/F), WarehouseDocumentNumber (`V2020*`), WarehouseTransactionType |

### Orders

| Code | Notes |
|---|---|
| `IMPEO_DBF` | import e-shop orders from DBF tables `ADRESY.DBF`, `ZAKAZKY.DBF` (header), `POZNAMKY.DBF`, `ZAKTEXT.DBF` (lines). Files are renamed after import. Card lookup in ZAKTEXT: card number, then `EANKAR`/`KOD` (EAN, only with uniqueness check), then `KODKAR`/`KOD1`. Prices in `CENPOL` are **net**. |
| `IMPEO_XML` | import orders in the **autonomous-mode IMPEO0 XML** format from files (deleted afterwards) — useful to replay a saved `objednavky_mrpks_*.xml` when the HTTP service is down |
| `IMPEO_SW` | (paid) import orders in Stormware (Pohoda) XML 2.0 format |
| `EXPORTOBJPR` / `EXPORTOBJVY` | (paid) received / issued orders via an export profile. Filters: Offer/Inquiry (T/F), DocumentNumber, Date, OriginalOrderNumber, CompanyId, WarehouseNumber, State (2 open, 1 partial, 0 done, -1 blocked, -2 centrally blocked), LogDate, StockCardNumber, Text |

## 5. How `lib/mrpks` uses it

- `MRPKS\CallExport($file, $name, $filter, $cmd, $firebird)` writes `temp_dir/<name>.xml` from `GenerateIni()` and runs `"<set_apppath>" /c<temp_dir>/<name>.xml` synchronously. `GenerateIni()` **hard-codes `EXPFAKVY`** (the `$cmd` argument is ignored), derives `DatabasePath = dirname(set_dbfile)` and `FirNumber = intval(basename(str_replace("DATA", "", set_dbfile)))` — works for `...\DATA\DATA0023.MRP` (→ 23) but gives 0 for the new `C:\MRPKS_DATA\DATACZ25` layout, where the company number is not in the path.
- `MRPKS\CallImport($file, $name)` runs `"<set_apppath>" /c<temp_dir>/<name>.xml` — the command file `<name>.xml` must already be in `temp_dir` (template `cfg_files/import_faktur.xml` with `[sw_user]`, `[sw_pass]`, `[temp_dir]` placeholders; the code that filled it is commented out). The `$file` argument is unused.
- Both use `set_apppath` as the **exe path**, while the HTTP functions use the same constant as **host:port**. A project cannot use both through these helpers — `mcp.php` therefore reads the exe from setting `1.mrpks_exe`.
- No results file is read; success = output file exists.
