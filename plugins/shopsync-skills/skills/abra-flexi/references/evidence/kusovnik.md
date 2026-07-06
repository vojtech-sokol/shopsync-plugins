# Kusovník

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `kusovnik` |
| **Evidence Type** | `KUSOVNIK` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `cKusovnik` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/kusovnik` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/kusovnik/properties` |

## Vlastnosti (13)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdKusovnik | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `nazev` | Název | string | Nazev | ne | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `mnoz` | Množství | numeric | Mnoz | **ANO** | ANO | - | 19 | 6 | - | Množství |
| `hladina` | Hladina | integer | Hladina | **ANO** | ANO | - | - | - | - | Hladina |
| `poradi` | Pořadí | integer | Poradi | **ANO** | ANO | - | - | - | - | Pořadí |
| `cesta` | Cesta | string | Cesta | **ANO** | ANO | - | - | - | - | Cesta |
| `otecCenik` | Nadřazený ceník | relation | IdOtecCenik | **ANO** | ANO | 64 | - | - | `cenik` | Nadřazený ceník |
| `cenik` | Ceník | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Ceník |
| `otec` | Nadřazený kusovník | relation | Idotec | ne | ANO | 20 | - | - | `kusovnik` | Nadřazený kusovník |
