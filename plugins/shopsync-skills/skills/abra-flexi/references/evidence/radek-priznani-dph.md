# Řádky uloženého přiznání DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `radek-priznani-dph` |
| **Evidence Type** | `RADEK_PRIZNANI_DPH` |
| **Import Status** | DISALLOWED |
| **DB Name** | `uRadekPriznaniDph` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/radek-priznani-dph` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/radek-priznani-dph/properties` |

## Vlastnosti (13)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdRadekPriznaniDph | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `rok` | Rok | integer | Rok | ne | ANO | - | - | - | - | Rok |
| `mesic` | Měsíc | integer | Mesic | ne | ANO | - | - | - | - | Měsíc |
| `ctvrtleti` | Čtvrtletí | integer | Ctvrtleti | ne | ANO | - | - | - | - | Čtvrtletí |
| `datum` | Datum výpočtu | date | Datum | **ANO** | ANO | - | - | - | - | Datum výpočtu |
| `stavK` | Typ přiznání DPH | select | StavK | ne | ANO | 50 | - | - | - | Typ přiznání DPH |
| `zaklad` | Základ | numeric | Zaklad | **ANO** | ANO | - | 19 | 6 | - | Základ |
| `dph` | DPH | numeric | Dph | **ANO** | ANO | - | 19 | 6 | - | DPH |
| `typSzbDphK` | Sazba DPH | select | TypSzbDphK | ne | ANO | 50 | - | - | - | Sazba DPH |
| `uzivatel` | Uživatel | relation | IdUzivatel | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
| `clenDph` | Řádky DPH | relation | IdClenDph | ne | ANO | - | - | - | `cleneni-dph` | Řádky DPH |
| `stat` | Stát | relation | IdStat | ne | ANO | 3 | - | - | `stat` | Stát |
