# Mapování skladů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `mapovani-skladu` |
| **Evidence Type** | `MAPOVANI_SKLADU` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `sMapSklad` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/mapovani-skladu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/mapovani-skladu/properties` |

## Vlastnosti (6)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdMapSklad | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `skupZboz` | Skupina zboží | relation | IdSkupZboz | ne | ANO | - | - | - | `skupina-zbozi` | Skupina zboží |
| `cenik` | Ceník | relation | IdCenik | ne | ANO | 64 | - | - | `cenik` | Ceník |
| `sklad` | Sklad | relation | IdSklad | **ANO** | ANO | - | - | - | `sklad` | Sklad |
