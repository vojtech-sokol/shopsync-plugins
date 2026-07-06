# Uživatelské transformace

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `xslt` |
| **Evidence Type** | `XSLT` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wXslt` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/xslt` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/xslt/properties` |

## Vlastnosti (10)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdXslt | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `transformace` | Transformace | string | Transformace | **ANO** | ANO | - | - | - | - | Transformace |
