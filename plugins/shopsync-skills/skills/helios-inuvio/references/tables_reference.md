# Helios Inuvio - Database Tables Reference

## Products & Inventory

### TabKmenZbozi - Product Master Catalog
Main product table ("kmen zboží" = product register).

| Column | Type | Description |
|---|---|---|
| ID | int PK | Product ID |
| SkupZbo | nvarchar | Product group code |
| RegCis | nvarchar | Registration number (product code) |
| Nazev1-4 | nvarchar | Product names (1=primary) |
| SKP | nvarchar | Variant parent code (shortened name) |
| PLUKod | nvarchar | PLU code |
| MJEvidence/Vstup/Vystup | nvarchar | Units of measure |
| SazbaDPH | numeric | Output VAT rate (SazbaDPHVystup) |
| SazbaSD | numeric | Excise duty rate (SazbaSDVystup) |
| PrepocetMJSD | numeric | Unit conversion for excise duty |
| Hmotnost | numeric | Weight |
| Objem | numeric | Volume |
| Vyska/Sirka/Hloubka | numeric | Dimensions |
| Vyrobce | int | Producer (FK→TabCisOrg.CisloOrg) |
| Blokovano | bit | Blocked flag |
| IdSortiment | int | Sortiment ID (category) |
| DatPorizeni | datetime | Creation date |
| DatZmeny | datetime | Last modified date |
| Obrazek | nvarchar | Image path |
| Poznamka | ntext | Product description/note |

**Composite product code** is typically `concat(SkupZbo, RegCis)`.

### TabKmenZbozi_EXT - Product Extensions
Custom attributes added per-installation. Contains same ID as TabKmenZbozi. Columns are user-defined (TabUzivAtr).

### TabStavSkladu - Stock Levels
Stock per product per warehouse.

| Column | Type | Description |
|---|---|---|
| ID | int PK | Stock record ID |
| IDKmenZbozi | int FK | Product ID |
| IDSklad | nvarchar | Warehouse ID |
| Mnozstvi | numeric | Quantity on hand |
| MnozstviDispo | numeric | Available quantity |
| MnozNaDObjKVyrizeni | numeric | Qty on pending received orders |
| MnozNaGPrUMZKVyrizeni | numeric | Qty reserved for production |
| MnozZPrKVazKVyrizeni | numeric | Qty reserved for binding |
| MnozstviKPrijmu | numeric | Qty to receive |
| Minimum | numeric | Minimum stock level |
| Maximum | numeric | Maximum stock level |
| Blokovano | bit | Blocked flag |
| Sleva | numeric | Discount |

**Available stock formula**: `Mnozstvi - MnozNaDObjKVyrizeni - MnozNaGPrUMZKVyrizeni - MnozZPrKVazKVyrizeni`

### TabBarcodeZbo - Product Barcodes

| Column | Type | Description |
|---|---|---|
| IDKmenZbo | int FK | Product ID |
| BarCode | nvarchar | Barcode / EAN |
| Prednastaveno | bit | Is default barcode |

### TabPohybyZbozi - Product Movements
Line items of goods circulation documents.

| Column | Type | Description |
|---|---|---|
| ID | int PK | Movement ID |
| IDZboSklad | int FK | Stock card ID (TabStavSkladu.ID) |
| IDDoklad | int FK | Document ID (TabDokladyZbozi.ID) |
| SkupZbo | nvarchar | Product group |
| RegCis | nvarchar | Registration number |
| Nazev1-4 | nvarchar | Product names |
| Mnozstvi | numeric | Quantity |
| MJ | nvarchar | Unit of measure |
| JCbezDaniKC | numeric | Unit price excl. tax (CZK) |
| JCsDPHKc | numeric | Unit price incl. VAT (CZK) |
| SazbaDPH | numeric | VAT rate |
| DatPorizeni | datetime | Date |
| DatZmeny | datetime | Modified date |

### TabUzivAtr - User-Defined Attributes
Metadata table describing custom columns added to _EXT tables.

| Column | Type | Description |
|---|---|---|
| NazevTabulkySys | nvarchar | Target table (e.g. 'TabKmenZbozi') |
| NazevAtrSys | nvarchar | Attribute system name |
| KonverzeAtr | ntext | Conversion values (line-separated key=value pairs) |

## Pricing

### TabNC - Price Lists

