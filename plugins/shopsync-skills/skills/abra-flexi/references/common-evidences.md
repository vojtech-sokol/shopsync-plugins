# ABRA Flexi — Common Evidence Types

Evidence = data entity / endpoint. Full property definitions for all 249 evidences are bundled with this skill at `references/evidence/<name>.md` (e.g. `references/evidence/cenik.md`). Each file lists every field with type, DB column, max length, mandatory/writable flags, and FK target. Mirror of the source at `C:\Users\Vojtech Sokol\Documents\share\podklady\abra_flexi\evidence\`.

This document picks out the subset most relevant to e-commerce ↔ ERP sync work.

## Products & Pricing

| Evidence | Purpose |
|----------|---------|
| `cenik` | Product (price list card) — core product record. Fields: `kod`, `nazev`, `cenaZakl`, `cenaZaklVcDph`, `cenaZaklBezDph`, `nakupCena`, `typSzbDphK`, `eanKod`, `hmotMj`, `stavy`, `cena2`-`cena5`, `procento2`-`procento5`, `limMnoz2`-`limMnoz5` |
| `cenik-obal` | Product packaging / EkoKom |
| `cenikova-skupina` | Product group / price group |
| `cenova-uroven` | Price level definition (B2B tiers) |
| `individualni-cenik` | Per-customer product pricing |
| `cenikovy-pohyb-prodej` | Sales price movement history |
| `cenikovy-pohyb-nakup` | Purchase price movement history |
| `skupina-zbozi` | Goods group with margin/markup config |
| `podobne-zbozi` | Related / similar products |
| `doplnek` | Product accessory / add-on |

## Stock

| Evidence | Purpose |
|----------|---------|
| `skladova-karta` | Stock card: `cenik` × `sklad`. Fields: `stavMj` (on-hand), `rezervMj` (reserved), `sklad`, `cenik` |
| `sklad` | Warehouse definition |
| `sklad-mj` | Stock card per unit-of-measure |
| `def-store` | Default warehouse rules |

## Orders (Sales & Purchase)

| Evidence | Purpose |
|----------|---------|
| `objednavka-prijata` | **Received order** (customer order from e-shop) |
| `objednavka-prijata-polozka` | Line items of received order |
| `objednavka-vydana` | Issued order (PO to supplier) |
| `objednavka-vydana-polozka` | Line items of issued order |
| `typ-objednavky-prijate` | Received order types |
| `typ-objednavky-vydane` | Issued order types |

## Invoices

| Evidence | Purpose |
|----------|---------|
| `faktura-vydana` | **Issued invoice** (sales) |
| `faktura-vydana-polozka` | Lines of issued invoice |
| `faktura-prijata` | Received invoice (purchase) |
| `faktura-prijata-polozka` | Lines of received invoice |
| `typ-faktury-vydane` | Issued invoice types |
| `typ-faktury-prijate` | Received invoice types |
| `zalohova-faktura-vydana` | Issued proforma / deposit invoice |
| `zalohova-faktura-prijata` | Received proforma invoice |

## Offers / Quotes / Inquiries

| Evidence | Purpose |
|----------|---------|
| `nabidka-vydana` / `-polozka` | Issued quote / offer |
| `nabidka-prijata` / `-polozka` | Received quote |
| `poptavka-vydana` / `-polozka` | Issued inquiry |
| `poptavka-prijata` / `-polozka` | Received inquiry |

## Stock Movements

| Evidence | Purpose |
|----------|---------|
| `prijemka` / `prijemka-polozka` | Stock receipt |
| `vydejka` / `vydejka-polozka` | Stock issue |
| `prevodka` / `prevodka-polozka` | Stock transfer |
| `inventura-dokl` / `inventura-polozka` | Stocktaking document |
| `rezervace` | Stock reservation |

## Customers, Addresses, Contacts

| Evidence | Purpose |
|----------|---------|
| `adresar` | **Companies / customers** (address book). Fields: `kod`, `nazev`, `ic`, `dic`, `ulice`, `mesto`, `psc`, `stat`, `tel`, `email`, `platce-dph` |
| `adresar-bankovni-ucet` | Customer bank account |
| `misto-urceni` | Delivery address / destination |
| `osoba` | Person / contact |
| `odberatelska-smlouva` | Customer contract |
| `dodavatelska-smlouva` | Supplier contract |

## Reference Data (Enums / Lists)

| Evidence | Purpose |
|----------|---------|
| `stat` | Country (ISO code key, `code:CZ`, `code:SK`...) |
| `region` | Region / state |
| `mena` | Currency |
| `sazba-dph` | VAT rate definition |
| `cleneni-dph` | VAT classification |
| `cleneni-kontrolni-hlaseni` | VAT control statement classification |
| `forma-uhrady` | Payment method (`code:DOBIRKA`, `code:HOTOVE`, `code:PREVODEM`...) |
| `forma-dopravy` | Shipping method |
| `merna-jednotka` | Unit of measure (ks, kg, m...) |
| `stredisko` | Cost center |
| `cinnost` | Activity |
| `zakazka` | Contract / project |
| `ucetni-obdobi` | Accounting period |
| `typ-pohybu-sklad` | Stock movement type |

## Accounting

| Evidence | Purpose |
|----------|---------|
| `ucet` | Account (chart of accounts) |
| `ucetni-obdobi` | Accounting period |
| `predkontace` | Predefined postings |
| `hlavni-kniha` | General ledger |
| `ucetni-dennik` | Journal |
| `interni-doklad` / `-polozka` | Internal document |
| `danovy-naklad` | Tax expense |
| `penezni-ustav` | Bank / financial institution |

## Cash & Bank

| Evidence | Purpose |
|----------|---------|
| `bankovni-ucet` | Bank account |
| `banka` / `banka-polozka` | Bank statement |
| `pokladna` / `pokladna-polozka` | Cash register / cash document |
| `uhrada` | Payment / settlement |

## Key Fields on Document Line Items

Line-item evidences (`*-polozka`) share a consistent field set:

| Field | Meaning |
|-------|---------|
| `kod` | SKU / product code |
| `nazev` | Name (defaults from `cenik.nazev`) |
| `cenik` | Reference to product card (often `code:...`) |
| `mnozMj` | Quantity |
| `mj` | Unit of measure |
| `cenaMj` | Unit price (before discount) |
| `typCenyDphK` | `typCeny.sDph` = inc. VAT, `typCeny.bezDph` = excl. VAT |
| `szbDph` | VAT percentage (numeric, e.g. 21) |
| `typSzbDphK` | `typSzbDph.dphZakl` / `dphSniz` / `dphSniz2` / `dphOsv` |
| `slevaPol` | Line-item discount [%] |
| `uplSlevaDokl` | Apply document-level discount? (bool) |
| `slevaDokl` | Document discount [%] (read-only on line) |
| `sumZkl` | Base amount [local currency] (computed) |
| `sumDph` | VAT amount (computed) |
| `sumCelkem` | Total (computed) |
| `sklad` | Warehouse reference (for stock-affecting rows) |
| `stredisko` / `cinnost` / `zakazka` | Cost center / activity / project refs |
| `poznam` | Note |

## Key Fields on Document Headers

Shared across `objednavka-*`, `faktura-*`, `nabidka-*`, `poptavka-*`:

| Field | Meaning |
|-------|---------|
| `kod` | Document number (auto from type) |
| `typDokl` | Document type ref |
| `cisDosle` | External / incoming number (e-shop order number) |
| `varSym` | Variable symbol |
| `firma` | Customer / supplier ref |
| `mistUrc` | Delivery location |
| `datVyst` | Issue date |
| `datSplat` | Due date |
| `datTermin` | Requested delivery date |
| `stredisko` | Cost center |
| `mena` | Currency |
| `stav` | Document status |
| `formaDopravy` | Shipping method |
| `formaUhrady` | Payment method |
| `slevaDokl` | Document-wide discount [%] |
| `zaokrJakSumK` | Rounding policy for totals |
| `polozkyObchDokladu` | Collection of line items |
| `kontaktJmeno`, `kontaktEmail`, `kontaktTel` | Contact info snapshot |

## Code-Referenced Enum Values (seen in field payloads)

| Field | Common values |
|-------|---------------|
| `typCenyDphK` | `typCeny.sDph`, `typCeny.bezDph`, `typCeny.czDph` |
| `typSzbDphK` | `typSzbDph.dphZakl`, `typSzbDph.dphSniz`, `typSzbDph.dphSniz2`, `typSzbDph.dphOsv`, `typSzbDph.dphPrenAll` |
| `stat` | `code:CZ`, `code:SK`, `code:DE`, `code:PL`, ... (ISO 3166-1) |
| `mena` | `code:CZK`, `code:EUR`, `code:USD`, ... |
| `formaUhrady` | project-dependent: `code:DOBIRKA`, `code:PREVODEM`, `code:HOTOVE`, `code:PLATCARD`, ... |
| `formaDopravy` | project-dependent: `code:GLS`, `code:CESKA_POSTA`, `code:ZASILKOVNA`, ... |

## How to Look Up a Field

1. Pick the evidence file: `references/evidence/<evidence>.md` (bundled with this skill)
2. File has: evidence path, DB name, ext-ID support, properties URL (on live demo)
3. Property table shows every field: name / label / type / DB column / mandatory / writable / max-length / FK target

Example: for order line discount fields, read `references/evidence/objednavka-prijata-polozka.md` and look for `slevaPol`, `slevaDokl`, `uplSlevaDokl`.
