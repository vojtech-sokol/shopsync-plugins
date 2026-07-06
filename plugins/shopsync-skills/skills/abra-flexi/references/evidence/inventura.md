# Inventury

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `inventura` |
| **Evidence Type** | `INVENTURA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `sInventura` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/inventura` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/inventura/properties` |

## Vlastnosti (12)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdInventura | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `popisInventury` | Popis inventury | string | PopisInventury | ne | ANO | - | - | - | - | Popis inventury |
| `typInventury` | Typ inventury | string | TypInventury | ne | ANO | 255 | - | - | - | Typ inventury |
| `datZahaj` | Datum zahájení | date | DatZahaj | **ANO** | ANO | - | - | - | - | Datum zahájení |
| `datKonec` | Datum ukončení | date | DatKonec | ne | ANO | - | - | - | - | Datum ukončení |
| `vedouci` | Vedoucí | string | Vedouci | ne | ANO | 255 | - | - | - | Vedoucí |
| `osoby` | Osoby | string | Osoby | ne | ANO | - | - | - | - | Osoby |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `stavK` | Stav inventury | select | StavK | ne | ANO | 50 | - | - | - | Stav inventury |
| `sklad` | Sklad | relation | IdSklad | ne | ANO | - | - | - | `sklad` | Sklad |
