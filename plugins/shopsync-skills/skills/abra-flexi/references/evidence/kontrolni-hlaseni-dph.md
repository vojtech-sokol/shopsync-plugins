# Kontrolní hlášení DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `kontrolni-hlaseni-dph` |
| **Evidence Type** | `KONTROLNI_HLASENI_DPH` |
| **Import Status** | DISALLOWED |
| **DB Name** | `KonVykDph` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/kontrolni-hlaseni-dph` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/kontrolni-hlaseni-dph/properties` |

## Vlastnosti (33)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `idKonVykDph` | ID výkazu | integer |  | ne | ANO | - | - | - | - | ID výkazu |
| `kod` | Evidenční číslo daňového dokladu | string |  | **ANO** | ANO | 20 | - | - | - | Evidenční číslo daňového dokladu |
| `kodDokl` | Interní číslo | string |  | ne | ANO | - | - | - | - | Interní číslo |
| `kodPuv` | Pořadové číslo původní faktury | string |  | ne | ANO | - | - | - | - | Pořadové číslo původní faktury |
| `duzpUcto` | Uplatnit zdaň. plnění | date |  | ne | ANO | - | - | - | - | Uplatnit zdaň. plnění |
| `duzpPuv` | Datum zdaň. plnění | date |  | ne | ANO | - | - | - | - | Datum zdaň. plnění |
| `dic` | DIČ | string |  | ne | ANO | 20 | - | - | - | DIČ |
| `sumZkl` | Základ [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ [Kč] |
| `sumZklPuv` | Základ daně původní faktury [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ daně původní faktury [Kč] |
| `sumDph` | DPH [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH [Kč] |
| `sumDphPuv` | Suma daně původní faktury [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Suma daně původní faktury [Kč] |
| `sumOdpocDph` | Výška odpočítané daně [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Výška odpočítané daně [Kč] |
| `szbDph` | DPH [%] | numeric |  | ne | ANO | - | 6 | 2 | - | DPH [%] |
| `typSzbDphK` | Sazba DPH | select |  | ne | ANO | 50 | - | - | - | Sazba DPH |
| `clenKonVykDph` | Řádek kontrolního hlášení DPH | relation |  | ne | ANO | - | - | - | `cleneni-kontrolni-hlaseni` | Řádek kontrolního hlášení DPH |
| `clenKonVykDphVysledny` | Řádek kon. hl. (výsl.) | string |  | ne | ANO | - | - | - | - | Řádek kon. hl. (výsl.) |
| `skupina` | Skupina | string |  | ne | ANO | - | - | - | - | Skupina |
| `clenDph` | Řádek DPH | relation |  | ne | ANO | - | - | - | `cleneni-dph` | Řádek DPH |
| `dphPren` | Kód přenesení DPH | relation |  | ne | ANO | - | - | - | `preneseni-dph` | Kód přenesení DPH |
| `mj` | MJ | relation |  | ne | ANO | - | - | - | `merna-jednotka` | MJ |
| `druhZbozi` | Druh zboží | string |  | ne | ANO | 255 | - | - | - | Druh zboží |
| `ciselnyKodZbozi` | Číselný kód zboží | string |  | ne | ANO | 255 | - | - | - | Číselný kód zboží |
| `sumMnozMj` | Suma množství zboží | numeric |  | ne | ANO | - | 19 | 6 | - | Suma množství zboží |
| `sumMnozMjPuv` | Suma množství zboží původní faktury | numeric |  | ne | ANO | - | 19 | 6 | - | Suma množství zboží původní faktury |
| `modul` | Modul | string |  | ne | ANO | - | - | - | - | Modul |
| `sumSkB3` | Suma B3 | numeric |  | ne | ANO | - | 15 | 2 | - | Suma B3 |
| `datNaroz` | Datum narození | date |  | ne | ANO | - | - | - | - | Datum narození |
| `nazev` | Název | string |  | **ANO** | ANO | 255 | - | - | - | Název |
| `ulice` | Ulice | string |  | ne | ANO | 255 | - | - | - | Ulice |
| `psc` | PSČ | string |  | ne | ANO | 255 | - | - | - | PSČ |
| `mesto` | Město | string |  | ne | ANO | 255 | - | - | - | Město |
| `stat` | Stát | relation |  | ne | ANO | 3 | - | - | `stat` | Stát |
| `idDokl` | ID dokladu | integer |  | ne | ANO | - | - | - | - | ID dokladu |
