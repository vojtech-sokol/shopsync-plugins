# Pohyby na účtech

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `pohyb-na-uctech` |
| **Evidence Type** | `POHYB_NA_UCTECH` |
| **Import Status** | DISALLOWED |
| **DB Name** | `PohybyNaUctech` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/pohyb-na-uctech` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/pohyb-na-uctech/properties` |

## Vlastnosti (43)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `lastUpdate` | Poslední změna | datetime |  | ne | ne | - | - | - | - | Poslední změna |
| `updatedBy` | Upravil | relation |  | ne | ANO | 254 | - | - | `uzivatel` | Upravil |
| `clenDph` | Řádky DPH | relation |  | ne | ANO | - | - | - | `cleneni-dph` | Řádky DPH |
| `datSplat` | Datum splatnosti | date |  | ne | ANO | - | - | - | - | Datum splatnosti |
| `datUhr` | Datum úhrady | date |  | ne | ANO | - | - | - | - | Datum úhrady |
| `datVyst` | Datum vyst. | date |  | ne | ANO | - | - | - | - | Vystaveno |
| `doklad` | Int.čís.dokladu | string |  | ne | ANO | - | - | - | - | Interní číslo dokladu |
| `duzpUcto` | Uplatnit zdaň. plnění | date |  | ne | ANO | - | - | - | - | Uplatnit zdaň. plnění |
| `datUcto` | Datum zaúčtování | date |  | ne | ANO | - | - | - | - | Datum zaúčtování |
| `postingPeriod` | Období zaúčtování | yearMonth |  | ne | ANO | - | - | - | - | Období zaúčtování |
| `firma` | Firma | relation |  | ne | ANO | 20 | - | - | `adresar` | Firma |
| `idUcetniDenik` | ID | integer |  | ne | ANO | - | - | - | - | ID |
| `kurz` | Kurz | numeric |  | ne | ANO | - | 19 | 6 | - | Kurz |
| `kurzMnozstvi` | Kurz. množství | numeric |  | ne | ANO | - | 19 | 6 | - | Kurz. množství |
| `mena` | Kód měny | relation |  | ne | ANO | 20 | - | - | `mena` | Kód měny |
| `modul` | Modul | string |  | ne | ANO | - | - | - | - | Modul |
| `nazFirmy` | Název firmy nebo jméno osoby | string |  | ne | ANO | 255 | - | - | - | Název firmy - jméno |
| `dic` | DIČ | string |  | ne | ANO | 20 | - | - | - | DIČ |
| `cisDosle` | Číslo došlé | string |  | ne | ANO | 40 | - | - | - | Číslo došlé |
| `popis` | Popis | string |  | ne | ANO | - | - | - | - | Popis |
| `protiUcet` | Protiúčet | relation |  | ne | ANO | 6 | - | - | `ucet` | Protiúčet |
| `statDph` | Stát DPH | relation |  | ne | ANO | 20 | - | - | `stat-dph` | Stát DPH |
| `stavUhrK` | Stav úhrady | select |  | ne | ANO | - | - | - | - | Stav úhrady |
| `stavUzivK` | Uživatelský stav | select |  | ne | ANO | - | - | - | - | Uživatelský stav |
| `modulK` | Název modulu | select |  | ne | ANO | - | - | - | - | Název modulu |
| `stredisko` | Středisko | relation |  | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `sumMenDal` | DAL [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Částka DAL [měna] |
| `sumMenMd` | MD [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Částka MD [měna] |
| `sumTuzDal` | DAL [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Částka DAL [Kč] |
| `sumTuzMd` | MD [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Částka MD [Kč] |
| `szbDph` | DPH [%] | numeric |  | ne | ANO | - | 6 | 2 | - | DPH [%] |
| `typSzbDphK` | Sazba DPH | select |  | ne | ANO | 50 | - | - | - | Sazba DPH |
| `ucet` | Účet | relation |  | ne | ANO | 6 | - | - | `ucet` | Účet |
| `varSym` | Variabilní symbol | string |  | ne | ANO | 30 | - | - | - | Variabilní symbol |
| `zakazka` | Zakázka | relation |  | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `idDokl` | ID dokladu | integer |  | ne | ANO | - | - | - | - | ID dokladu |
| `zuctovano` | Zaúčtováno | logic |  | ne | ANO | - | - | - | - | Stav zaúčtování |
| `parSymbol` | Párovací symbol | string |  | ne | ANO | - | - | - | - | Párovací symbol |
| `cinnost` | Činnost | relation |  | ne | ANO | - | - | - | `cinnost` | Činnost |
| `nazevUctu` | Název účtu | string |  | ne | ANO | - | - | - | - | Název účtu |
| `vyloucitSaldo` | Vynechat ze salda | logic |  | ne | ANO | - | - | - | - | Vynechat ze salda |
| `vatItem` | Položka pro DPH částku | logic |  | ne | ANO | - | - | - | - | Položka pro DPH částku |
| `accountsSwapped` | Převrácení stran účtování | logic |  | ne | ANO | - | - | - | - | Převrácení stran účtování |