| Column | Type | Description |
|---|---|---|
| ID | int PK | Price entry ID |
| CenovaUroven | int | Price level |
| IDKmenZbozi | int FK | Product ID |
| IDZboSklad | int FK | Stock card ID |
| CenaKC | numeric | Price in CZK |
| BezDPH | char(1) | 'A'=excl. VAT / 'N'=incl. VAT |
| CenaVal1-5 | numeric | Prices in foreign currencies 1-5 |
| Mena1-5 | nvarchar | Currency codes 1-5 |
| DatumOd/DatumDo | datetime | Validity period |
| AutAktualizace | bit | Auto-update flag |

### TabCisNC - Price Level Definitions

| Column | Type | Description |
|---|---|---|
| ID | int PK | Price level ID |
| CenovaUroven | int | Price level number |
| Nazev | nvarchar(50) | Price level name |
| Aktivni | char(1) | 'A'=active / 'I'=inactive |
| BezDPH | bit | Excl. VAT flag |

## Categories

### TabSoz - Category Tree (Sortiment)

| Column | Type | Description |
|---|---|---|
| ID | int PK | Category ID |
| Nazev | nvarchar | Category name |
| NadID | int | Parent category ID (0 = root) |
| SortNS | int | Sortiment type (1 = standard product categories) |
| ElObchod | bit | E-shop flag |
| Poradi | int | Sort order |

### TabSortiment - Sortiment (Alternative category view)

| Column | Type | Description |
|---|---|---|
| ID | int PK | Sortiment ID |
| Nazev | nvarchar | Name |
| IDNadrazene | int | Parent ID |
| K1-K5 | int | Key fields |

### TabSozNa - Product-Category Assignment

| Column | Type | Description |
|---|---|---|
| IDSoz | int FK | Category ID (TabSoz.ID) |
| IDKmenZbo | int FK | Product ID (TabKmenZbozi.ID) |
| CenovaUroven | int | Price level override |
| Sleva | numeric | Discount override |

## Organizations & Contacts

### TabCisOrg - Organizations / Addresses
Central address book for customers, suppliers, delivery addresses.

| Column | Type | Description |
|---|---|---|
| ID | int PK | Organization ID |
| CisloOrg | int UNIQUE | Organization number (used as FK everywhere) |
| NadrizenaOrg | int | Parent org number (for delivery addresses) |
| Nazev | nvarchar(250) | Company name / Full name |
| DruhyNazev | nvarchar | Second name (used for producer name) |
| Jmeno | nvarchar(85) | First name |
| Prijmeni | nvarchar(85) | Last name |
| Ulice | nvarchar(85) | Street |
| Misto | nvarchar(85) | City |
| PSC | nvarchar(8) | Postal code |
| IdZeme | nvarchar FK | Country ISO code (→TabZeme.ISOKod) |
| ICO | nvarchar | Company registration number |
| DIC | nvarchar | Tax ID |
| DICsk | nvarchar | Slovak Tax ID / IC DPH |
| Mena | nvarchar | Default currency |
| CenovaUroven | int | Price level |
| Sleva | numeric | Default discount |
| JeOdberatel | bit | Is customer |
| JeDodavatel | bit | Is supplier |
| Fakturacni | bit | Is billing address |
| MU | bit | Is delivery address (Místo Určení) |
| Prijemce | bit | Is receiver |
| PravniForma | int | Legal form (0=VAT payer, 1=company, 2=individual) |
| PlatceDPH | bit | VAT payer flag |

### TabCisOrg_EXT - Organization Extensions
Custom attributes. Same ID as TabCisOrg.

### TabKontakty - Contact Information

| Column | Type | Description |
|---|---|---|
| ID | int PK | Contact ID |
| IDOrg | int FK | Organization ID |
| IDCisKOs | int FK | Contact person ID |
| IDVztahKOsOrg | int FK | Person-Org relation ID |
| Druh | int | Contact type (see below) |
| Spojeni | nvarchar | Contact value (phone/email) |
| Prednastaveno | bit | Is default |

**Druh (Contact type) values** (common):
| Value | Type |
|---|---|
| 2 | Phone |
| 6 | Email |
| 10 | Email (secondary/notification) |

### TabCisKOs - Contact Persons

