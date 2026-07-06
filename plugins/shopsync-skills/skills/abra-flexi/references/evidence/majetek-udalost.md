# Události

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `majetek-udalost` |
| **Evidence Type** | `MAJETEK_UDALOST` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `mUdalosti` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/majetek-udalost` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/majetek-udalost/properties` |

## Vlastnosti (25)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdUdalosti | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `ucetni` | Je účetní | logic | Ucetni | ne | ANO | - | - | - | - | Doklad je účetní |
| `typUdalostiK` | Typ události | select | TypUdalostiK | **ANO** | ANO | 50 | - | - | - | Typ události |
| `datVyst` | Datum vyst. | date | DatVyst | **ANO** | ANO | - | - | - | - | Vystaveno |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `sumZkl` | Částka [Kč] | numeric | SumZkl | ne | ANO | - | 15 | 2 | - | Částka [Kč] |
| `sumZklMen` | Základ [měna] | numeric | SumZklMen | ne | ANO | - | 15 | 2 | - | Základ [měna] |
| `sumDph` | Částka účetní [Kč] | numeric | SumDph | ne | ANO | - | 15 | 2 | - | Částka účetní [Kč] |
| `sumDphMen` | DPH [měna] | numeric | SumDphMen | ne | ANO | - | 15 | 2 | - | DPH [měna] |
| `zamek` | Zámek | logic | Zamek | ne | ANO | - | - | - | - | Zámek |
| `kod` | Číslo dokladu | string | Kod | ne | ANO | 20 | - | - | - | Číslo dokladu |
| `modul` | Modul | string | Modul | ne | ANO | - | - | - | - | Modul |
| `zmenaDobyOdpis` | Prodl. úč. odp. | integer | ZmenaDobyOdpis | ne | ANO | - | - | - | - | Prodlouž. účet. odpisů o |
| `datUcto` | Datum zaúčtování | date | DatUcto | **ANO** | ANO | - | - | - | - | Datum zaúčtování |
| `zmena` | Uživ. změna zůst. | logic | Zmena | ne | ANO | - | - | - | - | Uživatelská změna zůstatku |
| `sumDphDanove` | Částka daňová [Kč] | numeric | SumDphDanove | ne | ANO | - | 15 | 2 | - | Částka daňová [Kč] |
| `nahrUcetOdpK` | Účetní odp.? | select | NahrUcetOdpK | ne | ne | 50 | - | - | - | Vytvářet úč. odpisy |
| `majetek` | Majetek | relation | IdMajetku | ne | ne | 20 | - | - | `majetek` | Majetek |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `dphMdUcet` | Úč.MD zůst. | relation | IdDphMdUcet | ne | ANO | 6 | - | - | `ucet` | Účet MD zůstatku |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `zklMdUcet` | Účet MD události | relation | IdZklMdUcet | ne | ANO | 6 | - | - | `ucet` | Účet MD události |
| `zklDalUcet` | Účet DAL události | relation | IdZklDalUcet | ne | ANO | 6 | - | - | `ucet` | Účet DAL události |
| `dphDalUcet` | Úč.DAL zůst. | relation | IdDphDalUcet | ne | ANO | 6 | - | - | `ucet` | Účet DAL zůstatku |
