# Zápůjčky

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `zapujcka` |
| **Evidence Type** | `ZAPUJCKA` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `mZapujcky` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/zapujcka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/zapujcka/properties` |

## Vlastnosti (22)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdZapujcky | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `jmeno` | Jméno | string | Jmeno | ne | ANO | 255 | - | - | - | Jméno |
| `prijmeni` | Příjmení | string | Prijmeni | ne | ANO | 255 | - | - | - | Příjmení |
| `ulice` | Ulice | string | Ulice | ne | ANO | 255 | - | - | - | Ulice |
| `mesto` | Město | string | Mesto | ne | ANO | 255 | - | - | - | Město |
| `psc` | PSČ | string | Psc | ne | ANO | 255 | - | - | - | PSČ |
| `www` | WWW | string | Www | ne | ANO | 255 | - | - | - | WWW |
| `email` | E-mail | string | Email | ne | ANO | 255 | - | - | - | E-mail |
| `fax` | Fax | string | Fax | ne | ANO | 255 | - | - | - | Fax |
| `mobil` | Mobil | string | Mobil | ne | ANO | 255 | - | - | - | Mobil |
| `tel` | Telefon | string | Tel | ne | ANO | 255 | - | - | - | Telefon |
| `datZahaj` | Od data | date | DatZahaj | ne | ANO | - | - | - | - | Od data |
| `datKonec` | Do data | date | DatKonec | ne | ANO | - | - | - | - | Do data |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `majetek` | Majetek | relation | IdMajetku | ne | ANO | 20 | - | - | `majetek` | Majetek |
| `leasing` | Leasing | relation | IdLeasing | ne | ANO | 20 | - | - | `leasing` | Leasing |
| `osoba` | Osoba | relation | IdOsoby | ne | ANO | 254 | - | - | `uzivatel` | Osoba |
| `stat` | Stát | relation | IdStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
