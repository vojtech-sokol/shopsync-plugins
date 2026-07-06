# Kódy nomenklatury

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `intrastat-kod-nomenklatury` |
| **Evidence Type** | `INTRASTAT_KOD_NOMENKLATURY` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `iNomen` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/intrastat-kod-nomenklatury` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/intrastat-kod-nomenklatury/properties` |

## Vlastnosti (12)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdNomen | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | - | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | - | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | - | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | - | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `intrMerJed` | Měrná jednotka | relation | IdIntrMerJed | **ANO** | ANO | - | - | - | `intrastat-merna-jednotka` | Měrná jednotka |
