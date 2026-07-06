# Nákupní ceny

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `dodavatel` |
| **Evidence Type** | `DODAVATEL` |
| **Import Status** | SUPPORTED |
| **DB Name** | `cDodavatele` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/dodavatel` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/dodavatel/properties` |

## Vlastnosti (21)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDodavatel | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kodIndi` | Kód zboží/materiálu | string | KodIndi | ne | ANO | 64 | - | - | - | Kód zboží/materiálu |
| `nakupCena` | Nákupní cena | numeric | NakupCena | ne | ANO | - | 19 | 6 | - | Nákupní cena |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `primarni` | Primární | logic | Primarni | ne | ANO | - | - | - | - | primární dodavatel |
| `stavMJ` | Stav skladu | numeric | StavMJ | ne | ANO | - | 19 | 6 | - | Stav skladu |
| `dodaciLhuta` | Dodací lhůta | numeric | DodaciLhuta | ne | ANO | - | 19 | 6 | - | Dodací lhůta |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `limMnoz2` | Limit MJ 2 | numeric | LimMnoz2 | ne | ANO | - | 19 | 6 | - | Množ. limit 2 |
| `limMnoz3` | Limit MJ 3 | numeric | LimMnoz3 | ne | ANO | - | 19 | 6 | - | Množ. limit 3 |
| `limMnoz4` | Limit MJ 4 | numeric | LimMnoz4 | ne | ANO | - | 19 | 6 | - | Množ. limit 4 |
| `limMnoz5` | Limit MJ 5 | numeric | LimMnoz5 | ne | ANO | - | 19 | 6 | - | Množ. limit 5 |
| `nakupCena2` | Nákupní cena 2 | numeric | NakupCena2 | ne | ANO | - | 19 | 6 | - | Nákupní cena 2 |
| `nakupCena3` | Nákupní cena 3 | numeric | NakupCena3 | ne | ANO | - | 19 | 6 | - | Nákupní cena 3 |
| `nakupCena4` | Nákupní cena 4 | numeric | NakupCena4 | ne | ANO | - | 19 | 6 | - | Nákupní cena 4 |
| `nakupCena5` | Nákupní cena 5 | numeric | NakupCena5 | ne | ANO | - | 19 | 6 | - | Nákupní cena 5 |
| `cenik` | Ceník | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Ceník |
| `firma` | Firma | relation | IdFirmy | ne | ANO | 20 | - | - | `adresar` | Firma |
| `mjDodaciLhuta` | MJ Dodací lhůty | relation | IdMjDodaciLhuta | ne | ANO | - | - | - | `merna-jednotka` | MJ Dodací lhůty |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
