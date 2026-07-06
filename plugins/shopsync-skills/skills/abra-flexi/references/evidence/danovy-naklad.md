# Daňové náklady

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `danovy-naklad` |
| **Evidence Type** | `DANOVY_NAKLAD` |
| **Import Status** | DISALLOWED |
| **DB Name** | `mDanNakl` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/danovy-naklad` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/danovy-naklad/properties` |

## Vlastnosti (15)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDanNakl | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `ucetni` | Je účetní | logic | Ucetni | ne | ANO | - | - | - | - | Doklad je účetní |
| `datVyst` | Datum účtování | date | DatVyst | **ANO** | ANO | - | - | - | - | Datum účtování |
| `sumZkl` | Základ [Kč] | numeric | SumZkl | **ANO** | ANO | - | 15 | 2 | - | Základ [Kč] |
| `sumZklMen` | Základ [měna] | numeric | SumZklMen | ne | ANO | - | 15 | 2 | - | Základ [měna] |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `modul` | Modul | string | Modul | ne | ANO | - | - | - | - | Modul |
| `kod` | Číslo dokladu | string | Kod | **ANO** | ANO | 20 | - | - | - | Číslo dokladu |
| `datUcto` | Datum zaúčtování | date | DatUcto | ne | ANO | - | - | - | - | Datum zaúčtování |
| `leasing` | Leasingový majetek | relation | IdLeasing | ne | ANO | 20 | - | - | `leasing` | Leasingový majetek |
| `zklMdUcet` | Účet MD základu | relation | IdZklMdUcet | ne | ANO | 6 | - | - | `ucet` | Účet MD základu |
| `zklDalUcet` | Účet DAL základu | relation | IdZklDalUcet | ne | ANO | 6 | - | - | `ucet` | Účet DAL základu |
| `stredisko` | Středisko | relation | IdStred | **ANO** | ANO | 20 | - | - | `stredisko` | Středisko |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
