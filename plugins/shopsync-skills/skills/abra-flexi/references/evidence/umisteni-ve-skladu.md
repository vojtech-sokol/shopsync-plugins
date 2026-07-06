# Umístění ve skladu

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `umisteni-ve-skladu` |
| **Evidence Type** | `UMISTENI_VE_SKLADU` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `sUmisteni` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/umisteni-ve-skladu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/umisteni-ve-skladu/properties` |

## Vlastnosti (13)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdUmisteni | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `visible` | Zobrazovat | logic | Show | ne | ANO | - | - | - | - | Zobrazovat |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `typUmisteniK` | Typ umístění | select | TypUmisteniK | **ANO** | ANO | 50 | - | - | - | Typ umístění |
