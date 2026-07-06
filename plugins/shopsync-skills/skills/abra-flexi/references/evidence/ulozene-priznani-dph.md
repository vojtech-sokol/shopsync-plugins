# Uložené přiznání DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `ulozene-priznani-dph` |
| **Evidence Type** | `ULOZENE_PRIZNANI_DPH` |
| **Import Status** | DISALLOWED |
| **DB Name** | `uRadekPriznaniDph` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/ulozene-priznani-dph` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/ulozene-priznani-dph/properties` |

## Vlastnosti (9)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdRadekPriznaniDph | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `rok` | Rok | integer | Rok | ne | ANO | - | - | - | - | Rok |
| `mesic` | Měsíc | integer | Mesic | ne | ANO | - | - | - | - | Měsíc |
| `ctvrtleti` | Čtvrtletí | integer | Ctvrtleti | ne | ANO | - | - | - | - | Čtvrtletí |
| `datum` | Datum výpočtu | date | Datum | **ANO** | ANO | - | - | - | - | Datum výpočtu |
| `stavK` | Typ přiznání DPH | select | StavK | ne | ANO | 50 | - | - | - | Typ přiznání DPH |
| `uzivatel` | Uživatel | relation | IdUzivatel | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
| `stat` | Stát | relation | IdStat | ne | ANO | 3 | - | - | `stat` | Stát |
