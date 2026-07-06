# Bankovní formáty

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `format-elektronickeho-bankovnictvi` |
| **Evidence Type** | `FORMAT_ELEKTRONICKEHO_BANKOVNICTVI` |
| **Import Status** | DISALLOWED |
| **DB Name** | `dElbanFormat` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/format-elektronickeho-bankovnictvi` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/format-elektronickeho-bankovnictvi/properties` |

## Vlastnosti (14)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdElbanFormat | ne | ne | - | - | - | - | ID |
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
| `priVypis` | Přípona výpisu | string | PriVypis | ne | ANO | 20 | - | - | - | přípona |
| `priPrikaz` | Přípona příkazu | string | PriPrikaz | ne | ANO | 3 | - | - | - | přípona |
| `priPrikazZahr` | Příp. zahr. přík. | string | PriPrikazZahr | ne | ANO | 3 | - | - | - | příp.zahr. |
