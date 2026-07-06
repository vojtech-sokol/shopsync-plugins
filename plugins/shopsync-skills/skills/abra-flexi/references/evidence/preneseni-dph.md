# Seznam zboží v režimu přenesení DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `preneseni-dph` |
| **Evidence Type** | `PRENESENI_DPH` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `uDphPren` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/preneseni-dph` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/preneseni-dph/properties` |

## Vlastnosti (12)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDphPren | ne | ne | - | - | - | - | ID |
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
| `omezPrenDanPovK` | Omezení | select | OmezPrenDanPovK | **ANO** | ANO | 50 | - | - | - | Omezení |
