# Adresy firem

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `adresar` |
| **Evidence Type** | `ADRESAR` |
| **Import Status** | SUPPORTED |
| **DB Name** | `aAdresar` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/adresar` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/adresar/properties` |

## Vlastnosti (68)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdFirmy | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Upozornění | string | Poznam | ne | ANO | - | - | - | - | Upozornění |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `ulice` | Ulice | string | Ulice | ne | ANO | 255 | - | - | - | Ulice |
| `mesto` | Město | string | Mesto | ne | ANO | 255 | - | - | - | Město |
| `psc` | PSČ | string | Psc | ne | ANO | 255 | - | - | - | PSČ |
| `tel` | Telefon | string | Tel | ne | ANO | 255 | - | - | - | Telefon |
| `mobil` | Mobil | string | Mobil | ne | ANO | 255 | - | - | - | Mobil |
| `fax` | Fax | string | Fax | ne | ANO | 255 | - | - | - | Fax |
| `email` | E-mail | string | Email | ne | ANO | 255 | - | - | - | E-mail |
| `www` | WWW | string | Www | ne | ANO | 255 | - | - | - | WWW |
| `stat` | Stát | relation | IdStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `region` | Kraj | relation | Idregion | ne | ANO | - | - | - | `region` | Kraj |
| `eanKod` | EAN | string | EanKod | ne | ANO | 20 | - | - | - | EAN |
| `ic` | IČO | string | Ic | ne | ANO | 20 | - | - | - | IČO |
| `dic` | DIČ | string | Dic | ne | ANO | 20 | - | - | - | DIČ |
| `vatId` | IČ DPH | string | VatId | ne | ANO | 20 | - | - | - | IČ DPH |
| `postovniShodna` | Poštovní adresa je shodná se sídlem | logic | PostovniShodna | ne | ANO | - | - | - | - | Poštovní adresa je shodná se sídlem |
| `faEanKod` | Pošt. EAN | string | FaEanKod | ne | ANO | 20 | - | - | - | EAN |
| `faJmenoFirmy` | Pošt. jméno firmy | string | FaJmenoFirmy | ne | ANO | 255 | - | - | - | Firma |
| `faUlice` | Pošt. ulice | string | FaUlice | ne | ANO | 255 | - | - | - | Ulice |
| `faMesto` | Pošt. město | string | FaMesto | ne | ANO | 255 | - | - | - | Město |
| `faPsc` | Pošt. PSČ | string | FaPsc | ne | ANO | 255 | - | - | - | PSČ |
| `splatDny` | Splatnost [dny] | integer | SplatDny | ne | ANO | - | - | - | - | Splatnost [dny] |
| `limitFak` | Limit fakt. | numeric | LimitFak | ne | ANO | - | 12 | 2 | - | Limit fakturace |
| `limitPoSplatDny` | Maximální počet dnů po splatnosti | integer | LimitPoSplatDny | ne | ANO | - | - | - | - | Maximální počet dnů po splatnosti |
| `limitPoSplatZakaz` | Zákaz prodeje po překročení splatnosti | logic | LimitPoSplatZakaz | ne | ANO | - | - | - | - | Zákaz prodeje po překročení splatnosti |
| `platceDph` | Plátce DPH | logic | PlatceDph | ne | ANO | - | - | - | - | Plátce DPH |
| `formExportK` | Formát exportu | select | FormExportK | ne | ANO | 50 | - | - | - | Formát exportu |
| `typVztahuK` | Typ vztahu | select | TypVztahuK | ne | ANO | 50 | - | - | - | Typ vztahu |
| `kodPojistovny` | Kód pro tisky | string | KodPojistovny | ne | ANO | 20 | - | - | - | Kód pro tisky |
| `nazevPojistovny` | Název pro tisky | string | NazevPojistovny | ne | ANO | 255 | - | - | - | Název pro tisky |
| `osloveni` | Oslovení | string | Osloveni | ne | ANO | - | - | - | - | Oslovení |
| `slevaDokl` | Sleva [%] | numeric | SlevaDokl | ne | ANO | - | 6 | 2 | - | Sleva [%] |
| `obpAutomHotovo` | Při částečné fakturaci objednávky označit za hotovou | logic | ObpAutomHotovo | ne | ANO | - | - | - | - | Při částečné fakturaci objednávky označit za hotovou |
| `nazev2` | Název - druhá řádka | string | Nazev2 | ne | ANO | 255 | - | - | - | Název - druhá řádka |
| `nazev2A` | Název - druhá řádka EN | string | Nazev2A | ne | ANO | 255 | - | - | - | Název - druhá řádka EN |
| `nazev2B` | Název - druhá řádka DE | string | Nazev2B | ne | ANO | 255 | - | - | - | Název - druhá řádka DE |
| `nazev2C` | Název - druhá řádka FR | string | Nazev2C | ne | ANO | 255 | - | - | - | Název - druhá řádka FR |
| `nespolehlivyPlatce` | Nespolehlivý plátce | logic | NespolehlivyPlatce | ne | ANO | - | - | - | - | Nespolehlivý plátce |
| `revize` | Revize | integer | Revize | ne | ANO | - | - | - | - | Revize |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `katastrUzemi` | Katastrální území | string | KatastrUzemi | ne | ANO | 255 | - | - | - | Katastrální území |
| `parcela` | Parcela | string | Parcela | ne | ANO | 255 | - | - | - | Parcela |
| `datNaroz` | Datum narození | date | DatNaroz | ne | ANO | - | - | - | - | Datum narození |
| `rodCis` | Rodné číslo | string | RodCis | ne | ANO | 20 | - | - | - | Rodné číslo |
| `datZaloz` | Datum založení | date | DatZaloz | ne | ANO | - | - | - | - | Datum založení |
| `canceled` | Zrušení | logic | Canceled | ne | ANO | - | - | - | - | Zrušení |
| `isdocPrilohaMailuK` | ISDOC v e-mailu | select | IsdocPrilohaMailuK | ne | ANO | 50 | - | - | - | ISDOC v e-mailu |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `skupFir` | Skupina | relation | IdSkupFir | ne | ANO | - | - | - | `skupina-firem` | Skupina |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `faStat` | Pošt. stát | relation | IdFaStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `faRegion` | Pošt. kraj | relation | Idfaregion | ne | ANO | - | - | - | `region` | Kraj |
| `zodpOsoba` | Zodpovědná osoba | relation | IdZodpOsoba | ne | ANO | 254 | - | - | `uzivatel` | Zodpovědná osoba |
| `skupCen` | Ceníková skupina | relation | IdSkupCen | ne | ANO | - | - | - | `cenikova-skupina` | Ceníková skupina |
| `formaUhradyCis` | Forma úhrady | relation | IdFormaUhradyCis | ne | ANO | - | - | - | `forma-uhrady` | Forma úhrady |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
