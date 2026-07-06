# Splátkový kalendář

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `splatkovy-kalendar` |
| **Evidence Type** | `SPLATKOVY_KALENDAR` |
| **Import Status** | DISALLOWED |
| **DB Name** | `mSplatKal` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/splatkovy-kalendar` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/splatkovy-kalendar/properties` |

## Vlastnosti (27)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSplatKal | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `ucetni` | Je účetní | logic | Ucetni | ne | ANO | - | - | - | - | Doklad je účetní |
| `clenSplK` | Členění splátky | select | ClenSplK | ne | ANO | 50 | - | - | - | Členění splátky |
| `typSplK` | Typ splátky | select | TypSplK | **ANO** | ANO | 50 | - | - | - | Typ splátky |
| `datVyst` | Datum splátky | date | DatVyst | **ANO** | ANO | - | - | - | - | Datum splátky |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `sumDph` | DPH [Kč] | numeric | SumDph | ne | ANO | - | 15 | 2 | - | DPH [Kč] |
| `sumDphMen` | DPH [měna] | numeric | SumDphMen | ne | ANO | - | 15 | 2 | - | DPH [měna] |
| `szbDph` | DPH [%] | numeric | SzbDph | ne | ANO | - | 6 | 2 | - | DPH [%] |
| `typSzbDphK` | Sazba DPH | select | TypSzbDphK | ne | ANO | 50 | - | - | - | Sazba DPH |
| `sumZkl` | Základ [Kč] | numeric | SumZkl | **ANO** | ANO | - | 15 | 2 | - | Základ [Kč] |
| `sumZklMen` | Základ [měna] | numeric | SumZklMen | ne | ANO | - | 15 | 2 | - | Základ [měna] |
| `modul` | Modul | string | Modul | ne | ANO | - | - | - | - | Modul |
| `kod` | Čís.dokl. | string | Kod | **ANO** | ANO | 20 | - | - | - | Číslo dokladu |
| `datUcto` | Datum zaúčtování | date | DatUcto | ne | ANO | - | - | - | - | Datum zaúčtování |
| `cisRad` | Pořadí | integer | CisRad | ne | ANO | - | - | - | - | Pořadí |
| `leasing` | Leasingový majetek | relation | IdLeasing | ne | ANO | 20 | - | - | `leasing` | Leasingový majetek |
| `zklMdUcet` | Úč.MD zakl. | relation | IdZklMdUcet | ne | ANO | 6 | - | - | `ucet` | Účet MD základu |
| `zklDalUcet` | Úč.DAL zakl. | relation | IdZklDalUcet | ne | ANO | 6 | - | - | `ucet` | Účet DAL základu |
| `dphMdUcet` | Úč.MD DPH | relation | IdDphMdUcet | ne | ANO | 6 | - | - | `ucet` | Účet MD DPH |
| `dphDalUcet` | Úč.DAL DPH | relation | IdDphDalUcet | ne | ANO | 6 | - | - | `ucet` | Účet DAL DPH |
| `clenDph` | Členění DPH | relation | IdClenDph | **ANO** | ANO | 20 | - | - | `cleneni-dph` | Členění DPH |
| `stredisko` | Středisko | relation | IdStred | **ANO** | ANO | 20 | - | - | `stredisko` | Středisko |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `zavazek` | Závazek | relation | IdDoklFak | ne | ANO | 6 | - | - | - | Závazek |
| `statDph` | Stát DPH | relation | IdStatDph | **ANO** | ANO | 3 | - | - | `stat-dph` | Stát DPH |
