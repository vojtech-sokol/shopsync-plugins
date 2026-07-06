# Typy leasingů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-leasingu` |
| **Evidence Type** | `LEASING_TYP` |
| **Import Status** | DISALLOWED |
| **DB Name** | `mTypLeas` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-leasingu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-leasingu/properties` |

## Vlastnosti (21)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdTypLeas | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `ucetObdobiOd` | Platí od | relation | IdUcetObdobiOd | ne | ANO | - | - | - | `ucetni-obdobi` | Platí od |
| `ucetObdobiDo` | Platí do | relation | IdUcetObdobiDo | ne | ANO | - | - | - | `ucetni-obdobi` | Platí do |
| `druhK` | Druh | select | DruhK | ne | ANO | 50 | - | - | - | Druh |
| `workFlow` | Zahájit workflow při založení dokladu | logic | WorkFlow | ne | ANO | - | - | - | - | Zahájit workflow při založení dokladu |
| `dphSnizUcet` | Účet DPH snížená sazba | relation | IdDphSnizUcet | ne | ANO | 6 | - | - | `ucet` | DPH snížená |
| `dphZaklUcet` | Účet DPH základní sazba | relation | IdDphZaklUcet | ne | ANO | 6 | - | - | `ucet` | DPH základní |
| `zavazUcet` | Úč.závaz. | relation | IdZavazUcet | ne | ANO | 6 | - | - | `ucet` | Účet závazku |
| `casUcet` | Úč.čas.rozl. | relation | IdCasUcet | ne | ANO | 6 | - | - | `ucet` | Účet časového rozlišení nákladů |
| `naklUcet` | Úč.daň.nakl. | relation | IdNaklUcet | ne | ANO | 6 | - | - | `ucet` | Účet daňových nákladů |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `typOrganizace` | Typ organizace | relation | IdTypOrg | **ANO** | ANO | 20 | - | - | `typ-organizace` | Typ organizace |
