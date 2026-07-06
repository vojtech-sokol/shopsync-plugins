# Standardní předpis sestavy

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `standardni-predpis` |
| **Evidence Type** | `STD_PREDPIS_SESTAVY` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `uSesStdPred` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/standardni-predpis` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/standardni-predpis/properties` |

## Vlastnosti (9)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSesStdPred | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `druhUctuK` | Druh účtu | select | DruhUctuK | ne | ANO | 50 | - | - | - | Druh účtu |
| `cisSloup` | Sloupec sestavy | integer | CisSloup | **ANO** | ANO | - | 4 | - | - | Sloupec sestavy |
| `zpusobVypK` | Způsob výpočtu | select | ZpusobVypK | **ANO** | ANO | 50 | - | - | - | Způsob výpočtu |
| `prevratZnam` | Převrátit znaménko | logic | PrevratZnam | ne | ANO | - | - | - | - | Převrátit znaménko |
| `jenKladne` | Uvažovat jen kladné hodnoty | logic | JenKladne | ne | ANO | - | - | - | - | Uvažovat jen kladné hodnoty |
| `radek` | Řádek | relation | IdSesRadky | ne | ne | - | - | - | `radek-sestavy` | Řádek |
| `cisloUctuSyn` | Číslo účtu syntetické | relation | IdStdUcet | **ANO** | ANO | 6 | - | - | `ucetni-osnova` | Číslo účtu syntetické |
