# Typy nákladů na události / aktivity

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-nakladu` |
| **Evidence Type** | `TYP_NAKLADU` |
| **Import Status** | SUPPORTED |
| **DB Name** | `aTypNaklAkt` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-nakladu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-nakladu/properties` |

## Vlastnosti (12)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdTypNaklAkt | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `visible` | Zobrazovat | logic | Show | ne | ANO | - | - | - | - | Zobrazovat |
| `fakturovat` | Fakturovat | logic | Fakturovat | ne | ANO | - | - | - | - | Fakturovat |
| `cenik` | Ceník | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Ceník |
