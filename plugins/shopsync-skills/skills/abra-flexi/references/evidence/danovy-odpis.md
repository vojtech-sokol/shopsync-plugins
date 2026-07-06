# Daňové odpisy

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `danovy-odpis` |
| **Evidence Type** | `DANOVY_ODPIS` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `mDanOdpisy` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/danovy-odpis` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/danovy-odpis/properties` |

## Vlastnosti (17)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDanOdpisu | ne | ne | - | - | - | - | ID |
| `ucetni` | Je účetní | logic | Ucetni | ne | ANO | - | - | - | - | Doklad je účetní |
| `zmena` | Uživ. změn. | logic | Zmena | ne | ne | - | - | - | - | Uživatelsky změněno |
| `datVyst` | Datum vyst. | date | DatVyst | **ANO** | ANO | - | - | - | - | Vystaveno |
| `sumZkl` | Daň.odpis [Kč] | numeric | SumZkl | **ANO** | ANO | - | 15 | 2 | - | Daň.odpis [Kč] |
| `stariMaj` | Stáří[Roky] | integer | StariMaj | ne | ne | - | - | - | - | Stáří majetku [Roky] |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `zamek` | Zámek | logic | Zamek | ne | ne | - | - | - | - | Zámek |
| `zustPoOdp` | Zůstatek [Kč] | numeric | ZustPoOdp | ne | ANO | - | 15 | 2 | - | Zůstatek [Kč] |
| `kod` | Číslo dokladu | string | Kod | ne | ANO | 20 | - | - | - | Číslo dokladu |
| `modul` | Modul | string | Modul | ne | ne | - | - | - | - | Modul |
| `datUcto` | Datum zaúčtování | date | DatUcto | ne | ne | - | - | - | - | Datum zaúčtování |
| `majetek` | Majetek | relation | IdMajetku | ne | ne | 20 | - | - | `majetek` | Majetek |
| `zklMdUcet` | Účet MD | relation | IdZklMdUcet | ne | ANO | 6 | - | - | `ucet` | Účet MD odpisu |
| `zklDalUcet` | Účet DAL | relation | IdZklDalUcet | ne | ANO | 6 | - | - | `ucet` | Účet DAL odpisu |
| `stredisko` | Středisko | relation | IdStred | **ANO** | ANO | 20 | - | - | `stredisko` | Středisko |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
