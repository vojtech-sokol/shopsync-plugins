# Obecný strom

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `strom-koren` |
| **Evidence Type** | `STROM_KOREN` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wStrom` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/strom-koren` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/strom-koren/properties` |

## Vlastnosti (15)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdStrom | ne | ne | - | - | - | - | ID |
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
| `tabulka` | Evidence | string | Tabulka | ne | ANO | 63 | - | - | - | Evidence |
| `primarni` | Primární | logic | Primarni | ne | ANO | - | - | - | - | Primární |
| `idzaznamu` | ID záznamu | integer | Idzaznamu | ne | ANO | - | - | - | - | ID záznamu |
| `uzivatel` | Uživatel | relation | IdUziv | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
