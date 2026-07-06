# Typy ostatních pohledávek

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-pohledavky` |
| **Evidence Type** | `POHLEDAVKA_TYP` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dTypDokl` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-pohledavky` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-pohledavky/properties` |

## Vlastnosti (46)

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
| `formaUhradyCis` | Forma úhrady | relation | IdFormaUhradyCis | ne | ANO | - | - | - | `forma-uhrady` | Forma úhrady |
| `doprava` | Doprava a vyskladnění | string | Doprava | ne | ANO | - | - | - | - | Doprava a vyskladnění |
| `popisDoklad` | Popis pro doklad | string | PopisDoklad | ne | ANO | - | - | - | - | Popis pro doklad |
| `radaPrijem` | Dokladová řada | relation | IdRadyPrijem | ne | ANO | - | - | - | `rada-pohledavky` | Dokladová řada |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
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
| `razeniProTiskK` | Řazení položek pro tisk | select | RazeniProTiskK | ne | ANO | 50 | - | - | - | Řazení položek pro tisk |
| `primarni` | Primární typ dokladu | logic | Primarni | **ANO** | ANO | - | - | - | - | Primární typ dokladu |
| `uhrAuto` | Automaticky hradit | logic | UhrAuto | ne | ANO | - | - | - | - | Automaticky hradit nezaúčtovanými přeplatky v bance a pokladně |
| `zapAuto` | Automatický zápočet | logic | ZapAuto | ne | ANO | - | - | - | - | Použít na automatizovaný vzájemný zápočet |
| `formaDopravy` | Forma dopravy | relation | IdFormaDopravy | ne | ANO | - | - | - | `forma-dopravy` | Forma dopravy |
| `emailTxt` | Text pro odesílání dokladu e-mailem | string | EmailTxt | ne | ANO | - | - | - | - | Text pro odesílání dokladu e-mailem |
| `vsCisObj` | VS z čís.obj. | logic | VsCisObj | ne | ANO | - | - | - | - | Variabilní symbol primárně z čísla objednávky |
| `clenKonVykDph` | Řádek kontrolního hlášení DPH | relation | IdClenKonVykDph | ne | ANO | - | - | - | `cleneni-kontrolni-hlaseni` | Řádek kontrolního hlášení DPH |
| `sablonaMail` | Šablona e-mail | relation | IdSablonaMail | ne | ANO | - | - | - | `sablona-mail` | Šablona e-mail |
| `statDphTd` | Preferovat na dokladech | logic | StatDphTd | **ANO** | ANO | - | - | - | - | Preferovat na dokladech |
