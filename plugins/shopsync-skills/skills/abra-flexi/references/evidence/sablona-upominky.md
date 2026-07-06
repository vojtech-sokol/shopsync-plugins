# Upomínky

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `sablona-upominky` |
| **Evidence Type** | `UPOMINKA_SABLONA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wSablona` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/sablona-upominky` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/sablona-upominky/properties` |

## Vlastnosti (31)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSablony | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `datum` | Datum | string | Datum | ne | ANO | 255 | - | - | - | Datum |
| `datuma` | Datum EN | string | Datuma | ne | ANO | 255 | - | - | - | Datum EN |
| `datumb` | Datum DE | string | Datumb | ne | ANO | 255 | - | - | - | Datum DE |
| `datumc` | Datum FR | string | Datumc | ne | ANO | 255 | - | - | - | Datum FR |
| `hlavicka` | Hlavička dopisu | string | Hlavicka | ne | ANO | - | - | - | - | Hlavička dopisu |
| `hlavickaa` | Hlavička dopisu EN | string | Hlavickaa | ne | ANO | - | - | - | - | Hlavička dopisu EN |
| `hlavickab` | Hlavička dopisu DE | string | Hlavickab | ne | ANO | - | - | - | - | Hlavička dopisu DE |
| `hlavickac` | Hlavička dopisu FR | string | Hlavickac | ne | ANO | - | - | - | - | Hlavička dopisu FR |
| `odberatel` | Odběratel | string | Odberatel | ne | ANO | 255 | - | - | - | Odběratel |
| `odberatela` | Odběratel EN | string | Odberatela | ne | ANO | 255 | - | - | - | Odběratel EN |
| `odberatelb` | Odběratel DE | string | Odberatelb | ne | ANO | 255 | - | - | - | Odběratel DE |
| `odberatelc` | Odběratel FR | string | Odberatelc | ne | ANO | 255 | - | - | - | Odběratel FR |
| `uvod` | Úvodní text | string | Uvod | ne | ANO | - | - | - | - | Úvodní text |
| `uvoda` | Úvodní text EN | string | Uvoda | ne | ANO | - | - | - | - | Úvodní text EN |
| `uvodb` | Úvodní text DE | string | Uvodb | ne | ANO | - | - | - | - | Úvodní text DE |
| `uvodc` | Úvodní text FR | string | Uvodc | ne | ANO | - | - | - | - | Úvodní text FR |
| `textNad` | Text nad fakturami | string | TextNad | ne | ANO | - | - | - | - | Text nad fakturami |
| `textNada` | Text nad fakturami EN | string | TextNada | ne | ANO | - | - | - | - | Text nad fakturami EN |
| `textNadb` | Text nad fakturami DE | string | TextNadb | ne | ANO | - | - | - | - | Text nad fakturami DE |
| `textNadc` | Text nad fakturami FR | string | TextNadc | ne | ANO | - | - | - | - | Text nad fakturami FR |
| `textPod` | Text pod fakturami | string | TextPod | ne | ANO | - | - | - | - | Text pod fakturami |
| `textPoda` | Text pod fakturami EN | string | TextPoda | ne | ANO | - | - | - | - | Text pod fakturami EN |
| `textPodb` | Text pod fakturami DE | string | TextPodb | ne | ANO | - | - | - | - | Text pod fakturami DE |
| `textPodc` | Text pod fakturami FR | string | TextPodc | ne | ANO | - | - | - | - | Text pod fakturami FR |
| `zapati` | Konec dopisu | string | Zapati | ne | ANO | - | - | - | - | Konec dopisu |
| `zapatia` | Konec dopisu EN | string | Zapatia | ne | ANO | - | - | - | - | Konec dopisu EN |
| `zapatib` | Konec dopisu DE | string | Zapatib | ne | ANO | - | - | - | - | Konec dopisu DE |
| `zapatic` | Konec dopisu FR | string | Zapatic | ne | ANO | - | - | - | - | Konec dopisu FR |
| `typSablonyK` | Typ šablony | select | TypSablonyK | **ANO** | ANO | 50 | - | - | - | Typ šablony |
