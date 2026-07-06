# Účetní deník

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `ucetni-denik` |
| **Evidence Type** | `UCETNI_DENIK` |
| **Import Status** | DISALLOWED |
| **DB Name** | `UcetniDenik` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/ucetni-denik` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/ucetni-denik/properties` |

## Vlastnosti (38)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `idUcetniDenik` | ID | integer |  | ne | ANO | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime |  | ne | ne | - | - | - | - | Poslední změna |
| `updatedBy` | Upravil | relation |  | ne | ANO | 254 | - | - | `uzivatel` | Upravil |
| `clenDph` | Řádky DPH | relation |  | ne | ANO | - | - | - | `cleneni-dph` | Řádky DPH |
| `datSplat` | Datum splatnosti | date |  | ne | ANO | - | - | - | - | Datum splatnosti |
| `datUhr` | Datum úhrady | date |  | ne | ANO | - | - | - | - | Datum úhrady |
| `datVyst` | Dat. vyst. dokladu | date |  | ne | ANO | - | - | - | - | Datum vystavení dokladu |
| `datUcto` | Datum zaúčtování | date |  | ne | ANO | - | - | - | - | Datum zaúčtování |
| `doklad` | Int.čís.dokladu | string |  | ne | ANO | - | - | - | - | Interní číslo dokladu |
| `duzpUcto` | Datum zdan. plnění | date |  | ne | ANO | - | - | - | - | Datum zdan. plnění |
| `postingPeriod` | Období zaúčtování | yearMonth |  | ne | ANO | - | - | - | - | Období zaúčtování |
| `firma` | Firma | relation |  | ne | ANO | 20 | - | - | `adresar` | Firma |
| `kurz` | Kurz | numeric |  | ne | ANO | - | 19 | 6 | - | Kurz |
| `kurzMnozstvi` | Kurz. množství | numeric |  | ne | ANO | - | 19 | 6 | - | Kurz. množství |
| `mena` | Měna | relation |  | ne | ANO | - | - | - | `mena` | Měna |
| `modul` | Modul | string |  | ne | ANO | - | - | - | - | Modul |
| `modulK` | Název modulu | select |  | ne | ANO | - | - | - | - | Název modulu |
| `nazFirmy` | Název firmy | string |  | ne | ANO | - | - | - | - | Název firmy |
| `dic` | DIČ | string |  | ne | ANO | 20 | - | - | - | DIČ |
| `popis` | Popis | string |  | ne | ANO | - | - | - | - | Popis |
| `varSym` | Variabilní symbol | string |  | ne | ANO | - | - | - | - | Variabilní symbol |
| `typSzbDphK` | Sazba DPH | select |  | ne | ANO | 50 | - | - | - | Sazba DPH |
| `szbDph` | Hodnota DPH | numeric |  | ne | ANO | - | 15 | 2 | - | Hodnota DPH |
| `sumTuz` | Částka [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Částka [Kč] |
| `sumMen` | Částka [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Částka [měna] |
| `stavUzivK` | Stav dokladu | select |  | ne | ANO | - | - | - | - | Stav dokladu |
| `stredisko` | Středisko | relation |  | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `mdUcet` | Účet MD | relation |  | ne | ANO | - | - | - | `ucet` | Účet MD |
| `dalUcet` | Účet DAL | relation |  | ne | ANO | - | - | - | `ucet` | Účet DAL |
| `idDokl` | ID dokladu | integer |  | ne | ANO | - | - | - | - | ID dokladu |
| `zuctovano` | Zaúčtováno | logic |  | ne | ANO | - | - | - | - | Stav zaúčtování |
| `vatItem` | Položka pro DPH částku | logic |  | ne | ANO | - | - | - | - | Položka pro DPH částku |
| `accountsSwapped` | Převrácení stran účtování | logic |  | ne | ANO | - | - | - | - | Převrácení stran účtování |
| `zakazka` | Zakázka | relation |  | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `parSymbol` | Párovací symbol | string |  | ne | ANO | - | - | - | - | Párovací symbol |
| `cinnost` | Činnost | relation |  | ne | ANO | - | - | - | `cinnost` | Činnost |
| `idPolozek` | Seznam ID položek | array |  | ne | ANO | - | - | - | - | Seznam ID položek |
| `bezPolozek` | Bezpoložkový doklad | logic |  | ne | ANO | - | - | - | - | bezpoložkový doklad |
