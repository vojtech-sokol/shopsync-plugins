# Typy událostí / aktivit

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-aktivity` |
| **Evidence Type** | `TYP_AKTIVITY` |
| **Import Status** | SUPPORTED |
| **DB Name** | `aTypAkt` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-aktivity` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-aktivity/properties` |

## Vlastnosti (15)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdTypAkt | ne | ne | - | - | - | - | ID |
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
| `druhUdalK` | Druh události | select | DruhUdalK | **ANO** | ANO | 50 | - | - | - | Druh události |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `zodpPrac` | Zodpovědný pracovník | relation | IdUzivatel | ne | ANO | 254 | - | - | `uzivatel` | Zodpovědný pracovník |
