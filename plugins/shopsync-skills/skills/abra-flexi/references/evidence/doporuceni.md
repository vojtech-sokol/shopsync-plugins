# Doporučení

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `doporuceni` |
| **Evidence Type** | `DOPORUCENI` |
| **Import Status** | DISALLOWED |
| **DB Name** | `Doporuceni` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/doporuceni` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/doporuceni/properties` |

## Vlastnosti (8)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `aktualniHodnota` | Aktuální hodnota | string |  | ne | ANO | - | - | - | - | Aktuální hodnota |
| `doporucenaHodnota` | Doporučená hodnota | string |  | ne | ANO | - | - | - | - | Doporučená hodnota |
| `typHodnoty` | Typ hodnoty | string |  | ne | ANO | - | - | - | - | Typ hodnoty |
| `vlastnost` | Název vlastnosti | string |  | ne | ANO | - | - | - | - | Název vlastnosti |
| `automaticky` | Automaticky | logic |  | ne | ANO | - | - | - | - | Automaticky |
| `popis` | Popis | string |  | ne | ANO | - | - | - | - | Popis |
| `doporuceniCilK` | Cíl doporučení | select |  | ne | ANO | - | - | - | - | Cíl doporučení |
| `doklad` | Doklad | relation |  | ne | ANO | - | - | - | - | Doklad |
