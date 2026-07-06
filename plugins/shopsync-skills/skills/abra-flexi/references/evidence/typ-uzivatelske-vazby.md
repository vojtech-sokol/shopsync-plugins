# Typy uživatelských vazeb

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-uzivatelske-vazby` |
| **Evidence Type** | `VAZBA_TYP` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wVazbaTyp` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-uzivatelske-vazby` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-uzivatelske-vazby/properties` |

## Vlastnosti (21)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdVazbaTyp | ne | ne | - | - | - | - | ID |
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
| `automaticka` | Automatická | logic | Automaticka | ne | ANO | - | - | - | - | Automatická |
| `beanKeysA` | Primární místa použití | string | BeanKeysA | ne | ANO | - | - | - | - | Primární místa použití |
| `beanKeysB` | Sekundární místa použití | string | BeanKeysB | ne | ANO | - | - | - | - | Sekundární místa použití |
| `visibleB` | Viditelná ze sekundárního záznamu | logic | VisibleB | ne | ANO | - | - | - | - | Viditelná ze sekundárního záznamu |
| `fkNameB` | Vazební sloupec sekundárního záznamu | string | FkNameB | ne | ANO | 100 | - | - | - | Vazební sloupec sekundárního záznamu |
| `tableNameB` | Tabulka DB | string | TableNameB | ne | ANO | 100 | - | - | - | Tabulka DB |
| `fkDbNameB` | Sloupec DB | string | FkDbNameB | ne | ANO | 100 | - | - | - | Sloupec DB |
| `pkDbNameB` | ID DB | string | PkDbNameB | ne | ANO | 100 | - | - | - | ID DB |
| `modulB` | Modul B | string | ModulB | ne | ANO | 3 | - | - | - | Modul B |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
