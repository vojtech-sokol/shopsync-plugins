# Leasing

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `leasing` |
| **Evidence Type** | `LEASING` |
| **Import Status** | DISALLOWED |
| **DB Name** | `mLeasing` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/leasing` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/leasing/properties` |

## Vlastnosti (47)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdLeasing | ne | ne | - | - | - | - | ID |
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
| `eanKod` | EAN kód | string | EanKod | ne | ANO | 20 | - | - | - | EAN kód |
| `druhK` | Druh | select | DruhK | **ANO** | ANO | 50 | - | - | - | Druh |
| `cena` | Cena [Kč] | numeric | Cena | ne | ANO | - | 15 | 2 | - | Cena [Kč] |
| `cidPoriz` | Číslo smlouvy | string | CidPoriz | **ANO** | ANO | 255 | - | - | - | Číslo smlouvy |
| `datKoupe` | Zahájení | date | DatKoupe | **ANO** | ANO | - | - | - | - | Datum zahájení leasingu |
| `datVyroby` | Vyrobeno | date | DatVyroby | ne | ANO | - | - | - | - | Datum výroby |
| `vyrCis` | Výrobní číslo | string | VyrCis | ne | ANO | 255 | - | - | - | Výrobní číslo |
| `mjZarukyK` | MJ záruky | select | MjZarukyK | ne | ANO | 50 | - | - | - | MJ záruky |
| `zaruka` | Záruka | integer | Zaruka | ne | ANO | 2 | - | - | - | Záruka |
| `zamek` | Zámek | logic | Zamek | ne | ANO | - | - | - | - | Zámek |
| `pocetSplatek` | ? splátek | integer | PocetSplatek | **ANO** | ANO | 2 | - | - | - | Počet splátek |
| `pocetDanNakl` | ? daň.nákl | integer | PocetDanNakl | **ANO** | ANO | 2 | - | - | - | Počet daňových nákladů [v měsících] |
| `frekDanNaklK` | Frekv.daň.nákl. | select | FrekDanNaklK | **ANO** | ANO | 50 | - | - | - | Frekvence daňových nákladů |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `vozCislo` | Číslo | string | VozCislo | ne | ANO | 255 | - | - | - | Číslo |
| `vozSpz` | SPZ | string | VozSpz | ne | ANO | 255 | - | - | - | SPZ |
| `vozZnacka` | Značka | string | VozZnacka | ne | ANO | 255 | - | - | - | Značka |
| `vozModel` | Model | string | VozModel | ne | ANO | 255 | - | - | - | Model |
| `vozTyp` | Typ vozidla | string | VozTyp | ne | ANO | 255 | - | - | - | Typ vozidla |
| `vozObjem` | Objem | numeric | VozObjem | ne | ANO | - | 15 | 2 | - | Objem |
| `vozHavar` | Havarijní pojištění | string | VozHavar | ne | ANO | 255 | - | - | - | Havarijní pojištění |
| `vozHavarVyse` | Výše havarijního pojištění | numeric | VozHavarVyse | ne | ANO | - | 15 | 2 | - | Výše havarijního pojištění |
| `vozVybava` | Výbava | string | VozVybava | ne | ANO | - | - | - | - | Výbava |
| `typLeasingu` | Typ | relation | IdTypLeas | **ANO** | ANO | 20 | - | - | `typ-leasingu` | Typ |
| `mena` | Měna | relation | IdMeny | ne | ANO | 20 | - | - | `mena` | Měna |
| `casUcet` | Úč.čas.rozl. | relation | IdCasUcet | ne | ANO | 6 | - | - | `ucet` | Účet časového rozlišení nákladů |
| `zavazUcet` | Úč.závazku | relation | IdZavazUcet | ne | ANO | 6 | - | - | `ucet` | Účet závazku |
| `naklUcet` | Úč.daň.nákl. | relation | IdNaklUcet | ne | ANO | 6 | - | - | `ucet` | Účet daňových nákladů |
| `dphZaklUcet` | Úč.DPH sníž. | relation | IdDphZaklUcet | ne | ANO | 6 | - | - | `ucet` | Účet DPH - základní sazba |
| `dphSnizUcet` | Úč.DPH zákl. | relation | IdDphSnizUcet | ne | ANO | 6 | - | - | `ucet` | Účet DPH - snížená sazba |
| `dodavatel` | Dodavatel | relation | IdFirmyDod | ne | ANO | 20 | - | - | `adresar` | Dodavatel |
| `vyrobce` | Výrobce | relation | IdFirmyVyr | ne | ANO | 20 | - | - | `adresar` | Výrobce |
| `stredisko` | Středisko | relation | IdStred | **ANO** | ANO | 20 | - | - | `stredisko` | Středisko |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `uzivatel` | Uživatel | relation | IdUziv | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
