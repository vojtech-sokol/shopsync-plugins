# Vazba uzlu na objekt

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `strom-cenik` |
| **Evidence Type** | `STROM_CENIK` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wVazUzel` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/strom-cenik` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/strom-cenik/properties` |

## Vlastnosti (4)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | Idvazuzel | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `idZaznamu` | ID Záznamu | integer | Idzaznamu | **ANO** | ANO | - | - | - | - | ID Záznamu |
| `uzel` | Strom | relation | Iduzlu | **ANO** | ANO | 20 | - | - | `strom` | Strom |
