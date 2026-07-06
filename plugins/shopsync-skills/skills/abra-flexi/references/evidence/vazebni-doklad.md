# Navázané doklady

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `vazebni-doklad` |
| **Evidence Type** | `VAZEBNI_DOKLAD` |
| **Import Status** | DISALLOWED |
| **DB Name** | `VazebniDoklad` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/vazebni-doklad` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/vazebni-doklad/properties` |

## Vlastnosti (26)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `idVazebniDoklad` | ID | integer |  | ne | ANO | - | - | - | - | ID |
| `idVazby` | ID vazby | integer |  | ne | ANO | - | - | - | - | ID vazby |
| `typVazbyK` | Typ vazby | select |  | ne | ANO | 50 | - | - | - | Typ vazby |
| `storno` | Storno | logic |  | ne | ANO | - | - | - | - | Storno |
| `idDokl` | ID dokladu | integer |  | ne | ANO | - | - | - | - | ID dokladu |
| `modul` | Modul | string |  | ne | ANO | - | - | - | - | Modul |
| `modulK` | Název modulu | select |  | ne | ANO | - | - | - | - | Název modulu |
| `kod` | Interní číslo | string |  | **ANO** | ANO | 20 | - | - | - | Interní číslo |
| `varSym` | Variabilní symbol | string |  | ne | ANO | 30 | - | - | - | Variabilní symbol |
| `datVyst` | Datum vyst. | date |  | ne | ANO | - | - | - | - | Vystaveno |
| `datUcto` | Datum zaúčtování | date |  | ne | ANO | - | - | - | - | Datum zaúčtování |
| `sumCelkem` | Celkem [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem [Kč] |
| `sumCelkemMen` | Celkem [měna] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem [měna] |
| `popis` | Popis | string |  | ne | ANO | - | - | - | - | Popis |
| `poznam` | Poznámka | string |  | ne | ANO | - | - | - | - | Poznámka |
| `uroven` | Vzdálenost | integer |  | ne | ANO | - | - | - | - | Vzdálenost |
| `stavK` | Stav dokladu | select |  | ne | ANO | - | - | - | - | Stav dokladu |
| `typDokl` | Typ dokladu | relation |  | ne | ANO | - | - | - | `typ-dokladu` | Typ dokladu |
| `mena` | Měna | relation |  | ne | ANO | - | - | - | `mena` | Měna |
| `uzivatel` | Uživatel | relation |  | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
| `nazFirmy` | Název firmy nebo jméno osoby | string |  | ne | ANO | 255 | - | - | - | Název firmy - jméno |
| `mesto` | Město | string |  | ne | ANO | 255 | - | - | - | Město |
| `juhSum` | Již uhrazeno [Kč] | numeric |  | ne | ANO | - | - | - | - | Již uhrazeno [Kč] |
| `juhSumMen` | Již uhrazeno [měna] | numeric |  | ne | ANO | - | - | - | - | Již uhrazeno [měna] |
| `zbyvaUhradit` | Zbývá uhradit [Kč] | numeric |  | ne | ANO | - | - | - | - | Zbývá uhradit [Kč] |
| `zbyvaUhraditMen` | Zbývá uhradit [měna] | numeric |  | ne | ANO | - | - | - | - | Zbývá uhradit [měna] |
