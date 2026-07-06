# Účtový rozvrh

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `ucet` |
| **Evidence Type** | `UCET` |
| **Import Status** | SUPPORTED |
| **DB Name** | `uUcty` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/ucet` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/ucet/properties` |

## Vlastnosti (18)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdUcet | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Účet | string | Kod | **ANO** | ANO | 6 | - | - | - | Číslo účtu |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `ucetObdobiOd` | Platí od | relation | IdUcetObdobiOd | ne | ANO | - | - | - | `ucetni-obdobi` | Platí od |
| `ucetObdobiDo` | Platí do | relation | IdUcetObdobiDo | ne | ANO | - | - | - | `ucetni-obdobi` | Platí do |
| `danovy` | Daňový | logic | Danovy | ne | ANO | - | - | - | - | Daňový |
| `saldo` | Saldo | logic | Saldo | ne | ANO | - | - | - | - | Saldo |
| `typUctuK` | Typ účtu | select | TypUctuK | ne | ANO | 50 | - | - | - | Typ účtu |
| `druhUctuK` | Druh účtu | select | DruhUctuK | ne | ANO | 50 | - | - | - | Druh účtu |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
| `stdUcet` | Syntetický účet | relation | IdStdUcet | ne | ne | 3 | - | - | `ucetni-osnova` | Syntetický účet |
| `typOrganizace` | Typ organizace | relation | IdTypOrg | ne | ne | 20 | - | - | `typ-organizace` | Typ organizace |
