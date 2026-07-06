# Cenové úrovně

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `cenova-uroven` |
| **Evidence Type** | `CENOVA_UROVEN` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `cCenHlad` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/cenova-uroven` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/cenova-uroven/properties` |

## Vlastnosti (34)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdCenHlad | ne | ne | - | - | - | - | ID |
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
| `docasnost` | Dočasnost | logic | Docasnost | ne | ANO | - | - | - | - | cenová úroveň je dočasná |
| `platiOdData` | Platnost od data | date | PlatiOdData | ne | ANO | - | - | - | - | Platnost od data |
| `platiDoData` | Platnost do data | date | PlatiDoData | ne | ANO | - | - | - | - | Platnost do data |
| `typCenyVychoziK` | Výchozí cena | select | TypCenyVychoziK | ne | ANO | 50 | - | - | - | Výchozí cena |
| `typVypCenyK` | Způsob výpočtu | select | TypVypCenyK | ne | ANO | 50 | - | - | - | Způsob výpočtu |
| `procZakl` | Marže / Přirážka / Rabat / Sleva [%] | numeric | ProcZakl | ne | ANO | - | 6 | 2 | - | Marže / Přirážka / Rabat / Sleva [%] |
| `typCenyVychozi25K` | Výchozí cena pro množ. slevy | select | TypCenyVychozi25K | ne | ANO | 50 | - | - | - | Výchozí cena |
| `typVypCeny25K` | Způsob výpočtu pro množ. slevy | select | TypVypCeny25K | ne | ANO | 50 | - | - | - | Způsob výpočtu |
| `limMnoz2` | Limit MJ 2 | numeric | LimMnoz2 | ne | ANO | - | 19 | 6 | - | Množ. limit 2 |
| `limMnoz3` | Limit MJ 3 | numeric | LimMnoz3 | ne | ANO | - | 19 | 6 | - | Množ. limit 3 |
| `limMnoz4` | Limit MJ 4 | numeric | LimMnoz4 | ne | ANO | - | 19 | 6 | - | Množ. limit 4 |
| `limMnoz5` | Limit MJ 5 | numeric | LimMnoz5 | ne | ANO | - | 19 | 6 | - | Množ. limit 5 |
| `procento2` | %2 | numeric | Procento2 | ne | ANO | - | 6 | 2 | - | % 2 |
| `procento3` | %3 | numeric | Procento3 | ne | ANO | - | 6 | 2 | - | %3 |
| `procento4` | %4 | numeric | Procento4 | ne | ANO | - | 6 | 2 | - | %4 |
| `procento5` | %5 | numeric | Procento5 | ne | ANO | - | 6 | 2 | - | %5 |
| `rucneVybrat` | Ručně vybrat | logic | RucneVybrat | ne | ANO | - | - | - | - | Ručně vybrat |
| `zaokrJakK` | Způsob zaokrouhlení - Cena | select | ZaokrJakK | ne | ANO | 50 | - | - | - | Způsob |
| `zaokrNaK` | Řád zaokrouhlení - Cena | select | ZaokrNaK | ne | ANO | 50 | - | - | - | Řád |
| `vsechnySkupZboz` | Pro všechny skupiny zboží | logic | VsechnySkupZboz | ne | ANO | - | - | - | - | Pro všechny skupiny zboží |
| `vsechnyFirmy` | Platí pro všechny firmy | logic | VsechnyFirmy | ne | ANO | - | - | - | - | Platí pro všechny firmy |
| `zakazSlevaDokl` | Neaplikovat slevu z dokladu | logic | ZakazSlevaDokl | ne | ANO | - | - | - | - | Neaplikovat slevu z dokladu |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
