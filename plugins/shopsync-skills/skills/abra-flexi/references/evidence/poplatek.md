# Poplatky

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `poplatek` |
| **Evidence Type** | `POPLATKY` |
| **Import Status** | SUPPORTED |
| **DB Name** | `cPoplatky` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/poplatek` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/poplatek/properties` |

## Vlastnosti (8)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPoplatek | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `mnozMj` | Množství | numeric | MnozMj | ne | ANO | - | 19 | 6 | - | Množství |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `typPoplatkuK` | Typ poplatku | select | TypPoplatkuK | **ANO** | ANO | 50 | - | - | - | Typ poplatku |
| `parentTypSzbDph` | Sazba DPH z nadřazené položky | logic | ParentTypSzbDph | ne | ANO | - | - | - | - | Sazba DPH z nadřazené položky |
| `cenikOtec` | Ceníková položka | relation | IdCenikOtec | **ANO** | ANO | 64 | - | - | `cenik` | Ceníková položka |
| `cenik` | Poplatek | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Poplatek |
