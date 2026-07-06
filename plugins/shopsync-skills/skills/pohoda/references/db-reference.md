# Pohoda DB Reference

Full DDL: `C:\Users\Vojtech Sokol\Documents\share\podklady\pohoda\db_schema.sql` (SQL Server, UTF-16, ~21 k lines). The `.mdb` variant has identical table/column names. Every table has `ID` (identity), `DatCreate`, `DatSave`, and most business tables have `Sel` (selected flag) and `RelPch` / `RelSzDPH` / `RefStr` / `RefCin` bookkeeping columns.

## Products — `SKz` (store cards)

The central table. "SKz" = "skladové karty základní". One row per product or variant.

| Column | Type | Meaning |
|--------|------|---------|
| `ID` | identity | PK |
| `IDS` | varchar(64) | **Product code** (primary pair field) |
| `EAN` | varchar(20) | Barcode |
| `PLU` | long | POS code |
| `Nazev`, `Nazev1`, `Nazev2` | varchar(90) | Display name (and 2 localizations) |
| `SText`, `SText1`, `SText2` | varchar(90) | Short text / subtitle |
| `Popis`, `Popis2` | MEMO | Long description / secondary description |
| `FmtPopis`, `FmtPopis2` | bit | Description contains HTML formatting |
| `NazevRP` | varchar(24) | **Parent code** — children share this; parent's `NazevRP` equals its own `IDS` |
| `RefSklad` | long | → `sSklad.ID` (storage location) |
| `RefStruct`, `RefSkSkup`, `RelSkTyp`, `RelSkDruh` | long | Classification / group / type / kind refs |
| `RelDPHn`, `RelDPHp` | long | → sDPH (purchase/sale VAT rate FK) |
| `MJ`, `MJ2`, `MJ3` | varchar(10) | Units of measure (base + two alternates) |
| `MJ2Koef`, `MJ3Koef` | float | Conversion coefficients |
| `StavZ` | float | **Stock quantity** |
| `StavZV` | float | Reserved + on-order-adjusted stock |
| `Rezer` | float | Reserved qty |
| `ObjedP`, `ObjedV` | float | Ordered-in / ordered-out qty |
| `MinLim`, `MinMax` | float | Reorder min / max |
| `Hmotnost`, `Objem` | float | Weight / volume |
| `NakupC`, `NakupDPH`, `NakupCM` | currency | Purchase price (base / with-VAT / foreign) |
| `CMKodNC` | varchar(3) | Foreign currency code for `NakupCM` |
| `ProdejKc`, `ProdejDPH`, `ProdejCM` | currency | **Sale price** (base / with-VAT / foreign) |
| `CMKodPC` | varchar(3) | Foreign currency for `ProdejCM` |
| `Marze`, `Rabat` | float | Margin / discount % |
| `ObjMn`, `ObjNazev` | float / varchar(90) | Order multiple / order name |
| `RefAD` | long | → `AD.ID` default supplier |
| `Firma` | varchar(255) | Supplier name cache |
| `IObchod` | bit | **1 = show on e-shop** (main filter flag) |
| `Template` | bit | 1 = template card (exclude from normal loads) |
| `mPohoda` | bit | Visible to mPohoda mobile |
| `Obrazek` | varchar(200) | Primary image path |
| `VPr*` (many) | various | **User-defined fields** — per-installation custom columns (e.g. `VPrSeoTop1`, `VPrHubModel`, `VPrPackingWeight`, `VPrKratkynazov`). Verify names against the actual DB. |
| `DatCreate`, `DatSave` | datetime | Created / last saved — `DatSave > [last]` drives incremental sync |

