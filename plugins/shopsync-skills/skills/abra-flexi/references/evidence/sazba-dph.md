# Sazby DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `sazba-dph` |
| **Evidence Type** | `SAZBA_DPH` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `uSazbyDph` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/sazba-dph` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/sazba-dph/properties` |

## Vlastnosti (9)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSazbyDph | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `typSzbDphK` | Sazba DPH | select | TypSzbDphK | **ANO** | ANO | 50 | - | - | - | Sazba DPH |
| `szbDph` | DPH [%] | numeric | SzbDph | ne | ANO | - | 6 | 2 | - | DPH [%] |
| `platiOdData` | Platí od data | date | PlatiOdData | **ANO** | ANO | - | - | - | - | Platí od data |
| `platiDoData` | Platí do data | date | PlatiDoData | ne | ANO | - | - | - | - | Platí do data |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `stat` | Stát | relation | IdStatu | **ANO** | ANO | 3 | - | - | `stat` | Stát |
