# Seznam bankovních účtů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `bankovni-ucet` |
| **Evidence Type** | `BANKOVNI_UCET` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dBsp` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/bankovni-ucet` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/bankovni-ucet/properties` |

## Vlastnosti (55)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdBsp | ne | ne | - | - | - | - | ID |
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
| `modul` | Modul | string | Modul | ne | ANO | - | - | - | - | Modul |
| `buc` | Číslo bank. účtu | string | Buc | ne | ANO | 255 | - | - | - | Číslo účtu |
| `specSym` | Specifický symbol | string | SpecSym | ne | ANO | 255 | - | - | - | Specifický symbol |
| `iban` | IBAN | string | Iban | ne | ANO | 255 | - | - | - | IBAN |
| `bic` | BIC | string | Bic | ne | ANO | 255 | - | - | - | BIC |
| `nazBanky` | Název banky | string | NazBanky | ne | ANO | 255 | - | - | - | Název |
| `zkrKlienta` | Název klienta | string | ZkrKlienta | ne | ANO | 255 | - | - | - | Název klienta |
| `sloVypis` | výpisy | string | SloVypis | ne | ANO | 255 | - | - | - | výpisy |
| `sloPrikaz` | příkazy | string | SloPrikaz | ne | ANO | 255 | - | - | - | příkazy |
| `priVypis` | Přípona výpisu | string | PriVypis | ne | ANO | 20 | - | - | - | přípona |
| `priPrikaz` | Přípona příkazu | string | PriPrikaz | ne | ANO | 3 | - | - | - | přípona |
| `priPrikazZahr` | Příp. zahr. přík. | string | PriPrikazZahr | ne | ANO | 3 | - | - | - | příp.zahr. |
| `prikPopKlient` | Název protistrany v textu příkazu | logic | PrikPopKlient | ne | ANO | - | - | - | - | Název protistrany v textu příkazu |
| `prikPopPopis` | Popis dokladu v textu příkazu | logic | PrikPopPopis | ne | ANO | - | - | - | - | Popis dokladu v textu příkazu |
| `vypisDuplicitaK` | Kontrolovat duplicitu výpisů | select | VypisDuplicitaK | **ANO** | ANO | 50 | - | - | - | Kontrolovat duplicitu výpisů |
| `tokenPrikaz` | Token pro příkazy | string | TokenPrikaz | ne | ANO | 255 | - | - | - | Token pro příkazy |
| `tokenPrikazPlatiDo` | Token pro příkazy - platnost do | datetime | TokenPrikazPlatiDo | ne | ne | - | - | - | - | Token pro příkazy - platnost do |
| `tokenVypis` | Token pro výpisy | string | TokenVypis | ne | ANO | 255 | - | - | - | Token pro výpisy |
| `tokenVypisPlatiDo` | Token pro výpisy - platnost do | datetime | TokenVypisPlatiDo | ne | ne | - | - | - | - | Token pro výpisy - platnost do |
| `bucPrimarni` | Prim. ban. účet | logic | BucPrimarni | ne | ANO | - | - | - | - | Primární účet |
| `ulice` | Ulice | string | Ulice | ne | ANO | 255 | - | - | - | Ulice |
| `mesto` | Město | string | Mesto | ne | ANO | 255 | - | - | - | Město |
| `region` | Kraj | relation | Idregion | ne | ANO | - | - | - | `region` | Kraj |
| `psc` | PSČ | string | Psc | ne | ANO | 255 | - | - | - | PSČ |
| `tel` | Telefon | string | Tel | ne | ANO | 255 | - | - | - | Telefon |
| `mobil` | Mobil | string | Mobil | ne | ANO | 255 | - | - | - | Mobil |
| `fax` | Fax | string | Fax | ne | ANO | 255 | - | - | - | Fax |
| `email` | E-mail | string | Email | ne | ANO | 255 | - | - | - | E-mail |
| `www` | WWW | string | Www | ne | ANO | 255 | - | - | - | WWW |
| `vytvaretPreceneni` | Vytvářet přecenění | logic | VytvaretPreceneni | ne | ANO | - | - | - | - | Vytvářet přecenění při inicializaci účetního období |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `radaPrijem` | Řada pro příjem | relation | IdRadyPrijem | ne | ANO | - | - | - | `rada-banka` | Řada pro příjem |
| `radaVydej` | Řada pro výdej | relation | IdRadyVydej | ne | ANO | - | - | - | `rada-banka` | Řada pro výdej |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `smerKod` | Kód banky | relation | IdSmerKod | ne | ANO | 20 | - | - | `penezni-ustav` | Kód banky |
| `primUcet` | Účet banky | relation | IdPrimUcet | ne | ANO | 6 | - | - | `ucet` | Účet banky |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
| `elBanFormatVypis` | Formát el. bank. pro výpisy | relation | IdElBanFormat | ne | ANO | 3 | - | - | `format-elektronickeho-bankovnictvi` | Formát - výpisy |
| `elBanFormatPrikaz` | Formát el. bank. pro příkazy | relation | IdElBanFormatPrikaz | ne | ANO | 3 | - | - | `format-elektronickeho-prikazu` | Formát - příkazy |
| `stahovatVypisOd` | Stahovat výpisy od | date | StahovatVypisOd | ne | ANO | - | - | - | - | Stahovat výpisy od |
| `menaBanky` | Měna banky | relation | IdMenaBanky | ne | ANO | 20 | - | - | `mena` | Měna banky |
| `stat` | Stát | relation | IdStatu | ne | ANO | 3 | - | - | `stat` | Stát |
