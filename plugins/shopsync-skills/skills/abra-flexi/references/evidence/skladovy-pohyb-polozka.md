# Položky příjemky/výdejky

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `skladovy-pohyb-polozka` |
| **Evidence Type** | `SKLADOVY_POHYB_POLOZKA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dPolSklad` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/skladovy-pohyb-polozka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/skladovy-pohyb-polozka/properties` |

## Vlastnosti (81)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPolSklad | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `ucetni` | Úč. pol. | logic | Ucetni | ne | ne | - | - | - | - | Položka je účetní |
| `kod` | Označení | string | Kod | ne | ANO | 64 | - | - | - | Označení |
| `eanKod` | EAN | string | EanKod | ne | ANO | 20 | - | - | - | EAN |
| `nazev` | Název | string | Nazev | ne | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `cisRad` | Pořadí | integer | CisRad | ne | ANO | - | - | - | - | Pořadí |
| `typPolozkyK` | Typ položky | select | TypPolozkyK | **ANO** | ANO | 50 | - | - | - | Typ položky |
| `baleniId` | Balení | integer | BaleniId | ne | ANO | - | 1 | - | - | Balení |
| `mnozBaleni` | Počet balení | numeric | MnozBaleni | ne | ANO | - | 19 | 6 | - | Počet balení |
| `mnozMj` | Množství | numeric | MnozMj | ne | ANO | - | 19 | 6 | - | Množství |
| `mnozMjPrijem` | Příjem MJ | numeric |  | ne | ANO | - | 19 | 6 | - | Příjem MJ |
| `mnozMjVydej` | Výdej MJ | numeric |  | ne | ANO | - | 19 | 6 | - | Výdej MJ |
| `typCenyDphK` | Typ ceny | select | TypCenyDphK | ne | ne | 50 | - | - | - | Typ ceny |
| `typSzbDphK` | Typ sazby DPH | select | TypSzbDphK | ne | ne | 50 | - | - | - | Typ sazby DPH |
| `cenaMj` | Cena za MJ | numeric | CenaMj | ne | ANO | - | 19 | 6 | - | Cena za MJ |
| `sumZkl` | Základ [Kč] | numeric | SumZkl | ne | ANO | - | 15 | 2 | - | Základ [Kč] |
| `sumCelkem` | Celkem [Kč] | numeric | sumZkl + sumDph | ne | ANO | - | 15 | 2 | - | Celkem [Kč] |
| `sumZklMen` | Základ [měna] | numeric | SumZklMen | ne | ANO | - | 15 | 2 | - | Základ [měna] |
| `sumCelkemMen` | Celkem [měna] | numeric | sumZklMen + sumDphMen | ne | ANO | - | 15 | 2 | - | Celkem [měna] |
| `objem` | Objem | numeric | Objem | ne | ANO | - | 19 | 6 | - | Objem |
| `cenJednotka` | Cen. jednotka | numeric | CenJednotka | ne | ANO | - | 19 | 6 | - | Cen. jednotka |
| `cenaMjProdej` | Prodejní cena | numeric | CenaMjProdej | ne | ANO | - | 19 | 6 | - | Prodejní cena |
| `cenaMjCenikTuz` | Ceníková cena [Kč] | numeric | CenaMjCenikTuz | ne | ANO | - | 19 | 6 | - | Ceníková cena [Kč] |
| `sarze` | Šarže | string | Sarze | ne | ANO | 100 | - | - | - | Šarže |
| `expirace` | Expirace | date | Expirace | ne | ANO | - | - | - | - | Expirace |
| `datTrvan` | Trvanlivost | date | DatTrvan | ne | ANO | - | - | - | - | Trvanlivost |
| `datVyroby` | Datum výroby | date | DatVyroby | ne | ANO | - | - | - | - | Datum výroby |
| `mnozMjPlan` | Požadavek MJ | numeric | MnozMjPlan | ne | ne | - | 19 | 6 | - | Požadavek MJ |
| `autogen` | Auto. pol. | logic | Autogen | ne | ne | - | - | - | - | Autogen |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `datVyst` | Datum vyst. | date | DatVyst | ne | ne | - | - | - | - | Vystaveno |
| `kopZklMdUcet` | Kopírovat MD účet základu | logic | KopZklMdUcet | ne | ANO | - | - | - | - | Kopírovat MD účet základu |
| `kopZklDalUcet` | Kopírovat D účet základu | logic | KopZklDalUcet | ne | ANO | - | - | - | - | Kopírovat D účet základu |
| `kopTypUcOp` | Kopírovat předpis zaúčtování | logic | KopTypUcOp | ne | ANO | - | - | - | - | Kopírovat předpis zaúčtování |
| `kopZakazku` | Kopírovat zakázku | logic | KopZakazku | ne | ANO | - | - | - | - | Kopírovat zakázku |
| `kopStred` | Kopírovat středisko | logic | KopStred | ne | ANO | - | - | - | - | Kopírovat středisko |
| `kopCinnost` | Kopírovat činnost | logic | KopCinnost | ne | ANO | - | - | - | - | Kopírovat činnost |
| `kopKlice` | Kopírovat štítky | logic | KopKlice | ne | ANO | - | - | - | - | Kopírovat štítky |
| `kopDatUcto` | Kopírovat dat. zaúčt. | logic | KopDatUcto | ne | ANO | - | - | - | - | Kopírovat dat. zaúčt. |
| `datUcto` | Datum zaúčtování | date | DatUcto | ne | ANO | - | - | - | - | Datum zaúčtování |
| `storno` | Storno | logic | Storno | ne | ne | - | - | - | - | Storno |
| `stornoPol` | Storno položky | logic | StornoPol | ne | ne | - | - | - | - | Storno položky |
| `sklad` | Sklad | relation | IdBspSkl | **ANO** | ANO | - | - | - | `sklad` | Sklad |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
| `mena` | Měna | relation | IdMeny | ne | ne | - | - | - | `mena` | Měna |
| `typUcOp` | Předpis zaúčtování | relation | IdTypUcOp | ne | ANO | - | - | - | `predpis-zauctovani` | Předpis zaúčtování |
| `zklMdUcet` | Účet MD základ | relation | IdZklMdUcet | ne | ANO | 6 | - | - | `ucet` | Má Dáti základu |
| `zklDalUcet` | Účet Dal základ | relation | IdZklDalUcet | ne | ANO | 6 | - | - | `ucet` | Dal základu |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `dodavatel` | Dodavatel | relation | IdFirmy | ne | ANO | - | - | - | `adresar` | Dodavatel |
| `cenik` | Kód z ceníku | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Kód z ceníku |
| `cenHlad` | Cenová úroveň | relation | IdCenHlad | ne | ANO | - | - | - | `cenova-uroven` | Cenová úroveň |
| `mj` | MJ | relation | IdMj | ne | ANO | - | - | - | `merna-jednotka` | MJ |
| `mjObjem` | MJ objemu | relation | IdMjObjem | ne | ANO | - | - | - | `merna-jednotka` | MJ objemu |
| `vyrobniCislaOk` | Výr. čísla OK | logic | VyrobniCislaOk | ne | ne | - | - | - | - | Výr. čísla OK |
| `idPolObchZdroj` | Zdrojová položka objednávky | integer | IdPolObchZdroj | ne | ne | - | - | - | - | Zdrojová položka objednávky |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `source` | Zdroj | string | Source | ne | ANO | 50 | - | - | - | Zdroj |
| `marze` | Marže | numeric |  | ne | ne | - | 12 | 2 | - | Marže |
| `prirazka` | Přirážka | numeric |  | ne | ne | - | 12 | 2 | - | Přirážka |
| `minMarze` | Minimální cenový rozdíl | numeric |  | ne | ne | - | 12 | 2 | - | Minimální cenový rozdíl |
| `typVypoctuHlidatMinK` | Typ min. cen. rozdílu | select |  | ne | ne | 50 | - | - | - | Typ hlídaného minimálního cenového rozdílu |
| `stavSkladu` | Stav skladu | numeric |  | ne | ne | - | 19 | 6 | - | Stav skladu |
| `rezervovano` | Rezervováno | numeric |  | ne | ne | - | 19 | 6 | - | Rezervováno |
| `doklSklad` | Příjemka/výdejka | relation | IdDoklSklad | ne | ne | - | - | - | `skladovy-pohyb` | Příjemka/výdejka |
| `skladovaKarta` | Skladová karta | relation | IdKarty | ne | ne | - | - | - | `skladova-karta` | Skladová karta |
| `prevodka` | Převodka | logic | Prevodka | ne | ne | - | - | - | - | Převodka |
| `zdrojProFak` | Zdroj pro faktury | logic | ZdrojProFak | **ANO** | ANO | - | - | - | - | Zdroj pro faktury |
| `cenaMjNeskl` | Cena neskladových částí | numeric | CenaMjNeskl | ne | ANO | - | 19 | 6 | - | Cena neskladových částí |
| `cenaMjSkl` | Cena skladových částí | numeric | CenaMjSkl | ne | ANO | - | 19 | 6 | - | Cena skladových částí |
| `cenyRucne` | Ceny zadány ručně | logic | CenyRucne | **ANO** | ANO | - | - | - | - | Ceny zadány ručně |
| `cenaMjPoriz` | Cena pořízení | numeric | CenaMjPoriz | ne | ANO | - | 19 | 6 | - | Cena pořízení |
| `cenaMjNakl` | Vedlejší náklady | numeric | CenaMjNakl | ne | ANO | - | 19 | 6 | - | Vedlejší náklady |
