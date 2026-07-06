# Položky ostatních závazků

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `zavazek-polozka` |
| **Evidence Type** | `ZAVAZEK_POLOZKA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dPolFak` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/zavazek-polozka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/zavazek-polozka/properties` |

## Vlastnosti (89)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPolFak | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `ucetni` | Úč. pol. | logic | Ucetni | ne | ne | - | - | - | - | Položka je účetní |
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
| `typCenyDphK` | Typ ceny | select | TypCenyDphK | ne | ANO | 50 | - | - | - | Typ ceny |
| `typSzbDphK` | Typ sazby DPH | select | TypSzbDphK | ne | ANO | 50 | - | - | - | Typ sazby DPH |
| `szbDph` | DPH [%] | numeric | SzbDph | ne | ANO | - | 6 | 2 | - | DPH [%] |
| `cenaMj` | Cena za MJ | numeric | CenaMj | ne | ANO | - | 19 | 6 | - | Cena za MJ |
| `sumZkl` | Základ [Kč] | numeric | SumZkl | ne | ANO | - | 15 | 2 | - | Základ [Kč] |
| `sumDph` | DPH [Kč] | numeric | SumDph | ne | ANO | - | 15 | 2 | - | DPH [Kč] |
| `sumCelkem` | Celkem [Kč] | numeric | sumZkl + sumDph | ne | ANO | - | 15 | 2 | - | Celkem [Kč] |
| `sumZklMen` | Základ [měna] | numeric | SumZklMen | ne | ANO | - | 15 | 2 | - | Základ [měna] |
| `sumDphMen` | DPH [měna] | numeric | SumDphMen | ne | ANO | - | 15 | 2 | - | DPH [měna] |
| `sumCelkemMen` | Celkem [měna] | numeric | sumZklMen + sumDphMen | ne | ANO | - | 15 | 2 | - | Celkem [měna] |
| `objem` | Objem | numeric | Objem | ne | ANO | - | 19 | 6 | - | Objem |
| `cenJednotka` | Cen. jednotka | numeric | CenJednotka | ne | ANO | - | 19 | 6 | - | Cen. jednotka |
| `typVypCenyK` | Způsob výpočtu | select | TypVypCenyK | ne | ANO | 50 | - | - | - | Způsob výpočtu |
| `cenaMjNakup` | Nákupní cena za MJ z ceníku | numeric | CenaMjNakup | ne | ANO | - | 19 | 6 | - | Nákupní |
| `cenaMjProdej` | Prodejní cena za MJ z ceníku | numeric | CenaMjProdej | ne | ANO | - | 19 | 6 | - | Základní prodejní |
| `cenaMjCenikTuz` | Ceníková cena [Kč] | numeric | CenaMjCenikTuz | ne | ANO | - | 19 | 6 | - | Ceníková cena [Kč] |
| `procZakl` | Marže / Přirážka / Rabat / Sleva [%] | numeric | ProcZakl | ne | ANO | - | 6 | 2 | - | Marže / Přirážka / Rabat / Sleva [%] |
| `slevaMnoz` | Množstevní sleva [%] | numeric | SlevaMnoz | ne | ANO | - | 6 | 2 | - | Množstevní sleva [%] |
| `zaokrJakK` | Způsob zaokrouhlení - Cena | select | ZaokrJakK | ne | ANO | 50 | - | - | - | Způsob |
| `zaokrNaK` | Řád zaokrouhlení - Cena | select | ZaokrNaK | ne | ANO | 50 | - | - | - | Řád |
| `sarze` | Šarže | string | Sarze | ne | ANO | 100 | - | - | - | Šarže |
| `expirace` | Expirace | date | Expirace | ne | ANO | - | - | - | - | Expirace |
| `datTrvan` | Trvanlivost | date | DatTrvan | ne | ANO | - | - | - | - | Trvanlivost |
| `datVyroby` | Datum výroby | date | DatVyroby | ne | ANO | - | - | - | - | Datum výroby |
| `stavUzivK` | Uživatelský stav | select | StavUzivK | ne | ANO | 50 | - | - | - | Uživatelský stav |
| `mnozMjPlan` | Plán MJ | numeric | MnozMjPlan | ne | ne | - | 19 | 6 | - | Plánované množství |
| `mnozMjReal` | Real. MJ | numeric | MnozMjReal | ne | ne | - | 19 | 6 | - | Realizované množství |
| `autoZaokr` | Zaokr. pol. | logic | AutoZaokr | ne | ne | - | - | - | - | AutoZaokr |
| `autogen` | Auto. pol. | logic | Autogen | ne | ne | - | - | - | - | Autogen |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `datVyst` | Datum vyst. | date | DatVyst | ne | ne | - | - | - | - | Vystaveno |
| `kopZklMdUcet` | Kopírovat MD účet základu | logic | KopZklMdUcet | ne | ANO | - | - | - | - | Kopírovat MD účet základu |
| `kopZklDalUcet` | Kopírovat D účet základu | logic | KopZklDalUcet | ne | ANO | - | - | - | - | Kopírovat D účet základu |
| `kopDphMdUcet` | Kopírovat MD účet DPH | logic | KopDphMdUcet | ne | ANO | - | - | - | - | Kopírovat MD účet DPH |
| `kopDphDalUcet` | Kopírovat D účet DPH | logic | KopDphDalUcet | ne | ANO | - | - | - | - | Kopírovat D účet DPH |
| `kopTypUcOp` | Kopírovat předpis zaúčtování | logic | KopTypUcOp | ne | ANO | - | - | - | - | Kopírovat předpis zaúčtování |
| `kopZakazku` | Kopírovat zakázku | logic | KopZakazku | ne | ANO | - | - | - | - | Kopírovat zakázku |
| `kopStred` | Kopírovat středisko | logic | KopStred | ne | ANO | - | - | - | - | Kopírovat středisko |
| `kopCinnost` | Kopírovat činnost | logic | KopCinnost | ne | ANO | - | - | - | - | Kopírovat činnost |
| `kopKlice` | Kopírovat štítky | logic | KopKlice | ne | ANO | - | - | - | - | Kopírovat štítky |
| `kopClenDph` | Kopírovat řádek DPH | logic | KopClenDph | ne | ANO | - | - | - | - | Kopírovat řádek DPH z dokladu |
| `kopDatUcto` | Kopírovat dat. zaúčt. | logic | KopDatUcto | ne | ANO | - | - | - | - | Kopírovat dat. zaúčt. |
| `datUcto` | Datum zaúčtování | date | DatUcto | ne | ANO | - | - | - | - | Datum zaúčtování |
| `storno` | Storno | logic | Storno | ne | ne | - | - | - | - | Storno |
| `stornoPol` | Storno položky | logic | StornoPol | ne | ne | - | - | - | - | Storno položky |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
| `mena` | Měna | relation | IdMeny | ne | ne | - | - | - | `mena` | Měna |
| `typUcOp` | Předpis zaúčtování | relation | IdTypUcOp | ne | ANO | - | - | - | `predpis-zauctovani` | Předpis zaúčtování |
| `zklMdUcet` | Účet MD základ | relation | IdZklMdUcet | ne | ANO | 6 | - | - | `ucet` | Má Dáti základu |
| `zklDalUcet` | Účet Dal základ | relation | IdZklDalUcet | ne | ANO | 6 | - | - | `ucet` | Dal základu |
| `dphMdUcet` | Účet MD DPH | relation | IdDphMdUcet | ne | ANO | 6 | - | - | `ucet` | Má dáti DPH |
| `dphDalUcet` | Účet Dal DPH | relation | IdDphDalUcet | ne | ANO | 6 | - | - | `ucet` | Dal DPH |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `dodavatel` | Dodavatel | relation | IdFirmy | ne | ANO | - | - | - | `adresar` | Dodavatel |
| `clenDph` | Řádky DPH | relation | IdClenDph | ne | ANO | - | - | - | `cleneni-dph` | Řádky DPH |
| `dphPren` | Kód přenesení DPH | relation | IdDphPren | ne | ANO | - | - | - | `preneseni-dph` | Kód přenesení DPH |
| `mj` | MJ | relation | IdMj | ne | ANO | - | - | - | `merna-jednotka` | MJ |
| `mjObjem` | MJ objemu | relation | IdMjObjem | ne | ANO | - | - | - | `merna-jednotka` | MJ objemu |
| `sazbaDph` | Sazba DPH | relation | IdSazbyDph | ne | ne | - | - | - | `sazba-dph` | Sazba DPH |
| `idPolObchZdroj` | Zdrojová položka objednávky | integer | IdPolObchZdroj | ne | ne | - | - | - | - | Zdrojová položka objednávky |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `source` | Zdroj | string | Source | ne | ANO | 50 | - | - | - | Zdroj |
| `clenKonVykDph` | Řádek kontrolního hlášení DPH | relation | IdClenKonVykDph | ne | ANO | - | - | - | `cleneni-kontrolni-hlaseni` | Řádek kontrolního hlášení DPH |
| `kopClenKonVykDph` | Kopírovat řádek kon. hl. DPH | logic | KopClenKonVykDph | ne | ANO | - | - | - | - | Kopírovat řádek kontrolního hlášení DPH z dokladu |
| `ciselnyKodZbozi` | Číselný kód zboží | string | CiselnyKodZbozi | ne | ANO | 255 | - | - | - | Číselný kód zboží |
| `druhZbozi` | Druh zboží | string | DruhZbozi | ne | ANO | 255 | - | - | - | Druh zboží |
| `marze` | Marže | numeric |  | ne | ne | - | 12 | 2 | - | Marže |
| `prirazka` | Přirážka | numeric |  | ne | ne | - | 12 | 2 | - | Přirážka |
| `minMarze` | Minimální cenový rozdíl | numeric |  | ne | ne | - | 12 | 2 | - | Minimální cenový rozdíl |
| `typVypoctuHlidatMinK` | Typ min. cen. rozdílu | select |  | ne | ne | 50 | - | - | - | Typ hlídaného minimálního cenového rozdílu |
| `doklFak` | Doklad | relation | IdDoklFak | ne | ne | - | - | - | `zavazek` | Doklad |
| `sumVedlNaklIntrMen` | Celkové vedlejší náklady [Kč] | numeric | SumVedlNaklIntrMen | ne | ANO | - | 19 | 6 | - | Celkové vedlejší náklady [Kč] |
