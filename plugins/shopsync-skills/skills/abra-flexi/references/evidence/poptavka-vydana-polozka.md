# Položky vydané poptávky

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `poptavka-vydana-polozka` |
| **Evidence Type** | `POPTAVKA_OUT_POLOZKA` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `dPolObch` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/poptavka-vydana-polozka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/poptavka-vydana-polozka/properties` |

## Vlastnosti (55)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPolObch | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
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
| `autogen` | Auto. pol. | logic | Autogen | ne | ne | - | - | - | - | Autogen |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `datVyst` | Datum vyst. | date | DatVyst | ne | ne | - | - | - | - | Vystaveno |
| `kopZakazku` | Kopírovat zakázku | logic | KopZakazku | ne | ANO | - | - | - | - | Kopírovat zakázku |
| `kopStred` | Kopírovat středisko | logic | KopStred | ne | ANO | - | - | - | - | Kopírovat středisko |
| `kopCinnost` | Kopírovat činnost | logic | KopCinnost | ne | ANO | - | - | - | - | Kopírovat činnost |
| `kopKlice` | Kopírovat štítky | logic | KopKlice | ne | ANO | - | - | - | - | Kopírovat štítky |
| `storno` | Storno | logic | Storno | ne | ne | - | - | - | - | Storno |
| `stornoPol` | Storno položky | logic | StornoPol | ne | ne | - | - | - | - | Storno položky |
| `sklad` | Sklad | relation | IdBspSkl | ne | ANO | - | - | - | `sklad` | Sklad |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
| `mena` | Měna | relation | IdMeny | ne | ne | - | - | - | `mena` | Měna |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `dodavatel` | Dodavatel | relation | IdFirmy | ne | ANO | - | - | - | `adresar` | Dodavatel |
| `cenik` | Kód z ceníku | relation | IdCenik | ne | ANO | 64 | - | - | `cenik` | Kód z ceníku |
| `mj` | MJ | relation | IdMj | ne | ANO | - | - | - | `merna-jednotka` | MJ |
| `mjObjem` | MJ objemu | relation | IdMjObjem | ne | ANO | - | - | - | `merna-jednotka` | MJ objemu |
| `sazbaDph` | Sazba DPH | relation | IdSazbyDph | ne | ne | - | - | - | `sazba-dph` | Sazba DPH |
| `idPolObchZdroj` | Zdrojová položka objednávky | integer | IdPolObchZdroj | ne | ne | - | - | - | - | Zdrojová položka objednávky |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `source` | Zdroj | string | Source | ne | ANO | 50 | - | - | - | Zdroj |
| `stavSkladu` | Stav skladu | numeric |  | ne | ne | - | 19 | 6 | - | Stav skladu |
| `doklObch` | Obchodní doklad | relation | IdDoklObch | ne | ne | - | - | - | `poptavka-vydana` | Obchodní doklad |
| `poplatekParentPolObch` | Poplatek k položce | relation | IdPolObchPoplatek | ne | ANO | - | - | - | `poptavka-vydana-polozka` | Poplatek k položce |
| `datTermin` | Termín | date | DatTermin | ne | ANO | - | - | - | - | Termín |
| `kopDatTermin` | Kopírovat termín | logic | KopDatTermin | ne | ANO | - | - | - | - | Kopírovat termín |
