# Evidence obalů EkoKom

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `cenik-obal` |
| **Evidence Type** | `CENIK_OBAL` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `cEkoKom` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/cenik-obal` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/cenik-obal/properties` |

## Vlastnosti (22)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdEkoKom | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `hmotnost` | Hmotnost | numeric | Hmotnost | ne | ANO | - | 19 | 6 | - | Hmotnost |
| `mjHmotK` | MJ hmotnosti | select | MjHmotK | **ANO** | ANO | - | - | - | - | MJ hmotnosti |
| `typObaluK` | Typ obalu | select | TypObaluK | **ANO** | ANO | - | - | - | - | Typ obalu |
| `typVznikuK` | Typ vzniku | select | TypVznikuK | **ANO** | ANO | - | - | - | - | Typ vzniku |
| `typPouzitiK` | Typ použití | select | TypPouzitiK | **ANO** | ANO | - | - | - | - | Typ použití |
| `materialK` | Materiál | select | MaterialK | **ANO** | ANO | - | - | - | - | Materiál |
| `surovinaK` | Surovina | select | SurovinaK | **ANO** | ANO | - | - | - | - | Surovina |
| `barvaMaterialuK` | Barva | select | BarvaMaterialuK | ne | ANO | - | - | - | - | Barva |
| `obsahujeNapoje` | Obsahuje nápoje | logic | ObsahujeNapoje | ne | ANO | - | - | - | - | Obsahuje nápoje |
| `litterObalK` | Typ litteringového obalu | select | LitterObalK | **ANO** | ANO | - | - | - | - | Typ |
| `litterObalHmotnostPlast` | Hmotnost plastu | numeric | LitterObalHmotnostPlast | ne | ANO | - | - | - | - | Hmotnost plastu |
| `cenik` | Ceník | relation | IdCenik | **ANO** | ANO | 64 | - | - | `cenik` | Ceník |
