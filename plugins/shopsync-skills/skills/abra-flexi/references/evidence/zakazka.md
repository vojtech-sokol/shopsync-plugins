# Zakázky

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `zakazka` |
| **Evidence Type** | `ZAKAZKA` |
| **Import Status** | SUPPORTED |
| **DB Name** | `uZakazky` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/zakazka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/zakazka/properties` |

## Vlastnosti (41)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdZakazky | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 30 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `datZahaj` | Datum zahájení | date | DatZahaj | ne | ANO | - | - | - | - | Datum zahájení |
| `datKonec` | Datum ukončení | date | DatKonec | ne | ANO | - | - | - | - | Datum ukončení |
| `procVyh` | Procento vyhodnocení | numeric | ProcVyh | ne | ANO | - | 6 | 2 | - | Procento vyhodnocení |
| `termin` | Termín realizace | datetime | Termin | ne | ANO | - | - | - | - | Termín realizace |
| `splatDny` | Splatnost [dny] | integer | SplatDny | ne | ANO | - | - | - | - | Splatnost [dny] |
| `rozsah` | Rozsah zakázky | numeric | Rozsah | ne | ANO | - | 19 | 6 | - | Rozsah zakázky |
| `nakladyPredpoklad` | Předpokl. náklady | numeric | NakladyPredpoklad | ne | ANO | - | 19 | 6 | - | Předpokl. náklady |
| `ziskPredpoklad` | Předpokl. zisk | numeric | ZiskPredpoklad | ne | ANO | - | 19 | 6 | - | Předpokl. zisk |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `varSym` | Variabilní symbol | string | VarSym | ne | ANO | 30 | - | - | - | Variabilní symbol |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `cisObj` | Číslo objednávky | string | CisObj | ne | ANO | 30 | - | - | - | Číslo objednávky |
| `cisSml` | Číslo smlouvy | string | CisSml | ne | ANO | 30 | - | - | - | Číslo smlouvy |
| `datZahajPlan` | Plánované zahájení | date | DatZahajPlan | ne | ANO | - | - | - | - | Plánované zahájení |
| `datPredaniPlan` | Plánované předání | date | DatPredaniPlan | ne | ANO | - | - | - | - | Plánované předání |
| `datPredani` | Datum předání | date | DatPredani | ne | ANO | - | - | - | - | Datum předání |
| `zaruka` | Záruka | logic | Zaruka | ne | ANO | - | - | - | - | Záruka |
| `datZaruky` | Datum záruky | date | DatZaruky | ne | ANO | - | - | - | - | Datum záruky |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `firma` | Firma | relation | IdFirmy | ne | ANO | 20 | - | - | `adresar` | Firma |
| `mistUrc` | Místo určení | relation | IdMur | ne | ANO | - | - | - | `misto-urceni` | Místo určení |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `stavZakazky` | Stav zakázky | relation | IdStavZakazky | ne | ANO | 20 | - | - | `stav-zakazky` | Stav zakázky |
| `typZakazky` | Typ zakázky | relation | Idtypzakazky | ne | ANO | 20 | - | - | `typ-zakazky` | Typ zakázky |
| `zodpPrac` | Zodpovědný pracovník | relation | IdUzivatel | ne | ANO | 254 | - | - | `uzivatel` | Zodpovědný pracovník |
| `vyhZakazky` | Vyhodnocení zakázky | relation | IdVyhZakazky | ne | ANO | 20 | - | - | `hodnoceni-zakazky` | Vyhodnocení zakázky |
| `kontaktOsoba` | Kontaktní osoba | relation | IdKontaktOsoba | ne | ANO | - | - | - | `kontakt` | Kontaktní osoba |
| `mena` | Měna | relation | IdMena | ne | ANO | - | - | - | `mena` | Měna |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