**Typical products SELECT** (from `Pohoda\Products::$select`):
```sql
SELECT SKz.*, (SELECT TOP 1 sSklad.IDS FROM sSklad WHERE sSklad.ID=SKz.RefSklad) AS storage
FROM SKz
INNER JOIN sSklad ON SKz.RefSklad = sSklad.ID
WHERE (
    SKz.DatSave > '[last]'
    OR (SELECT MAX(SkACn.DatSave) FROM SkACn
        INNER JOIN SkACnPol ON SkACn.ID = SkACnPol.RefAg
        WHERE SkACnPol.RefSKz = SKz.ID) > '[last]'
    OR (SKz.NazevRP <> '' AND SKz.NazevRP IS NOT NULL
        AND (SELECT MAX(s2.DatSave) FROM SKz AS s2 WHERE s2.IDS = SKz.NazevRP) > '[last]')
) AND SKz.IObchod = 1 AND SKz.Template = 0
AND ('[filter_stock]' = '' OR sSklad.IDS IN ('[filter_stock]'))
```

## Storage locations — `sSklad`

| Column | Meaning |
|--------|---------|
| `ID` | PK, matched by `SKz.RefSklad` |
| `IDS` | Storage code (what `filter_stock` matches against) |
| `SText` | Storage display name |

## Categories — `SkKat`

Hierarchical. Every project's "category tree" lives here.

| Column | Meaning |
|--------|---------|
| `ID` | PK |
| `IDS` | **Category name** (acts as pair field — must be unique) |
| `RefNodeID` | → parent `SkKat.ID`; 0 for top level |
| `SupNodeIDS` | Parent's `IDS` (denormalized) — root is literally `Všechny kategorie` (CZ) or `Všetky kategórie` (SK) |
| `Node` | Depth level (1 = top) |
| `FullTreeNode` | Full slash-delimited path |
| `Poradi` | Sort order |
| `Obrazek` | Image path |
| `SText` | Description |

Product→category mapping is via a separate link table (commonly `SKzKat` or `SkKatSKz` depending on Pohoda version — verify in the actual DB).

## Address book — `AD`

Customers, suppliers, and all partners in one table.

| Column | Meaning |
|--------|---------|
| `ID` | PK |
| `Cislo` | Partner number |
| `Firma`, `Jmeno`, `Ulice`, `Obec`, `PSC` | Billing company / name / street / city / zip |
| `RefZeme` | → country |
| `ICO`, `DIC`, `ICDPH` | Tax IDs (CZ IČO / DIČ / SK IČ DPH) |
| `RelTypDIC` | VAT ID type |
| `Firma2`, `Jmeno2`, `Ulice2`, `Obec2`, `PSC2`, `RefZeme2` | **Shipping** address block |
| `Email`, `Email2` | Billing / shipping email |
| `Tel`, `Tel2`, `GSM` | Phones |
| `Ucet`, `KodBanky` | Bank account / bank code |
| `DataBox` | Czech "datová schránka" ID |
| `Skupina` | Price-list group name (`B2B`, `VIP`, etc.) |
| `RelFor Uh` | Default payment-type ref |
| `ADKredit`, `ADKreditMax` | Credit limit |
| `KcObrat`, `KcObrat2` | Turnover counters |
| `GdprDat*` | GDPR consent dates |
| `DatCreate`, `DatSave` | Timestamps |

## Parameters — `SkParam` (+ value lookups)

Attribute definitions attached to `SKz`.

- `SkParam.IDS` - parameter code
- `SkParam.SText` - display name
- `SkParam.Typ` - `text`, `cislo` (number), `seznam` (list), `datum` (date), `logicka` (bool)
- `SkParam.RefPULo` - → `sVPULo` definition row for `seznam` type (the list itself)
- List value lookups: `sVPULpol` — `ID`, `IDS` (code), `SText` (label), `RefAg` → `sVPULo.ID`

Per-product values: stored either directly on `SKz` (for fixed parameters) or in the product parameter values table (varies by Pohoda version — check DB).

## Action prices — `SkACn` / `SkACnPol`

Time-bounded price lists (sales / B2B tiers).

- `SkACn` - the "akce" header: `IDS`, `SText`, `DatOd`, `DatDo`, `Skupina` (price-list group, maps to `AD.Skupina`)
- `SkACnPol` - lines: `RefAg` → `SkACn.ID`, `RefSKz` → `SKz.ID`, `ProdejC` (price), `Sleva` (discount %), `SDph` (1 = price incl. VAT)