| Column | Type | Description |
|---|---|---|
| ID | int PK | Person ID |
| Cislo | int | Person number |
| Jmeno | nvarchar(85) | First name |
| Prijmeni | nvarchar(85) | Last name |
| TitulPred/TitulZa | nvarchar | Title before/after name |

### TabVztahOrgKOs - Person-Organization Relations

| Column | Type | Description |
|---|---|---|
| ID | int PK | Relation ID |
| IDCisKOs | int FK | Person ID |
| IDOrg | int FK | Organization ID |

### TabZeme - Countries

| Column | Type | Description |
|---|---|---|
| ID | int PK | Country ID |
| ISOKod | nvarchar | ISO code (CZ, SK, DE...) |
| Nazev | nvarchar | Country name |
| EU | bit | EU member |
| SEPA | bit | SEPA member |

## Received Orders

### TabDosleObjH01 / TabDosleObjH02 - Order Headers
Two variants for different order types.

| Column | Type | Description |
|---|---|---|
| ID | int PK | Order header ID |
| Rada | nvarchar(3) | Document series |
| Cislo | nvarchar(17) | Document number |
| IDSklad | nvarchar | Warehouse |
| CisloOrg | int FK | Customer org number |
| MistoUrceni | nvarchar | Delivery address org number |
| Prijemce | nvarchar | Receiver org number |
| DatumPripadu | datetime | Order date |
| DatumDodavky | datetime | Delivery date |
| ExterniCislo | nvarchar | External order number (e-shop ID) |
| PopisDodavky | nvarchar | Delivery description |
| Mena | nvarchar | Currency |
| DatumKurzu | datetime | Exchange rate date |
| Kurz | numeric | Exchange rate |
| JednotkaMeny | int | Currency unit |
| VstupniCena | int | Input price type |
| IDFormaUhrady | int | Payment method ID |
| IDFormaDopravy | int | Shipping method ID |
| IDCenik | int | Price list ID |
| IDBankSpojeni | int | Bank connection ID |
| InterniPoznamka | ntext | Internal note |
| VerejnaPoznamka | ntext | Public note |
| VerejnaPoznamka2/3/4 | ntext | Additional notes |
| Stav | int | Status |
| SumaKc | numeric | Total in CZK |
| SumaVal | numeric | Total in foreign currency |
| DatPorizeni | datetime | Created date |
| DatZmeny | datetime | Modified date |

### TabDosleObjR01 / TabDosleObjR02 - Order Line Items

| Column | Type | Description |
|---|---|---|
| ID | int PK | Line item ID |
| IDHlava | int FK | Order header ID |
| IDZboSklad | int FK | Stock card ID |
| PoradiPolozky | int | Item sequence |
| SkupZbo | nvarchar | Product group |
| RegCis | nvarchar | Product code |
| Nazev1-4 | nvarchar | Product names |
| Mnozstvi | numeric | Quantity |
| MJ | nvarchar | Unit of measure |
| SazbaDPH | numeric | VAT rate |
| JCbezDaniKC | numeric | Unit price excl. tax CZK |
| JCsDPHKc | numeric | Unit price incl. VAT CZK |
| JCbezDaniVal | numeric | Unit price excl. tax foreign |
| JCsDPHVal | numeric | Unit price incl. VAT foreign |
| VstupniCena | int | Input price type |
| Poznamka | nvarchar | Note |

## Goods Circulation Documents

### TabDokladyZbozi - Document Headers
Universal table for all goods movement documents (expedition orders, invoices, stock receipts, etc.).

| Column | Type | Description |
|---|---|---|
| ID | int PK | Document ID |
| DruhPohybuZbo | tinyint | Movement type (0=receipt, 2=issue, 9=expedition, 13=invoice...) |
| IDSklad | nvarchar | Warehouse |
| RadaDokladu | nvarchar(3) | Document series |
| PoradoveCislo | int | Sequence number |
| CisloOrg | int FK | Organization number |
| DatPorizeni | datetime | Created date |
| Mena | nvarchar | Currency |
| Kurz | numeric | Exchange rate |
| VstupniCena | int | Input price type |
| FormaUhrady | int | Payment method |
| FormaDopravy | int | Shipping method |
| SumaKc | numeric | Total CZK |
| SumaVal | numeric | Total foreign currency |
| Stav | int | Status |
| BlokovaniEditoru | int | Editor lock (set NULL to trigger recalc) |
