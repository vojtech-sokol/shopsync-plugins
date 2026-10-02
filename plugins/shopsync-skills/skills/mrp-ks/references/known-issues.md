# Known Issues, Pitfalls and Unused Capabilities

Found by reading `C:\lib\mrpks`, 63 project copies, the MRP docs (FAQ 392/403/483) and real MRP responses (Oct 2026). Severity: **H** = wrong data / lost documents, **M** = breaks in some setups, **L** = cosmetic or edge case. Check the project's own lib copy — some issues are fixed or absent in individual variants.

## A. Transport and response handling

| # | Sev | Issue | Fix |
|---|---|---|---|
| A1 | **H** | **HTTP 200 is treated as success.** MRP returns 200 also when the command failed (`status/error`). Project `orders.php` scripts do `if ($vystup[0] == "200") { insert into sync_orders ... }` → a rejected order is marked as synced and **never retried**. Same pattern for OP2SV0/SV2FV0 in some projects (others regex `<cislo>`/`<scislo>`/`<DocumentNumber>` from the body — better). | Parse the body (`scripts/mrpks_codec.php` → `mrpksParseResponse()`); mark synced only if `ok` and the expected number came back; log `errorCode` + `errorMessage`. |
| A2 | **H** | **`requestId` replay.** MRP keeps executed `requestId`s ~12 h and answers repeats with the cached response without executing. Templates use `requestId = <id_prefix>_<order id>`, so a resend after fixing a card/series within that window returns the *old error* (or the old success) and does nothing. | Make retries unique (`<prefix>_<id>_<attempt or timestamp>`). Before re-sending an order that might have succeeded, check with `EXPOP0` filter `OBJPR.ORIGCISLO` to avoid duplicates. |
| A3 | M | `MRPKS\sendRequest()` has no connect/read timeout and calls `die()` on any non-200 → one unreachable MRP kills the whole transfer (other entities included). | Use timeouts (`CURLOPT_CONNECTTIMEOUT` 10, `CURLOPT_TIMEOUT` 60–300) and return errors; `mcp.php` `mcpSendRequest()` already does. |
| A4 | M | `McpOrders::transportInsert()` decides failure by `stripos($out, "error"/"chyba")` — matches item names/notes containing those words, and is unnecessary because the error element is documented. | `status/error` check + read `datasets/objednavka/rows/row/fields/cislo`. |
| A5 | L | Several `orders.php` insert the raw response into SQLite without escaping (`'...'.$vystup[1].'...'`) — a quote in the response breaks the insert (BB-TECHNIK escapes, older projects don't). | `SQLite3::escapeString()` or prepared statements; store the MRP number, not the whole body. |
| A6 | M | Characters outside Windows-1250 (emoji, Cyrillic, CJK, some typographic symbols; Central-European letters incl. ő/ű and `€` are fine) end up as `?` or break the import. | Transliterate/strip before templating (keep cp1250-safe text). |

## B. IMPEO0 order template (`templates/orders.php`)

| # | Sev | Issue | Fix |
|---|---|---|---|
| B1 | **H** | `formaUhrady="<?php echo substr($data["payment"], 0, 20) ?>"` — MRP limit is **10**, cut is by **bytes** (can split a UTF-8 character), value is not XML-escaped. | `xmlStr(mb_substr($payment, 0, 10), …)`; better: validate against `EXPUHRADY`. |
| B2 | **H** | `zpusobDopravy="<?php echo xmlStr($data["carrier"], 0, 20) ?>"` — `xmlStr($s, $maxlen)` has two params; `0` is taken as `$maxlen` and `0 != null` is false → **no truncation at all**. MRP limit is **10** and the value must match `EXPDOPRAVA`. | `xmlStr($carrier, 10)` after mapping via settings group 3. |
| B3 | **H** | `<firma nazev ico ic_dph>` — `ic_dph` exists **only in the SK version**. In the CZ version the DIČ must be in `dic`; the default template does not send `dic` → CZ customers' DIČ is lost. 48 project templates send `ico=""` and `dic=""` (empty). 23 send `dic_dph`, which is not documented. | CZ: `dic = invoice.dic` (VAT id `CZ…`). SK: `dic = invoice.dic` (DIČ), `ic_dph = invoice.icdph`. Drop `dic_dph` unless verified. |
| B4 | **H** | `$storecard` is set only when `trim($item["code"]) != ""` and never reset → an item **without code inherits the previous item's card number** (e.g. shipping/discount line gets the last product's card). | `$storecard = "";` at the start of each item iteration. |
| B5 | **H** | Anonymous customers share one MRP address: `adresa id = md53(serialize(email . " " . ic))` cut to 10 chars. Orders without e-mail and IČO (marketplaces, phone orders) all hash to the same id → MRP finds "the" address by id and attaches every such order to the **first anonymous customer**. Changing the hash formula later creates duplicates for everyone. | Include a stable e-shop customer id / phone / name+street in the hash; never change the formula on a live install. |
| B6 | M | `<osoba jmeno prijmeni>`: combined length must be **< 30**; `ulice`/`mesto` 30, `psc` 15, `firma nazev` 100, `polozka text` 50, `poznamkaPolozky` 20 — none of these limits are enforced in the template. | `xmlStr($v, N)`; split long names sensibly. |
| B7 | M | `<poznamka><?php echo $data["note"] ?></poznamka>` — not escaped → `&` or `<` in a customer note makes the whole request invalid XML (order rejected). Also `<email>` in `adresa_dod` is unescaped. | `xmlStr()` everywhere. |
| B8 | M | SQLite schema clash: `templates/orders.php` creates `sync_storecards (id, code, guid, storage_guid, storage_code, storage_name)` if `mrpks.sqlite` does not exist yet, while `products.php` expects `(id, code, storecard, last_price, last_stock)`. If an order run happens before the first product sync on a fresh install, the product upsert and the lookup `select storecard ...` fail. | Run product sync first (MCP instructions say so); better: `create table if not exists` with the products schema in both places. |
| B9 | M | Item lookup by `eanKarty`/`kodKarty` only works if the uniqueness check of that field is enabled in MRP. The library always sends `cisloKarty` from the local map, so an item whose code is not in `sync_storecards` arrives as a **text-only line** (no stock movement, no reservation). | Log items without a card; optionally also send `eanKarty`/`kodKarty`. |
| B10 | L | `cenaMJ` with `cenySDPH="T"` relies on MRP rounding (`parametryDokladu` not sent) → totals can differ from the e-shop by rounding. | Send `<parametryDokladu UPDP="2" VATRU="0.01" TRU="0.01" .../>` matching the e-shop. |

