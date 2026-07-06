# Měny

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `mena` |
| **Evidence Type** | `MENA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `uMeny` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/mena` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/mena/properties` |

## Vlastnosti (14)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdMeny | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `symbol` | Symbol | string | Symbol | ne | ANO | 3 | - | - | - | Symbol |
| `kurzMnozstvi` | Kurz. množství | numeric | KurzMnozstvi | **ANO** | ANO | - | 19 | 6 | - | Kurz. množství |
| `zpusobStahKurzK` | Způsob stahování kurzu | select | ZpusobStahKurzK | ne | ANO | 50 | - | - | - | Způsob stahování kurzu |