## Orders — `OBJ` / `OBJpol`

Received orders (tag "Přijaté objednávky").

- `OBJ` (header): `ID`, `PDoklad` (document number — **pair field for e-shop order number**), `Datum`, `DatTermin`, `RefAD`, `Firma`, `Jmeno`, `Ulice`, …, billing + shipping address block, `RefStr` (centre), `RefCin` (activity), `RelSzDPH`, `KcCelkem`, `VarSym`, `RelFor Uh`, `Popis`, `Pozn`
- `OBJpol` (lines): `RefAg` → `OBJ.ID`, `RefSKz` → `SKz.ID`, `Kod`, `Nazev`, `MnMj`, `KcJedn`, `SDph`, `SazbaDPH`, `RelTpDPH`, `PercentoSlevy`

## Invoices — `FV` / `FVpol` (shape identical)

Issued invoices. Same header/lines pattern as `OBJ`/`OBJpol` but with dates `DatVy`, `DatSp`, `DatSplat` and a `CisObj` column linking back to an order. Paired classes: `FP`/`FPpol` for received invoices.

## Images / attachments

- `SkRefObraz` - product images: `ID`, `RefAg` → `SKz.ID`, `Soubor` (filename/path), `Popis` (description), `Vychozi` (default=1), `OrderFld` (sort)
- `SkRefSvazany` - product file attachments: `Soubor`, `Popis`, `RefAg`

## Currency rates — `sCKurs` / `sCKurspol`

- `sCKurs` - rate table per date: `ID`, `Datum`
- `sCKurspol` - per-currency line: `RefAg` → `sCKurs.ID`, `Kod` (e.g. `EUR`), `NBs` (rate per unit)

Typical "get rate on date" query:
```sql
SELECT TOP 1 sCKurspol.NBs FROM sCKurs
INNER JOIN sCKurspol ON sCKurspol.RefAg = sCKurs.ID AND sCKurspol.Kod = 'EUR'
WHERE sCKurs.Datum <= {d '2026-01-01'}
ORDER BY sCKurs.Datum DESC
```

## VAT — `sDPH`

| Column | Meaning |
|--------|---------|
| `ID` | PK (referenced by `SKz.RelDPHn`/`RelDPHp`, `OBJpol.RelTpDPH`, etc.) |
| `SazbaDPH` | Rate % |
| `Typ` | `H` (high), `L` (low), `T` (third), `N` (none) |

## List-value lookup — `sVPULpol` / `sVPULo`

Dropdown list definitions (used for parameters, activity codes, centres, etc.):
- `sVPULo` - list header (`ID`, `SText` = list name)
- `sVPULpol` - list rows (`ID`, `RefAg` → `sVPULo.ID`, `IDS` = code, `SText` = label)

Helpers `getRefVal()` / `getRefVal2()` in `lib/pohoda/inc.php` wrap this lookup.

## Column naming cheat-sheet

| Prefix | Meaning |
|--------|---------|
| `ID` | Own PK |
| `IDS` | Code / short ID (string, usually the business-side pair field) |
| `Ref*` | FK to another table's `ID` (hard reference) |
| `Rel*` | FK into a classifier/enum list (`sDPH`, `sDruhDokl`, …) |
| `Dat*` | Date / datetime |
| `Kc*` | Amount in home currency |
| `CM*` | Amount in foreign currency |
| `VPr*` | **User-defined column** (per-installation custom field) — verify existence before referencing |
| `S*` bit / `I*` bit | Boolean-ish flags |

## Working with `db_schema.sql`

The file is UTF-16LE encoded, so Grep patterns need to match every other byte position. Easier to use column numbers to find table defs — each `CREATE TABLE [dbo].[<Name>](` sits at a known line (see the Grep output), then read with `Read` using `offset`/`limit` to pull just that table's ~N columns.
