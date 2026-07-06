# Sady

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `sady-a-komplety` |
| **Evidence Type** | `SADY_A_KOMPLETY` |
| **Import Status** | SUPPORTED |
| **DB Name** | `cSady` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/sady-a-komplety` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/sady-a-komplety/properties` |

## Vlastnosti (8)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSady | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `mnozMj` | Množství | numeric | MnozMj | ne | ANO | - | 19 | 6 | - | Množství |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `baleniId` | Balení | integer | BaleniId | ne | ANO | - | 1 | - | - | Balení |
| `mnozBaleni` | Počet balení | numeric |  | ne | ANO | - | 19 | 6 | - | Počet balení |
| `cenikSada` | Sada | relation | IdCenikSada | **ANO** | ANO | 64 | - | - | `cenik` | Sada |
| `cenik` | Ceníková položka | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Ceníková položka |
