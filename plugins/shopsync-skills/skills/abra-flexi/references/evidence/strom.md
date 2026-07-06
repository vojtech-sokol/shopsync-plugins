# Uzel stromu

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `strom` |
| **Evidence Type** | `STROM` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wUzel` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/strom` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/strom/properties` |

## Vlastnosti (19)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdUzel | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | ne | ANO | 30 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `strobr` | Obrázek | string | Strobr | ne | ANO | - | - | - | - | Obrázek |
| `hladina` | Hladina | integer | Hladina | ne | ne | - | - | - | - | Hladina |
| `poradi` | Pořadí | integer | Poradi | **ANO** | ANO | - | - | - | - | Pořadí |
| `cesta` | Cesta | string | Cesta | ne | ne | - | - | - | - | Cesta |
| `kratkyPopis` | Krátký popis | string | KratkyPopis | ne | ANO | - | - | - | - | Krátký popis |
| `klicSlova` | Klíčová slova | string | KlicSlova | ne | ANO | 255 | - | - | - | Klíčová slova |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `txtNad` | Text nad | string | TxtNad | ne | ANO | - | - | - | - | Text nad |
| `txtPod` | Text pod | string | TxtPod | ne | ANO | - | - | - | - | Text pod |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `strom` | Strom | relation | Idstrom | **ANO** | ANO | 20 | - | - | `strom-koren` | Strom |
| `otec` | Nadřazený uzel | relation | Idotec | ne | ANO | 20 | - | - | `strom` | Nadřazený uzel |
