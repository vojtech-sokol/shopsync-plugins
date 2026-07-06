# Náklady na události / aktivity

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `naklad` |
| **Evidence Type** | `NAKLAD` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `aNaklAkt` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/naklad` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/naklad/properties` |

## Vlastnosti (12)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdNaklAkt | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `faktMnoz` | Fakturované množství | numeric | FaktMnoz | ne | ANO | - | 19 | 6 | - | Fakturované množství |
| `fakturovat` | Fakturovat | logic | Fakturovat | ne | ANO | - | - | - | - | Fakturovat |
| `fakturovano` | Fakturováno | logic | Fakturovano | ne | ANO | - | - | - | - | Fakturováno |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `realMnoz` | Realizované množství | numeric | RealMnoz | ne | ANO | - | 19 | 6 | - | Realizované množství |
| `termin` | Čas nákladu | datetime | Termin | ne | ANO | - | - | - | - | Čas nákladu |
| `typNaklAkt` | Typ nákladu na aktivitu | relation | IdTypNaklAkt | **ANO** | ANO | 20 | - | - | `typ-nakladu` | Typ nákladu na aktivitu |
| `cenik` | Ceník | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Ceník |
| `zodpPrac` | Zodpovědný pracovník | relation | IdUzivatel | **ANO** | ANO | 254 | - | - | `uzivatel` | Zodpovědný pracovník |
| `adrUdalost` | Událost | relation | IdAdrUdalost | **ANO** | ANO | - | - | - | `udalost` | Událost |
