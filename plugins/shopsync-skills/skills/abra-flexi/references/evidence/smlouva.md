# Odběratelské smlouvy

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `smlouva` |
| **Evidence Type** | `SMLOUVA` |
| **Import Status** | SUPPORTED |
| **DB Name** | `SmlouvaView` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/smlouva` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/smlouva/properties` |

## Vlastnosti (55)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSmlouvy | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Číslo smlouvy | string | Kod | **ANO** | ANO | 20 | - | - | - | Číslo smlouvy |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `sablona` | Šablona | logic | Sablona | ne | ANO | - | - | - | - | Šablona |
| `smlouvaOd` | Platnost od | date | SmlouvaOd | **ANO** | ANO | - | - | - | - | Platnost od |
| `smlouvaDo` | Platnost do | date | SmlouvaDo | ne | ANO | - | - | - | - | Platnost do |
| `datumPodepsani` | Datum podepsání | date | DatumPodepsani | ne | ANO | - | - | - | - | Datum podepsání |
| `datumUcinnosti` | Datum účinnosti | date | DatumUcinnosti | ne | ANO | - | - | - | - | Datum účinnosti |
| `frekFakt` | Frekvence fakturace | integer | FrekFakt | ne | ANO | - | - | - | - | Frekvence fakturace (měsíců) |
| `den` | Obrátkový den | integer | Den | ne | ANO | - | - | - | - | Obrátkový den |
| `mesic` | Obrátkový měsíc | integer | Mesic | ne | ANO | - | - | - | - | Obrátkový měsíc |
| `zpusFaktK` | Způsob fakturace | select | ZpusFaktK | ne | ANO | 50 | - | - | - | Způsob fakturace |
| `dnyFakt` | Fakturovat dní předem/po | integer | DnyFakt | ne | ANO | - | - | - | - | Fakturovat dní předem/po |
| `varSym` | Variabilní symbol | string | VarSym | ne | ANO | 30 | - | - | - | Variabilní symbol |
| `cisDosle` | Číslo došlé | string | CisDosle | ne | ANO | 40 | - | - | - | Číslo došlé |
| `cisSmlProti` | Číslo smlouvy protistrany | string | CisSmlProti | ne | ANO | 50 | - | - | - | Číslo smlouvy protistrany |
| `autoGen` | Automaticky generovat | logic | AutoGen | ne | ANO | - | - | - | - | Automaticky generovat |
| `autoMail` | Automaticky posílat e-mailem klientovi | logic | AutoMail | ne | ANO | - | - | - | - | Automaticky posílat e-mailem klientovi |
| `autoProdl` | Automaticky prodlužovat | logic | AutoProdl | ne | ANO | - | - | - | - | Automaticky prodlužovat |
| `autoProlong` | Automatická prolongace | integer | AutoProlong | ne | ANO | - | - | - | - | Automatická prolongace |
| `autoZakazka` | Automaticky vytvářet zakázky | logic | AutoZakazka | ne | ANO | - | - | - | - | Automaticky vytvářet zakázky |
| `datVystZDuzp` | Dat.vyst. z DUZP | logic | DatVystZDuzp | ne | ANO | - | - | - | - | Dat.vyst. z DUZP |
| `generovatNuloveFaktury` | Generovat i nulové faktury | logic | GenerovatNuloveFaktury | ne | ANO | - | - | - | - | Generovat i nulové faktury |
| `ignorovatTypSml` | Ignorovat nastavení typu smlouvy | logic | IgnorovatTypSml | ne | ANO | - | - | - | - | Ignorovat nastavení typu smlouvy |
| `preplatky` | Řešit přeplatky | logic | Preplatky | ne | ANO | - | - | - | - | Řešit přeplatky |
| `varSymFakt` | Variabilní symbol z faktury | logic | VarSymFakt | ne | ANO | - | - | - | - | Variabilní symbol je generován z čísla faktury |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `katastrUzemi` | Katastrální území | string | KatastrUzemi | ne | ANO | 255 | - | - | - | Katastrální území |
| `parcela` | Parcela | string | Parcela | ne | ANO | 255 | - | - | - | Parcela |
| `vypovedniLhuta` | Výpovědní lhůta [měsíc] | integer | VypovedniLhuta | ne | ANO | - | - | - | - | Výpovědní lhůta [měsíc] |
| `datZaloz` | Datum založení | date | DatZaloz | ne | ANO | - | - | - | - | Datum založení |
| `datVypoz` | Datum vypovězení | date | DatVypoz | ne | ANO | - | - | - | - | Datum vypovězení |
| `typDoklFakSplatDny` | Typ faktury - Splatnost ve dnech | integer |  | ne | ne | - | - | - | - | Typ faktury - Splatnost ve dnech |
| `poslDatSplat` | Datum splatnosti nejstarší neuhrazené faktury u smlouvy | date |  | ne | ne | - | - | - | - | Datum splatnosti nejstarší neuhrazené faktury u smlouvy |
| `firma_nazev` | Název firmy | string |  | ne | ne | 255 | - | - | - | Název firmy |
| `typSml` | Typ smlouvy | relation | IdTypSml | **ANO** | ANO | - | - | - | `typ-smlouvy` | Typ smlouvy |
| `firma` | Firma | relation | IdFirmy | **ANO** | ANO | - | - | - | `adresar` | Firma |
| `firmaFakt` | Fakturovat firmě | relation | IdFirmyFakt | ne | ANO | - | - | - | `adresar` | Fakturovat firmě |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | - | - | - | `zakazka` | Zakázka |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | - | - | - | `stredisko` | Středisko |
| `typDoklFak` | Typ faktury | relation | IdTypDokl | ne | ANO | - | - | - | `typ-faktury-vydane` | Typ faktury |
| `konSym` | Konstantní symbol | relation | IdKonSym | ne | ANO | - | - | - | `konst-symbol` | Konstantní symbol |
| `stavSml` | Stav smlouvy | relation | IdStavSml | ne | ANO | - | - | - | `stav-smlouvy` | Stav smlouvy |
| `typDoklFakStredisko` | Typ faktury - Středisko | relation |  | ne | ne | - | - | - | `stredisko` | Typ faktury - Středisko |
| `typDoklFakCinnost` | Typ faktury - Činnost | relation |  | ne | ne | - | - | - | `cinnost` | Typ faktury - Činnost |
| `typDoklFakBspBan` | Typ faktury - Bankovní účet | relation |  | ne | ne | - | - | - | `bankovni-ucet` | Typ faktury - Bankovní účet |
| `zodpOsoba` | Zodpovědná osoba | relation | IdZodpOsoba | ne | ANO | 254 | - | - | `uzivatel` | Zodpovědná osoba |
| `kontaktOsoba` | Kontaktní osoba | relation | IdKontaktOsoba | ne | ANO | - | - | - | `kontakt` | Kontaktní osoba |
