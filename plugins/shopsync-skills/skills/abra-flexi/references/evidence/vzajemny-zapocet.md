# Vzájemné zápočty

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `vzajemny-zapocet` |
| **Evidence Type** | `VZAJEMNY_ZAPOCET` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dDoklInt` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/vzajemny-zapocet` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/vzajemny-zapocet/properties` |

## Vlastnosti (109)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDoklInt | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | idUziv | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `kod` | Interní číslo | string | Kod | **ANO** | ANO | 20 | - | - | - | Interní číslo |
| `zamekK` | Zámek | select | ZamekK | ne | ne | 50 | - | - | - | Zámek |
| `typPohybuK` | Typ pohybu | select | TypPohybuK | **ANO** | ANO | 50 | - | - | - | Typ pohybu |
| `cisDosle` | Číslo došlé | string | CisDosle | ne | ANO | 40 | - | - | - | Číslo došlé |
| `varSym` | Variabilní symbol | string | VarSym | ne | ANO | 30 | - | - | - | Variabilní symbol |
| `cisObj` | Ref. číslo | string | CisObj | ne | ANO | 2000 | - | - | - | Ref. číslo |
| `datVyst` | Vystaveno | date | DatVyst | **ANO** | ANO | - | - | - | - | Vystaveno |
| `duzpPuv` | Datum zdaň. plnění | date | DuzpPuv | ne | ANO | - | - | - | - | Datum zdaň. plnění |
| `duzpUcto` | Uplatnit zdaň. plnění | date | DuzpUcto | ne | ANO | - | - | - | - | Uplatnit zdaň. plnění |
| `datSazbyDph` | Datum sazeb DPH | date | DatSazbyDph | ne | ANO | - | - | - | - | Datum sazeb DPH |
| `popis` | Popis | string | Popis | ne | ANO | 255 | - | - | - | Popis |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `sumOsv` | Osvob., bez DPH [Kč] | numeric | SumOsv | ne | ANO | - | 15 | 2 | - | 0 % |
| `sumZklSniz` | Základ DPH sníž. [Kč] | numeric | SumZklSniz | ne | ANO | - | 15 | 2 | - | Základ DPH sníž. [Kč] |
| `sumZklSniz2` | Základ DPH 2. sníž. [Kč] | numeric | SumZklSniz2 | ne | ANO | - | 15 | 2 | - | Základ DPH 2. sníž. [Kč] |
| `sumZklZakl` | Základ DPH zákl. [Kč] | numeric | SumZklZakl | ne | ANO | - | 15 | 2 | - | Základ DPH zákl. [Kč] |
| `sumZklCelkem` | Základ celkem [Kč] | numeric | sumOsv + sumZklSniz + sumZklSniz2 + sumZklZakl | ne | ne | - | 15 | 2 | - | Základ |
| `sumDphSniz` | DPH snížená [Kč] | numeric | SumDphSniz | ne | ANO | - | 15 | 2 | - | DPH snížená |
| `sumDphSniz2` | DPH 2. snížená [Kč] | numeric | SumDphSniz2 | ne | ANO | - | 15 | 2 | - | DPH 2. snížená |
| `sumDphZakl` | DPH základní [Kč] | numeric | SumDphZakl | ne | ANO | - | 15 | 2 | - | DPH základní |
| `sumDphCelkem` | DPH celkem [Kč] | numeric | sumDphSniz + sumDphSniz2 + sumDphZakl | ne | ne | - | 15 | 2 | - | DPH |
| `sumCelkSniz` | Celkem vč. DPH - sníž. [Kč] | numeric | sumZklSniz + sumDphSniz | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - sníž. [Kč] |
| `sumCelkSniz2` | Celkem vč. DPH - 2. sníž. [Kč] | numeric | sumZklSniz2 + sumDphSniz2 | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - 2. sníž. [Kč] |
| `sumCelkZakl` | Celkem vč. DPH - zákl. [Kč] | numeric | sumZklZakl + sumDphZakl | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - zákl. [Kč] |
| `sumCelkem` | Celkem [Kč] | numeric | SumCelkem | ne | ANO | - | 15 | 2 | - | Celkem [Kč] |
| `sumOsvMen` | Osvob., bez DPH [měna] | numeric | SumOsvMen | ne | ANO | - | - | - | - | 0 % |
| `sumZklSnizMen` | Základ DPH sníž. [měna] | numeric | SumZklSnizMen | ne | ANO | - | 15 | 2 | - | Základ DPH sníž. [měna] |
| `sumZklSniz2Men` | Základ DPH 2. sníž. [měna] | numeric | SumZklSniz2Men | ne | ANO | - | 15 | 2 | - | Základ DPH 2. sníž. [měna] |
| `sumZklZaklMen` | Základ DPH zákl. [měna] | numeric | SumZklZaklMen | ne | ANO | - | 15 | 2 | - | Základ DPH zákl. [měna] |
| `sumZklCelkemMen` | Základ celkem [měna] | numeric | sumOsvMen + sumZklSnizMen + sumZklSniz2Men + sumZklZaklMen | ne | ne | - | 15 | 2 | - | Základ |
| `sumDphZaklMen` | DPH základní [měna] | numeric | SumDphZaklMen | ne | ANO | - | 15 | 2 | - | DPH základní |
| `sumDphSnizMen` | DPH snížená [měna] | numeric | SumDphSnizMen | ne | ANO | - | 15 | 2 | - | DPH snížená |
| `sumDphSniz2Men` | DPH 2. snížená [měna] | numeric | SumDphSniz2Men | ne | ANO | - | 15 | 2 | - | DPH 2. snížená |
| `sumDphCelkemMen` | DPH celkem [měna] | numeric | sumDphSnizMen + sumDphSniz2Men + sumDphZaklMen | ne | ne | - | 15 | 2 | - | DPH |
| `sumCelkSnizMen` | Celkem vč. DPH - sníž. [měna] | numeric | sumZklSnizMen + sumDphSnizMen | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - sníž. [měna] |
| `sumCelkSniz2Men` | Celkem vč. DPH - 2. sníž. [měna] | numeric | sumZklSniz2Men + sumDphSniz2Men | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - 2. sníž. [měna] |
| `sumCelkZaklMen` | Celkem vč. DPH - zákl. [měna] | numeric | sumZklZaklMen + sumDphZaklMen | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - zákl. [měna] |
| `sumCelkemMen` | Celkem [měna] | numeric | SumCelkemMen | ne | ANO | - | 15 | 2 | - | Celkem [měna] |
| `kurz` | Kurz | numeric | Kurz | ne | ANO | - | 19 | 6 | - | Kurz |
| `kurzMnozstvi` | Kurz. množství | numeric | KurzMnozstvi | ne | ANO | - | 19 | 6 | - | Kurz. množství |
| `stavUzivK` | Uživatelský stav | select | StavUzivK | ne | ANO | 50 | - | - | - | Uživatelský stav |
| `nazFirmy` | Název firmy nebo jméno osoby | string | NazFirmy | ne | ANO | 255 | - | - | - | Název firmy - jméno |
| `ulice` | Ulice | string | Ulice | ne | ANO | 255 | - | - | - | Ulice |
| `mesto` | Město | string | Mesto | ne | ANO | 255 | - | - | - | Město |
| `psc` | PSČ | string | Psc | ne | ANO | 255 | - | - | - | PSČ |
| `eanKod` | EAN | string | EanKod | ne | ANO | 20 | - | - | - | EAN |
| `ic` | IČO | string | Ic | ne | ANO | 20 | - | - | - | IČO |
| `dic` | DIČ | string | Dic | ne | ANO | 20 | - | - | - | DIČ |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `buc` | Číslo bank. účtu | string | Buc | ne | ANO | 255 | - | - | - | Číslo účtu |
| `iban` | IBAN | string | Iban | ne | ANO | 255 | - | - | - | IBAN |
| `bic` | BIC | string | Bic | ne | ANO | 255 | - | - | - | BIC |
| `specSym` | Specifický symbol | string | SpecSym | ne | ANO | 255 | - | - | - | Specifický symbol |
| `bezPolozek` | Bezpoložkový doklad | logic | BezPolozek | ne | ANO | - | - | - | - | bezpoložkový doklad |
| `ucetni` | Je účetní | logic | Ucetni | ne | ne | - | - | - | - | Doklad je účetní |
| `szbDphSniz` | Snížená sazba DPH | numeric | SzbDphSniz | ne | ANO | - | 6 | 2 | - | Snížená |
| `szbDphSniz2` | 2. snížená sazba DPH | numeric | SzbDphSniz2 | ne | ANO | - | 6 | 2 | - | 2. snížená |
| `szbDphZakl` | Základní sazba DPH | numeric | SzbDphZakl | ne | ANO | - | 6 | 2 | - | Základní |
| `uzpTuzemsko` | Místo plnění tuzemsko | logic | UzpTuzemsko | ne | ANO | - | - | - | - | Místo plnění tuzemsko |
| `zuctovano` | Zaúčtováno | logic | Zuctovano | ne | ne | - | - | - | - | Stav zaúčtování |
| `datUcto` | Datum zaúčtování | date | DatUcto | ne | ANO | - | - | - | - | Datum zaúčtování |
| `vyloucitSaldo` | Vynechat ze salda | logic | VyloucitSaldo | ne | ANO | - | - | - | - | Vynechat ze salda |
| `storno` | Storno | logic | Storno | ne | ne | - | - | - | - | Storno |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `typDokl` | Typ dokladu | relation | IdTypDokl | **ANO** | ANO | - | - | - | `typ-vzajemnych-zapoctu` | Typ dokladu |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
| `konSym` | Konstantní symbol | relation | IdKonSym | ne | ANO | - | - | - | `konst-symbol` | Konstantní symbol |
| `firma` | Firma | relation | IdFirmy | ne | ANO | 20 | - | - | `adresar` | Firma |
| `stat` | Stát | relation | IdStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `region` | Kraj | relation | Idregion | ne | ANO | - | - | - | `region` | Kraj |
| `banSpojDod` | Účet firmy | relation | IdBanSpojDod | ne | ANO | - | - | - | `adresar-bankovni-ucet` | Účet firmy |
| `typUcOp` | Předpis zaúčtování | relation | IdTypUcOp | ne | ANO | - | - | - | `predpis-zauctovani` | Předpis zaúčtování |
| `primUcet` | Účet banky | relation | IdPrimUcet | ne | ANO | 6 | - | - | `ucet` | Účet banky |
| `protiUcet` | Protiúčet | relation | IdProtiUcet | ne | ANO | 6 | - | - | `ucet` | Protiúčet |
| `dphZaklUcet` | Účet DPH základní sazba | relation | IdDphZaklUcet | ne | ANO | 6 | - | - | `ucet` | DPH základní |
| `dphSnizUcet` | Účet DPH snížená sazba | relation | IdDphSnizUcet | ne | ANO | 6 | - | - | `ucet` | DPH snížená |
| `dphSniz2Ucet` | Účet DPH 2. snížená sazba | relation | IdDphSniz2Ucet | ne | ANO | 6 | - | - | `ucet` | DPH 2. snížená |
| `smerKod` | Kód banky | relation | IdSmerKod | ne | ANO | 20 | - | - | `penezni-ustav` | Kód banky |
| `statDph` | Stát DPH | relation | IdStatDph | ne | ANO | 3 | - | - | `stat-dph` | Stát DPH |
| `clenDph` | Řádky DPH | relation | IdClenDph | ne | ANO | - | - | - | `cleneni-dph` | Řádky DPH |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `uzivatel` | Uživatel | relation | IdUziv | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
| `zodpOsoba` | Zodpovědná osoba | relation | IdZodpOsoba | ne | ANO | 254 | - | - | `uzivatel` | Zodpovědná osoba |
| `kontaktOsoba` | Kontaktní osoba | relation | IdKontaktOsoba | ne | ANO | - | - | - | `kontakt` | Kontaktní osoba |
| `kontaktJmeno` | Kontaktní jméno | string | KontaktJmeno | ne | ANO | 255 | - | - | - | Jméno |
| `kontaktEmail` | Kontaktní e-mail | string | KontaktEmail | ne | ANO | 255 | - | - | - | E-mail |
| `kontaktTel` | Kontaktní telefon | string | KontaktTel | ne | ANO | 255 | - | - | - | Telefon |
| `rada` | Čís. řada | relation | IdRady | ne | ANO | - | - | - | `rada-banka` | Čís. řada |
| `sazbaDphOsv` | Osvobozená sazba DPH | relation | IdSazbyDphOsv | ne | ne | - | - | - | `sazba-dph` | Osvobozená sazba DPH |
| `sazbaDphSniz` | Snížená sazba DPH | relation | IdSazbyDphSniz | ne | ne | - | - | - | `sazba-dph` | Snížená sazba DPH |
| `sazbaDphSniz2` | 2. snížená sazba DPH | relation | IdSazbyDphSniz2 | ne | ne | - | - | - | `sazba-dph` | 2. snížená sazba DPH |
| `sazbaDphZakl` | Základní sazba DPH | relation | IdSazbyDphZakl | ne | ne | - | - | - | `sazba-dph` | Základní sazba DPH |
| `uuid` | Uuid | string | Uuid | ne | ne | 50 | - | - | - | Univerzální unikátní identifikátor |
| `source` | Zdroj | string | Source | ne | ANO | 50 | - | - | - | Zdroj |
| `clenKonVykDph` | Řádek kontrolního hlášení DPH | relation | IdClenKonVykDph | ne | ANO | - | - | - | `cleneni-kontrolni-hlaseni` | Řádek kontrolního hlášení DPH |
| `jakUhrK` | Jak uhrazeno | select | JakUhrK | ne | ANO | 50 | - | - | - | Jak uhrazeno |
| `sparovano` | Spárováno | logic | Sparovano | ne | ne | - | - | - | - | Spárováno |
| `zapocet` | Zápočet | logic | Zapocet | ne | ANO | - | - | - | - | Zápočet |
| `vypisCisDokl` | Číslo dokladu banky | string | VypisCisDokl | ne | ANO | 50 | - | - | - | Číslo dokladu banky |
| `menaAlt` | Alt. měna | relation | IdMenyAlt | ne | ne | - | - | - | `mena` | Alt. měna |
| `sumCelkemAlt` | Celkem [alt. měna] | numeric | SumCelkemAlt | ne | ne | - | 15 | 2 | - | Celkem [alt. měna] |
| `cisSouhrnne` | Čís. výpisu | string | CisSouhrnne | ne | ANO | 30 | - | - | - | Čís. výpisu |
