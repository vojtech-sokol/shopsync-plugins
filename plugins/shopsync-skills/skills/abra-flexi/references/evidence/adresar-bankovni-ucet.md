# Bankovní spojení

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `adresar-bankovni-ucet` |
| **Evidence Type** | `ADR_BANKOVNI_UCET` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `aBanSpoj` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/adresar-bankovni-ucet` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/adresar-bankovni-ucet/properties` |

## Vlastnosti (20)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdBanSpoj | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `ulice` | Ulice | string | Ulice | ne | ANO | 255 | - | - | - | Ulice |
| `mesto` | Město | string | Mesto | ne | ANO | 255 | - | - | - | Město |
| `psc` | PSČ | string | Psc | ne | ANO | 255 | - | - | - | PSČ |
| `stat` | Stát | relation | IdStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `region` | Kraj | relation | Idregion | ne | ANO | - | - | - | `region` | Kraj |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `nazBanky` | Název banky | string | NazBanky | ne | ANO | 255 | - | - | - | Název |
| `buc` | Číslo bank. účtu | string | Buc | ne | ANO | 255 | - | - | - | Číslo účtu |
| `iban` | IBAN | string | Iban | ne | ANO | 255 | - | - | - | IBAN |
| `bic` | BIC | string | Bic | ne | ANO | 255 | - | - | - | BIC |
| `specSym` | Specifický symbol | string | SpecSym | ne | ANO | 255 | - | - | - | Specifický symbol |
| `varSym` | Variabilní symbol | string | VarSym | ne | ANO | 30 | - | - | - | Variabilní symbol |
| `primarni` | Prim. ban. spoj. | logic | Primarni | ne | ANO | - | - | - | - | Primární ban. spojení |
| `firma` | Firma | relation | IdFirmy | **ANO** | ANO | - | - | - | `adresar` | Firma |
| `smerKod` | Kód banky | relation | IdSmerKod | ne | ANO | 20 | - | - | `penezni-ustav` | Kód banky |
| `konSym` | Konstantní symbol | relation | IdKonSym | ne | ANO | 20 | - | - | `konst-symbol` | Konstantní symbol |
| `registered` | Registrovaný účet | logic | Registered | ne | ANO | - | - | - | - | Registrovaný účet |
