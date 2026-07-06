# Ostatní pohledávky

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `pohledavka` |
| **Evidence Type** | `POHLEDAVKA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dDoklFak` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/pohledavka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/pohledavka/properties` |

## Vlastnosti (146)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDoklFak | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | idUziv | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `kod` | Interní číslo | string | Kod | **ANO** | ANO | 20 | - | - | - | Interní číslo |
| `zamekK` | Zámek | select | ZamekK | ne | ne | 50 | - | - | - | Zámek |
| `cisDosle` | Číslo došlé | string | CisDosle | ne | ANO | 40 | - | - | - | Číslo došlé |
| `varSym` | Variabilní symbol | string | VarSym | **ANO** | ANO | 30 | - | - | - | Variabilní symbol |
| `cisSml` | Číslo smlouvy | string | CisSml | ne | ANO | 30 | - | - | - | Číslo smlouvy |
| `cisObj` | Číslo objednávky | string | CisObj | ne | ANO | 2000 | - | - | - | Číslo objednávky |
| `datObj` | Objednáno | date | DatObj | ne | ANO | - | - | - | - | Objednáno |
| `cisDodak` | Dodací list | string | CisDodak | ne | ANO | 30 | - | - | - | Dodací list |
| `doprava` | Doprava a vyskladnění | string | Doprava | ne | ANO | - | - | - | - | Doprava a vyskladnění |
| `datVyst` | Vystaveno | date | DatVyst | **ANO** | ANO | - | - | - | - | Vystaveno |
| `duzpPuv` | Datum zdaň. plnění | date | DuzpPuv | ne | ANO | - | - | - | - | Datum zdaň. plnění |
| `duzpUcto` | Uplatnit zdaň. plnění | date | DuzpUcto | ne | ANO | - | - | - | - | Uplatnit zdaň. plnění |
| `datSplat` | Splatnost | date | DatSplat | ne | ANO | - | - | - | - | Splatnost |
| `datUhr` | Datum úhrady | date | DatUhr | ne | ne | - | - | - | - | Datum úhrady |
| `datTermin` | Termín | date | DatTermin | ne | ANO | - | - | - | - | Termín |
| `datReal` | Realizace | date | DatReal | ne | ANO | - | - | - | - | Realizace |
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
| `sumCelkem` | Celkem [Kč] | numeric | SumCelkem | ne | ANO | - | 15 | 2 | - | Celkem |
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
| `sumCelkemMen` | Celkem [měna] | numeric | SumCelkemMen | ne | ANO | - | 15 | 2 | - | Celkem |
| `kurz` | Kurz | numeric | Kurz | ne | ANO | - | 19 | 6 | - | Kurz |
| `kurzMnozstvi` | Kurz. množství | numeric | KurzMnozstvi | ne | ANO | - | 19 | 6 | - | Kurz. množství |
| `stavUzivK` | V příkazu ? | select | StavUzivK | ne | ANO | 50 | - | - | - | V příkazu ? |
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
| `typDokl` | Typ pohl. | relation | IdTypDokl | **ANO** | ANO | - | - | - | `typ-pohledavky` | Typ pohl. |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
| `konSym` | Konst. sym. | relation | IdKonSym | ne | ANO | - | - | - | `konst-symbol` | Kon. sym. |
| `firma` | Firma | relation | IdFirmy | ne | ANO | 20 | - | - | `adresar` | Firma |
| `stat` | Stát | relation | IdStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `region` | Kraj | relation | Idregion | ne | ANO | - | - | - | `region` | Kraj |
| `banSpojDod` | Účet odběratele | relation | IdBanSpojDod | ne | ANO | - | - | - | `adresar-bankovni-ucet` | Účet odběratele |
| `bankovniUcet` | Bankovní účet | relation | IdBspBan | ne | ANO | - | - | - | `bankovni-ucet` | Bankovní účet |
| `typUcOp` | Předpis zaúčtování | relation | IdTypUcOp | ne | ANO | - | - | - | `predpis-zauctovani` | Předpis zaúčtování |
| `primUcet` | Účet MD | relation | IdPrimUcet | ne | ANO | 6 | - | - | `ucet` | Účet MD |
| `protiUcet` | Účet DAL | relation | IdProtiUcet | ne | ANO | 6 | - | - | `ucet` | Účet DAL |
| `dphZaklUcet` | Účet DPH základní sazba | relation | IdDphZaklUcet | ne | ANO | 6 | - | - | `ucet` | DPH základní |
| `dphSnizUcet` | Účet DPH snížená sazba | relation | IdDphSnizUcet | ne | ANO | 6 | - | - | `ucet` | DPH snížená |
| `dphSniz2Ucet` | Účet DPH 2. snížená sazba | relation | IdDphSniz2Ucet | ne | ANO | 6 | - | - | `ucet` | DPH 2. snížená |
| `smerKod` | Směr.kód | relation | IdSmerKod | ne | ANO | 20 | - | - | `penezni-ustav` | Směr.kód |
| `statDph` | Stát DPH | relation | IdStatDph | ne | ANO | 3 | - | - | `stat-dph` | Stát DPH |
| `clenDph` | Řádky DPH | relation | IdClenDph | ne | ANO | - | - | - | `cleneni-dph` | Řádky DPH |
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
| `rada` | Čís. řada | relation | IdRady | ne | ANO | - | - | - | `rada-pohledavky` | Čís. řada |
| `sazbaDphOsv` | Osvobozená sazba DPH | relation | IdSazbyDphOsv | ne | ne | - | - | - | `sazba-dph` | Osvobozená sazba DPH |
| `sazbaDphSniz` | Snížená sazba DPH | relation | IdSazbyDphSniz | ne | ne | - | - | - | `sazba-dph` | Snížená sazba DPH |
| `sazbaDphSniz2` | 2. snížená sazba DPH | relation | IdSazbyDphSniz2 | ne | ne | - | - | - | `sazba-dph` | 2. snížená sazba DPH |
| `sazbaDphZakl` | Základní sazba DPH | relation | IdSazbyDphZakl | ne | ne | - | - | - | `sazba-dph` | Základní sazba DPH |
| `smlouva` | Smlouva | relation | IdSmlouvy | ne | ANO | 20 | - | - | `smlouva` | Smlouva |
| `formaDopravy` | Forma dopravy | relation | IdFormaDopravy | ne | ANO | - | - | - | `forma-dopravy` | Forma dopravy |
| `uuid` | Uuid | string | Uuid | ne | ne | 50 | - | - | - | Univerzální unikátní identifikátor |
| `source` | Zdroj | string | Source | ne | ANO | 50 | - | - | - | Zdroj |
| `clenKonVykDph` | Řádek kontrolního hlášení DPH | relation | IdClenKonVykDph | ne | ANO | - | - | - | `cleneni-kontrolni-hlaseni` | Řádek kontrolního hlášení DPH |
| `datUp1` | Datum upomínky 1 | date | DatUp1 | ne | ANO | - | - | - | - | Datum upomínky 1 |
| `datUp2` | Datum upomínky 2 | date | DatUp2 | ne | ANO | - | - | - | - | Datum upomínky 2 |
| `datSmir` | Datum smíru | date | DatSmir | ne | ANO | - | - | - | - | Datum smíru |
| `datPenale` | Datum penalizace | date | DatPenale | ne | ANO | - | - | - | - | Datum penalizace |
| `podpisPrik` | Podpis příkazu | logic | PodpisPrik | ne | ne | - | - | - | - | Vyžadovat podpis před vystavením příkazu k úhradě |
| `prikazSum` | Příkazy [Kč] | numeric | PrikazSum | ne | ne | - | - | - | - | Odeslané příkazy [Kč] |
| `prikazSumMen` | Příkazy [měna] | numeric | PrikazSumMen | ne | ne | - | - | - | - | Odeslané příkazy [měna] |
| `juhSum` | Již uhrazeno [Kč] | numeric | JuhSum | ne | ne | - | - | - | - | Již uhrazeno [Kč] |
| `juhSumMen` | Již uhrazeno [měna] | numeric | JuhSumMen | ne | ne | - | - | - | - | Již uhrazeno [měna] |
| `juhDat` | Uhr. k datu [Kč] | numeric | JuhDat | ne | ne | - | - | - | - | Uhr. k datu [Kč] |
| `juhDatMen` | Uhr. k datu [měna] | numeric | JuhDatMen | ne | ne | - | - | - | - | Uhr. k datu [měna] |
| `zbyvaUhradit` | Zbývá uhradit [Kč] | numeric | sumCelkem - juhSum | ne | ne | - | - | - | - | Zbývá uhradit [Kč] |
| `zbyvaUhraditMen` | Zbývá uhradit [měna] | numeric | sumCelkemMen - juhSumMen | ne | ne | - | - | - | - | Zbývá uhradit [měna] |
| `formaUhradyCis` | Forma úhrady | relation | IdFormaUhradyCis | ne | ANO | - | - | - | `forma-uhrady` | Forma úhrady |
| `stavUhrK` | Stav úhrady dokladu | select | StavUhrK | ne | ANO | - | - | - | - | Stav úhrady dokladu |
| `juhSumPp` | Již uhrazeno přeplatky [Kč] | numeric | JuhSumPp | ne | ANO | - | - | - | - | Již uhrazeno přeplatky [Kč] |
| `juhSumPpMen` | Již uhrazeno přeplatky [měna] | numeric | JuhSumPpMen | ne | ANO | - | - | - | - | Již uhrazeno přeplatky [měna] |
| `sumPrepl` | Přeplaceno [Kč] | numeric | SumPrepl | ne | ANO | - | - | - | - | Přeplaceno [Kč] |
| `sumPreplMen` | Přeplaceno [měna] | numeric | SumPreplMen | ne | ANO | - | - | - | - | Přeplaceno [měna] |
| `sumZalohy` | Zálohy | numeric | SumZalohy | ne | ne | - | - | - | - | Zálohy |
| `sumZalohyMen` | Zálohy [měna] | numeric | SumZalohyMen | ne | ne | - | - | - | - | Zálohy [měna] |
| `stavOdpocetK` | Odpočet zál. | select | StavOdpocetK | ne | ne | - | - | - | - | Odpočet zál. |
| `formaUhradyCisKasa` | Zaúč.kasa-forma úhr. | relation | IdFormaUhradyCisKasa | ne | ANO | - | - | - | `forma-uhrady` | Zaúč.kasa-forma úhr. |
| `sumCelkemBezZaloh` | Celkem bez záloh [Kč] | numeric | sumCelkem + sumZalohy | ne | ANO | - | 15 | 2 | - | Celkem bez záloh |
| `sumCelkemBezZalohMen` | Celkem bez záloh [měna] | numeric | sumCelkemMen + sumZalohyMen | ne | ANO | - | 15 | 2 | - | Celkem bez záloh |
| `osobUpravaDph` | Zvláštní režim DPH | logic | OsobUpravaDph | ne | ne | - | - | - | - | Zvláštní režim DPH |
