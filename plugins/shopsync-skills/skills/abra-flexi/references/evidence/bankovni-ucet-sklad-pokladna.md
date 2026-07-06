# Banky/pokladny/sklady

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `bankovni-ucet-sklad-pokladna` |
| **Evidence Type** | `BANKOVNI_UCET_SKLAD_POKLADNA` |
| **Import Status** | DISALLOWED |
| **DB Name** | `dBsp` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/bankovni-ucet-sklad-pokladna` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/bankovni-ucet-sklad-pokladna/properties` |

## Vlastnosti (17)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdBsp | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `ucetObdobiOd` | Platí od | relation | IdUcetObdobiOd | ne | ANO | - | - | - | `ucetni-obdobi` | Platí od |
| `ucetObdobiDo` | Platí do | relation | IdUcetObdobiDo | ne | ANO | - | - | - | `ucetni-obdobi` | Platí do |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od roku |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do roku |
| `modul` | Modul | string | Modul | ne | ANO | - | - | - | - | Modul |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
