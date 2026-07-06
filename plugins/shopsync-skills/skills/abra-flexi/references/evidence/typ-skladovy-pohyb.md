# Typy skladových dokladů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-skladovy-pohyb` |
| **Evidence Type** | `SKLADOVY_POHYB_TYP` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dTypDokl` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-skladovy-pohyb` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-skladovy-pohyb/properties` |

## Vlastnosti (47)

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
| `typPohybuSkladK` | Typ pohybu + upřesnění | select | TypPohybuSkladK | ne | ANO | 50 | - | - | - | Typ pohybu + upřesnění |
| `doprava` | Doprava a vyskladnění | string | Doprava | ne | ANO | - | - | - | - | Doprava a vyskladnění |
| `popisDoklad` | Popis pro doklad | string | PopisDoklad | ne | ANO | - | - | - | - | Popis pro doklad |
| `uvodTxt` | Úvodní text (tiskne se před položkami) | string | UvodTxt | ne | ANO | - | - | - | - | Úvodní text (tiskne se před položkami) |
| `zavTxt` | Závěrečný text (tiskne se za položkami) | string | ZavTxt | ne | ANO | - | - | - | - | Závěrečný text (tiskne se za položkami) |
| `radaPrijem` | Řada pro příjem | relation | IdRadyPrijem | ne | ANO | - | - | - | `rada-skladovy-pohyb` | Řada pro příjem |
| `radaVydej` | Řada pro výdej | relation | IdRadyVydej | ne | ANO | - | - | - | `rada-skladovy-pohyb` | Řada pro výdej |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
| `bsp` | Sklad | relation | IdBsp | ne | ANO | - | - | - | `sklad` | Sklad |
| `typProtiDokladuPrijem` | Typ dokladu převodky | relation | IdTypProtiDokladuPrijem | ne | ANO | - | - | - | `typ-skladovy-pohyb` | Typ dokladu převodky |
| `typProtiDokladuVydej` | Typ dokladu výroby | relation | IdTypProtiDokladuVydej | ne | ANO | - | - | - | `typ-skladovy-pohyb` | Typ dokladu výroby |
| `typUcOpPrijem` | Předpis zaúčtování - příjem [DAL] | relation | IdTypUcOpP | ne | ANO | - | - | - | `predpis-zauctovani` | pro příjem [DAL] |
| `typUcOpVydej` | Předpis zaúčtování - výdej [MD] | relation | IdTypUcOpV | ne | ANO | - | - | - | `predpis-zauctovani` | pro výdej [MD] |
| `tiskAutomat` | Aut. tisk | logic | TiskAutomat | **ANO** | ANO | - | - | - | - | Automaticky tisknout při vytvoření nového dokladu |
| `workFlow` | Zahájit workflow při založení dokladu | logic | WorkFlow | ne | ANO | - | - | - | - | Zahájit workflow při založení dokladu |
| `statOdesl` | Stát odesl. | relation | IdStatOdesl | ne | ANO | 3 | - | - | `stat` | Stát odesl. |
| `statUrc` | Stát určení | relation | IdStatUrc | ne | ANO | 3 | - | - | `stat` | Stát určení |
| `statPuvod` | Stát původu | relation | IdStatPuvod | ne | ANO | 3 | - | - | `stat` | Stát původu |
| `dodPodm` | Podmínky dodání | relation | IdDodPodm | ne | ANO | - | - | - | `intrastat-dodaci-podminky` | Podmínky dodání |
| `zvlPoh` | Zvláštní pohyby | relation | IdZvlPoh | ne | ANO | - | - | - | `intrastat-zvlastni-pohyb` | Zvláštní pohyby |
| `obchTrans` | Transakce | relation | IdObchTrans | ne | ANO | - | - | - | `intrastat-obchodni-transakce` | Transakce |
| `druhDopr` | Druh dopravy | relation | IdDruhDopr | ne | ANO | - | - | - | `intrastat-druh-dopravy` | Druh dopravy |
| `krajUrc` | Kraj odesílatele | relation | IdKrajUrc | ne | ANO | - | - | - | `intrastat-kraj-urceni` | Kraj odesílatele |
| `razeniProTiskK` | Řazení položek pro tisk | select | RazeniProTiskK | ne | ANO | 50 | - | - | - | Řazení položek pro tisk |
| `primarni` | Primární typ dokladu | logic | Primarni | **ANO** | ANO | - | - | - | - | Primární typ dokladu |
| `formaDopravy` | Forma dopravy | relation | IdFormaDopravy | ne | ANO | - | - | - | `forma-dopravy` | Forma dopravy |
| `emailTxt` | Text pro odesílání dokladu e-mailem | string | EmailTxt | ne | ANO | - | - | - | - | Text pro odesílání dokladu e-mailem |
| `eanAkceNahrat` | Vytváření dokladu EAN čtečkou | logic | EanAkceNahrat | **ANO** | ANO | - | - | - | - | Vytváření dokladu EAN čtečkou |
| `eanAkcePopis` | Popis pro čtečku | string | EanAkcePopis | ne | ANO | - | - | - | - | Popis pro čtečku |
| `sablonaMail` | Šablona e-mail | relation | IdSablonaMail | ne | ANO | - | - | - | `sablona-mail` | Šablona e-mail |
