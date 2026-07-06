# Skupiny zboží a materiálu

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `skupina-zbozi` |
| **Evidence Type** | `SKUPINA_ZBOZI` |
| **Import Status** | SUPPORTED |
| **DB Name** | `cSkupZboz` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/skupina-zbozi` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/skupina-zbozi/properties` |

## Vlastnosti (39)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSkupZboz | ne | ne | - | - | - | - | ID |
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
| `typCenyDphK` | Typ ceny | select | TypCenyDphK | ne | ANO | 50 | - | - | - | Typ ceny |
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
| `zaokrJakK` | Způsob zaokrouhlení - Cena | select | ZaokrJakK | ne | ANO | 50 | - | - | - | Způsob |
| `zaokrNaK` | Řád zaokrouhlení - Cena | select | ZaokrNaK | ne | ANO | 50 | - | - | - | Řád |
| `hlidatMinMarzi` | Hlídat min. cen. rozdíl | logic | HlidatMinMarzi | ne | ANO | - | - | - | - | Hlídat minimální cenový rozdíl |
| `minMarze` | Minimální cenový rozdíl | numeric | MinMarze | ne | ANO | - | 6 | 2 | - | Minimální cenový rozdíl [%] |
| `typVypoctuHlidatMinK` | Typ min. cen. rozdílu | select | TypVypoctuHlidatMinK | **ANO** | ANO | 50 | - | - | - | Typ hlídaného minimálního cenového rozdílu |
| `workFlow` | Zahájit workflow při založení dokladu | logic | WorkFlow | ne | ANO | - | - | - | - | Zahájit workflow při založení dokladu |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `ucetProtiPfa` | účet přijaté faktury | relation | IdProtiUcetPfa | ne | ANO | 6 | - | - | `ucet` | pro přijaté faktury / pokladna - výdej |
| `ucetProtiVfa` | účet vydané f. | relation | IdProtiUcetVfa | ne | ANO | 6 | - | - | `ucet` | pro vydané faktury / pokladna - příjem |
| `ucetProtiSklp` | účet skl. - P | relation | IdProtiUcetSklP | ne | ANO | 6 | - | - | `ucet` | pro příjem na sklad |
| `ucetProtiSklv` | účet skl. - V k faktuře | relation | IdProtiUcetSklV | ne | ANO | 6 | - | - | `ucet` | pro výdejku k faktuře |
| `ucetProtiSklHolyv` | účet skl. - holý V | relation | IdProtiUcetSklHolyV | ne | ANO | 6 | - | - | `ucet` | pro holou výdejku |
| `ucetProtiSklPrevv` | účet skl. - převodka V | relation | IdProtiUcetSklPrevV | ne | ANO | 6 | - | - | `ucet` | pro převodku výdej |
| `typOrganizace` | Typ organizace | relation | IdTypOrg | **ANO** | ANO | 20 | - | - | `typ-organizace` | Typ organizace |
