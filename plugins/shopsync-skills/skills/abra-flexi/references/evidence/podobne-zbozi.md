# Podobné

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `podobne-zbozi` |
| **Evidence Type** | `PODOBNE_ZBOZI` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `cPodobne` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/podobne-zbozi` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/podobne-zbozi/properties` |

## Vlastnosti (5)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPodobne | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `cenikOtec` | Ceníková položka | relation | IdCenikOtec | **ANO** | ANO | 64 | - | - | `cenik` | Ceníková položka |
| `cenik` | Podobné | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Podobné |
