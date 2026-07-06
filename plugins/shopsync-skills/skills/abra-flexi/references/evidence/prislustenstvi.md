# Příslušenství

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `prislustenstvi` |
| **Evidence Type** | `PRISLUSENSTVI` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `cPrislusenstvi` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/prislustenstvi` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/prislustenstvi/properties` |

## Vlastnosti (5)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPrislusenstvi | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `cenikOtec` | Ceníková položka | relation | IdCenikOtec | **ANO** | ANO | 64 | - | - | `cenik` | Ceníková položka |
| `cenik` | Příslušenství | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Příslušenství |
