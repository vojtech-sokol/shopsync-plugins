# Položky banky a vzájemných zápočtů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `banka-polozka` |
| **Evidence Type** | `BANKA_POLOZKA` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `dPolInt` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/banka-polozka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/banka-polozka/properties` |

## Vlastnosti (54)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPolInt | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `ucetni` | Úč. pol. | logic | Ucetni | ne | ne | - | - | - | - | Položka je účetní |
| `nazev` | Název | string | Nazev | ne | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `cisRad` | Pořadí | integer | CisRad | ne | ANO | - | - | - | - | Pořadí |
| `typPolozkyK` | Typ položky | select | TypPolozkyK | **ANO** | ANO | 50 | - | - | - | Typ položky |
| `typSzbDphK` | Typ sazby DPH | select | TypSzbDphK | ne | ANO | 50 | - | - | - | Typ sazby DPH |
| `szbDph` | DPH [%] | numeric | SzbDph | ne | ANO | - | 6 | 2 | - | DPH [%] |
| `sumZkl` | Základ [Kč] | numeric | SumZkl | ne | ANO | - | 15 | 2 | - | Základ [Kč] |
| `sumDph` | DPH [Kč] | numeric | SumDph | ne | ANO | - | 15 | 2 | - | DPH [Kč] |
| `sumCelkem` | Celkem [Kč] | numeric | sumZkl + sumDph | ne | ANO | - | 15 | 2 | - | Celkem [Kč] |
| `sumZklMen` | Základ [měna] | numeric | SumZklMen | ne | ANO | - | 15 | 2 | - | Základ [měna] |
| `sumDphMen` | DPH [měna] | numeric | SumDphMen | ne | ANO | - | 15 | 2 | - | DPH [měna] |
| `sumCelkemMen` | Celkem [měna] | numeric | sumZklMen + sumDphMen | ne | ANO | - | 15 | 2 | - | Celkem [měna] |
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
| `clenDph` | Řádky DPH | relation | IdClenDph | ne | ANO | - | - | - | `cleneni-dph` | Řádky DPH |
| `sazbaDph` | Sazba DPH | relation | IdSazbyDph | ne | ne | - | - | - | `sazba-dph` | Sazba DPH |
| `doklInt` | Doklad | relation | IdDoklInt | ne | ne | - | - | - | `banka` | Bankovní doklad |
| `source` | Zdroj | string | Source | ne | ANO | 50 | - | - | - | Zdroj |
| `clenKonVykDph` | Řádek kontrolního hlášení DPH | relation | IdClenKonVykDph | ne | ANO | - | - | - | `cleneni-kontrolni-hlaseni` | Řádek kontrolního hlášení DPH |
| `kopClenKonVykDph` | Kopírovat řádek kon. hl. DPH | logic | KopClenKonVykDph | ne | ANO | - | - | - | - | Kopírovat řádek kontrolního hlášení DPH z dokladu |
| `dphPren` | Kód přenesení DPH | relation | IdDphPren | ne | ANO | - | - | - | `preneseni-dph` | Kód přenesení DPH |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