## C. Products / categories / pictures

| # | Sev | Issue | Fix |
|---|---|---|---|
| C1 | **H** | `stavy` has **one row per card per warehouse**, but `$this->stavy[$item["cislo"]] = $item` keeps only the **last warehouse**. Works only because most installs restrict EXPEO1 to one warehouse in the profile (*Číslo skladu* + *Vždy přidat omezující podmínky*). Setting `4.scitat_sklady` exists in 8 profiles but no code reads it. | Either send `cisloSkladu` explicitly, or aggregate: `$stavy[cislo][cisloskl] = row` and sum `pocetmj − pocrezmj`. |
| C2 | M | Docs list the `stavy` key as `cislokar`; real responses use **`cislo`** (code is right, docs are wrong). Real responses also contain undocumented `kod2`, `kod3`, `idkarty`, `zakazslevy`, `upd_date`, `minimum`, `norma`, `maximum`, `pocsprmj`, `pocoprmj`. Field availability depends on the MRP version. | Use `isset()` for every optional field. |
| C3 | M | Selling prices are **not** part of `SKKAR.UPD_DATE` → price-only changes are missed by incremental syncs. | Keep `kompletni_prenos_denne` (daily full sync) or periodically run `stavy=T`. |
| C4 | M | `SKKAR.UPD_DATE` value is built with `date("j.n.Y H:i")` — MRP evaluates it with the **client workstation locale**. A non-Czech/Slovak Windows locale on the MRP machine breaks incremental sync silently (empty result). | Check `test.xml` after the first incremental run. |
| C5 | L | `katalog` rows are not wrapped in `asArray()` in `Products::load()` / `Categories::load()` → a catalog with exactly one group is iterated field by field. | `asArray()`. |
| C6 | L | `Categories` downloads the full EXPEO1 card list just to read the catalog. | `EXPKATZBOZI` (codebook) is much lighter — enable it in the profile. |
| C7 | L | `Pictures::load()` replaces `[last]` in a request that has no placeholder → always full; an image changed in MRP is never re-downloaded while a local file with that name exists. | Delete `img_dir/<name>.*` to force, or compare `velobr` name/size. |
| C8 | L | `loadCategories()` duplicate check `if (array_search(...) === false) {}` is empty → `ciskat` appears twice in `categories`. | Move the push inside the `if`. |

