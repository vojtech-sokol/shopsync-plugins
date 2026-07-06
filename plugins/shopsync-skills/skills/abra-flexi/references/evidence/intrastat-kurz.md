# Kurzy pro Intrastat

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `intrastat-kurz` |
| **Evidence Type** | `INTRASTAT_KURZ` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `uKurzy` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/intrastat-kurz` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/intrastat-kurz/properties` |

## Vlastnosti (6)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdKurzy | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `platiOdData` | Datum | date | PlatiOdData | **ANO** | ANO | - | - | - | - | Datum |
| `kurz` | Kurz | numeric | Kurz | **ANO** | ANO | - | 19 | 6 | - | Kurz |
| `kurzMnozstvi` | Množství | numeric | KurzMnozstvi | **ANO** | ANO | - | 19 | 6 | - | Množství |
| `mena` | Měna | relation | IdMeny | **ANO** | ANO | - | - | - | `mena` | Měna |
