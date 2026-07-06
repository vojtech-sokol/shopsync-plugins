# Typy interních dokladů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-interniho-dokladu` |
| **Evidence Type** | `INTERNI_DOKLAD_TYP` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dTypDokl` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-interniho-dokladu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-interniho-dokladu/properties` |

## Vlastnosti (31)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdTypDokl | ne | ne | - | - | - | - | ID |
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
| `modul` | Modul | string | Modul | ne | ne | - | - | - | - | Modul |
| `ucetni` | Je účetní | logic | Ucetni | ne | ne | - | - | - | - | Doklad je účetní |
| `typDoklK` | Druh | select | TypDoklK | **ANO** | ANO | 50 | - | - | - | Druh |
| `popisDoklad` | Popis pro doklad | string | PopisDoklad | ne | ANO | - | - | - | - | Popis pro doklad |
| `radaPrijem` | Dokladová řada | relation | IdRadyPrijem | ne | ANO | - | - | - | `rada-interniho-dokladu` | Dokladová řada |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
| `primUcet` | Účet základu MD | relation | IdPrimUcet | ne | ANO | 6 | - | - | `ucet` | základu Má Dáti |
| `typUcOpPrijem` | Předpis zaúčtování | relation | IdTypUcOpP | ne | ANO | - | - | - | `predpis-zauctovani` | Předpis zaúčtování |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
| `statDph` | Stát DPH | relation | IdStatDph | ne | ANO | 3 | - | - | `stat-dph` | Stát DPH |
| `tiskAutomat` | Aut. tisk | logic | TiskAutomat | **ANO** | ANO | - | - | - | - | Automaticky tisknout při vytvoření nového dokladu |
| `workFlow` | Zahájit workflow při založení dokladu | logic | WorkFlow | ne | ANO | - | - | - | - | Zahájit workflow při založení dokladu |
| `razeniProTiskK` | Řazení položek pro tisk | select | RazeniProTiskK | ne | ANO | 50 | - | - | - | Řazení položek pro tisk |
| `primarni` | Primární typ dokladu | logic | Primarni | **ANO** | ANO | - | - | - | - | Primární typ dokladu |
| `emailTxt` | Text pro odesílání dokladu e-mailem | string | EmailTxt | ne | ANO | - | - | - | - | Text pro odesílání dokladu e-mailem |
| `clenKonVykDph` | Řádek kontrolního hlášení DPH | relation | IdClenKonVykDph | ne | ANO | - | - | - | `cleneni-kontrolni-hlaseni` | Řádek kontrolního hlášení DPH |
| `sablonaMail` | Šablona e-mail | relation | IdSablonaMail | ne | ANO | - | - | - | `sablona-mail` | Šablona e-mail |