## D. Invoices

| # | Sev | Issue | Fix |
|---|---|---|---|
| D1 | **H** | `Invoices::loadInvoice()` sets `datedue = PaymentDueDate + 14 days` (MCP instructions call it a known bug). | Remove the `+ 14 * 24 * 60 * 60`. |
| D2 | **H** | VAT id mapping. Docs: `VatNumber` = DIČ (CZ: `CZ…` VAT id; SK: tax number), `VatNumberSK` = IČ DPH (SK only). Reader: `dic ← VatNumberSK`, `icdph ← VatNumber`. Template: `VatNumber ← icdph`, `VatNumberSK ← dic`. For the **SK version both are swapped** (DIČ lands in IČ DPH and vice versa); for CZ the reader returns an empty `dic`. | Reader `dic ← VatNumber`, `icdph ← VatNumberSK`; template the inverse. Verify on one SK and one CZ invoice. |
| D3 | M | Exported `UnitPrice` is documented as **net** (`TaxAmount` = VAT per unit). The reader flags items `withvat=1` when `1.ceny_s_dani=1` (54 of 59 profiles) and recomputes `basesum`/`vatsum` as if the price were gross. | Use `UnitPrice` as net, gross = `UnitPrice − UnitDiscount + TaxAmount`; or take sums from `SumValues`. Confirm on live data. |
| D4 | M | Import template hard-codes `ValuesWithTax=T` and `TaxAmount = price × vat`. If `price` is gross, VAT per unit is `price − price/(1+vat)`; if net, `ValuesWithTax` should be `F`. | Make `ValuesWithTax` follow `ceny_s_dani` and compute `TaxAmount` consistently. Test-import one invoice per new install. |
| D5 | M | Only two VAT buckets (`set_vat`, `set_vatlow`) are written into the header; a document with two reduced rates (SK 19 % + 5 %) or OSS rates of other countries needs `SumValues`, otherwise MRP's header sums are wrong. | Emit `SumValues/SumValue` per rate. |
| D6 | M | Reader ignores `RoundingAmount` (MIMO DPH incl. total rounding) → `total_incl_vat` differs from the invoice total by the rounding. Filler lines (`.`, `----`) with quantity 0 are imported as items. | Add `RoundingAmount`; skip `Quantity=0 && UnitPrice=0` / `RowType=2`. |
| D7 | M | Not mapped although present in EXPFAKVY/EXPFV1 output: `Payments`/`PaidAmount` (paid status), `InvoiceType` (F/X proforma/P), `DocType` (D credit note, V debit note), `OriginalOrderNumber` (pairing to the e-shop order), `StockCardNumber` (item code), `UUID`, `DeliveryAddress` (reader copies billing). The MCP instructions consequently claim these are "not available". | Map them — see section F. |
| D8 | L | `GetPDFInvoice()` uses an undefined `$order_number` in its message and logs only `chyba` when the response has no attachment (EXPFVPDF error, template dialog, wrong number). | Parse `status/error`; log the invoice number and MRP message. |

## E. Command-line helpers

| # | Sev | Issue | Fix |
|---|---|---|---|
| E1 | M | `GenerateIni()` ignores the `$cmd` parameter of `CallExport()` — always `EXPFAKVY`. | Use `$cmd`. |
| E2 | M | `FirNumber = intval(basename(str_replace("DATA","",set_dbfile)))` → 23 for `…\DATA\DATA0023.MRP`, but **0** for the new layout `C:\MRPKS_DATA\DATACZ25` (company number 102 is not in the path). `DatabasePath = dirname(set_dbfile)` differs from the `cfg_files` template that uses the full file path. | Separate settings for Firebird server, data path and company number. |
| E3 | M | `set_apppath` is the HTTP address for the API helpers and the exe path for `CallImport`/`CallExport`. | Exe path in its own setting (`1.mrpks_exe` as in `mcp.php`). |
| E4 | M | No `ResultsFileName` → command-line errors (rights, licences, paused command, duplicate UUID) are invisible. IMPFAKVY deletes the input file even on failure → nothing left to inspect. | Always add `<ResultsFileName>` and parse `Result`; keep a copy of the input. |
| E5 | L | `CallImport($file, …)` ignores `$file`; the command XML `<name>.xml` must already exist in `temp_dir` (placeholder replacement code is commented out). | Generate it from `cfg_files/import_faktur.xml` with real values per run, delete afterwards (contains the password). |

