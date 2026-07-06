# Rezervace

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `rezervace` |
| **Evidence Type** | `REZERVACE` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `sRezervace` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/rezervace` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/rezervace/properties` |

## Vlastnosti (12)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdRezervace | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `datumOd` | Datum vzniku | datetime | DatumOd | **ANO** | ANO | - | - | - | - | Datum vzniku |
| `datumDo` | Datum zániku | date | DatumDo | ne | ANO | - | - | - | - | Datum zániku |
| `mnozstvi` | Množství | numeric | Mnozstvi | **ANO** | ANO | - | 19 | 6 | - | Množství |
| `skladMj` | Na skladě | numeric | SkladMj | ne | ne | - | 19 | 6 | - | Na skladě |
| `poznamka` | Poznámka | string | Poznamka | ne | ANO | - | - | - | - | Poznámka |
| `firma` | Firma | relation | IdFirmy | **ANO** | ANO | 20 | - | - | `adresar` | Firma |
| `cenik` | Ceník | relation | IdCenik | **ANO** | ANO | - | - | - | `cenik` | Ceník |
| `sklad` | Sklad | relation | IdSklad | **ANO** | ANO | - | - | - | `sklad` | Sklad |
| `polObch` | Obchodní položka | relation | IdPolObch | ne | ne | - | - | - | - | Obchodní položka |
| `uzivatel` | Uživatel | relation | IdUziv | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
