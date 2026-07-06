# Typy zakázek

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-zakazky` |
| **Evidence Type** | `TYP_ZAKAZKY` |
| **Import Status** | SUPPORTED |
| **DB Name** | `uTypZakazky` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-zakazky` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-zakazky/properties` |

## Vlastnosti (15)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdTypZakazky | ne | ne | - | - | - | - | ID |
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
| `druhZakK` | Druh zakázky | select | DruhZakK | ne | ANO | 50 | - | - | - | Druh zakázky |
| `workFlow` | Zahájit workflow při založení dokladu | logic | WorkFlow | ne | ANO | - | - | - | - | Zahájit workflow při založení dokladu |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `zodpPrac` | Zodpovědný pracovník | relation | IdUzivatel | ne | ANO | 254 | - | - | `uzivatel` | Zodpovědný pracovník |
