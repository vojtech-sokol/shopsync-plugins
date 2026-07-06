# Šarže a expirace

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `sarze-expirace` |
| **Evidence Type** | `SARZE_EXPIRACE` |
| **Import Status** | DISALLOWED |
| **DB Name** | `dPolSkladFbezVC` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/sarze-expirace` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/sarze-expirace/properties` |

## Vlastnosti (12)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPolSklad | ne | ne | - | - | - | - | ID |
| `pocet` | Množství | numeric | Pocet | ne | ANO | - | 19 | 6 | - | Množství |
| `cenaMj` | Cena za MJ | numeric | CenaMj | ne | ANO | - | 19 | 6 | - | Cena za MJ |
| `datVyst` | Datum vyst. | date | DatVyst | ne | ANO | - | - | - | - | Vystaveno |
| `datSklad` | Datum skladového pohybu | date | DatSklad | ne | ANO | - | - | - | - | Datum skladového pohybu |
| `datTrvan` | Trvanlivost | date | DatTrvan | ne | ANO | - | - | - | - | Trvanlivost |
| `datVyroby` | Datum výroby | date | DatVyroby | ne | ANO | - | - | - | - | Datum výroby |
| `expirace` | Expirace | date | Expirace | ne | ANO | - | - | - | - | Expirace |
| `sarze` | Šarže | string | Sarze | ne | ANO | 100 | - | - | - | Šarže |
| `typPohybuK` | Typ pohybu | select | TypPohybuK | ne | ANO | 50 | - | - | - | Typ pohybu |
| `sklad` | Sklad | relation | IdSkladu | ne | ANO | - | - | - | `sklad` | Sklad |
| `cenik` | Ceník | relation | IdCenik | ne | ANO | 64 | - | - | `cenik` | Ceník |
