# Čísla balíků

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `cislo-baliku` |
| **Evidence Type** | `CISLO_BALIKU` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dCisloBal` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/cislo-baliku` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/cislo-baliku/properties` |

## Vlastnosti (7)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdCisloBal | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `cislo` | Číslo | string | Cislo | ne | ANO | 100 | - | - | - | Číslo |
| `formaDopravy` | Forma dopravy | relation | IdFormaDopravy | ne | ANO | - | - | - | `forma-dopravy` | Forma dopravy |
| `doklFak` | Doklad faktury | relation | IdDoklFak | ne | ANO | - | - | - | - | Doklad faktury |
| `doklSklad` | Příjemka/výdejka | relation | IdDoklSklad | ne | ANO | - | - | - | `skladovy-pohyb` | Příjemka/výdejka |
| `doklObch` | Obchodní doklad | relation | IdDoklObch | ne | ANO | - | - | - | - | Obchodní doklad |
