---
name: helios-inuvio
description: Helios Inuvio (Orange/Easy) ERP - tables, stored procedures, order import. Use when user mentions "helios" and "inuvio" or "easy" in same prompt, or works in project containing `lib/helios_inuvio/`.
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# Helios Inuvio (Orange / Easy) ERP System

Czech ERP system on **MS SQL Server**, accessed via **ODBC**.

## Key Concepts

- Tables use `Tab` prefix. **Every table can have a `_EXT` extension table** with custom user-defined attributes (same ID).
- Custom attribute definitions stored in `TabUzivAtr`.
- Product code = `concat(SkupZbo, RegCis)` from TabKmenZbozi.
- Stock card (`IDZboSklad`) = TabStavSkladu record (product + warehouse).
- Available stock = `Mnozstvi - MnozNaDObjKVyrizeni - MnozNaGPrUMZKVyrizeni - MnozZPrKVazKVyrizeni`.
- `TabCisOrg` = address book. Use `CisloOrg` as FK (not ID). Delivery addresses use `NadrizenaOrg`.
- Contacts in `TabKontakty`: Druh 2=phone, 6=email, 10=email2.
- Prices in `TabNC` with `CenovaUroven` levels. `BezDPH`: 'A'=excl. VAT, 'N'=incl. VAT.

## Two Ways to Import Orders

### 1. Received Orders (Došlé objednávky)
Tables: `TabDosleObjH0{type}` / `TabDosleObjR0{type}` (pairs: 01/02).
Procedures: `hp_DosleObj_PoradoveCislo`, `hp_DosleObj_NovaHlavicka0{type}`, `hp_DosleObj_NovaPolozka0{type}`, `hp_DosleObj_NovaTxtPolozka0{type}`, `hp_DosleObj_NastavSlevuMnozstviDPHPolozky0{type}`, `hp_DosleObj_ZmenaMenaKurz0{type}`.
Use for: **e-shop orders imported into ERP**.

### 2. Goods Circulation / Expedition (Oběh zboží)
Tables: `TabDokladyZbozi` / `TabPohybyZbozi`.
Procedures: `hp_InsertHlavickyOZ`, `hp_InsertPolozkyOZ`, `hp_VypCenOZPolozek_IDDokladu`.
DruhPohybu: 0=receipt, 2=issue, 9=expedition, 13=invoice.
Requires `#TabTempUziv` temp table outside HeO. Trigger after: `UPDATE TabDokladyZbozi SET BlokovaniEditoru = NULL WHERE Id = @Id`.

### VstupniCena values
0=excl. tax CZK, 1=incl. VAT CZK, 4=excl. tax foreign, 5=incl. VAT foreign.

## References

Consult these before writing queries or procedures:

- `references/tables_reference.md` - Table schemas with column descriptions
- `references/received_orders.md` - Došlé objednávky procedure docs
- `references/goods_circulation.md` - Oběh zboží procedure docs
- `references/code_examples.md` - PHP/ODBC code patterns for ShopSync
- `references/schema.sql` - Full DB schema (14k lines, for column lookups)
