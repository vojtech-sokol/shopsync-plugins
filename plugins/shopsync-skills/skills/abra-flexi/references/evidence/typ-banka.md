# Typy bankovních dokladů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-banka` |
| **Evidence Type** | `BANKA_TYP` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dTypDokl` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-banka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-banka/properties` |

## Vlastnosti (35)

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
| `ucetni` | Je účetní | logic | Ucetni | ne | ANO | - | - | - | - | Doklad je účetní |
| `typPohybuK` | Typ pohybu | select | TypPohybuK | ne | ANO | 50 | - | - | - | Typ pohybu |
| `typDoklK` | Druh | select | TypDoklK | ne | ANO | 50 | - | - | - | Druh |
| `splatDny` | Splatnost [dny] | integer | SplatDny | ne | ANO | - | - | - | - | Splatnost [dny] |
| `popisDoklad` | Popis pro doklad | string | PopisDoklad | ne | ANO | - | - | - | - | Popis pro doklad |
| `radaPrijem` | Řada pro příjem | relation | IdRadyPrijem | ne | ANO | - | - | - | `rada-banka` | Řada pro příjem |
| `radaVydej` | Řada pro výdej | relation | IdRadyVydej | ne | ANO | - | - | - | `rada-banka` | Řada pro výdej |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
| `bsp` | Bank.účet | relation | IdBsp | ne | ANO | - | - | - | `bankovni-ucet` | Bank.účet |
| `typUcOpPrijem` | Předpis zaúčtování - příjem [DAL] | relation | IdTypUcOpP | ne | ANO | - | - | - | `predpis-zauctovani` | pro příjem [DAL] |
| `typUcOpVydej` | Předpis zaúčtování - výdej [MD] | relation | IdTypUcOpV | ne | ANO | - | - | - | `predpis-zauctovani` | pro výdej [MD] |
| `statDph` | Stát DPH | relation | IdStatDph | ne | ANO | 3 | - | - | `stat-dph` | Stát DPH |
| `tiskAutomat` | Aut. tisk | logic | TiskAutomat | **ANO** | ANO | - | - | - | - | Automaticky tisknout při vytvoření nového dokladu |
| `workFlow` | Zahájit workflow při založení dokladu | logic | WorkFlow | ne | ANO | - | - | - | - | Zahájit workflow při založení dokladu |
| `razeniProTiskK` | Řazení položek pro tisk | select | RazeniProTiskK | ne | ANO | 50 | - | - | - | Řazení položek pro tisk |
| `primarni` | Primární typ dokladu | logic | Primarni | **ANO** | ANO | - | - | - | - | Primární typ dokladu |
| `zapocet` | Zápočet | logic | Zapocet | ne | ANO | - | - | - | - | Zápočet |
| `emailTxt` | Text pro odesílání dokladu e-mailem | string | EmailTxt | ne | ANO | - | - | - | - | Text pro odesílání dokladu e-mailem |
| `clenKonVykDph` | Řádek kontrolního hlášení DPH | relation | IdClenKonVykDph | ne | ANO | - | - | - | `cleneni-kontrolni-hlaseni` | Řádek kontrolního hlášení DPH |
| `sablonaMail` | Šablona e-mail | relation | IdSablonaMail | ne | ANO | - | - | - | `sablona-mail` | Šablona e-mail |
