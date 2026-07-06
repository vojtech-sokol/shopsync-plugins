# Seznam skladů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `sklad` |
| **Evidence Type** | `SKLAD` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dBsp` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/sklad` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/sklad/properties` |

## Vlastnosti (22)

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
| `automatickySklad` | Automatický sklad | logic | AutomatickySklad | ne | ANO | - | - | - | - | Nové zboží automaticky přidat na tento sklad |
| `eanKod` | EAN | string | EanKod | ne | ANO | 20 | - | - | - | EAN |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `radaPrijem` | Řada pro příjem | relation | IdRadyPrijem | ne | ANO | - | - | - | `rada-skladovy-pohyb` | Řada pro příjem |
| `radaVydej` | Řada pro výdej | relation | IdRadyVydej | ne | ANO | - | - | - | `rada-skladovy-pohyb` | Řada pro výdej |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `primUcet` | Účet skladu | relation | IdPrimUcet | ne | ANO | 6 | - | - | `ucet` | Účet skladu |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
