# Typ sazby DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `cenik-typ-sazby-dph` |
| **Evidence Type** | `TYP_SAZBY_DPH` |
| **Import Status** | SUPPORTED |
| **DB Name** | `cTypSazbyDph` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/cenik-typ-sazby-dph` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/cenik-typ-sazby-dph/properties` |

## Vlastnosti (8)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdTypSazbyDph | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `typSzbDphK` | Typ sazby DPH | select | TypSzbDphK | **ANO** | ANO | 50 | - | - | - | Typ sazby DPH |
| `kodPlneniK` | Kód plnění pro DPH | select | KodPlneniK | ne | ANO | 50 | - | - | - | Kód plnění pro DPH |
| `platiOd` | Platí od data | date | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do data | date | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `cenik` | Ceník | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Ceník |
| `stat` | Stát | relation | IdStatu | **ANO** | ANO | 3 | - | - | `stat-dph` | Stát |
