# Měrné jednotky 

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `merna-jednotka` |
| **Evidence Type** | `MERNA_JEDNOTKA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `cMerJed` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/merna-jednotka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/merna-jednotka/properties` |

## Vlastnosti (17)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdMj | ne | ne | - | - | - | - | ID |
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
| `typMjK` | Typ | select | TypMjK | ne | ANO | 50 | - | - | - | Typ |
| `normalMjK` | Normal. jednotka | select | NormalMjK | ne | ANO | 50 | - | - | - | Normal. jednotka |
| `kodTisk` | Zkratka pro tisky | string | KodTisk | ne | ANO | 20 | - | - | - | Zkratka pro tisky |
| `kodTiskA` | Zkratka pro tisky EN | string | KodTiskA | ne | ANO | 20 | - | - | - | Zkratka pro tisky EN |
| `kodTiskB` | Zkratka pro tisky DE | string | KodTiskB | ne | ANO | 20 | - | - | - | Zkratka pro tisky DE |
| `kodTiskC` | Zkratka pro tisky FR | string | KodTiskC | ne | ANO | 20 | - | - | - | Zkratka pro tisky FR |
