# Standardní účetní osnova

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `ucetni-osnova` |
| **Evidence Type** | `UCETNI_OSNOVA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `uStdUcty` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/ucetni-osnova` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/ucetni-osnova/properties` |

## Vlastnosti (15)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdStdUcet | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Účet | string | Kod | **ANO** | ANO | 3 | - | - | - | Syntetický účet |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `druhUctuK` | Druh účtu | select | DruhUctuK | ne | ne | 50 | - | - | - | Druh účtu |
| `typUctuK` | Typ účtu | select | TypUctuK | ne | ANO | 50 | - | - | - | Typ účtu |
| `saldo` | Sledovat saldo | logic | Saldo | ne | ANO | - | - | - | - | Sledovat saldo |
| `typOrganizace` | Typ organizace | relation | IdTypOrg | ne | ne | 20 | - | - | `typ-organizace` | Typ organizace |
