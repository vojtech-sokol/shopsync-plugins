# Skupiny firem

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `skupina-firem` |
| **Evidence Type** | `SKUPINA_FIREM` |
| **Import Status** | SUPPORTED |
| **DB Name** | `aSkupFir` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/skupina-firem` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/skupina-firem/properties` |

## Vlastnosti (15)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSkupFir | ne | ne | - | - | - | - | ID |
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
| `workFlow` | Zahájit workflow při založení dokladu | logic | WorkFlow | ne | ANO | - | - | - | - | Zahájit workflow při založení dokladu |
| `ucetPrimVfa` | Prim.účet VF | relation | IdPrimUcetVfa | ne | ANO | 6 | - | - | `ucet` | pro vydané faktury |
| `ucetPrimPfa` | Prim.účet PF | relation | IdPrimUcetPfa | ne | ANO | 6 | - | - | `ucet` | pro přijaté faktury |
| `typOrganizace` | Typ organizace | relation | IdTypOrg | **ANO** | ANO | 20 | - | - | `typ-organizace` | Typ organizace |
