# Střediska

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `stredisko` |
| **Evidence Type** | `STREDISKO` |
| **Import Status** | SUPPORTED |
| **DB Name** | `uStrediska` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/stredisko` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/stredisko/properties` |

## Vlastnosti (27)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdStred | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `ulice` | Ulice | string | Ulice | ne | ANO | 255 | - | - | - | Ulice |
| `mesto` | Město | string | Mesto | ne | ANO | 255 | - | - | - | Město |
| `psc` | PSČ | string | Psc | ne | ANO | 255 | - | - | - | PSČ |
| `tel` | Telefon | string | Tel | ne | ANO | 255 | - | - | - | Telefon |
| `mobil` | Mobil | string | Mobil | ne | ANO | 255 | - | - | - | Mobil |
| `fax` | Fax | string | Fax | ne | ANO | 255 | - | - | - | Fax |
| `email` | E-mail | string | Email | ne | ANO | 255 | - | - | - | E-mail |
| `www` | WWW | string | Www | ne | ANO | 255 | - | - | - | WWW |
| `stat` | Stát | relation | IdStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `region` | Kraj | relation | Idregion | ne | ANO | - | - | - | `region` | Kraj |
| `tisknout` | Tisknout | logic | Tisknout | ne | ANO | - | - | - | - | Tisknout na doklady |
| `nazev2` | Název - druhá řádka | string | Nazev2 | ne | ANO | 255 | - | - | - | Název - druhá řádka |
| `nazev2A` | Název - druhá řádka EN | string | Nazev2A | ne | ANO | 255 | - | - | - | Název - druhá řádka EN |
| `nazev2B` | Název - druhá řádka DE | string | Nazev2B | ne | ANO | 255 | - | - | - | Název - druhá řádka DE |
| `nazev2C` | Název - druhá řádka FR | string | Nazev2C | ne | ANO | 255 | - | - | - | Název - druhá řádka FR |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
