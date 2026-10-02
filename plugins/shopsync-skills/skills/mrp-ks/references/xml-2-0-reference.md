# XML MRP-K/S 2.0 Reference

The "XML MRP-K/S ver. 2.0" format is the document format of MRP K/S. It is used by:
- file export/import in the MRP UI (Faktury vydané → Export/Import),
- command-line mode (`EXPFAKVY`, `IMPFAKVY`, `IMPFAKVY1`, …) — `cmdline-mode.md`,
- autonomous mode XML-2.0 commands (`EXPEO2`, `EXPFV*`, `IMPFV0`, `EXPOP1`, `EXPSP0`, `IMPSP0`, codebooks) — inside `<data>`.

Official per-agenda field lists (TXT) and sample XMLs: MRP FAQ 392 (https://faq.mrp.cz/faqcz/FaqAnswer.aspx?cislo=392). Local copy on Dave's machine: `C:\Temp\mrpks_podklady\docs\mrpks_xml_2_0_doc_*.txt` (cp1250!) and `mrpks_*.XML` samples. This file is a condensed, integration-oriented summary — check the TXT for rarely used fields.

## 1. Envelope and conventions

```xml
<?xml version="1.0" encoding="UTF-8"?>
<MRPKSData version="2.0" countryCode="CZ" currencyCode="CZK">
  <!--Source AppVendor="MRP" AppName="MRP-K/S" AppVersion="6.75(001)" AppSerial="UC010001"-->
  <IssuedInvoices>
    <Invoice> ... </Invoice>
  </IssuedInvoices>
</MRPKSData>
```

| Root node | Record | Agenda |
|---|---|---|
| `IssuedInvoices` | `Invoice` | issued invoices (FV) |
| `IncomingInvoices` | `Invoice` | received invoices (FP) |
| `IncomingOrders` | `Order` | received orders (OP) |
| `IssuedOrders` | `Order` | issued orders (OV) |
| `StockCards` | `StockCard` | store cards (SK) |
| `WarehouseTransactions` | `WarehouseTransaction` | stock movements (SP) |
| `CashVouchers` | `CashVoucher` | cash desk (PK) |
| `OtherReceivables` / `OtherPayables` | `Receivable` / `Payable` | other receivables / payables |
| `InternalDocuments` | `InternalDocument` | internal documents |
| `AccountingItems` | `AccountingItem` | accounting journal |
| `AddressList`, `PaymentTypeList`, `TransportationTypeList`, `TaxCodeList`, `SeriesList`, `WarehouseList`, `PriceGroupList` (+`PriceGroupListRec`), `CostCentreList`, `ContractList`, `ItemTypeList`, `GoodsCatalogList`, `GoodsGroupList`, `AccountList`, `ActivityList`, `ContactList`, `PreAsignmentList`, `InvoiceItemsList`, `FulfillmentTypeList`, `SingleEntryBookkeepingCodesList`, `CashRegistersList` | `<Root>Item` | codebooks |

Conventions:
- **Booleans** are `T` / `F`.
- **Dates** `YYYY-MM-DD` (in the XML itself — filters use the client locale `d.m.yyyy`).
- **Decimals** with `.`; amounts (15,2), unit prices/quantities (15,6), card numbers (15,2).
- **Encoding**: file is UTF-8 but contents must fit Windows-1250.
- **Header amounts are in local currency** (`ZeroTaxRateAmount`, `ReducedTaxRateAmount`, `BaseTaxRateAmount`, `RoundingAmount`, `…Tax`). Foreign-currency total is `TotalWithTaxCurr`; items are in document currency.
- `RoundingAmount` = the **"MIMO DPH"** (non-taxed) amount, which also absorbs total rounding when `TRD=0`. It is part of the total.
- Base/Reduced header sums aggregate **all** rates of that kind. If a document has more than one base or more than one reduced rate (e.g. SK 23/19/5, historical CZ 15/10), **`SumValues` is mandatory**.
- `TaxPercent` special values: `0` = exempt (osvobozeno), `99` = out of VAT scope (mimo DPH).
- `CostCentre` default `"0"`, `ContractNumber` default `"0"`; any other value must exist in the codebook.
- `CountryCode` ISO2, must exist in MRP's country codebook.
- Fields marked "(Pouze pro Vizuální účetní systém)" in the TXT (`HeadText`, `HeadNote`, `IBAN` on invoice header, `OldDocumentNumber`, `TaxTypeSTR`) belong to MRP's other product — **do not use for MRP K/S**.

### CalcParams / parametryDokladu

`CalcParams` (string 200) = `KEY=value;KEY=value` (order irrelevant, all optional), e.g. `UPDP=2;VATRU=0.01;VATRM=0;TRU=0.01;TRM=0;VATCA=0;VATCUPA=0;TRD=0;TRDCA=1;VATFRB=1`. The same keys are attributes of `<parametryDokladu>` in IMPEO0.

| Key | Meaning |
|---|---|
| `UPDP` | decimal places of the unit price (1..4, SK 1..6) |
| `VATRU` | VAT rounding unit (1.00 / 0.10 / 0.01) — CZ only |
| `VATRM` | VAT rounding method: 0 natural, 1 down, 2 up, 3 banker's — CZ only |
| `TRU` | total rounding unit |
| `TRM` | total rounding method (0..3 as above) |
| `VATCA` | use VAT coefficient for the total VAT (0/1) — CZ only |
| `VATCUPA` | use VAT coefficient for unit VAT (0/1) — CZ only |
| `TRD` | where the total rounding goes: 0 into MIMO DPH, 1 into base+VAT |
| `TRDCA` | coefficient for dissolving the rounding (CZ only, with TRD=1) |
| `VATFRB` | total VAT from the rounded base (0/1) — SK only |

### TaxCode, VatRegime, OSS

- `TaxCode` = "Typ DPH" codebook (`EXPTYPYDPH`). Common CZ values: **41** domestic realised supply, **71** domestic received supply, **19** non-tax document realised, **39** non-tax document received. SK version: 10 domestic realised, 40 received. OSS sales use a dedicated type configured per installation (ShopSync setting `1.kod_dph_oss`, seen values 40/54) — **always confirm on the target install** (`EXPTYPYDPH`).
- `VatRegime`: 0 domestic, 1 EU VAT registration, 2 OSS (MOSS). `VatCountry` = country of VAT (for 0 always `CZ`/`SK` per program version). `VatNumber` (header) = foreign VAT registration number for regime 1/2 — must exist in MRP's "Registrace plátců v zemích EU".
- `EURExchangeRate` / `EURExchangeRateAmount` = document-currency/EUR rate for OSS documents in the CZ version.
- `RecapitulativeStatementCode` (souhrnné hlášení): "" domestic/none, 0 goods to EU, 1 transfer of assets, 2 triangular trade, 3 services.

### VAT IDs in CZ vs SK version (frequent mix-up)

| Element | CZ version | SK version |
|---|---|---|
| `Company/CompanyId` | IČO | IČO |
| `Company/VatNumber` (17) | **DIČ** = EU VAT id `CZ12345678` | **DIČ** (SK tax no. `2020123456`, no prefix) |
| `Company/VatNumberSK` (14) | not used | **IČ DPH** = EU VAT id `SK2020123456` |

ShopSync order arrays: `invoice.ic` = IČO, `invoice.dic` = DIČ (Shoptet: `taxId` or `vatId`), `invoice.icdph` = EU VAT id (`vatId`). Correct mapping is therefore `VatNumber ← dic`, `VatNumberSK ← icdph` (SK) — see `known-issues.md` for what the bundled templates do.

## 2. Issued invoice — `IssuedInvoices/Invoice`

Header:

| Element | Type | Notes |
|---|---|---|
| `DocumentNumber` | string 10 | unique; omit on import + send `DocumentNumberPrefix` to let MRP number it |
| `DocumentNumberPrefix` | string 10 | series prefix for import numbering (series must exist, `EXPCISRAD0`) |
| `UUID` | string 36 | unique; MRP assigns one if missing. Duplicate UUID on import → error "Doklad s UUID … už ve Vaší evidenci existuje" (use as idempotency key!) |
| `IssueDate`, `TaxPointDate`, `DeliveryDate`, `PaymentDueDate`, `OrderDate` | date | `DeliveryDate` also used for the Kontrolní hlášení |
| `CurrencyCode`, `CurrRate`, `CurrRateAmount` | | local currency: rate 1 / amount 1 |
| `ValuesWithTax` | T/F | how item prices were entered (`T` gross). Exported `UnitPrice` is documented as **net** — verify on live data before relying on it |
| `TaxCode`, `DocType` | | `DocType` " " normal tax document, `D` credit note (dobropis), `V` debit note (vrubopis) |
| `InvoiceType` | string 1 | `F` normal, `X` proforma (předfaktura), `P` penalty |
| `ZeroTaxRateAmount`, `ReducedTaxRateAmount`, `BaseTaxRateAmount`, `RoundingAmount`, `ReducedTaxRateTax`, `BaseTaxRateTax` | 15,2 local | see conventions |
| `TotalWithTaxCurr` | 15,2 | total in foreign currency |
| `PaidAmount`, `PaidAmountCurr` | 15,2 | sum of payments (export only, computed) |
| `VariableSymbol` (10), `ConstantSymbol` (8), `SpecificSymbol` (10) | | |
| `PaymentMeansCode` (10), `DeliveryTypeCode` (10) | | codebook texts (`EXPUHRADY`, `EXPDOPRAVA`) |
| `OrderNumber` (20) | | MRP order number |
| `OriginalOrderNumber` (50) | | e-shop/customer order number (= `OBJPR.ORIGCISLO` / `puvodniCislo`) — the pairing key back to the e-shop |
| `OriginalDocumentNumber` (50) | | issuer's number |
| `CreditNoteOriginalNumber` (50), `DocumentNumberCreditNote` (10), `DocumentNumberDebitNote` (10) | | link of credit/debit note to the corrected invoice |
| `DeliveryNoteID` (10), `ProformaInvoiceID` (10), `PaymentInvoiceID` (10) | | `PaymentInvoiceID` is set by MRP — never fill from outside |
| `CostCentre` (6), `ContractNumber` (15) | | |
| `VatRegime`, `VatCountry`, `VatNumber` (17), `EURExchangeRate`, `EURExchangeRateAmount` | | OSS/EU |
| `DoubleEntryBookkeepingCode` (15,3) | | accounting pre-assignment (`predkontace`, e.g. `32.000`) |
| `SingleEntryBookkeepingCode`, `SingleEntryBookkeepingSubCode` | int | tax-records movement code |
| `RecapitulativeStatementCode` (1), `ControlStatement_Leasing` (T/F) | | |
| `TotalWeight` | 15,6 | |
| `Discount` | 15,2 | % discount for the whole document |
| `Note` (32768), `UserField1..5` (40), `CalcParams` (200) | | |
| `ImportParams/ReCalcTotals` | 0/1/2 | 0 per profile, 1 do not recalc, 2 recalc totals after import |

`Company` (partner): `CompanyId` (12), `AddressId` (50 — e-shop id), `Name` (50), `Name2` (50), `CustomerName` (30), `Street` (30), `City` (30), `Country` (30), `CountryCode` (2), `ShortNote` (30), `ZipCode` (15), `VatNumber` (17), `VatNumberSK` (14), `Phone`/`Phone2`/`Phone3` (30), `Fax`, `Email` (256), `Note`, `NaturalPerson` (T/F), `AddressFormationDate`, `UserField1..5`; optional `BankAccounts/BankAccount` (`Name`, `AccountNumber` 6+10, `BankCode`, `IBAN`, `CurrencyCode`, `BIC`, `DefaultForDoc`).

`DeliveryAddress/*` — same fields as `Company` (issued invoices only).

`Items/Item`:

| Element | Type | Notes |
|---|---|---|
| `Description` | string 100 | |
| `RowType` | int | 1 financial, 2 text row |
| `TaxCode` | int | per line |
| `ItemType` | string 10 | `EXPTYPYPOL` |
| `UnitCode` | string 3 | |
| `Quantity` | 15,6 | |
| `UnitPrice` | 15,6 | net unit price in document currency; `(UnitPrice − UnitDiscount) × Quantity` = line net |
| `TaxPercent` | 15,2 | 0 exempt, 99 out of scope |
| `TaxAmount` | 15,6 | **VAT per unit** in document currency |
| `DiscountPercent` / `UnitDiscount` | | `UnitDiscount` is what counts for the totals |
| `StockCardNumber` | 15,2 | store card; optional on import (0.00 = none) |
| `CostCentre`, `ContractNumber` | | |
| `RowSumType` | int | 1 normal, 2 advance deduction, 3 reverse charge, 4 advance deduction reverse charge |
| `TotalWeight` | 15,6 | per unit |
| `SubscriptionStartPeriod` / `SubscriptionEndPeriod` | date | accruals |

Exports contain filler lines (`Description` `.` or `----- text -----`, quantity 0, price 0) — filter them out (`Quantity=0 AND UnitPrice=0` or `RowType=2`).

`SumValues/SumValue`: `TaxCode`, `TaxType` (0 undefined, 1 base, 2 reduced, 3 exempt, 4 out of VAT), `TaxPercent`, `CurrencyCode` (local row always present, foreign row for foreign documents), `Amount`, `Tax`, `TaxCurrRateAmount`, `TaxCurrRateTax`, `ReverseChargeAmount`, `ReverseChargeTax`, `TaxCurrRateReverseChargeAmount`, `TaxCurrRateReverseChargeTax`, `TaxApplied`.

`Payments/Payment`: `PaymentType` (0 n/a, 1 bank, 2 cash desk, 3 exchange difference, 4 offset/zápočet, 5 internal document), `PaymentDate`, `DocumentNumber` (paying document), `Amount` (local), `AmountCurr` (payment currency), `AmountPaidDocumentCurr` (invoice currency), `CurrencyCode`, `CurrRate`, `CurrRateAmount`, optional `BankAccount/{BankAccount,BankCode,IBAN,CurrencyCode}`.
Payment import (separate MRP function): `DocumentNumber` + `Payments` only; incremental; a payment is "the same" when `PaymentDate` + `Payments/DocumentNumber` + `Amount` match.

`PaymentSchedule/PaymentScheduleItem`: `PaymentMeansCode`, `BankAccount`, `BankCode`, `IBAN`, `VariableSymbol`, `ConstantSymbol`, `SpecificSymbol`, `PaymentDueDate`, `AmountCurr`.

`Attachments/Attachment`: `FileName` (50), `FileContent` (base64 blob), `Description` (100).

## 3. Received invoice — `IncomingInvoices/Invoice`

Same as issued invoice except: no `DeliveryAddress`, no `Attachments` in the field list, no `OriginalOrderNumber`, no `Discount`, no `RecapitulativeStatementCode`; extra reverse-charge and tax-rate header amounts (`ReverseChargeBaseTaxRateAmount/Tax`, `ReverseChargeReducedTaxRateAmount/Tax`, `TaxCurrRate`, `TaxCurrRate…Amount/Tax`, `TaxCurrRateRoundingAmount`, `TaxCurrRateZeroTaxRateAmount`). `Company/BankAccounts/BankAccount/DefaultForDoc` marks the account to pay to. `SumValue/TaxApplied` = deductible VAT (0 = no deduction).

## 4. Received order — `IncomingOrders/Order` (EXPOP1)

Header: `DocumentNumber` (10), `OriginalOrderNumber` (50 — e-shop number), `IssueDate`, `OriginalIssueDate`, `DeliveryDate`, `TaxCode`, `ProcessingStatus` (0 fulfilled, 1 partially, 2 not, −1 blocked lines, −2 blocked order), `WarehouseNumber`, `PaymentMeansCode` (10), `DeliveryTypeCode` (10), `VariableSymbol`, `CostCentre`, `ContractNumber`, `Note`, `ValuesWithTax`, `TotalWeight`, `CurrencyCode`, `CurrRate`, `CurrRateAmount`, `EURExchangeRate*`, `CalcParams`, `UserField1..5`, `VatRegime`, `VatCountry`, `VatNumber`, `Offer` (T = offer/nabídka), `Reservation` (T = reserves stock).
`Company/*`, `DeliveryAddress/*` (final recipient) as for invoices.
`Items/Item`: `ItemID` (PK; on import number from 1 per batch), `Description` (100), `RowType`, `ItemType`, `UnitCode`, `Quantity`, `UnitPrice` (net), `TaxPercent`, `TaxAmount`, `DiscountPercent`, `UnitDiscount`, `CostCentre`, `ContractNumber`, `ProcessingStatus`, `WarehouseNumber`, `QuantityToCover`, `QuantityCovered`, `TotalWeight`, `Note` (20), `FixedPrice`, `StockCardNumber`, `ReservedQuantity`, `ReservedQuantityToCover`, `ReservedQuantityCovered`.
`SumValues`, `Attachments` as invoices.

`IssuedOrders/Order` (EXPOV1) mirrors this for orders to suppliers (`Inquiry` instead of `Offer`).

## 5. Store card — `StockCards/StockCard` (EXPEO2)

Main: `StockCardNumber` (15,2), `StockCardName` (64), `StockCardName2` (64), `UnitCode` (3), `TaxPercent`, `CatalogNumber`, `StockCardEshopID` (36 — unique id for e-shops), `EANCode` (25), `StockCardCode1..3` (50), `TotalWeight` (kg), `QuantityInPackage`, `UserField1..5`, `ShortNote` (50), `Note`, `NoChangePrice` (T = no discount), `MaxDiscountPercent`, `Variant` (variant group number, mainly for e-shops), `MinSaleQuantity`, `Length`/`Width`/`Height` (m), `GroupCode` (10), `GroupName` (50), `CardType` (0 normal, 1 composed), `ItemType`, `RelatedCardsAction` (import only: " ", `+`, `+P`, `+V`, `=`, `=P`, `=V`).
`Detail`: `SmallImageName`, `LargeImageName` (40), `SmallDescription` (80), `LargeDescription`, `SmallDescription2`, `LargeDescription2`, `SmallImage`, `LargeImage` (base64).
`Statuses/Status` (one per warehouse): `WarehouseNumber`, `Quantity`, `MinimumQuantity`, `NormaQuantity`, `MaximumQuantity`, `ReservedQuantity`, `OutOrderedQuantity` (ordered from suppliers), `InOrderedQuantity` (ordered by customers), `ReservedQuantityUnfinished`, `UnitPrice` (stock price), `UnitPrice1..5`, `UnitPriceWithTax`, `UnitPrice1WithTax..5`.
`ForeignCurrencies/ForeignCurrency`: `CurrencyCode`, `WarehouseNumber`, `UnitPrice1..5`, `UnitPrice1WithTax..5`.
`Replacements/Replacement` (`StockCardNumber`, `EANCode`, `StockCardCode1`, `ShortNote`, `Bidirectional`), `Supplements/Supplement`, `RelatedCards/RelatedCard` (+`Quantity`, `AccountingItem`, `ItemType` M composed / R chained), `AuxiliaryEANCodes/AuxiliaryEANCode` (`EANCode`, `QuantityInPackage`, `ShortNote`), `SerialNumbers/SerialNumber` (`ReceivedDate`, `DocumentNumber`, `Label`, `Quantity`, `ProductionDate`, `WarrantyDate`, `WarrantyInMonths`, `ShortNote`, `WarehouseNumber`), `Attachments/Attachment` (`FileName` 128).

Free stock for an e-shop = `Quantity − ReservedQuantity` (EXPEO1: `pocetmj − pocrezmj`).

## 6. Stock movement — `WarehouseTransactions/WarehouseTransaction` (EXPSP0 / IMPSP0)

Header: `DocumentNumberPrefix`, `WarehouseDocumentValid` (T valid, F draft, R draft with reservation, O retail archive), `DocumentNumber` (9 — base number; full number = warehouse + P/V + number), `OrderDate`, `OrderNumber`, `OriginalOrderDate`, `OriginalOrderNumber`, `DeliveryDate`, `InvoiceNumber`, `OriginalDocumentNumber`, `WarehouseNumber`, `DestinationWarehouseNumber` (transfers), `WarehouseIncomeDocument` (T receipt, F issue), `WarehouseTransactionType2` (movement kind number), `WarehouseTransactionType` (P/M/C/O/V/I), `IssueDate`, `CostCentre`, `ContractNumber`, `ValuesWithTax`, `CurrencyCode`, `CurrRate`, `CurrRateAmount`, `VariableSymbol`, `PaymentMeansCode`, `DeliveryTypeCode`, `Note`, `UserField1..5`, `TaxCode`, `VatRegime`, `VatCountry`, `VatNumber`, `CalcParams`, `LogUser` (do not fill). `Company`, `DeliveryAddress`.
`Items/Item`: `StockCardNumber`, `Quantity`, `UnitPrice` (base selling price per unit in accounting currency), `UnitDiscount`, `DiscountPercent`, `TaxPercent`, `TaxAmount`, `ItemType`, `IssuedOrderItemID`, `IncomingOrderItemID`, `StockCardId` (36), `StockCardEAN`, `StockCardCode`.
`SumValues`, `Attachments`.

## 7. Addresses — `AddressList/AddressListItem` (EXPADR20)

`CompanyId` (12), `AddressId` (50), `Name`, `Name2` (50), `CustomerName` (30), `Street`, `City`, `Country` (30), `CountryCode`, `ShortNote`, `ZipCode`, `VatNumber`, `VatNumberSK`, `Phone*`, `Fax`, `Email`, `Note` (1024), `NaturalPerson`, `AddressFormationDate`, `UserField1..5`, `RecipientID` (12 — IČO of the final recipient, links billing ↔ delivery address), `BankAccounts/BankAccount`.

## 8. Codebooks

| Codebook | Fields |
|---|---|
| `PaymentTypeList` | `Number`, `Text` (10 — use as `formaUhrady`/`PaymentMeansCode`), `EdiCode` (3) |
| `TransportationTypeList` | `Number`, `TransportationType` (10 — `zpusobDopravy`/`DeliveryTypeCode`), `ShipmentType` (5) |
| `TaxCodeList` | `Number` (required), `Text` (50), `ValidFrom`, `ValidTo`, `RealizedTaxableSupplies` (T realised / F received) |
| `SeriesList` | `SeriesType`, `TypeDescr`, `WarehouseNumber`, `Prefix` (20), `Offset` (zero-padded; length = max value; shows the last assigned number), `Text` |
| `WarehouseList` | `Number`, `Text` (30), `WarehouseEANCode`, `FinancialClose`, `AccountSynth`, `AccountAnalyt`, `GoodsReceipt`, `GoodsIssue` (default movement kinds) |
| `PriceGroupList` | `Number`, `Description`; rules `PriceGroupListRec/…Item`: `StockCardGroup`, `StockCardNumber`, `ItemType`, `ValidFrom`, `ValidTo`, `DiscountPercent`, `DiscountAmount`, `CurrencyCode`, `DiscountAmountVAT`, `PriceNumber` (NULL at issue, 0 stock, 1..5), `PriceType` (0 % change, 1 amount change, 2 fixed, 3 amount into price, 4 % into price, 5 new price 0..5) |
| `CostCentreList` | `Code` (6), `Text` (30) |
| `ContractList` | `Code` (15), `Text`, `CompanyId`, `StartDate`, `EndDate`, `ContractStatus` (0 open, 1 in progress, 2 closed), `ContractPrice`, `InitialState`, `Note` |
| `ItemTypeList` | `Code` (10), `Description`, `RecapitulativeStatementSuppliesCode`, `ReverseChargeCodeSK`, `ReverseChargeCodeCZ` |
| `GoodsCatalogList` | `CatalogNumber`, `ParentCatalogNumber`, `Description` (45), `CatalogOrder` |
| `GoodsGroupList` | `Code` (10), `Description` (50) |
| `CashRegistersList` | `CashRegisterIdentif` (20 — used by IMPPOKDOK*), `Description`, `InitialState`, `InitialStateCurrency`, `CurrencyCode`, `CostCentre`, `AccountSynth`, `AccountAnalyt`, `IncomeReceiptsSeriePrefix`, `ExpenditureReceiptsSeriePrefix` |

`SeriesType` values: 1 FP normal, 2 FP proforma, 3 FP penalty, 4 FV normal, 5 FV proforma, 6 FV penalty, 7 other payables, 8 other receivables, 9 received orders, 10 received offers, 11 issued orders, 12 issued inquiries, 13 stock receipts, 14 stock issues, 15 cash income, 16 cash expense, 17 offsets, 18 repairs & claims, 19 contracts received, 20 contracts issued, 21 internal docs costs, 22 internal docs revenues.

## 9. Legacy format 1.0

"XML(DBF) MRP-K/S ver. 1.0" (`MRPKS_FAKTURY_IMPORT_5_53_001.TXT`, `MRPKS_POKLADNA_IMPORT_5_63_004.TXT`) is kept only for backward compatibility. Do not use it for new work.
