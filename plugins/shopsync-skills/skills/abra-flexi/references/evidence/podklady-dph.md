# Podklady DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `podklady-dph` |
| **Evidence Type** | `PODKLADY_DPH` |
| **Import Status** | DISALLOWED |
| **DB Name** | `PodkladyDph` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/podklady-dph` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/podklady-dph/properties` |

## Vlastnosti (47)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `clenDph` | Řádky DPH | relation |  | ne | ANO | - | - | - | `cleneni-dph` | Řádky DPH |
| `clenKonVykDph` | Řádek kontrolního hlášení DPH | relation |  | ne | ANO | - | - | - | `cleneni-kontrolni-hlaseni` | Řádek kontrolního hlášení DPH |
| `datSplat` | Datum splatnosti | date |  | ne | ANO | - | - | - | - | Datum splatnosti |
| `datUhr` | Datum úhrady | date |  | ne | ANO | - | - | - | - | Datum úhrady |
| `datVyst` | Dat. vyst. dokladu | date |  | ne | ANO | - | - | - | - | Datum vystavení dokladu |
| `datUcto` | Datum zaúčtování | date |  | ne | ANO | - | - | - | - | Datum zaúčtování |
| `doklad` | Int. čís. dokladu | string |  | ne | ANO | - | - | - | - | Interní číslo dokladu |
| `duzpPuv` | Datum zdaň. plnění | date |  | ne | ANO | - | - | - | - | Datum zdaň. plnění |
| `duzpUcto` | Uplatnit zdaň. plnění | date |  | ne | ANO | - | - | - | - | Uplatnit zdaň. plnění |
| `firma` | Firma | relation |  | ne | ANO | 20 | - | - | `adresar` | Firma |
| `jeDph` | Je DPH | logic |  | ne | ANO | - | - | - | - | Je DPH |
| `kurz` | Kurz | numeric |  | ne | ANO | - | 19 | 6 | - | Kurz |
| `modul` | Modul | string |  | ne | ANO | - | - | - | - | Modul |
| `modulK` | Název modulu | select |  | ne | ANO | - | - | - | - | Název modulu |
| `nazFirmy` | Název firmy nebo jméno osoby | string |  | ne | ANO | 255 | - | - | - | Název firmy - jméno |
| `popis` | Popis | string |  | ne | ANO | - | - | - | - | Popis |
| `varSym` | Variabilní symbol | string |  | ne | ANO | 30 | - | - | - | Variabilní symbol |
| `typSzbDphK` | Sazba DPH | select |  | ne | ANO | 50 | - | - | - | Sazba DPH |
| `szbDph` | Hodnota DPH | numeric |  | ne | ANO | - | 6 | 2 | - | Hodnota DPH |
| `sumZklTuz` | Základ [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ [Kč] |
| `sumZklMen` | Základ [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ [měna] |
| `sumDphTuz` | DPH [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH [Kč] |
| `sumDphMen` | DPH [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH [měna] |
| `stavUzivK` | Stav dokladu | select |  | ne | ANO | 50 | - | - | - | Stav dokladu |
| `zklMdUcet` | Účet MD základ | relation |  | ne | ANO | 6 | - | - | `ucet` | Má Dáti základu |
| `zklDalUcet` | Účet Dal základ | relation |  | ne | ANO | 6 | - | - | `ucet` | Dal základu |
| `dphMdUcet` | Účet MD DPH | relation |  | ne | ANO | 6 | - | - | `ucet` | Má dáti DPH |
| `dphDalUcet` | Účet Dal DPH | relation |  | ne | ANO | 6 | - | - | `ucet` | Dal DPH |
| `idDokl` | ID dokladu | integer |  | ne | ANO | - | - | - | - | ID dokladu |
| `zuctovano` | Zaúčtováno | logic |  | ne | ANO | - | - | - | - | Stav zaúčtování |
| `zakazka` | Zakázka | relation |  | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `stredisko` | Středisko | relation |  | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `typPlneniK` | Typ plnění DPH | select |  | ne | ANO | 50 | - | - | - | Typ plnění DPH |
| `statDph` | Stát DPH | relation |  | ne | ANO | 3 | - | - | `stat-dph` | Stát DPH |
| `mesicUcto` | Měsíc zaúčtování | integer |  | ne | ANO | - | - | - | - | Měsíc zaúčtování |
| `rokUcto` | Rok zaúčtování | integer |  | ne | ANO | - | - | - | - | Rok zaúčtování |
| `mesicDuzp` | Měsíc DUZP | integer |  | ne | ANO | - | - | - | - | Měsíc DUZP |
| `rokDuzp` | Rok DUZP | integer |  | ne | ANO | - | - | - | - | Rok DUZP |
| `typUcOp` | Předpis zaúčtování | relation |  | ne | ANO | - | - | - | `predpis-zauctovani` | Předpis zaúčtování |
| `dic` | DIČ | string |  | ne | ANO | 20 | - | - | - | DIČ |
| `cisDosle` | Číslo došlé | string |  | ne | ANO | 40 | - | - | - | Číslo došlé |
| `vypRozdilDphMen` | Vyp. rozdíl DPH [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Vyp. rozdíl DPH [měna] |
| `vypRozdilDphTuz` | Vyp. rozdíl DPH [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Vyp. rozdíl DPH [Kč] |
| `vypSumDphMen` | Vyp. DPH [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Vyp. DPH [měna] |
| `vypSumDphTuz` | Vyp. DPH [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Vyp. DPH [Kč] |
| `vypSzbDph` | Vyp. sazba DPH | numeric |  | ne | ANO | - | 15 | 6 | - | Vyp. sazba DPH |
| `vypRozdilSzbDph` | Vyp. rozdíl sazby DPH | numeric |  | ne | ANO | - | 15 | 6 | - | Vyp. rozdíl sazby DPH |
