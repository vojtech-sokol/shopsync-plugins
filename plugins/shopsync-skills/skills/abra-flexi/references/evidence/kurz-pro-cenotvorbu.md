# Kurzy pro cenotvorbu

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `kurz-pro-cenotvorbu` |
| **Evidence Type** | `KURZ_PRO_CENOTVORBU` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `uKurzy` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/kurz-pro-cenotvorbu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/kurz-pro-cenotvorbu/properties` |

## Vlastnosti (6)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdKurzy | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `platiOdData` | Datum | date | PlatiOdData | **ANO** | ANO | - | - | - | - | Datum |
| `kurz` | Kurz | numeric | Kurz | **ANO** | ANO | - | 19 | 6 | - | Kurz |
| `kurzMnozstvi` | Množství | numeric | KurzMnozstvi | **ANO** | ANO | - | 19 | 6 | - | Množství |
| `mena` | Měna | relation | IdMeny | **ANO** | ANO | - | - | - | `mena` | Měna |