## F. Capabilities the library does not use (and claims are impossible)

`mcp_manifest.json` / `mcp_instructions.txt` say there is no order export, no codebooks and no payment info. The API has all of it:

| Need | Command | Notes |
|---|---|---|
| Invoices over HTTP incl. items and payments, no exe | `EXPFV1` (paged) | `PaymentState` 2/3/5 for paid/unpaid/underpaid, `PaymentsToDate` |
| Paid status | `EXPFV1` `Payments`, `PaidAmount` | |
| Proforma / credit note distinction | `InvoiceType`, `DocType` | |
| Invoice ↔ e-shop order pairing | `OriginalOrderNumber` (= `puvodniCislo`) | filter `OriginalOrderNumber` too |
| Order states (vybavená / částečně / nevybavená) | `EXPOP0` | replaces Firebird `OBJPR.VYBAVENE` queries |
| Full received orders | `EXPOP1` | |
| MRP order number after import | IMPEO0 answer `datasets/objednavka/.../cislo` | |
| Payment / delivery / VAT-type / series / warehouse codebooks | `EXPUHRADY`, `EXPDOPRAVA`, `EXPTYPYDPH`, `EXPCISRAD0`, `EXPSKLADY` | validate settings groups 2/3 against them |
| Customer price groups | `ADREO0` (`censkup`) + `CENEO0` / `EXPCENSKUP` | |
| Stock issue + invoice from an order | `OP2SV0` → `SV2FV0` | used in pullmann, lemitas, bukovy, slavicek, quadroflex, babica, 123kolo |
| Invoice PDF already stored | `EXPFV2` | |
| Per-warehouse stock, foreign prices, related cards, serial numbers | `EXPEO2` | XML 2.0, paged |
| Card attachments (image URLs etc.) | EXPEO1 `prilohy=T` (undocumented) | |

## G. Documentation / guide discrepancies

- Internal guide `shopsync_docs/docs/navody/erp/mrpks/nasteveni-mrpks.md` says to enable profiles **`EXPE00`, `EXPE01`, `IMPE00`** (zero) — the commands are **`EXPEO0`, `EXPEO1`, `IMPEO0`** (letter O, then zero). It also shows the server address as `https://localhost:801` while the library needs `localhost:801` (it prepends `http://`); the screenshot in the same guide shows `localhost: 801` with a space. The guide says products pair by EAN by default — the code default is the card number (`$pair_field = "cislo"`).
- MRP docs: `stavy.cislokar` is really `cislo`; EXPEO0/1 use `mena` in the table and `meny` in the example; `zahrceny` lists only net prices; the response example of `doplnky` has mismatched closing tags. Trust real responses (`temp_dir/test.xml`).
- An earlier note claimed `templates/invoices.php` writes `<n>` instead of `<Name>` — **false alarm**: the files contain `<Name>`; some tool output renders the tag as `<n>`. Verify with `grep -c "<Name>"` before "fixing" it.

## H. Security

- `order_states.php` in several projects connects to Firebird with the default **`SYSDBA` / `masterkey`** hard-coded. Use `sw_user`/`sw_pass` (as most projects do) and a restricted Firebird user.
- Start scripts like `mrpauto.bat` (`MRPKS.EXE -A -F<n> -Y<user>,<password>`) keep the MRP password in plain text inside the Nextcloud-synced project folder. Keep them outside shared folders / on the client PC only.
- Command-line XML files contain `UserPwd` — write to `temp_dir`, delete after the run, never commit.
- Some project `config.php` files contain full SQL connection strings with passwords — never copy config values into skills, tickets or chats.
