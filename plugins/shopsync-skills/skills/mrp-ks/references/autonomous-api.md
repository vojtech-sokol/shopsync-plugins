# MRP K/S Autonomous Mode (HTTP API) Reference

Source: MRP FAQ 483 "API - Autonomní režim" (https://faq.mrp.cz/faqcz/FaqAnswer.aspx?cislo=483, revision 10.5.2024) plus behaviour observed in ShopSync production projects. Everything marked **[observed]** is not in the official docs.

## 1. What it is

The MRP K/S **client** (`MRPKS.EXE`) runs as a small HTTP server for one company ("firma"). It takes `HTTP POST` requests with an XML body and answers with XML. It permanently occupies **one client licence**.

Start (typically a shortcut / scheduled task "at system start"):

```
"C:\Program Files (x86)\MRP\MRPKS\MRPKS.EXE" -A -F2 -Ymrpdba,mrpdba
```

| Switch | Meaning |
|---|---|
| `-A` | autonomous mode |
| `-F<n>` | company number (the same number as in `DATA00nn.MRP` / `FirNumber`) |
| `-Y<user>,<password>` | MRP login, comma, no spaces. The user needs rights for the commands. |

First start: window "MRP K/S - Režim automatické služby - firma č. N" → **Nastavení…**
- tab **Komunikace**: tick **Http server**, set **Číslo TCP portu** (ShopSync installs use 110, 120, 122, 801 …). Optional **Vyžadovat šifrování** + base64 key (button *Generovat*).
- tab **Profily**: every command must be **enabled** ("Vykonání příkazu je povoleno"). Disabled commands are listed in red. Per-command profile settings: warehouse number (*Číslo skladu*), price number (*Číslo ceny*), card-number range, *Vždy přidat omezující podmínky* (profile restrictions are ANDed to every request — a request cannot widen them), export small/large image, default series/středisko/zakázka for imports.
- The service must show **Stav služby: Spuštěno**.

There is no URL path. ShopSync posts to `http://<set_apppath>` where `set_apppath` = `host:port` (e.g. `localhost:801`, `192.168.1.10:120`) — **without** `http://`, `lib/mrpks` adds it. Content-Type `text/plain` works.

## 2. Envelope

Request:

```xml
<?xml version="1.0" encoding="windows-1250"?>   <!-- UTF-8 also accepted -->
<mrpEnvelope>
  <body>
    <mrpRequest>
      <request command="IMPEO0" requestId="1234"/>
      <data>
        <params> <paramvalue name="...">...</paramvalue> </params>   <!-- command parameters -->
        <paging> <RowFrom>1</RowFrom> <RowTo>200</RowTo> </paging>    <!-- optional, some exports -->
        <filter> <fltvalue name="...">expression</fltvalue> </filter> <!-- export filters -->
        <!-- or the payload itself: <objednavka>, <MRPKSData>, ... -->
      </data>
    </mrpRequest>
  </body>
</mrpEnvelope>
```

Response:

```xml
<mrpEnvelope>
  <body>
    <mrpResponse>
      <status>
        <request command="IMPEO0" requestId="1234"/>
        <!-- only on failure: -->
        <error errorCode="106" errorClass="ESvcClientError">
          <errorMessage>Není zadaná číselná řada pro sklad 2!</errorMessage>
        </error>
      </status>
      <data> ... </data>
    </mrpResponse>
  </body>
</mrpEnvelope>
```

Rules that matter:

- **HTTP status is 200 even when the command failed.** Success = no `status/error` element. Always parse it (`scripts/mrpks_codec.php` → `mrpksParseResponse()`).
- **`requestId` is idempotency, not a label.** For commands that modify data it is mandatory. MRP stores executed requests for a limited time (docs: "currently about half a day"). A request with an already-seen `requestId` is **not executed again**; MRP returns a copy of the first answer. Consequence: if an order failed (e.g. missing card) and you fix the data and resend with the same `requestId` within ~12 h, you get the old error again and nothing happens. Use `prefix_number_attempt` or append a timestamp for retries. Read-only exports can use `requestId=""`.
- **Encoding:** the MRP database is Windows-1250. XML may be UTF-8, but characters outside cp1250 (emoji, many non-Latin scripts, some typographic characters) must be stripped or transliterated before sending.
- **Data shape** of most native exports:

```xml
<data><datasets>
  <TABLE_NAME><rows>
    <row><fields><field1>value</field1>...</fields></row>
  </rows></TABLE_NAME>
</datasets></data>
```

  XML-2.0 exports (`EXPEO2`, `EXPFV*`, `EXPOP1`, `EXPSP0`, codebooks, imports' answers) put an `<MRPKSData version="2.0" ...>` document inside `<data>` instead. `EXPOP0` uses attributes on `<objednavka>`.
- Empty fields come as `<kod></kod>` or `<kod/>`. With `json_decode(json_encode(simplexml))` (what `lib/mrpks` does) they turn into **empty arrays** → wrap with `MRPKS\flatArray()`. Elements that MRP omits (e.g. `uciskat` of a root catalog node) are simply missing → use `isset()`.
- A dataset with exactly **one row** becomes a bare row (no numeric index) after the json trick → wrap with `MRPKS\asArray()`.
- Numbers use `.` as decimal separator in native fields; **user fields** (`usrfld1..5`) are free text and can contain `17,000000` **[observed]**.

## 3. Filter expressions (`<fltvalue>`)

Same syntax as the filter dialogs in the MRP UI. Values are evaluated with the **client workstation's** locale (decimal separator, date format — CZ/SK installs use `d.m.yyyy`).

| Syntax | Meaning | Example |
|---|---|---|
| `<`, `>`, `<=`, `>=` | comparison (write `&gt;` / `&lt;` in XML) | `&gt;1.10.2026 08:00` |
| `=` / `!=` | equals (numbers) / not equals | `!=0` |
| `a..b` | interval | `100..500`, `1.1.2026..31.1.2026` |
| `\|` | OR | `1\|2\|3`, `&gt;1.1.2026 12:34\|null` |
| `&` | AND | `!=1&!=2` |
| `*` / `?` | wildcard (group / one char) | `EO26*`, `N?v*` |
| `*xxx*` | contains `xxx` (no further wildcards inside) | `*kabel*` |
| `EMPTY` / `NOT EMPTY` | empty / filled field | `not empty` |
| `NULL` / `NOT NULL` | empty / filled codebook link | `not null` |
| `$UCETDATUM$`, `$UCETMESIC$`, `$FISKALROK$` | accounting date / month / year (+ shifts `-x$`, `..+x$`, `....-x$`) | |

`SKKAR.UPD_DATE` (since 6.42.001) changes when any of these change: card type, number, name, EAN, group, catalog, VAT rate, item type, unit, *used* flag, date of entry, weight, user fields 1–5, initial/current stock price, current quantity, reserved quantity. **Selling prices 1–5 are not in the list** → a price-only change may not move `UPD_DATE`. ShopSync handles it with a periodic full transfer (`4. Produkty / kompletni_prenos_denne`, window `_od`/`_do` hours).

Some exports also accept `<fltvalue name="sql">` (since 6.40.011) — raw SQL condition for the database server; field names must be table-qualified.

## 4. Paging

`<paging><RowFrom>1</RowFrom><RowTo>200</RowTo></paging>` inside `<data>`. Defaults 1 / 999999. Officially supported by `EXPFV0`, `EXPFV1`, `EXPFV2`, `EXPFP0`, `EXPFP1`, `EXPEO2`, and the codebook exports show it in their examples. `EXPEO0/EXPEO1` are **not** paged — limit them with filters (`SKKAR.CISLO` ranges, `UPD_DATE`).

## 5. Encoded communication (compression / encryption / authentication)

Optional. If MRP has *Vyžadovat šifrování* ticked, unauthenticated requests are refused. Working, test-vector-verified PHP: `scripts/mrpks_codec.php` (`mrpksEncodeRequest`, `mrpksDecodeResponse`, self-test `php mrpks_codec.php`).

```xml
<mrpEnvelope>
  <encodedBody authentication="hmac_sha256">
    <encodingParams><![CDATA[ base64(<mrpEncodingParams compression="zlib" encryption="aes"><varKey>base64(32B)</varKey></mrpEncodingParams>) ]]></encodingParams>
    <encodedData><![CDATA[ base64(payload) ]]></encodedData>
    <authCode>base64(HMAC)</authCode>
  </encodedBody>
</mrpEnvelope>
```

Algorithm (sender):

1. `secret` = 32 bytes (base64 in MRP settings).
2. `encKey = HMAC_SHA256(secret, 0x01)`, `authKey = HMAC_SHA256(secret, encKey || 0x02)`.
3. payload = the inner XML whose root is `<mrpRequest>` (the content of `<body>`), optionally zlib-compressed.
4. Encryption: random 32-byte `varKey` (never reuse), `finalKey = HMAC_SHA256(encKey, varKey)`, `IV = first 16 B of SHA256(varKey)`, AES-256-CTR (big-endian counter increment = OpenSSL `aes-256-ctr`).
5. `authCode = HMAC_SHA256(authKey, rawParamsXml || rawEncryptedPayload)` — the raw bytes **before** base64. Mandatory with encryption.
6. Compression only (no key): `<encodedBody>` without `authentication`, params `<mrpEncodingParams compression="zlib"/>`.

The receiver verifies `authCode` first and answers with an error if it does not match. Responses come back in the same form.

Compression note: the docs say "zlib deflate/inflate"; the codec sends `gzcompress()` (zlib stream, RFC 1950) and accepts both zlib and raw deflate on input. Verify once on a live install before relying on compression.

## 6. Command catalogue

O = optional, M = mandatory. Types: N number, T text, D date, DT date-time, L logical `T|F`, B base64 blob, M memo.

### 6.1 Store cards

#### EXPEO0 / EXPEO1 — store cards for e-shops (native datasets)

Both take the same filters; `EXPEO1` returns stock per warehouse in a separate `<stavy>` dataset and accepts a **range** in `cisloSkladu`. `lib/mrpks` uses **EXPEO1** for products/categories and **EXPEO0** for single-card image download.

Control filters:

| name | Type | Meaning |
|---|---|---|
| `stavy` | L | `T` = only stock/prices (`EXPEO1`: datasets `sklady`+`stavy` only). Default `F`. |
| `cisloSkladu` | N | warehouse (EXPEO0: one, EXPEO1: range/list). Can be forced by the profile. |
| `cisloCeny` | N | which selling price goes into `cena`/`cenasdph` (0 = stock price, 1..5). Default 1. |
| `malObraz`, `velObraz` | L | include small/large image as base64 (`malobraz`/`velobraz`). Expensive. |
| `polePoznamka1` | L | include `poznamka1` (memo). |
| `poleDetail2` | L | include `malpopis2`/`velpopis2`. |
| `mena` / `meny` | T | foreign currency prices, e.g. `EUR\|USD` → dataset `zahrceny` (since 6.43.001; the docs use both spellings in different places). |
| `sql` | T | raw SQL condition (since 6.40.011). |
| `prilohy` | L | **[observed]** include dataset `prilohy` (card attachments). |

Field filters (MRP filter syntax): `SKKAR.CISLO`, `SKKAR.NAZOV` (name — Slovak column name!), `SKKAR.KOD` (EAN), `SKKAR.KOD1`, `SKKAR.KOD2`, `SKKAR.KOD3`, `SKKAR.SKUPINA`, `SKKAR.CISKAT`, `SKKAR.TYP_POL`, `SKKAR.SADZBADPH`, `SKKAR.BEZDPH`, `SKKAR.POZNAMKA`, `SKKAR.ZAKAZSLEVY`, `SKKAR.DODAVATEL`, `SKKAR.POZNAMKA1`, `SKKAR.DAT_ZAR`, `SKKAR.UPD_DATE` (DT), `SKKAR.POUZIVANA`, `SKKAR.TLAC`, `SKKAR.USRFLD1..5`, `SKKARSTA.POCETMJ`, `SKKARSTA.POCREZMJ`, `SKKARSTA.POCOBJMJ`, `SKKARSTA.POZICE`, `SKKARSTA.MINIMUM`, `SKKARSTA.NORMA`, `SKKARSTA.MAXIMUM`.

Response datasets (EXPEO1). Fields marked **[obs]** appear in real responses but not in the docs; the docs list `cislokar` in `stavy`, real responses use **`cislo`**.

| Dataset | When | Fields |
|---|---|---|
| `sklady` | always | `cisloskl`, `nazevskl` |
| `stavy` | always, **one row per card per warehouse** | `cislo` (card no., docs say `cislokar`), `cisloskl`, `pocetmj`, `pocrezmj`, `pocobjmj`, `datdostup`, `cena`, `cenasdph`, `cena1..5`, `cena1sdph..cena5sdph`, `pozice`, `mena`; [obs] `idkarty`, `tisk`, `upd_date`, `minimum`, `norma`, `maximum`, `pocsprmj`, `pocoprmj` |
| `karty` | `stavy=F` | `cislo`, `nazev`(64), `jednotka`(3), `sazbadph`, `ciskat`, `ciskatlist` (`2\|21\|22`), `kod` (EAN), `kod1`, `skupina`, `hmotnost` (kg), `delka`/`sirka`/`vyska` (m), `baleni`, `usrfld1..5`(40), `poznamka`(50), `poznamka1`, `nazev2`, `maxslevap`, `variantgrp`, `malpopis`(80), `velpopis` (memo), `malpopis2`, `velpopis2`, `malobr`/`velobr` (file names, 40), `malobraz`/`velobraz` (base64), `skupnazev`, `phe_kod`, `phe_popis`, `phe_castka`, `phe_zakg` (recycling fee), `minprodmj`; [obs] `kod2`, `kod3`, `idkarty`, `zakazslevy` |
| `katalog` | `stavy=F` | `idr`, `ciskat`, `uciskat` (parent, missing for roots), `popis`(45), `poradi` |
| `nahrady` | `stavy=F` | `cislo`, `kod`, `kod1`, `cislo_z`, `kod_z`, `kod1_z` (interchangeable cards) |
| `doplnky` | `stavy=F` | `cislo`, `kod`, `kod1`, `cislo_r`, `kod_r`, `kod1_r` (accessories) |
| `navazujici` | `stavy=F` | `cislo`, `pocetmj`, `cislo_s`, `pocetmj_s` (linked/composed cards) |
| `zahrceny` | with `mena` | `cislo`, `cisloskl`, `mena`, `cena1..5`, `cena1sdph..5` [docs list net only] |
| `dodavatel` | default supplier set | `ico`, `firma`, `meno`, `ulica`, `mesto`, `psc`, `kodstat`, `stat`, `telefon*`, `email`, `web_url`, `usrfld1..5` |
| `prilohy` | [obs] `prilohy=T` | `cislo`, `idkarty`, `docname`, `doccontent` (base64), `doctext` |

EXPEO0 returns stock/price fields directly inside `karty` (no `stavy`, no `sklady`).

Card numbers are decimals: `cislo` = `1925` or `1.1` (variants/sub-cards use the decimal part). `lib/mrpks` normalises to `number_format(..., 2)` → `"1925.00"`.

#### EXPEO2 — store cards in XML 2.0

Paged. Filters: `WarehouseNumber` (one; none = all), `Statuses`, `Prices`, `Detail`, `RelatedCards` (T/F), `Attachments` (`LIST`/`FULL`), `StockCardNumber`, `StockCardName`, `TaxPercent` (0 exempt, 99 out of VAT), `CatalogNumber`, `StockCardEshopID`, `EANCode`, `StockCardCode1..3`, `UserField1..5`, `GroupCode`, `ShortNote`, `Note`, `StockCardName2`, `NoChangePrice`, `CardType` (0 normal, 1 composed). Returns `MRPKSData/StockCards/StockCard` (fields in `xml-2-0-reference.md`). Cleaner than EXPEO1 for new code: per-warehouse `Statuses/Status`, foreign prices, related cards, serial numbers, auxiliary EANs.

#### CENEO0 — customer price-group prices

Filters: `cisloSkladu`, `cisloCeny` (base price 0..5), `cenovaSkupina` (one number, or since 6.40.011 a list/range `1|2|4..6`), `datum` (validity date, XML format `YYYY-MM-DD`), `cenySDPH` (T/F), `sql`, plus all `SKKAR.*`/`SKKARSTA.*` filters.
Dataset `ceny`: `cislo`, `idkarty`, `censkup`, `cisloceny` (-1 undefined, 0 stock price, 1..5), `typceny` (0 % change, 1 amount change, 2 fixed amount, 3 amount into price, 4 % into price, 5 replace by price 0..5), `mena`, `cenamj`, `sleva_p`, `slevamj`.

#### EXPSP0 / IMPSP0 — stock movements (XML 2.0)

`EXPSP0` filters: `DocumentNumber`, `WarehouseNumber`, `WarehouseIncomeDocument` (T receipt / F issue), `IssueDate`, `WarehouseTransactionType` (P normal, M transfer at stock price, C transfer with selling price, O transfer (do not use), V retail, I inventory), `WarehouseTransactionType2` (movement kind number), `CompanyId`, `CostCentre`, `ContractNumber`.
`IMPSP0` imports `MRPKSData/WarehouseTransactions/WarehouseTransaction`. Items may reference `IssuedOrderItemID` / `IncomingOrderItemID` → MRP checks the order exists (receipt↔issued order, issue↔received order) and optionally that the card matches; "fixed price" orders override item prices. Answer: dataset `WarehouseTransaction` with `OriginalDocumentNumber` + `DocumentNumber` (e.g. `001V202400002`).

#### OP2SV0 — stock issue from a received order

Params (`<params><paramvalue>`): `idObj` (N, evaluated first) or `cislo` (T, MRP order number), `cisloSkladu`, `druhPohybu`, `datum` (`-1` today, `0` order date — default, `YYYY-MM-DD`). Missing values come from the profile.
Success: `data/MRPKSData/skladoveVydejky/skladovaVydejka/scislo` = full issue number `<warehouse><P|V><number>` e.g. `001V000000340`.
Error codes (`errorCode`):

| Code | Meaning |
|---|---|
| 1 | stock module not installed |
| 2 | document identification missing |
| 3 / 103 | warehouse number missing |
| 4 / 104 | inserting movements into the warehouse not allowed |
| 5 / 105 | series prefix missing |
| 6 | no right to insert into this series |
| 7 / 106 | series prefix not found (synchronisation) |
| 11 | movement kind not found |
| 12 | movement date invalid (out of range, closed period) |
| 100 | order not found / not eligible / already has a movement |
| 107 | exchange-rate lookup failed |
| 110 | general database error |
| 111 | Firebird error |
| < 0 | exceptions raised inside the database |

### 6.2 Invoices, receivables, payables, cash

| Command | Purpose | Notes |
|---|---|---|
| `EXPFV0` | issued invoices, header + `Company` | paged; no `Items`, `Payments`, `SumValues`, `PaymentSchedule` |
| `EXPFV1` | as EXPFV0 + `Items` + `Payments` | **use this for invoice sync and payment status over HTTP** |
| `EXPFV2` | as EXPFV0 + stored PDF from the *Přílohy* tab | requires "save PDF as attachment" in MRP |
| `EXPFV3` | list + `Attachments` names (no `FileContent`) | |
| `EXPFV4` | one invoice + one attachment with content | filters `DocumentNumber` or `UUID` + `FileName` |
| `EXPFVPDF` | one invoice + PDF rendered now | exactly one `DocumentNumber`; FastReport template from profile or `<paramvalue name="ReportName">FV01_1A2.FR3</paramvalue>` (default "01 - Faktura"); the template must not open dialogs (would hang the service) |
| `EXPFP0` / `EXPFP1` | received invoices (as FV0/FV1) | no `OriginalOrderNumber` filter |
| `IMPFV0` / `IMPFP0` | import ONE issued / received invoice (XML 2.0) | only the first `<Invoice>` is used; answer = `DocumentNumber` + `UUID` |
| `IMPFVPR` / `IMPFPPR` | add attachment to an invoice | `DocumentNumber` or `UUID` + `Attachments/Attachment/{FileName,FileContent}`; first attachment only |
| `SV2FV0` | issued invoice from an existing stock issue | params `WarehouseDocumentNumber` (M, e.g. `001V000000158`), `DocumentNumberPrefix`, `IssueDate`, `TaxPointDate`; answer `DocumentNumber` + `UUID` |
| `IMPOSPOH0` / `IMPOSZAV0` | other receivable / payable (XML 2.0 `OtherReceivables/Receivable`, `OtherPayables/Payable`) | first document only |
| `IMPPOKDOK0` | cash voucher | param `CashRegisterIdentif` (M) = identifier from the cash-register codebook |
| `EXPUCDE` / `IMPUCDE` | accounting journal | `Archive` filter: 1 all, 2 current period (default!), 3 archive only |

Invoice export filters (`EXPFV*`, `EXPFP*`): `UUID` (single), `DocumentNumber`, `CompanyId`, `PaymentState` (0 all, 1 all with payments up to `PaymentsToDate`, 2 paid, 3 unpaid/unsettled, 4 overpaid, 5 underpaid, 6 paid + overpaid), `PaymentsToDate` (one concrete date only, e.g. `31.12.2026`), `IssueDate`, `TaxPointDate`, `PaymentDueDate`, `CostCentre`, `ContractNumber`, `OrderNumber`, `OriginalOrderNumber` (FV only).

`EXPUCDE` filters: `SourceDocument`, `CostCentre`, `ContractNumber`, `Activity`, `Date`, `PairingSymbol`, `DocumentNumber`, `Text`, `Archive`, `AccountsFilter` (`321` either side, `321/` debit, `/321` credit, `311/343` pair, `395/|/321` OR).

### 6.3 Orders

#### IMPEO0 — import received orders (the e-shop → MRP command)

Structure:

```xml
<data>
  <params>                                   <!-- optional globals -->
    <paramvalue name="cisloSkladu">1</paramvalue>
    <paramvalue name="stredisko">0</paramvalue>
    <paramvalue name="cisloZakazky">0</paramvalue>
    <paramvalue name="prefixRadyObj">EO</paramvalue>
  </params>
  <objednavka ...>                           <!-- 1..n orders per request -->
    <parametryDokladu .../>  <mena .../>  <rezimDPH .../>
    <adresa ...> <firma/> <osoba/> <email/>* <tel/>{0,3} <uzivatelskaPole/> </adresa>
    <adresa_dod ...> ...same... </adresa_dod>
    <polozky> <polozka .../>* </polozky>
    <poznamka>long text</poznamka>
    <uzivatelskaPole> <uzivatelskePole1..5/> </uzivatelskaPole>
  </objednavka>
</data>
```

Global `<paramvalue>` (all O): `cisloSkladu` (N3), `stredisko` (T6), `cisloZakazky` (T15), `prefixRadyObj` (T10). Missing → program configuration / profile.

`<objednavka>` attributes:

| Attr | Type/len | Meaning |
|---|---|---|
| `stredisko`, `cisloZakazky` | T6 / T15 | per order (5.55.005) |
| `formaUhrady` | **T10** | payment method — must match the MRP codebook text (`EXPUHRADY`), e.g. `převodem`, `dobírka`, `p.p.` |
| `zpusobDopravy` | **T10** | delivery method — must match the codebook (`EXPDOPRAVA`) |
| `variabilniSymbol` | N10 | |
| `puvodniCislo` | T50 | e-shop order number (stored as OBJPR.ORIGCISLO). Required to get the MRP number back in the answer. |
| `datum` | D | `YYYY-MM-DD` |
| `datumDodani` | D | delivery deadline (5.55.005) |
| `cenySDPH` | L | prices include VAT |
| `fixniCena` | T1 | `T`/`F`/`X` prices fixed |
| `typDPH` | N2 | VAT type code from the codebook for realised supplies (6.30.001), e.g. 41 |

Středisko precedence: order attr → address (if enabled in config) → `<paramvalue>` → import configuration.

`<parametryDokladu>` (6.50.001): `UPDP`, `VATRU`, `TRU`, `TRM`, `VATCA`, `VATCUPA`, `TRD`, `TRDCA`, `VATFRB` — same meaning as `CalcParams` (see `xml-2-0-reference.md`). Example `<parametryDokladu TRU="1.00"/>` = round the total to whole crowns.

`<mena kod="EUR" kurz="25.10" mnozstvi="1"/>` — ISO code, rate, per how many units.

`<rezimDPH kod="0|1|2" statDPH="SK" vatDPH="SK2020..."/>` (6.30.001) — 0 domestic, 1 EU VAT registration, 2 OSS. `statDPH` = VAT country, `vatDPH` = foreign VAT reg. no. (must exist in MRP's "Registrace plátců v zemích EU").

`<adresa>` / `<adresa_dod>` attributes: `id` (**T10**, e-shop customer id), `ulice` (T30), `mesto` (T30), `psc` (T15), `kodStatu` (ISO2, 5.35.005), `fyzickaOsoba` (L, 5.72.001).
`<firma>`: `nazev` (T100), `ico` (T12), `dic` (T17 — CZ VAT no. `CZ12345678`; SK DIČ), `ic_dph` (T14, **SK version only**). Projects also send `dic_dph` — not in the docs.
`<osoba>`: `jmeno` (T30), `prijmeni` (T30) — **combined length must be < 30**.
`<email>` repeatable, concatenated up to the DB column length (256). `<tel>` max 3 × T30. `<uzivatelskaPole><uzivatelskePole1..5>` T40 (6.29.002) — on the address and on the order.

`<polozka>`:

| Attr | Type/len | Meaning |
|---|---|---|
| `cisloKarty` | N(10,2) | store card number — lookup #1 |
| `eanKarty` | T13 | lookup #2 — only if EAN uniqueness check is ON in MRP |
| `kodKarty` | T30 | user code (KOD1) — lookup #3 — only if code uniqueness check is ON |
| `text` | **T50** | line text (if alone → text-only line, `pocetMJ`/`cenaMJ` not needed) |
| `mj` | T3 | unit, only for lines without a card |
| `pocetMJ` | M, N(15,6) | quantity |
| `cenaMJ` | M, N(17,6) | unit price (gross/net per `cenySDPH`) |
| `cisloCeny` | N1 | 6.88.001: 1–5 selling price, 0 stock price — used when `cenaMJ` is missing or 0 |
| `slevaMJ` | N(17,6) | discount per unit (wins over `sleva`) |
| `sleva` | N(6,2) | discount % |
| `sazbaDPH` | N(5,2) | VAT % |
| `typPolozky` | T2 | item type code (`EXPTYPYPOL`) |
| `fixniCena` | L | fixed price on the line |
| `poznamkaPolozky` | T20 | line note |

Address matching (what MRP does with `id` and `ico`):

- **Billing address**: search by `id` → found: take its IČO, don't update the address. Not found → search by `ico`: found with empty stored id → store our `id` into it; found with a *different* id → create a **new address with `ico/1`** (slash + sub-version) and use it; not found at all → create a new address. Empty `ico` → MRP generates its own (`A00001` style).
- **Delivery address**: same, but also searched in the addresses of the current request; a new delivery address gets the billing IČO + slash.
- Consequences: with an empty `ico` and a stable hashed `id` (what `lib/mrpks` does: `md53(email + " " + ic)` cut to 10) returning customers are recognised. Changing the hash formula creates duplicates. ADREO0 later shows these sub-addresses as `12345678/1`.

Answer (only if `puvodniCislo` was sent):

```xml
<data><datasets><objednavka><rows>
  <row><fields><puvodnicislo>2026001234</puvodnicislo><cislo>EO26000123</cislo></fields></row>
</rows></objednavka></datasets></data>
```

`cislo` (T10) = number assigned by MRP — store it (needed for `OP2SV0`). Errors come in `status/error` (HTTP still 200).

#### EXPOP0 — state of received orders

Filters: `OBJPR.CISLO`, `OBJPR.DATUM`, `OBJPR.ORIGCISLO` (e-shop number), `OBJPR.ICO`, `polozky` (T = line states too), `typDokladu` (`O` orders, `N` offers, `X` both; **default only orders**).
Answer (attributes, not datasets): `<objednavka cisloObj puvodniCislo datum stav usrLock ico nabidka>` with optional `<polozky><polozka stav vybavitMJ text cisloKarty eanKarty kodKarty/></polozky>`. `stav`: < 0 blocked, 0 fulfilled (*vybavená*), 1 partially, 2 not fulfilled. `usrLock` T = locked by a user (6.39.006). Ideal for e-shop status sync without Firebird access.

#### EXPOP1 / EXPOV1 — received / issued orders in XML 2.0

Filters: `DocumentNumber`, `OriginalOrderNumber`*, `CompanyId`, `CostCentre`, `ContractNumber`, `IssueDate`, `OriginalIssueDate`*, `DeliveryDate`, `ProcessingStatus` (0, 1, 2, -1 blocked lines, -2 blocked order), `Offer`* (T/F), `Inquiry` (EXPOV1). *received orders only. Returns `MRPKSData/IncomingOrders/Order` (fields in `xml-2-0-reference.md`).

### 6.4 Codebooks and addresses

All return `MRPKSData` XML 2.0 and accept paging. **Each must be enabled in the profiles.**

| Command | Root / item | Key fields |
|---|---|---|
| `EXPUHRADY` | `PaymentTypeList/PaymentTypeListItem` | `Number`, `Text` (T10 — the value for `formaUhrady`), `EdiCode` |
| `EXPDOPRAVA` | `TransportationTypeList/…Item` | `Number`, `TransportationType` (T10 — value for `zpusobDopravy`), `ShipmentType` |
| `EXPTYPYDPH` | `TaxCodeList/…Item` | `Number`, `Text`, `ValidFrom`, `ValidTo`, `RealizedTaxableSupplies` |
| `EXPCISRAD0` | `SeriesList/…Item` | `SeriesType`, `TypeDescr`, `WarehouseNumber`, `Prefix`, `Offset`, `Text` |
| `EXPSKLADY` | `WarehouseList/…Item` | `Number`, `Text`, `WarehouseEANCode`, `FinancialClose`, `GoodsReceipt`, `GoodsIssue` |
| `EXPCENSKUP` | `PriceGroupList/…Item` + `PriceGroupListRec/…Item` | groups + rules (card group/card/item type, validity, discount %, amount, price number, price type) |
| `EXPSTR0` | `CostCentreList/…Item` | `Code`, `Text` |
| `EXPZAK0` | `ContractList/…Item` | `Code`, `Text`, `CompanyId`, dates, `ContractStatus` |
| `EXPOSN0` | `AccountList/…Item` | chart of accounts |
| `EXPTYPYPOL` | `ItemTypeList/…Item` | `Code`, `Description`, reverse-charge codes |
| `EXPTYPYPLN` | fulfilment types | |
| `EXPKATZBOZI` | `GoodsCatalogList/…Item` | `CatalogNumber`, `ParentCatalogNumber`, `Description`, `CatalogOrder` |
| `EXPSKUPZBOZI` | `GoodsGroupList/…Item` | `Code`, `Description` |
| `EXPCINNOSTI`, `EXPKONTAKTY`, `EXPPREDKONT`, `EXPPOLFAK`, `EXPPDPOHYBY` | activities, contacts (sales reps), pre-assignments, predefined invoice/order lines, tax-records movement codes | |
| `EXPADR20` | `AddressList/AddressListItem` | XML 2.0 addresses; filters `CompanyId`, `VatNumber`, `VatNumberSK`, `Name`, `CustomerName`, `City`, `ZipCode`, `CountryCode`, `NaturalPerson`, `AddressFormationDate`, `UserField1..5` |

#### ADREO0 — addresses (native dataset `adres`)

Filters: `ADRES.FIRMA`, `ADRES.MENO`, `ADRES.ULICA`, `ADRES.MESTO`, `ADRES.PSC`, `ADRES.KODSTAT`, `ADRES.ICO`, `ADRES.DIC`, `ADRES.TELEFON`, `ADRES.FAX`, `ADRES.EMAIL`, `ADRES.DAT_ZAR`, `ADRES.POZNAMKA`, `ADRES.CENSKUP`, `ADRES.EANKOD`, `ADRES.FYZOSOB`, `ADRES.TLAC`, `ADRES.UCET`, `ADRES.USRFLD1..5`, `ADRES.SPLATNOST`, `ADRES.KREDIT`, `ADRES.CRPSTATUS`, `ADRES.FAKSTRED`, `KONTAKTY.IDENTIF` (sales rep).
Fields: `ico`, `dic`, `ic_dph`, `id` (e-shop id, T10), `firma`, `meno`, `ulica`, `mesto`, `psc`, `kodstat`, `telefon`, `telefon1`, `telefon2`, `fax`, `email`, `censkup`, `stat`.

### 6.5 Not documented

`EXPSQL` appears in one ShopSync debug script (`woo_mrpks_marton/debug/debug_mrp_check.php`) as an *attempt* to run raw SQL. It is not documented and there is no evidence it works — use the `sql` filter of EXPEO0/EXPEO1/CENEO0 or direct Firebird access instead (see `project-patterns.md`).

## 7. Troubleshooting

| Symptom | Cause / check |
|---|---|
| `Server neodpovida` / curl connect error | service not started (`-A`), wrong port, *Http server* unticked, firewall, `set_apppath` contains `http://` or a space (`localhost: 801`) |
| HTTP 200 + `<error>` "příkaz není povolen" or similar | command not enabled in *Profily* |
| HTTP 200, empty datasets | profile restriction (*Vždy přidat omezující podmínky*, warehouse, card range), wrong date format in the filter, `UPD_DATE` without `\|null` on first sync |
| Order "imported" but nothing in MRP | response had `<error>` (HTTP 200) or `requestId` replay within ~12 h |
| Wrong/missing payment or delivery method on the order | value longer than 10 chars or not in the codebook (`EXPUHRADY`/`EXPDOPRAVA`) |
| Item without card in the order | `cisloKarty` empty (sqlite map not filled — run product sync), EAN/code lookup used but uniqueness check off in MRP |
| `EXPFVPDF` hangs | FastReport template shows a dialog; fix the template |
| Garbled or `?` characters | characters outside Windows-1250 |
| One warehouse's stock only | see `known-issues.md` (stavy keyed by card) |
