# Nákupní, prodejní a skladové pohyby

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `cenikovy-pohyb-nakup` |
| **Evidence Type** | `CENIKOVE_POHYBY_NAKUP` |
| **Import Status** | DISALLOWED |
| **DB Name** | `CenikovePohyby` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/cenikovy-pohyb-nakup` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/cenikovy-pohyb-nakup/properties` |

## Vlastnosti (83)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `idCenikovePohyby` | ID | integer |  | ne | ANO | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime |  | ne | ne | - | - | - | - | Poslední změna |
| `idDokl` | ID doklad | integer |  | ne | ANO | - | - | - | - | ID doklad |
| `kodDokl` | Kód dokladu | string |  | ne | ANO | - | - | - | - | Kód dokladu |
| `modulK` | Název modulu | select |  | ne | ANO | - | - | - | - | Název modulu |
| `firmaDokl` | Firma | relation |  | ne | ANO | - | - | - | `adresar` | Firma |
| `ucetni` | Je účetní | logic |  | ne | ANO | - | - | - | - | Doklad je účetní |
| `modul` | Modul | string |  | ne | ANO | - | - | - | - | Modul |
| `kod` | Zkratka | string |  | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `eanKod` | EAN | string |  | ne | ANO | 20 | - | - | - | EAN |
| `nazev` | Název | string |  | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string |  | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string |  | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string |  | ne | ANO | 255 | - | - | - | Název FR |
| `cisRad` | Pořadí | integer |  | ne | ANO | - | - | - | - | Pořadí |
| `typPolozkyK` | Typ položky | select |  | ne | ANO | 50 | - | - | - | Typ položky |
| `baleniId` | Balení | integer |  | ne | ANO | - | 1 | - | - | Balení |
| `mnozBaleni` | Počet balení | numeric |  | ne | ANO | - | 19 | 6 | - | Počet balení |
| `mnozMj` | Množství | numeric |  | ne | ANO | - | 19 | 6 | - | Množství |
| `typCenyDphK` | Typ ceny | select |  | ne | ANO | 50 | - | - | - | Typ ceny |
| `typSzbDphK` | Sazba DPH | select |  | ne | ANO | 50 | - | - | - | Sazba DPH |
| `szbDph` | DPH [%] | numeric |  | ne | ANO | - | 6 | 2 | - | DPH [%] |
| `cenaMj` | Cena za MJ | numeric |  | ne | ANO | - | 19 | 6 | - | Cena za MJ |
| `slevaPol` | Sleva položky[%] | numeric |  | ne | ANO | - | 6 | 2 | - | Sleva položky |
| `uplSlevaDokl` | Uplatnit slevu z dokladu | logic |  | ne | ANO | - | - | - | - | Uplatnit slevu z dokladu |
| `sumZkl` | Základ [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ [Kč] |
| `sumDph` | DPH [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH [Kč] |
| `sumCelkem` | Celkem [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem [Kč] |
| `sumZklMen` | Základ [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ [měna] |
| `sumDphMen` | DPH [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH [měna] |
| `sumCelkemMen` | Celkem [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem [měna] |
| `objem` | Objem | numeric |  | ne | ANO | - | 19 | 6 | - | Objem |
| `cenJednotka` | Cen. jednotka | numeric |  | ne | ANO | - | 19 | 6 | - | Cen. jednotka |
| `typVypCenyK` | Způsob výpočtu | select |  | ne | ANO | 50 | - | - | - | Způsob výpočtu |
| `cenaMjNakup` | Nákupní cena za MJ z ceníku | numeric |  | ne | ANO | - | 19 | 6 | - | Nákupní |
| `cenaMjProdej` | Prodejní cena za MJ z ceníku | numeric |  | ne | ANO | - | 19 | 6 | - | Základní prodejní |
| `procZakl` | Marže / Přirážka / Rabat / Sleva [%] | numeric |  | ne | ANO | - | 6 | 2 | - | Marže / Přirážka / Rabat / Sleva [%] |
| `slevaMnoz` | Množstevní sleva [%] | numeric |  | ne | ANO | - | 6 | 2 | - | Množstevní sleva [%] |
| `zaokrJakK` | Způsob zaokrouhlení - Cena | select |  | ne | ANO | 50 | - | - | - | Způsob |
| `zaokrNaK` | Řád zaokrouhlení - Cena | select |  | ne | ANO | 50 | - | - | - | Řád |
| `sarze` | Šarže | string |  | ne | ANO | 100 | - | - | - | Šarže |
| `expirace` | Expirace | date |  | ne | ANO | - | - | - | - | Expirace |
| `stavUzivK` | Uživatelský stav | select |  | ne | ANO | 50 | - | - | - | Uživatelský stav |
| `objednatK` | Objednat u dodavatele | select |  | ne | ANO | 50 | - | - | - | Objednat u dodavatele |
| `rezervovat` | Rezervovat na skladě | logic |  | ne | ANO | - | - | - | - | Rezervovat na skladě |
| `mnozMjPlan` | Plán MJ | numeric |  | ne | ANO | - | 19 | 6 | - | Plánované množství |
| `mnozMjReal` | Real. MJ | numeric |  | ne | ANO | - | 19 | 6 | - | Realizované množství |
| `autoZaokr` | Zaokr. pol. | logic |  | ne | ANO | - | - | - | - | AutoZaokr |
| `autogen` | Auto. pol. | logic |  | ne | ANO | - | - | - | - | Autogen |
| `poznam` | Poznámka | string |  | ne | ANO | - | - | - | - | Poznámka |
| `slevaDokl` | Sleva [%] | numeric |  | ne | ANO | - | 6 | 2 | - | Sleva [%] |
| `datVyst` | Datum vyst. | date |  | ne | ANO | - | - | - | - | Vystaveno |
| `kopZklMdUcet` | Kopírovat MD účet základu | logic |  | ne | ANO | - | - | - | - | Kopírovat MD účet základu |
| `kopZklDalUcet` | Kopírovat D účet základu | logic |  | ne | ANO | - | - | - | - | Kopírovat D účet základu |
| `kopDphMdUcet` | Kopírovat MD účet DPH | logic |  | ne | ANO | - | - | - | - | Kopírovat MD účet DPH |
| `kopDphDalUcet` | Kopírovat D účet DPH | logic |  | ne | ANO | - | - | - | - | Kopírovat D účet DPH |
| `kopTypUcOp` | Kopírovat předpis zaúčtování | logic |  | ne | ANO | - | - | - | - | Kopírovat předpis zaúčtování |
| `kopZakazku` | Kopírovat zakázku | logic |  | ne | ANO | - | - | - | - | Kopírovat zakázku |
| `kopStred` | Kopírovat středisko | logic |  | ne | ANO | - | - | - | - | Kopírovat středisko |
| `kopKlice` | Kopírovat štítky | logic |  | ne | ANO | - | - | - | - | Kopírovat štítky |
| `kopClenDph` | Kopírovat řádek DPH | logic |  | ne | ANO | - | - | - | - | Kopírovat řádek DPH z dokladu |
| `kopCinnost` | Kopírovat činnost | logic |  | ne | ANO | - | - | - | - | Kopírovat činnost |
| `datUcto` | Datum zaúčtování | date |  | ne | ANO | - | - | - | - | Datum zaúčtování |
| `storno` | Storno | logic |  | ne | ANO | - | - | - | - | Storno |
| `stornoPol` | Storno položky | logic |  | ne | ANO | - | - | - | - | Storno položky |
| `vyrobniCislaOk` | Výr. čísla OK | logic |  | ne | ANO | - | - | - | - | Výr. čísla OK |
| `sklad` | Sklad | relation |  | ne | ANO | - | - | - | `sklad` | Sklad |
| `stredisko` | Středisko | relation |  | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `mena` | Měna | relation |  | ne | ANO | - | - | - | `mena` | Měna |
| `typUcOp` | Předpis zaúčtování | relation |  | ne | ANO | - | - | - | `predpis-zauctovani` | Předpis zaúčtování |
| `zklMdUcet` | Účet MD základ | relation |  | ne | ANO | 6 | - | - | `ucet` | Má Dáti základu |
| `zklDalUcet` | Účet Dal základ | relation |  | ne | ANO | 6 | - | - | `ucet` | Dal základu |
| `dphMdUcet` | Účet MD DPH | relation |  | ne | ANO | 6 | - | - | `ucet` | Má dáti DPH |
| `dphDalUcet` | Účet Dal DPH | relation |  | ne | ANO | 6 | - | - | `ucet` | Dal DPH |
| `cenHlad` | Cenová úroveň | relation |  | ne | ANO | - | - | - | `cenova-uroven` | Cenová úroveň |
| `zakazka` | Zakázka | relation |  | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `dodavatel` | Dodavatel | relation |  | ne | ANO | - | - | - | `adresar` | Dodavatel |
| `clenDph` | Řádky DPH | relation |  | ne | ANO | - | - | - | `cleneni-dph` | Řádky DPH |
| `cenik` | Ceník | relation |  | ne | ANO | 64 | - | - | `cenik` | Ceník |
| `mj` | MJ | relation |  | ne | ANO | - | - | - | `merna-jednotka` | MJ |
| `mjObjem` | MJ objemu | relation |  | ne | ANO | - | - | - | `merna-jednotka` | MJ objemu |
| `sazbaDph` | Sazba DPH | relation |  | ne | ANO | - | - | - | `sazba-dph` | Sazba DPH |
| `cinnost` | Činnost | relation |  | ne | ANO | - | - | - | `cinnost` | Činnost |
