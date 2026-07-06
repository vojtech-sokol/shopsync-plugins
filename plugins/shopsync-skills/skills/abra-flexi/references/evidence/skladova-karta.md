# Skladové karty

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `skladova-karta` |
| **Evidence Type** | `SKLADOVA_KARTA` |
| **Import Status** | SUPPORTED |
| **DB Name** | `sKarty` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/skladova-karta` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/skladova-karta/properties` |

## Vlastnosti (43)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdKarty | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `prumCenaTuz` | Průměrná cena [Kč] | numeric | PrumCenaTuz | ne | ne | - | 19 | 6 | - | Průměrná cena [Kč] |
| `prumCenaMen` | Průměrná cena [měna] | numeric | PrumCenaMen | ne | ne | - | 19 | 6 | - | Průměrná cena [měna] |
| `stavMJ` | Stav zásob v MJ | numeric | StavMJ | ne | ANO | - | 19 | 6 | - | Stav zásob v MJ |
| `stavTuz` | Stav zásob [Kč] | numeric | StavTuz | ne | ANO | - | 15 | 2 | - | Stav zásob [Kč] |
| `stavMen` | Stav zásob [měna] | numeric | StavMen | ne | ANO | - | 15 | 2 | - | Stav zásob [měna] |
| `datPosl` | Datum posl. pohybu | date | DatPosl | ne | ne | - | - | - | - | Datum posl. pohybu |
| `pocatMJ` | Počátek MJ | numeric | PocatMJ | ne | ne | - | 19 | 6 | - | Počátek MJ |
| `pocatTuz` | Počátek [Kč] | numeric | PocatTuz | ne | ne | - | 15 | 2 | - | Počátek [Kč] |
| `pocatMen` | Počátek [měna] | numeric | PocatMen | ne | ne | - | 15 | 2 | - | Počátek [měna] |
| `minMJ` | Min. zásoba MJ | numeric | MinMJ | ne | ANO | - | 19 | 6 | - | Min. zásoba MJ |
| `maxMJ` | Maximum | numeric | MaxMJ | ne | ANO | - | 19 | 6 | - | Max. zásoba MJ |
| `rezervMJ` | Rezervováno MJ | numeric | RezervMJ | ne | ANO | - | 19 | 6 | - | Rezervováno MJ |
| `datStavMJ` | Stav k datu MJ | numeric | DatStavMJ | ne | ne | - | 19 | 6 | - | Stav k datu MJ |
| `datStavTuz` | Stav k datu [Kč] | numeric | DatStavTuz | ne | ne | - | 15 | 2 | - | Stav k datu [Kč] |
| `datStavMen` | Stav k datu [měna] | numeric | DatStavMen | ne | ne | - | 15 | 2 | - | Stav k datu [měna] |
| `poslCenaTuz` | Poslední cena [Kč] | numeric | PoslCenaTuz | ne | ANO | - | 19 | 6 | - | Poslední cena [Kč] |
| `poslCenaMen` | Poslední cena [měna] | numeric | PoslCenaMen | ne | ANO | - | 19 | 6 | - | Poslední cena [měna] |
| `vydExpir` | Výdej dle expirace | logic | VydExpir | ne | ANO | - | - | - | - | Výdej dle expirace |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `popisA` | Popis EN | string | PopisA | ne | ANO | - | - | - | - | Popis EN |
| `popisB` | Popis DE | string | PopisB | ne | ANO | - | - | - | - | Popis DE |
| `popisC` | Popis FR | string | PopisC | ne | ANO | - | - | - | - | Popis FR |
| `poznamVelka` | Poznámka | string | PoznamVelka | ne | ANO | - | - | - | - | Poznámka |
| `nazev` | Název | string | Nazev | ne | ne | - | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ne | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ne | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ne | 255 | - | - | - | Název FR |
| `cenPopis` | Ceník - popis | string | CenPopis | ne | ANO | - | - | - | - | Ceník - popis |
| `cenPopisA` | Ceník - popis EN | string | CenPopisA | ne | ANO | - | - | - | - | Ceník - popis EN |
| `cenPopisB` | Ceník - popis DE | string | CenPopisB | ne | ANO | - | - | - | - | Ceník - popis DE |
| `cenPopisC` | Ceník - popis FR | string | CenPopisC | ne | ANO | - | - | - | - | Ceník - popis FR |
| `cenPoznam` | Ceník - poznámka | string | CenPoznam | ne | ANO | - | - | - | - | Ceník - poznámka |
| `pozadavkyMj` | Požadavky MJ | numeric | PozadavkyMj | ne | ne | - | 19 | 6 | - | Požadavky MJ |
| `stavMjSPozadavky` | Stav zásob v MJ s požadavky | numeric | StavMjSPozadavky | ne | ne | - | 19 | 6 | - | Stav zásob v MJ s požadavky |
| `dostupMj` | Dostupné množství | numeric | stavMjSPozadavky - rezervMJ | ne | ANO | - | 19 | 6 | - | Dostupné množství |
| `ucetObdobi` | Účetní období | relation | IdUcetObdobi | **ANO** | ANO | - | - | - | `ucetni-obdobi` | Účetní období |
| `cenik` | Ceník | relation | IdCenik | **ANO** | ANO | - | - | - | `cenik` | Ceník |
| `sklad` | Sklad | relation | IdSkladu | **ANO** | ANO | - | - | - | `sklad` | Sklad |
| `mistnost` | Místnost | relation | IdMistnost | ne | ANO | - | - | - | `umisteni-ve-skladu` | Místnost |
| `regal` | Regál | relation | IdRegal | ne | ANO | - | - | - | `umisteni-ve-skladu` | Regál |
| `police` | Police | relation | IdPolice | ne | ANO | - | - | - | `umisteni-ve-skladu` | Police |
