# Účetní odpisy

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `ucetni-odpis` |
| **Evidence Type** | `UCETNI_ODPIS` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `mUcetOdpisy` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/ucetni-odpis` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/ucetni-odpis/properties` |

## Vlastnosti (16)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdUcetOdpisu | ne | ne | - | - | - | - | ID |
| `ucetni` | Je účetní | logic | Ucetni | ne | ANO | - | - | - | - | Doklad je účetní |
| `zmena` | Uživ. změn. | logic | Zmena | ne | ne | - | - | - | - | Uživatelsky změněno |
| `datVyst` | Datum vyst. | date | DatVyst | **ANO** | ANO | - | - | - | - | Vystaveno |
| `sumZkl` | Účet. odpis [Kč] | numeric | SumZkl | **ANO** | ANO | - | 15 | 2 | - | Účet. odpis [Kč] |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `kod` | Číslo dokladu | string | Kod | ne | ANO | 20 | - | - | - | Číslo dokladu |
| `modul` | Modul | string | Modul | ne | ne | - | - | - | - | Modul |
| `zamek` | Zámek | logic | Zamek | ne | ne | - | - | - | - | Zámek |
| `zustPoOdp` | Zůstatek [Kč] | numeric | ZustPoOdp | ne | ANO | - | 15 | 2 | - | Zůstatek [Kč] |
| `datUcto` | Datum zaúčtování | date | DatUcto | ne | ne | - | - | - | - | Datum zaúčtování |
| `majetek` | Majetek | relation | IdMajetku | ne | ne | 20 | - | - | `majetek` | Majetek |
| `zklMdUcet` | Účet MD | relation | IdZklMdUcet | **ANO** | ANO | 6 | - | - | `ucet` | Účet MD odpisu |
| `zklDalUcet` | Účet DAL | relation | IdZklDalUcet | **ANO** | ANO | 6 | - | - | `ucet` | Účet DAL odpisu |
| `stredisko` | Středisko | relation | IdStred | **ANO** | ANO | 20 | - | - | `stredisko` | Středisko |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
