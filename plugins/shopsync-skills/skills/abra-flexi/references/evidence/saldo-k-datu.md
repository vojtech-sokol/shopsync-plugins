# Stav úhrad k datu

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `saldo-k-datu` |
| **Evidence Type** | `SALDO_K_DATU` |
| **Import Status** | DISALLOWED |
| **DB Name** | `SaldoKdatu` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/saldo-k-datu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/saldo-k-datu/properties` |

## Vlastnosti (133)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `idSaldoKdatu` | ID | integer |  | ne | ANO | - | - | - | - | ID |
| `idDokl` | ID dokladu | integer |  | ne | ANO | - | - | - | - | ID dokladu |
| `lastUpdate` | Poslední změna | datetime |  | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string |  | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `modul` | Modul | string |  | ne | ANO | - | - | - | - | Modul |
| `cisDosle` | Číslo došlé | string |  | ne | ANO | 40 | - | - | - | Číslo došlé |
| `varSym` | Variabilní symbol | string |  | ne | ANO | 30 | - | - | - | Variabilní symbol |
| `cisSml` | Číslo smlouvy | string |  | ne | ANO | 30 | - | - | - | Číslo smlouvy |
| `cisObj` | Číslo objednávky | string |  | ne | ANO | 2000 | - | - | - | Číslo objednávky |
| `datObj` | Objednáno | date |  | ne | ANO | - | - | - | - | Objednáno |
| `cisDodak` | Dodací list | string |  | ne | ANO | 30 | - | - | - | Dodací list |
| `doprava` | Doprava a vyskladnění | string |  | ne | ANO | - | - | - | - | Doprava a vyskladnění |
| `datVyst` | Datum vyst. | date |  | ne | ANO | - | - | - | - | Vystaveno |
| `duzpPuv` | Datum zdaň. plnění | date |  | ne | ANO | - | - | - | - | Datum zdaň. plnění |
| `duzpUcto` | Uplatnit zdaň. plnění | date |  | ne | ANO | - | - | - | - | Uplatnit zdaň. plnění |
| `datSplat` | Splatnost | date |  | ne | ANO | - | - | - | - | Splatnost |
| `datUhr` | Datum úhrady | date |  | ne | ANO | - | - | - | - | Datum úhrady |
| `datTermin` | Termín | date |  | ne | ANO | - | - | - | - | Termín |
| `datReal` | Realizace | date |  | ne | ANO | - | - | - | - | Realizace |
| `popis` | Popis | string |  | ne | ANO | - | - | - | - | Popis |
| `poznam` | Poznámka | string |  | ne | ANO | - | - | - | - | Poznámka |
| `uvodTxt` | Úvodní text (tiskne se před položkami) | string |  | ne | ANO | - | - | - | - | Úvodní text (tiskne se před položkami) |
| `zavTxt` | Závěrečný text (tiskne se za položkami) | string |  | ne | ANO | - | - | - | - | Závěrečný text (tiskne se za položkami) |
| `sumOsv` | Osvob., bez DPH [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | 0 % |
| `sumZklSniz` | Základ DPH sníž. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ DPH sníž. [Kč] |
| `sumZklSniz2` | Základ DPH 2. sníž. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ DPH 2. sníž. [Kč] |
| `sumZklZakl` | Základ DPH zákl. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ DPH zákl. [Kč] |
| `sumZklCelkem` | Základ celkem [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ |
| `sumDphSniz` | DPH snížená [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH snížená |
| `sumDphSniz2` | DPH 2. snížená [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH 2. snížená |
| `sumDphZakl` | DPH základní [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH základní |
| `sumDphCelkem` | DPH celkem [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH |
| `sumCelkSniz` | Celkem vč. DPH - sníž. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - sníž. [Kč] |
| `sumCelkSniz2` | Celkem vč. DPH - 2. sníž. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - 2. sníž. [Kč] |
| `sumCelkZakl` | Celkem vč. DPH - zákl. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - zákl. [Kč] |
| `sumCelkem` | Původní hodnota faktury [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Původní hodnota faktury [Kč] |
| `sumOsvMen` | Osvob., bez DPH [měna] | numeric |  | ne | ANO | - | - | - | - | 0 % |
| `sumZklSnizMen` | Základ DPH sníž. [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ DPH sníž. [měna] |
| `sumZklSniz2Men` | Základ DPH 2. sníž. [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ DPH 2. sníž. [měna] |
| `sumZklZaklMen` | Základ DPH zákl. [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ DPH zákl. [měna] |
| `sumZklCelkemMen` | Základ celkem [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ |
| `sumDphZaklMen` | DPH základní [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH základní |
| `sumDphSniz2Men` | DPH 2. snížená [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH 2. snížená |
| `sumDphSnizMen` | DPH snížená [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH snížená |
| `sumDphCelkemMen` | DPH celkem [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH |
| `sumCelkSnizMen` | Celkem vč. DPH - sníž. [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - sníž. [měna] |
| `sumCelkSniz2Men` | Celkem vč. DPH - 2. sníž. [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - 2. sníž. [měna] |
| `sumCelkZaklMen` | Celkem vč. DPH - zákl. [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - zákl. [měna] |
| `sumCelkemMen` | Celkem [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem [měna] |
| `slevaDokl` | Sleva [%] | numeric |  | ne | ANO | - | 6 | 2 | - | Sleva [%] |
| `kurz` | Kurz | numeric |  | ne | ANO | - | 19 | 6 | - | Kurz |
| `kurzMnozstvi` | Kurz. množství | numeric |  | ne | ANO | - | 19 | 6 | - | Kurz. množství |
| `stavUzivK` | Uživatelský stav | select |  | ne | ANO | 50 | - | - | - | Uživatelský stav |
| `nazFirmy` | Název firmy nebo jméno osoby | string |  | ne | ANO | 255 | - | - | - | Název firmy - jméno |
| `ulice` | Ulice | string |  | ne | ANO | 255 | - | - | - | Ulice |
| `mesto` | Město | string |  | ne | ANO | 255 | - | - | - | Město |
| `psc` | PSČ | string |  | ne | ANO | 255 | - | - | - | PSČ |
| `eanKod` | EAN | string |  | ne | ANO | 20 | - | - | - | EAN |
| `ic` | IČO | string |  | ne | ANO | 20 | - | - | - | IČO |
| `dic` | DIČ | string |  | ne | ANO | 20 | - | - | - | DIČ |
| `postovniShodna` | Poštovní adresa je shodná se sídlem | logic |  | ne | ANO | - | - | - | - | Poštovní adresa je shodná se sídlem |
| `faNazev` | Pošt. jméno firmy | string |  | ne | ANO | 255 | - | - | - | Firma |
| `faUlice` | Pošt. ulice | string |  | ne | ANO | 255 | - | - | - | Ulice |
| `faMesto` | Pošt. město | string |  | ne | ANO | 255 | - | - | - | Město |
| `faPsc` | Pošt. PSČ | string |  | ne | ANO | 255 | - | - | - | PSČ |
| `faEanKod` | Pošt. EAN | string |  | ne | ANO | 20 | - | - | - | EAN |
| `buc` | Číslo bank. účtu | string |  | ne | ANO | 255 | - | - | - | Číslo účtu |
| `iban` | IBAN | string |  | ne | ANO | 255 | - | - | - | IBAN |
| `bic` | BIC | string |  | ne | ANO | 255 | - | - | - | BIC |
| `specSym` | Specifický symbol | string |  | ne | ANO | 255 | - | - | - | Specifický symbol |
| `bezPolozek` | Bezpoložkový doklad | logic |  | ne | ANO | - | - | - | - | bezpoložkový doklad |
| `ucetni` | Je účetní | logic |  | ne | ANO | - | - | - | - | Doklad je účetní |
| `szbDphSniz` | Snížená sazba DPH | numeric |  | ne | ANO | - | 6 | 2 | - | Snížená |
| `szbDphSniz2` | 2. snížená sazba DPH | numeric |  | ne | ANO | - | 6 | 2 | - | 2. snížená |
| `szbDphZakl` | Základní sazba DPH | numeric |  | ne | ANO | - | 6 | 2 | - | Základní |
| `zuctovano` | Zaúčtováno | logic |  | ne | ANO | - | - | - | - | Stav zaúčtování |
| `datUcto` | Datum zaúčtování | date |  | ne | ANO | - | - | - | - | Datum zaúčtování |
| `storno` | Storno | logic |  | ne | ANO | - | - | - | - | Storno |
| `zamekK` | Zámek | select |  | ne | ne | 50 | - | - | - | Zámek |
| `zaokrJakSumK` | Způsob zaokrouhlení - Celkem | select |  | ne | ANO | 50 | - | - | - | Celkem (způsob) |
| `zaokrNaSumK` | Řád zaokrouhlení - Celkem | select |  | ne | ANO | 50 | - | - | - | Celkem (řády) |
| `zaokrJakDphK` | Způsob zaokrouhlení - DPH | select |  | ne | ANO | 50 | - | - | - | DPH (způsob) |
| `zaokrNaDphK` | Řád zaokrouhlení - DPH | select |  | ne | ANO | 50 | - | - | - | DPH (řády) |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `pocetPriloh` | Přílohy | integer |  | ne | ANO | - | - | - | - | Přílohy |
| `typDokl` | Typ dokladu | relation |  | ne | ANO | - | - | - | `typ-dokladu` | Typ dokladu |
| `mena` | Měna | relation |  | ne | ANO | - | - | - | `mena` | Měna |
| `konSym` | Konstantní symbol | relation |  | ne | ANO | - | - | - | `konst-symbol` | Konstantní symbol |
| `firma` | Firma | relation |  | ne | ANO | 20 | - | - | `adresar` | Firma |
| `stat` | Stát | relation |  | ne | ANO | 3 | - | - | `stat` | Stát |
| `faStat` | Pošt. stát | relation |  | ne | ANO | 3 | - | - | `stat` | Stát |
| `region` | Kraj | relation |  | ne | ANO | - | - | - | `region` | Kraj |
| `faRegion` | Pošt. kraj | relation |  | ne | ANO | - | - | - | `region` | Kraj |
| `mistUrc` | Místo určení | relation |  | ne | ANO | - | - | - | `misto-urceni` | Místo určení |
| `banSpojDod` | Účet dodavatele | relation |  | ne | ANO | - | - | - | `adresar-bankovni-ucet` | Účet dodavatele |
| `bankovniUcet` | Bankovní účet | relation |  | ne | ANO | - | - | - | `bankovni-ucet` | Bankovní účet |
| `typDoklSkl` | Typ skladového dokladu | relation |  | ne | ANO | - | - | - | `typ-skladovy-pohyb` | Typ skladového dokladu |
| `typUcOp` | Předpis zaúčtování | relation |  | ne | ANO | - | - | - | `predpis-zauctovani` | Předpis zaúčtování |
| `primUcet` | Prim.účet | relation |  | ne | ANO | 6 | - | - | `ucet` | Primární |
| `protiUcet` | Protiúčet | relation |  | ne | ANO | 6 | - | - | `ucet` | Protiúčet |
| `dphZaklUcet` | Účet DPH základní sazba | relation |  | ne | ANO | 6 | - | - | `ucet` | DPH základní |
| `dphSnizUcet` | Účet DPH snížená sazba | relation |  | ne | ANO | 6 | - | - | `ucet` | DPH snížená |
| `dphSniz2Ucet` | Účet DPH 2. snížená sazba | relation |  | ne | ANO | 6 | - | - | `ucet` | DPH 2. snížená |
| `smerKod` | Kód banky | relation |  | ne | ANO | 20 | - | - | `penezni-ustav` | Kód banky |
| `statDph` | Stát DPH | relation |  | ne | ANO | 3 | - | - | `stat-dph` | Stát DPH |
| `clenDph` | Řádky DPH | relation |  | ne | ANO | - | - | - | `cleneni-dph` | Řádky DPH |
| `stredisko` | Středisko | relation |  | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `zakazka` | Zakázka | relation |  | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `statOdesl` | Stát odesl. | relation |  | ne | ANO | 3 | - | - | `stat` | Stát odesl. |
| `statUrc` | Stát určení | relation |  | ne | ANO | 3 | - | - | `stat` | Stát určení |
| `statPuvod` | Stát původu | relation |  | ne | ANO | 3 | - | - | `stat` | Stát původu |
| `dodPodm` | Podmínky dodání | relation |  | ne | ANO | - | - | - | `intrastat-dodaci-podminky` | Podmínky dodání |
| `obchTrans` | Transakce | relation |  | ne | ANO | - | - | - | `intrastat-obchodni-transakce` | Transakce |
| `druhDopr` | Druh dopravy | relation |  | ne | ANO | - | - | - | `intrastat-druh-dopravy` | Druh dopravy |
| `zvlPoh` | Zvláštní pohyby | relation |  | ne | ANO | - | - | - | `intrastat-zvlastni-pohyb` | Zvláštní pohyby |
| `krajUrc` | Kraj odesílatele | relation |  | ne | ANO | - | - | - | `intrastat-kraj-urceni` | Kraj odesílatele |
| `uzivatel` | Uživatel | relation |  | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
| `zodpOsoba` | Zodpovědná osoba | relation |  | ne | ANO | 254 | - | - | `uzivatel` | Zodpovědná osoba |
| `rada` | Čís. řada | relation |  | ne | ANO | - | - | - | `rada` | Čís. řada |
| `sazbaDphOsv` | Osvobozená sazba DPH | relation |  | ne | ANO | - | - | - | `sazba-dph` | Osvobozená sazba DPH |
| `sazbaDphSniz` | Snížená sazba DPH | relation |  | ne | ANO | - | - | - | `sazba-dph` | Snížená sazba DPH |
| `sazbaDphSniz2` | 2. snížená sazba DPH | relation |  | ne | ANO | - | - | - | `sazba-dph` | 2. snížená sazba DPH |
| `sazbaDphZakl` | Základní sazba DPH | relation |  | ne | ANO | - | - | - | `sazba-dph` | Základní sazba DPH |
| `cinnost` | Činnost | relation |  | ne | ANO | - | - | - | `cinnost` | Činnost |
| `juhSum` | Již uhrazeno [Kč] | numeric |  | ne | ANO | - | - | - | - | Již uhrazeno [Kč] |
| `juhSumMen` | Již uhrazeno [měna] | numeric |  | ne | ANO | - | - | - | - | Již uhrazeno [měna] |
| `stavUhrK` | Stav úhrady dokladu | select |  | ne | ANO | - | - | - | - | Stav úhrady dokladu |
| `zbyvaUhradit` | Zbývá uhradit [Kč] | numeric |  | ne | ANO | - | - | - | - | Zbývá uhradit [Kč] |
| `zbyvaUhraditMen` | Zbývá uhradit [měna] | numeric |  | ne | ANO | - | - | - | - | Zbývá uhradit [měna] |
| `sumCelkemAkt` | Aktuální hodnota faktury [Kč] | numeric |  | ne | ANO | - | - | - | - | Aktuální hodnota faktury [Kč] |
| `juhSumDat` | Uhrazeno k datu [Kč] | numeric |  | ne | ANO | - | - | - | - | Uhrazeno k datu [Kč] |
| `juhSumDatMen` | Uhrazeno k datu [měna] | numeric |  | ne | ANO | - | - | - | - | Uhrazeno k datu [měna] |
| `stavUhrDatK` | Stav k datu | select |  | ne | ANO | - | - | - | - | Stav k datu |
