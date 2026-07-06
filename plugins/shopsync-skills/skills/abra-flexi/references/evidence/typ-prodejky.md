# Seznam prodejních kas

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-prodejky` |
| **Evidence Type** | `PRODEJKA_TYP` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dTypDokl` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-prodejky` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-prodejky/properties` |

## Vlastnosti (65)

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
| `typDoklK` | Druh | select | TypDoklK | **ANO** | ANO | 50 | - | - | - | Druh |
| `slevaDokl` | Sleva [%] | numeric | SlevaDokl | ne | ANO | - | 6 | 2 | - | Sleva [%] |
| `zaokrJakSumK` | Způsob zaokrouhlení - Celkem | select | ZaokrJakSumK | ne | ANO | 50 | - | - | - | Celkem (způsob) |
| `zaokrNaSumK` | Řád zaokrouhlení - Celkem | select | ZaokrNaSumK | ne | ANO | 50 | - | - | - | Celkem (řády) |
| `zaokrJakDphK` | Způsob zaokrouhlení - DPH | select | ZaokrJakDphK | ne | ANO | 50 | - | - | - | DPH (způsob) |
| `zaokrNaDphK` | Řád zaokrouhlení - DPH | select | ZaokrNaDphK | ne | ANO | 50 | - | - | - | DPH (řády) |
| `metodaZaokrDoklK` | Metoda zaokrouhlení | select | MetodaZaokrDoklK | **ANO** | ANO | 50 | - | - | - | Metoda zaokrouhlení |
| `vytvaretKorPol` | Korekce DPH | logic | VytvaretKorPol | **ANO** | ANO | - | - | - | - | Korekce DPH |
| `zaokrouhlitPoOdpoctu` | Zaokrouhlit po odpočtu | logic | ZaokrouhlitPoOdpoctu | **ANO** | ANO | - | - | - | - | Zaokrouhlit po odpočtu |
| `splatDny` | Splatnost [dny] | integer | SplatDny | ne | ANO | - | - | - | - | Splatnost [dny] |
| `formaUhradyCis` | Forma úhrady | relation | IdFormaUhradyCis | ne | ANO | - | - | - | `forma-uhrady` | Forma úhrady |
| `doprava` | Doprava a vyskladnění | string | Doprava | ne | ANO | - | - | - | - | Doprava a vyskladnění |
| `popisDoklad` | Popis pro doklad | string | PopisDoklad | ne | ANO | - | - | - | - | Popis pro doklad |
| `uvodTxt` | Úvodní text (tiskne se před položkami) | string | UvodTxt | ne | ANO | - | - | - | - | Úvodní text (tiskne se před položkami) |
| `zavTxt` | Závěrečný text (tiskne se za položkami) | string | ZavTxt | ne | ANO | - | - | - | - | Závěrečný text (tiskne se za položkami) |
| `radaPrijem` | Dokladová řada | relation | IdRadyPrijem | ne | ANO | - | - | - | `rada-faktury-vydane` | Dokladová řada |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
| `bspBan` | Bankovní účet | relation | IdBspBan | ne | ANO | - | - | - | `bankovni-ucet` | Bankovní účet |
| `typProtiDokladuPrijem` | Typ příjemky | relation | IdTypProtiDokladuPrijem | ne | ANO | - | - | - | `typ-skladovy-pohyb` | Typ příjemky |
| `typProtiDokladuVydej` | Typ výdejky | relation | IdTypProtiDokladuVydej | ne | ANO | - | - | - | `typ-skladovy-pohyb` | Typ výdejky |
| `konSym` | Konstantní symbol | relation | IdKonSym | ne | ANO | 20 | - | - | `konst-symbol` | Konstantní symbol |
| `primUcet` | Účet MD odběratele | relation | IdPrimUcet | ne | ANO | 6 | - | - | `ucet` | Účet MD |
| `typUcOpPrijem` | Předpis zaúčtování [DAL] | relation | IdTypUcOpP | ne | ANO | - | - | - | `predpis-zauctovani` | Předpis zaúčtování [DAL] |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
| `statDph` | Stát DPH | relation | IdStatDph | ne | ANO | 3 | - | - | `stat-dph` | Stát DPH |
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
| `generovatSkl` | Generovat sklad | logic | GenerovatSkl | **ANO** | ANO | - | - | - | - | Automaticky generovat skladové doklady a vyžadovat zadání výrobních čísel. |
| `razeniProTiskK` | Řazení položek pro tisk | select | RazeniProTiskK | ne | ANO | 50 | - | - | - | Řazení položek pro tisk |
| `primarni` | Primární typ dokladu | logic | Primarni | **ANO** | ANO | - | - | - | - | Primární typ dokladu |
| `prodejka` | Prodejka | logic | Prodejka | ne | ne | - | - | - | - | Prodejka |
| `typDoklPok` | Typ pokladního dokladu | relation | IdTypDoklPok | ne | ne | - | - | - | `typ-faktury-vydane` | Typ pokladního dokladu |
| `bspSkl` | Sklad | relation | IdBspSkl | ne | ANO | - | - | - | `sklad` | Sklad |
| `formaDopravy` | Forma dopravy | relation | IdFormaDopravy | ne | ANO | - | - | - | `forma-dopravy` | Forma dopravy |
| `emailTxt` | Text pro odesílání dokladu e-mailem | string | EmailTxt | ne | ANO | - | - | - | - | Text pro odesílání dokladu e-mailem |
| `umoznitRefun` | Umožnit refundaci zboží | logic | UmoznitRefun | **ANO** | ANO | - | - | - | - | Umožnit refundaci zboží |
| `ekokomK` | Výkaz EkoKom | select | EkokomK | ne | ANO | - | - | - | - | Výkaz EkoKom |
| `cashRegister` | Použít registrační pokladnu | logic | CashRegister | ne | ANO | - | - | - | - | Použít registrační pokladnu |
| `clenKonVykDph` | Řádek kontrolního hlášení DPH | relation | IdClenKonVykDph | ne | ANO | - | - | - | `cleneni-kontrolni-hlaseni` | Řádek kontrolního hlášení DPH |
| `sablonaMail` | Šablona e-mail | relation | IdSablonaMail | ne | ANO | - | - | - | `sablona-mail` | Šablona e-mail |
| `generovatRecyklacniPoplatky` | Vytvářet recyklační poplatky | logic | GenerovatRecyklacniPoplatky | **ANO** | ANO | - | - | - | - | Vytvářet recyklační poplatky |
