# Sumace v sestavách

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `sumace-sestavy` |
| **Evidence Type** | `SUMACE_SESTAVY` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `uSesSumace` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/sumace-sestavy` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/sumace-sestavy/properties` |

## Vlastnosti (5)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSesSumace | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `prevratZnam` | Převrátit znaménko | logic | PrevratZnam | ne | ANO | - | - | - | - | Převrátit znaménko |
| `radek` | Řádek | relation | IdSesRadky | ne | ne | 20 | - | - | `radek-sestavy` | Řádek |
| `radekSum` | Přičíst řádek | relation | IdSesRadkySum | **ANO** | ANO | 20 | - | - | `radek-sestavy` | Přičíst řádek |
