# Stavy položek ceníku

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `stav-ceniku` |
| **Evidence Type** | `STAV_CENIKU` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `cStavCen` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/stav-ceniku` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/stav-ceniku/properties` |

## Vlastnosti (14)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdStavCen | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `visible` | Zobrazovat | logic | Show | ne | ANO | - | - | - | - | Zobrazovat |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `neprodejne` | Neprodejné | logic | Neprodejne | ne | ANO | - | - | - | - | Neprodejné |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
