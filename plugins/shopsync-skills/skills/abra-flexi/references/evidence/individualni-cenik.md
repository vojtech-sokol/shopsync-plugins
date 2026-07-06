# Individuální ceník

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `individualni-cenik` |
| **Evidence Type** | `INDIVIDUALNI_CENIK` |
| **Import Status** | DISALLOWED |
| **DB Name** | `CenyView` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/individualni-cenik` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/individualni-cenik/properties` |

## Vlastnosti (20)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer |  | ne | ne | - | - | - | - | ID |
| `kod` | Zkratka | string |  | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string |  | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string |  | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string |  | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string |  | ne | ANO | 255 | - | - | - | Název FR |
| `cenaZakl` | Prodejní cena | numeric |  | ne | ANO | - | 19 | 6 | - | Prodejní cena |
| `cena2` | Cena 2 | numeric |  | ne | ANO | - | 19 | 6 | - | Cena 2 |
| `cena3` | Cena 3 | numeric |  | ne | ANO | - | 19 | 6 | - | Cena 3 |
| `cena4` | Cena 4 | numeric |  | ne | ANO | - | 19 | 6 | - | Cena 4 |
| `cena5` | Cena 5 | numeric |  | ne | ANO | - | 19 | 6 | - | Cena 5 |
| `limMnoz2` | Limit MJ 2 | numeric |  | ne | ANO | - | 19 | 6 | - | Množ. limit 2 |
| `limMnoz3` | Limit MJ 3 | numeric |  | ne | ANO | - | 19 | 6 | - | Množ. limit 3 |
| `limMnoz4` | Limit MJ 4 | numeric |  | ne | ANO | - | 19 | 6 | - | Množ. limit 4 |
| `limMnoz5` | Limit MJ 5 | numeric |  | ne | ANO | - | 19 | 6 | - | Množ. limit 5 |
| `typCenyDphK` | Typ ceny | select |  | ne | ANO | 50 | - | - | - | Typ ceny |
| `typSzbDphK` | Sazba DPH | select |  | ne | ANO | 50 | - | - | - | Sazba DPH |
| `cenik` | Ceník | relation |  | ne | ANO | 64 | - | - | `cenik` | Ceník |
| `cenHlad` | Cenová úroveň | relation |  | ne | ANO | - | - | - | `cenova-uroven` | Cenová úroveň |
| `skupZboz` | Skupina zboží | relation |  | ne | ANO | - | - | - | `skupina-zbozi` | Skupina zboží |
