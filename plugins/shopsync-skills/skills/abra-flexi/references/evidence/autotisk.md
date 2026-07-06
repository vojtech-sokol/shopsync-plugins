# Automatický tisk

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `autotisk` |
| **Evidence Type** | `AUTOTISK` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dAutoTisk` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/autotisk` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/autotisk/properties` |

## Vlastnosti (8)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdAutoTisk | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `pocet` | Kopií | integer | Pocet | ne | ANO | - | - | - | - | Kopií |
| `typTiskDoklK` | Tisknout doklad | select | TypTiskDoklK | **ANO** | ANO | 50 | - | - | - | Tisknout doklad |
| `report` | Report | string | Report | **ANO** | ANO | - | - | - | - | Report |
| `sumovany` | Sumovaný | logic | Sumovany | ne | ANO | - | - | - | - | Sumovaný |
| `rozsireny` | Rozšířený | logic | Rozsireny | ne | ANO | - | - | - | - | Rozšířený |
| `typDokl` | Typ dokladu | relation | IdTypDokl | **ANO** | ANO | - | - | - | `typ-dokladu` | Typ dokladu |
