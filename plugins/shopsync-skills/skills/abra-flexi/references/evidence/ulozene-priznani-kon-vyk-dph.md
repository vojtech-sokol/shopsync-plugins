# Uložené přiznání Kontrolního hlášení DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `ulozene-priznani-kon-vyk-dph` |
| **Evidence Type** | `ULOZENE_PRIZNANI_KON_VYK_DPH` |
| **Import Status** | DISALLOWED |
| **DB Name** | `uPriznaniKonVykDph` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/ulozene-priznani-kon-vyk-dph` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/ulozene-priznani-kon-vyk-dph/properties` |

## Vlastnosti (10)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPriznaniKonVykDph | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `rok` | Rok | integer | Rok | ne | ANO | - | - | - | - | Rok |
| `mesic` | Měsíc | integer | Mesic | ne | ANO | - | - | - | - | Měsíc |
| `ctvrtleti` | Čtvrtletí | integer | Ctvrtleti | ne | ANO | - | - | - | - | Čtvrtletí |
| `datum` | Datum výpočtu | date | Datum | **ANO** | ANO | - | - | - | - | Datum výpočtu |
| `stavK` | Typ kontrolního hlášení | select | StavK | ne | ANO | 50 | - | - | - | Typ kontrolního hlášení |
| `xml` | XML | string | Xml | **ANO** | ANO | - | - | - | - | XML |
| `uzivatel` | Uživatel | relation | IdUzivatel | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
| `stat` | Stát | relation | IdStat | ne | ANO | 3 | - | - | `stat` | Stát |
