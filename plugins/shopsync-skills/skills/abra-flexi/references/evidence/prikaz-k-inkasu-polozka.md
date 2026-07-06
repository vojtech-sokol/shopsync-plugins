# Položka inkasa

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `prikaz-k-inkasu-polozka` |
| **Evidence Type** | `PRIKAZ_K_INKASU_POLOZKA` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `dPolPrikazUhr` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/prikaz-k-inkasu-polozka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/prikaz-k-inkasu-polozka/properties` |

## Vlastnosti (33)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPolPrikazUhr | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `buc` | Číslo účtu příjemce | string | Buc | ne | ANO | 255 | - | - | - | Číslo účtu příjemce |
| `bic` | BIC | string | Bic | ne | ANO | 255 | - | - | - | BIC |
| `iban` | IBAN | string | Iban | ne | ANO | 255 | - | - | - | IBAN |
| `nazBanky` | Název banky | string | NazBanky | ne | ANO | 255 | - | - | - | Název |
| `mestoBanky` | Město | string | MestoBanky | ne | ANO | - | - | - | - | Město |
| `pscBanky` | PSČ | string | PscBanky | ne | ANO | - | - | - | - | PSČ |
| `uliceBanky` | Ulice | string | UliceBanky | ne | ANO | - | - | - | - | Ulice |
| `nazPrijem` | Název příjemce | string | NazPrijem | ne | ANO | - | - | - | - | Název příjemce |
| `mestoPrijem` | Město | string | MestoPrijem | ne | ANO | - | - | - | - | Město |
| `pscPrijem` | PSČ | string | PscPrijem | ne | ANO | - | - | - | - | PSČ |
| `ulicePrijem` | Ulice | string | UlicePrijem | ne | ANO | - | - | - | - | Ulice |
| `castka` | Částka | numeric | Castka | ne | ANO | - | 15 | 2 | - | Částka |
| `varSymPrijem` | Var. sym. | string | VarSymPrijem | ne | ANO | - | - | - | - | Variabilní symbol |
| `specSymPrijem` | Spec. sym. | string | SpecSymPrijem | ne | ANO | - | - | - | - | Specifický symbol |
| `varSymPrikaz` | Variab. symbol příkazce | string | VarSymPrikaz | ne | ANO | - | - | - | - | Variab. symbol příkazce |
| `specSymPrikaz` | Specif. symbol příkazce | string | SpecSymPrikaz | ne | ANO | - | - | - | - | Specif. symbol příkazce |
| `kod` | Kód / číslo dokladu | string | Kod | ne | ANO | - | - | - | - | Kód / číslo dokladu |
| `datSplat` | Splatnost | date | DatSplat | ne | ANO | - | - | - | - | Splatnost |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `kontakt` | Kontakt | string | Kontakt | ne | ANO | - | - | - | - | Kontakt |
| `poplatekK` | Plátce poplatků | select | PoplatekK | ne | ANO | 50 | - | - | - | Plátce poplatků |
| `konSym` | Konst. sym. | string | KonSym | ne | ANO | 20 | - | - | - | Konstantní symbol |
| `transakceVBanceId` | ID transakce v bance | string | TransakceVBanceId | ne | ne | 50 | - | - | - | ID transakce v bance |
| `datSplatPrik` | Dat. splat. příkazu | date |  | ne | ANO | - | - | - | - | Dat. splat. příkazu |
| `prikaz` | Příkaz | relation | IdPrikazUhr | **ANO** | ANO | - | - | - | `prikaz-k-uhrade` | Příkaz |
| `faStat` | Pošt. stát | relation | IdStatuPrijem | ne | ANO | 3 | - | - | `stat` | Stát |
| `baStat` | Stát | relation | IdStatuBanky | ne | ANO | - | - | - | `stat` | Stát |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
| `smerKod` | Kód banky | relation | IdSmerKod | ne | ANO | 20 | - | - | `penezni-ustav` | Kód banky |
| `doklFak` | Doklad faktury | relation | IdPrimDokl | ne | ANO | - | - | - | - | Doklad faktury |
