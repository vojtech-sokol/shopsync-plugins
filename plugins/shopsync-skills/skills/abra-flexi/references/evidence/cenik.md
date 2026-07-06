# Ceník

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `cenik` |
| **Evidence Type** | `CENIK` |
| **Import Status** | SUPPORTED |
| **DB Name** | `CenikView` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/cenik` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/cenik/properties` |

## Vlastnosti (114)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdCenik | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Kód/zkratka | string | Kod | **ANO** | ANO | 64 | - | - | - | Kód/zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `eanKod` | EAN | string | EanKod | ne | ANO | 20 | - | - | - | EAN |
| `kodPlu` | Kód PLU | string | KodPlu | ne | ANO | 20 | - | - | - | Kód PLU |
| `typCenyDphK` | Typ ceny | select | TypCenyDphK | ne | ANO | 50 | - | - | - | Typ ceny |
| `procZakl` | %Zakl | numeric | ProcZakl | ne | ANO | - | 6 | 2 | - | %Zakl |
| `individCena` | Individuální cenotvorba | logic | IndividCena | ne | ANO | - | - | - | - | Individuální cenotvorba |
| `limMnoz2` | Limit MJ 2 | numeric | LimMnoz2 | ne | ANO | - | 19 | 6 | - | Množ. limit 2 |
| `limMnoz3` | Limit MJ 3 | numeric | LimMnoz3 | ne | ANO | - | 19 | 6 | - | Množ. limit 3 |
| `limMnoz4` | Limit MJ 4 | numeric | LimMnoz4 | ne | ANO | - | 19 | 6 | - | Množ. limit 4 |
| `limMnoz5` | Limit MJ 5 | numeric | LimMnoz5 | ne | ANO | - | 19 | 6 | - | Množ. limit 5 |
| `procento2` | %2 | numeric | Procento2 | ne | ANO | - | 6 | 2 | - | % 2 |
| `procento3` | %3 | numeric | Procento3 | ne | ANO | - | 6 | 2 | - | %3 |
| `procento4` | %4 | numeric | Procento4 | ne | ANO | - | 6 | 2 | - | %4 |
| `procento5` | %5 | numeric | Procento5 | ne | ANO | - | 6 | 2 | - | %5 |
| `cena2` | Cena 2 | numeric | Cena2 | ne | ANO | - | 19 | 6 | - | Množstevní |
| `cena3` | Cena 3 | numeric | Cena3 | ne | ANO | - | 19 | 6 | - | Cena 3 |
| `cena4` | Cena 4 | numeric | Cena4 | ne | ANO | - | 19 | 6 | - | Cena 4 |
| `cena5` | Cena 5 | numeric | Cena5 | ne | ANO | - | 19 | 6 | - | Cena 5 |
| `zaokrJakK` | Způsob zaokr. | select | ZaokrJakK | ne | ANO | 50 | - | - | - | Způsob zaokr. |
| `zaokrNaK` | Řád zaokrouhlení | select | ZaokrNaK | ne | ANO | 50 | - | - | - | Řád zaokrouhlení |
| `typSzbDphK` | Sazba DPH | select | TypSzbDphK | ne | ANO | 50 | - | - | - | Sazba DPH |
| `desetinMj` | Počet desetin MJ | integer | DesetinMj | ne | ANO | - | - | - | - | Počet desetin MJ |
| `nakupCena` | Nákupní cena | numeric | NakupCena | ne | ANO | - | 19 | 6 | - | Nákupní cena |
| `cenJednotka` | Počet MJ v ceně | numeric | CenJednotka | ne | ANO | - | 19 | 6 | - | Počet MJ v ceně |
| `typCenyVychoziK` | Výchozí cena | select | TypCenyVychoziK | ne | ANO | 50 | - | - | - | Výchozí cena |
| `typVypCenyK` | Způsob výpočtu | select | TypVypCenyK | ne | ANO | 50 | - | - | - | Způsob výpočtu |
| `typCenyVychozi25K` | Výchozí cena pro množ. slevy | select | TypCenyVychozi25K | ne | ANO | 50 | - | - | - | Výchozí cena |
| `typVypCeny25K` | Způsob výpočtu pro množ. slevy | select | TypVypCeny25K | ne | ANO | 50 | - | - | - | Způsob výpočtu |
| `evidVyrCis` | Evidovat výrobní čísla | logic | EvidVyrCis | ne | ANO | - | - | - | - | Evidovat výrobní čísla |
| `unikVyrCis` | Výr. čís. musí být unikátní | logic | UnikVyrCis | ne | ANO | - | - | - | - | Výr. čís. musí být unikátní |
| `zaruka` | Záruka | integer | Zaruka | ne | ANO | - | - | - | - | Záruka |
| `mjZarukyK` | MJ záruky | select | MjZarukyK | ne | ANO | 50 | - | - | - | MJ záruky |
| `mjKoef2` | MJ2 / MJ1 | numeric | MjKoef2 | ne | ANO | - | 19 | 6 | - | MJ2 / MJ1 |
| `mjKoef3` | MJ3 / MJ1 | numeric | MjKoef3 | ne | ANO | - | 19 | 6 | - | MJ3 / MJ1 |
| `prodejMj` | Prodávat násobky MJ | numeric | ProdejMj | ne | ANO | - | 19 | 6 | - | Prodávat násobky MJ |
| `hmotMj` | Hmotnost (netto) | numeric | HmotMj | ne | ANO | - | 19 | 6 | - | Hmotnost (netto) |
| `hmotObal` | Hmotnost obalu | numeric | HmotObal | ne | ANO | - | 19 | 6 | - | Hmotnost obalu |
| `objem` | Objem | numeric | Objem | ne | ANO | - | 19 | 6 | - | Objem |
| `zatrid` | Zatřídění | string | Zatrid | ne | ANO | 255 | - | - | - | Zatřídění |
| `skladove` | Skladové | logic | Skladove | ne | ANO | - | - | - | - | Skladové zboží |
| `typZasobyK` | Typ zásoby | select | TypZasobyK | **ANO** | ANO | - | - | - | - | Typ zásoby |
| `baleniNazev1` | Balení 1 - Kód nebo název | string | BaleniNazev1 | ne | ANO | 255 | - | - | - | Kód nebo název |
| `baleniNazev2` | Balení 2 - Kód nebo název | string | BaleniNazev2 | ne | ANO | 255 | - | - | - | Kód nebo název |
| `baleniNazev3` | Balení 3 - Kód nebo název | string | BaleniNazev3 | ne | ANO | 255 | - | - | - | Kód nebo název |
| `baleniNazev4` | Balení 4 - Kód nebo název | string | BaleniNazev4 | ne | ANO | 255 | - | - | - | Kód nebo název |
| `baleniNazev5` | Balení 5 - Kód nebo název | string | BaleniNazev5 | ne | ANO | 255 | - | - | - | Kód nebo název |
| `baleniMj1` | Balení 1 - Počet MJ | numeric | BaleniMj1 | ne | ANO | - | 19 | 6 | - | Počet MJ |
| `baleniMj2` | Balení 2 - Počet MJ | numeric | BaleniMj2 | ne | ANO | - | 19 | 6 | - | Počet MJ |
| `baleniMj3` | Balení 3 - Počet MJ | numeric | BaleniMj3 | ne | ANO | - | 19 | 6 | - | Počet MJ |
| `baleniMj4` | Balení 4 - Počet MJ | numeric | BaleniMj4 | ne | ANO | - | 19 | 6 | - | Počet MJ |
| `baleniMj5` | Balení 5 - Počet MJ | numeric | BaleniMj5 | ne | ANO | - | 19 | 6 | - | Počet MJ |
| `baleniEan1` | Balení 1 - EAN | string | BaleniEan1 | ne | ANO | 20 | - | - | - | EAN |
| `baleniEan2` | Balení 2 - EAN | string | BaleniEan2 | ne | ANO | 20 | - | - | - | EAN |
| `baleniEan3` | Balení 3 - EAN | string | BaleniEan3 | ne | ANO | 20 | - | - | - | EAN |
| `baleniEan4` | Balení 4 - EAN | string | BaleniEan4 | ne | ANO | 20 | - | - | - | EAN |
| `baleniEan5` | Balení 5 - EAN | string | BaleniEan5 | ne | ANO | 20 | - | - | - | EAN |
| `inEvid` | Evidovat Intrastat | logic | InEvid | ne | ANO | - | - | - | - | Evidovat Intrastat |
| `inKoefMj` | Koeficient pro MJ | numeric | InKoefMj | ne | ANO | - | 19 | 6 | - | Koeficient pro MJ |
| `inKoefStat` | Koeficient pro statistickou hodnotu | numeric | InKoefStat | ne | ANO | - | 19 | 6 | - | Koeficient pro statistickou hodnotu |
| `inKodSled` | Kód sledovanosti druhu zboží | string | InKodSled | ne | ANO | 50 | - | - | - | Kód sledovanosti druhu zboží |
| `popisA` | Popis EN | string | PopisA | ne | ANO | - | - | - | - | Popis EN |
| `popisB` | Popis DE | string | PopisB | ne | ANO | - | - | - | - | Popis DE |
| `popisC` | Popis FR | string | PopisC | ne | ANO | - | - | - | - | Popis FR |
| `cenaBezna` | Běžná cena | numeric | CenaBezna | ne | ANO | - | 19 | 6 | - | Běžná cena |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `stavy` | Stavy | string |  | ne | ANO | - | - | - | - | Stavy |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `exportNaEshop` | Export na E-shop | logic | ExportNaEshop | ne | ANO | - | - | - | - | Exportovat na internetový obchod |
| `minMarzeCenik` | Hlídat minimální cenový rozdíl | logic | MinMarzeCenik | ne | ANO | - | - | - | - | Hlídat minimální cenový rozdíl |
| `minMarze` | Minimální cenový rozdíl [%] | numeric | MinMarze | ne | ANO | - | 6 | 2 | - | Minimální cenový rozdíl [%] |
| `typVypoctuHlidatMinK` | Typ min. cen. rozdílu | select | TypVypoctuHlidatMinK | **ANO** | ANO | 50 | - | - | - | Typ hlídaného minimálního cenového rozdílu |
| `evidSarze` | Evidovat šarže | logic | EvidSarze | ne | ANO | - | - | - | - | Evidovat šarže |
| `evidExpir` | Evidovat expirace | logic | EvidExpir | ne | ANO | - | - | - | - | Evidovat expirace |
| `sada` | Sada | logic | Sada | ne | ne | - | - | - | - | Sada |
| `dnyTrvanPoExpir` | Trvanlivost je X dní po expiraci | integer | DnyTrvanPoExpir | ne | ANO | - | - | - | - | Trvanlivost je X dní po expiraci |
| `neseskupovatObj` | Neseskupovat položky při vytváření objednávky vydané | logic | NeseskupovatObj | ne | ANO | - | - | - | - | Neseskupovat položky při vytváření objednávky vydané |
| `kratkyPopis` | Krátký popis | string | KratkyPopis | ne | ANO | - | - | - | - | Krátký popis |
| `klicSlova` | Klíčová slova | string | KlicSlova | ne | ANO | 255 | - | - | - | Klíčová slova |
| `techParam` | Technické parametry | string | TechParam | ne | ANO | - | - | - | - | Technické parametry |
| `dodaciLhuta` | Dodací lhůta | numeric | DodaciLhuta | ne | ANO | - | 19 | 6 | - | Dodací lhůta |
| `prodejKasa` | Umožnit prodej na kase | logic | ProdejKasa | ne | ANO | - | - | - | - | Umožnit prodej na kase |
| `kodGenerated` | Kód je generovaný | logic |  | ne | ANO | - | - | - | - | Kód je generovaný |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `skupZboz` | Skupina zboží | relation | IdSkupZboz | ne | ANO | - | - | - | `skupina-zbozi` | Skupina zboží |
| `mj1` | MJ | relation | IdMj1 | ne | ANO | - | - | - | `merna-jednotka` | Měrná jednotka |
| `mj2` | MJ č. 2 | relation | IdMj2 | ne | ANO | - | - | - | `merna-jednotka` | MJ č. 2 |
| `mj3` | MJ č. 3 | relation | IdMj3 | ne | ANO | - | - | - | `merna-jednotka` | MJ č. 3 |
| `mjHmot` | MJ hmotnosti | relation | IdMjHmot | ne | ANO | - | - | - | `merna-jednotka` | MJ hmotnosti |
| `mjObj` | MJ objemu | relation | IdMjObj | ne | ANO | - | - | - | `merna-jednotka` | MJ objemu |
| `stat` | Stát | relation | IdStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `nomen` | Nomenklatura | relation | IdNomen | ne | ANO | 20 | - | - | `intrastat-kod-nomenklatury` | Nomenklatura |
| `dodavatel` | Dodavatel | relation | IdDodavatel | ne | ANO | - | - | - | `adresar` | Dodavatel |
| `vyrobce` | Výrobce | relation | IdVyrobce | ne | ANO | - | - | - | `adresar` | Výrobce |
| `dphPren` | Kód přenesení DPH | relation | IdDphPren | ne | ANO | - | - | - | `preneseni-dph` | Kód přenesení DPH |
| `mjDodaciLhuta` | MJ Dodací lhůty | relation | IdMjDodaciLhuta | ne | ANO | - | - | - | `merna-jednotka` | MJ Dodací lhůty |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
| `sumStavMj` | Stav skladu | numeric |  | ne | ne | - | 19 | 6 | - | Stav skladu |
| `sumRezerMj` | Rezervováno | numeric |  | ne | ne | - | 19 | 6 | - | Rezervováno |
| `sumPozadavkyMj` | Požadavky | numeric |  | ne | ne | - | 19 | 6 | - | Požadavky |
| `sumDostupMj` | Dostupné | numeric |  | ne | ne | - | 19 | 6 | - | Dostupné |
| `cenaZaklBezDph` | Prodejní cena bez DPH | numeric |  | ne | ne | - | 19 | 6 | - | bez DPH |
| `cenaZaklVcDph` | Prodejní cena včetně DPH | numeric |  | ne | ne | - | 19 | 6 | - | s DPH |
| `cenaZakl` | Prodejní cena | numeric | CenaZakl | ne | ANO | - | 19 | 6 | - | Prodejní cena |
