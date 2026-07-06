# Typy majetků

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-majetku` |
| **Evidence Type** | `MAJETEK_TYP` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `mTypMaj` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-majetku` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-majetku/properties` |

## Vlastnosti (22)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdTypMaj | ne | ne | - | - | - | - | ID |
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
| `jeOdpis` | Majetek je odpisován | logic | JeOdpis | ne | ANO | - | - | - | - | Majetek je odpisován |
| `druhK` | Druh | select | DruhK | **ANO** | ANO | 50 | - | - | - | Druh |
| `workFlow` | Zahájit workflow při založení dokladu | logic | WorkFlow | ne | ANO | - | - | - | - | Zahájit workflow při založení dokladu |
| `stredisko` | Středisko | relation | IdStred | **ANO** | ANO | 20 | - | - | `stredisko` | Středisko |
| `primarniUcet` | Účet majetku | relation | IdPrimUcet | ne | ANO | 6 | - | - | `ucet` | Účet majetku |
| `protiUcetZarazeni` | Účet zařazení | relation | IdProtiUcetZar | ne | ANO | 6 | - | - | `ucet` | Účet zařazení |
| `opravnyUcet` | Účet oprávek | relation | IdOpravUcet | ne | ANO | 6 | - | - | `ucet` | Účet oprávek |
| `odpisovyUcet` | Účet odpisu | relation | IdOdpUcet | ne | ANO | 6 | - | - | `ucet` | Účet odpisu |
| `zustVyrazUcet` | Účet zůstatku vyřazení | relation | IdZustVyrazUcet | ne | ANO | - | - | - | `ucet` | Účet zůstatku vyřazení |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `typOrganizace` | Typ organizace | relation | IdTypOrg | **ANO** | ANO | 20 | - | - | `typ-organizace` | Typ organizace |
