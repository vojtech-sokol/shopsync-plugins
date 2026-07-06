# Příjemky/výdejky

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `skladovy-pohyb` |
| **Evidence Type** | `SKLADOVY_POHYB` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dDoklSklad` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/skladovy-pohyb` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/skladovy-pohyb/properties` |

## Vlastnosti (88)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDoklSklad | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | idUziv | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `kod` | Interní číslo | string | Kod | **ANO** | ANO | 20 | - | - | - | Interní číslo |
| `zamekK` | Zámek | select | ZamekK | ne | ne | 50 | - | - | - | Zámek |
| `typPohybuK` | Typ pohybu | select | TypPohybuK | **ANO** | ANO | 50 | - | - | - | Typ pohybu |
| `varSym` | Variabilní symbol | string | VarSym | ne | ANO | 30 | - | - | - | Variabilní symbol |
| `cisObj` | Číslo objednávky | string | CisObj | ne | ANO | 2000 | - | - | - | Číslo objednávky |
| `cisDodak` | Dodací list | string | CisDodak | ne | ANO | 30 | - | - | - | Dodací list |
| `doprava` | Doprava a vyskladnění | string | Doprava | ne | ANO | - | - | - | - | Doprava a vyskladnění |
| `datVyst` | Datum vystavení | date | DatVyst | **ANO** | ANO | - | - | - | - | Datum vystavení |
| `popis` | Popis | string | Popis | ne | ANO | 255 | - | - | - | Popis |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `uvodTxt` | Úvodní text (tiskne se před položkami) | string | UvodTxt | ne | ANO | - | - | - | - | Úvodní text (tiskne se před položkami) |
| `zavTxt` | Závěrečný text (tiskne se za položkami) | string | ZavTxt | ne | ANO | - | - | - | - | Závěrečný text (tiskne se za položkami) |
| `sumOsv` | Osvob., bez DPH [Kč] | numeric | SumOsv | ne | ne | - | 15 | 2 | - | 0 % |
| `sumZklCelkem` | Základ celkem [Kč] | numeric | sumOsv + sumZklSniz + sumZklSniz2 + sumZklZakl | ne | ne | - | 15 | 2 | - | Základ |
| `sumCelkem` | Celkem [Kč] | numeric | SumCelkem | ne | ne | - | 15 | 2 | - | Celkem [Kč] |
| `sumOsvMen` | Osvob., bez DPH [měna] | numeric | SumOsvMen | ne | ne | - | - | - | - | 0 % |
| `sumZklCelkemMen` | Základ celkem [měna] | numeric | sumOsvMen + sumZklSnizMen + sumZklSniz2Men + sumZklZaklMen | ne | ne | - | 15 | 2 | - | Základ |
| `sumCelkemMen` | Celkem [měna] | numeric | SumCelkemMen | ne | ne | - | 15 | 2 | - | Celkem [měna] |
| `kurz` | Kurz | numeric | Kurz | ne | ANO | - | 19 | 6 | - | Kurz |
| `kurzMnozstvi` | Kurz. množství | numeric | KurzMnozstvi | ne | ANO | - | 19 | 6 | - | Kurz. množství |
| `nazFirmy` | Název firmy nebo jméno osoby | string | NazFirmy | ne | ANO | 255 | - | - | - | Název firmy - jméno |
| `faNazev2` | Název firmy - druhá řádka | string |  | ne | ne | 255 | - | - | - | Název firmy - druhá řádka |
| `ulice` | Ulice | string | Ulice | ne | ANO | 255 | - | - | - | Ulice |
| `mesto` | Město | string | Mesto | ne | ANO | 255 | - | - | - | Město |
| `psc` | PSČ | string | Psc | ne | ANO | 255 | - | - | - | PSČ |
| `region` | Kraj | relation | Idregion | ne | ANO | - | - | - | `region` | Kraj |
| `faRegion` | Pošt. kraj | relation | Idfaregion | ne | ANO | - | - | - | `region` | Kraj |
| `eanKod` | EAN | string | EanKod | ne | ANO | 20 | - | - | - | EAN |
| `ic` | IČO | string | Ic | ne | ANO | 20 | - | - | - | IČO |
| `dic` | DIČ | string | Dic | ne | ANO | 20 | - | - | - | DIČ |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `postovniShodna` | Poštovní adresa je shodná se sídlem | logic | PostovniShodna | ne | ANO | - | - | - | - | Poštovní adresa je shodná se sídlem |
| `faNazev` | Pošt. jméno firmy | string | FaNazev | ne | ANO | 255 | - | - | - | Firma |
| `faUlice` | Pošt. ulice | string | FaUlice | ne | ANO | 255 | - | - | - | Ulice |
| `faMesto` | Pošt. město | string | FaMesto | ne | ANO | 255 | - | - | - | Město |
| `faPsc` | Pošt. PSČ | string | FaPsc | ne | ANO | 255 | - | - | - | PSČ |
| `faStat` | Pošt. stát | relation | IdFaStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `faEanKod` | Pošt. EAN | string | FaEanKod | ne | ANO | 20 | - | - | - | EAN |
| `bezPolozek` | Bezpoložkový doklad | logic | BezPolozek | ne | ANO | - | - | - | - | bezpoložkový doklad |
| `ucetni` | Je účetní | logic | Ucetni | ne | ne | - | - | - | - | Doklad je účetní |
| `zuctovano` | Zaúčtováno | logic | Zuctovano | ne | ne | - | - | - | - | Stav zaúčtování |
| `datUcto` | Datum zaúčtování | date | DatUcto | ne | ANO | - | - | - | - | Datum zaúčtování |
| `storno` | Storno | logic | Storno | ne | ne | - | - | - | - | Storno |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `hromFakt` | Hrom. fakturace | logic | HromFakt | ne | ANO | - | - | - | - | Hrom. fakturace |
| `typDokl` | Typ dokladu | relation | IdTypDokl | **ANO** | ANO | - | - | - | `typ-skladovy-pohyb` | Typ dokladu |
| `sklad` | Sklad | relation | IdBsp | **ANO** | ANO | - | - | - | `sklad` | Sklad |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
| `firma` | Firma | relation | IdFirmy | ne | ANO | - | - | - | `adresar` | Firma |
| `stat` | Stát | relation | IdStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `mistUrc` | Místo určení | relation | IdMur | ne | ANO | - | - | - | `misto-urceni` | Místo určení |
| `typUcOp` | Předpis zaúčtování | relation | IdTypUcOp | ne | ANO | - | - | - | `predpis-zauctovani` | Předpis zaúčtování |
| `primUcet` | Účet skladu | relation | IdPrimUcet | ne | ANO | 6 | - | - | `ucet` | Účet skladu |
| `protiUcet` | Protiúčet | relation | IdProtiUcet | ne | ANO | 6 | - | - | `ucet` | Protiúčet |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `statOdesl` | Stát odesl. | relation | IdStatOdesl | ne | ANO | 3 | - | - | `stat` | Stát odesl. |
| `statUrc` | Stát určení | relation | IdStatUrc | ne | ANO | 3 | - | - | `stat` | Stát určení |
| `statPuvod` | Stát původu | relation | IdStatPuvod | ne | ANO | 3 | - | - | `stat` | Stát původu |
| `dodPodm` | Podmínky dodání | relation | IdDodPodm | ne | ANO | - | - | - | `intrastat-dodaci-podminky` | Podmínky dodání |
| `obchTrans` | Transakce | relation | IdObchTrans | ne | ANO | - | - | - | `intrastat-obchodni-transakce` | Transakce |
| `druhDopr` | Druh dopravy | relation | IdDruhDopr | ne | ANO | - | - | - | `intrastat-druh-dopravy` | Druh dopravy |
| `zvlPoh` | Zvláštní pohyby | relation | IdZvlPoh | ne | ANO | - | - | - | `intrastat-zvlastni-pohyb` | Zvláštní pohyby |
| `krajUrc` | Kraj odesílatele | relation | IdKrajUrc | ne | ANO | - | - | - | `intrastat-kraj-urceni` | Kraj odesílatele |
| `uzivatel` | Uživatel | relation | IdUziv | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
| `zodpOsoba` | Zodpovědná osoba | relation | IdZodpOsoba | ne | ANO | 254 | - | - | `uzivatel` | Zodpovědná osoba |
| `kontaktOsoba` | Kontaktní osoba | relation | IdKontaktOsoba | ne | ANO | - | - | - | `kontakt` | Kontaktní osoba |
| `kontaktJmeno` | Kontaktní jméno | string | KontaktJmeno | ne | ANO | 255 | - | - | - | Jméno |
| `kontaktEmail` | Kontaktní e-mail | string | KontaktEmail | ne | ANO | 255 | - | - | - | E-mail |
| `kontaktTel` | Kontaktní telefon | string | KontaktTel | ne | ANO | 255 | - | - | - | Telefon |
| `rada` | Čís. řada | relation | IdRady | ne | ANO | - | - | - | `rada-skladovy-pohyb` | Čís. řada |
| `zdrojProFak` | Zdroj pro faktury | logic | ZdrojProFak | **ANO** | ANO | - | - | - | - | Zdroj pro faktury |
| `stavSkladK` | Stav dokladu | select | StavSkladK | ne | ANO | 50 | - | - | - | Stav dokladu |
| `typPohybuSkladK` | Typ pohybu + upřesnění | select | TypPohybuSkladK | ne | ANO | 50 | - | - | - | Typ pohybu + upřesnění |
| `typDoklSkl` | Typ skladového dokladu | relation | IdTypDoklSkl | ne | ANO | - | - | - | `typ-skladovy-pohyb` | Typ skladového dokladu |
| `formaDopravy` | Forma dopravy | relation | IdFormaDopravy | ne | ANO | - | - | - | `forma-dopravy` | Forma dopravy |
| `uuid` | Uuid | string | Uuid | ne | ne | 50 | - | - | - | Univerzální unikátní identifikátor |
| `source` | Zdroj | string | Source | ne | ANO | 50 | - | - | - | Zdroj |
| `vyloucitSaldo` | Vynechat ze salda | logic | VyloucitSaldo | ne | ANO | - | - | - | - | Vynechat ze salda |
| `skladCil` | Sklad cíl | relation | IdSkladCil | ne | ANO | - | - | - | `sklad` | Sklad cíl |
| `inventura` | Inventura | relation | IdInventura | ne | ANO | - | - | - | `inventura` | Inventura |
| `branchId` | ID výdejního místa | string | BranchId | ne | ANO | 255 | - | - | - | ID výdejního místa |
