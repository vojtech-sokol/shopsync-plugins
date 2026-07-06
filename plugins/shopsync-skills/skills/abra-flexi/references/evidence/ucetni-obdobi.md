# Účetní období

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `ucetni-obdobi` |
| **Evidence Type** | `UCETNI_OBDOBI` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `nUcetObdobi` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/ucetni-obdobi` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/ucetni-obdobi/properties` |

## Vlastnosti (10)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdUcetObdobi | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `platiOdData` | Platí od data | date | PlatiOdData | **ANO** | ANO | - | - | - | - | Platí od data |
| `platiDoData` | Platí do data | date | PlatiDoData | **ANO** | ANO | - | - | - | - | Platí do data |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `zmenaZaver` | Změna po uzávěrce | logic | ZmenaZaver | ne | ANO | - | - | - | - | Změna po uzávěrce |
| `chybaPreceneni` | Chyba při přecenění | logic | ChybaPreceneni | ne | ANO | - | - | - | - | Chyba při přecenění |
| `rokProRadu` | Kód roku pro řadu | integer | RokProRadu | ne | ANO | - | - | - | - | Kód roku pro řadu |
