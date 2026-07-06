# Prodejní ceny

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `odberatel` |
| **Evidence Type** | `ODBERATEL` |
| **Import Status** | SUPPORTED |
| **DB Name** | `cOdberatele` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/odberatel` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/odberatel/properties` |

## Vlastnosti (21)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdOdberatel | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kodIndi` | Kód zboží/materiálu | string | KodIndi | ne | ANO | 64 | - | - | - | Kód zboží/materiálu |
| `prodejCena` | Prodejní cena | numeric | ProdejCena | ne | ANO | - | 19 | 6 | - | Prodejní cena |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `platiOdData` | Platí od data | date | PlatiOdData | ne | ANO | - | - | - | - | Platí od data |
| `platiDoData` | Platí do data | date | PlatiDoData | ne | ANO | - | - | - | - | Platí do data |
| `rucneVybrat` | Ručně vybrat | logic | RucneVybrat | ne | ANO | - | - | - | - | Ručně vybrat |
| `limMnoz2` | Limit MJ 2 | numeric | LimMnoz2 | ne | ANO | - | 19 | 6 | - | Množ. limit 2 |
| `limMnoz3` | Limit MJ 3 | numeric | LimMnoz3 | ne | ANO | - | 19 | 6 | - | Množ. limit 3 |
| `limMnoz4` | Limit MJ 4 | numeric | LimMnoz4 | ne | ANO | - | 19 | 6 | - | Množ. limit 4 |
| `limMnoz5` | Limit MJ 5 | numeric | LimMnoz5 | ne | ANO | - | 19 | 6 | - | Množ. limit 5 |
| `prodejCena2` | Prodejní cena 2 | numeric | ProdejCena2 | ne | ANO | - | 19 | 6 | - | Prodejní cena 2 |
| `prodejCena3` | Prodejní cena 3 | numeric | ProdejCena3 | ne | ANO | - | 19 | 6 | - | Prodejní cena 3 |
| `prodejCena4` | Prodejní cena 4 | numeric | ProdejCena4 | ne | ANO | - | 19 | 6 | - | Prodejní cena 4 |
| `prodejCena5` | Prodejní cena 5 | numeric | ProdejCena5 | ne | ANO | - | 19 | 6 | - | Prodejní cena 5 |
| `cenik` | Ceník | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Ceník |
| `firma` | Firma | relation | IdFirmy | ne | ANO | 20 | - | - | `adresar` | Firma |
| `skupCen` | Ceníková skupina | relation | IdSkupCen | ne | ANO | - | - | - | `cenikova-skupina` | Ceníková skupina |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
