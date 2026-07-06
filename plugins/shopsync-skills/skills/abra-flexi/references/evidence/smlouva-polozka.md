# Položky smluv

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `smlouva-polozka` |
| **Evidence Type** | `SMLOUVA_POLOZKA` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `dPolSml` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/smlouva-polozka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/smlouva-polozka/properties` |

## Vlastnosti (46)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPolSml | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Označení | string | Kod | **ANO** | ANO | 64 | - | - | - | Označení |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `cisRad` | Pořadí | integer | CisRad | ne | ANO | - | - | - | - | Pořadí |
| `platiOdData` | Platnost od | date | PlatiOdData | ne | ANO | - | - | - | - | Platnost od |
| `platiDoData` | Platnost do | date | PlatiDoData | ne | ANO | - | - | - | - | Platnost do |
| `frekFakt` | Frekvence fakturace | integer | FrekFakt | ne | ANO | - | - | - | - | Frekvence fakturace |
| `den` | Obrátkový den | integer | Den | ne | ANO | - | - | - | - | Obrátkový den |
| `mesic` | Obrátkový měsíc | integer | Mesic | ne | ANO | - | - | - | - | Obrátkový měsíc |
| `zpusFaktK` | Způsob fakturace | select | ZpusFaktK | ne | ANO | 50 | - | - | - | Způsob fakturace |
| `dnyFakt` | Fakturovat dní předem/po | integer | DnyFakt | ne | ANO | - | - | - | - | Fakturovat dní předem/po |
| `varSym` | Variabilní symbol | string | VarSym | ne | ANO | 30 | - | - | - | Variabilní symbol |
| `cenaRucne` | Cena ručně | logic | CenaRucne | ne | ANO | - | - | - | - | Cena ručně |
| `cenaMj` | Cena za MJ | numeric | CenaMj | ne | ANO | - | 19 | 6 | - | Cena za MJ |
| `mnozMj` | Množství | numeric | MnozMj | ne | ANO | - | 19 | 6 | - | Množství |
| `cenaCelkem` | Cena celkem | numeric | CenaCelkem | ne | ANO | - | 15 | 2 | - | Cena celkem |
| `dphRucne` | DPH ručně | logic | DphRucne | ne | ANO | - | - | - | - | DPH ručně |
| `typCenyDphK` | Typ ceny | select | TypCenyDphK | ne | ANO | 50 | - | - | - | Typ ceny |
| `typSzbDphK` | Sazba DPH | select | TypSzbDphK | ne | ANO | 50 | - | - | - | Sazba DPH |
| `sleva` | Sleva | numeric | Sleva | ne | ANO | - | 6 | 2 | - | Sleva |
| `extGener` | Ext. gener. | logic | ExtGener | ne | ANO | - | - | - | - | Ext. gener. |
| `datPoslFaktObd` | Konec posl. fakt. období | date | DatPoslFaktObd | ne | ANO | - | - | - | - | Konec posl. fakt. období |
| `autoGen` | Generovat položku faktury | logic | AutoGen | ne | ANO | - | - | - | - | Generovat položku faktury |
| `valorizovat` | Valorizovat | logic | Valorizovat | ne | ANO | - | - | - | - | Valorizovat |
| `valorizovatMesic` | Valorizovat k měsíci | integer | ValorizovatMesic | ne | ANO | - | - | - | - | Valorizovat k měsíci |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `cisDosle` | Číslo došlé | string | CisDosle | ne | ANO | 40 | - | - | - | Číslo došlé |
| `smlouva` | Smlouva | relation | IdSmlouvy | ne | ANO | - | - | - | `smlouva` | Smlouva |
| `cenik` | Kód z ceníku | relation | IdCenik | ne | ANO | - | - | - | `cenik` | Kód z ceníku |
| `sklad` | Sklad | relation | IdBspSkl | ne | ANO | - | - | - | `sklad` | Sklad |
| `misto` | Místo | relation | IdMisto | ne | ANO | - | - | - | `misto-urceni` | Místo |
| `typUcOp` | Předpis zaúčtování | relation | IdTypUcOp | ne | ANO | - | - | - | `predpis-zauctovani` | Předpis zaúčtování |
| `typDoklFak` | Typ faktury | relation | IdTypDokl | ne | ANO | - | - | - | `typ-faktury-vydane` | Typ faktury |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | - | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `banSpoj` | Číslo účtu | relation | IdBanSpoj | ne | ANO | - | - | - | `adresar-bankovni-ucet` | Číslo účtu |
| `firmaFakt` | Fakturovat firmě | relation | IdFirmyFakt | ne | ANO | - | - | - | `adresar` | Fakturovat firmě |
| `valorPolSml` | Valorizační položka | relation | IdValorPolSml | ne | ANO | - | - | - | `smlouva-polozka` | Valorizační položka |
