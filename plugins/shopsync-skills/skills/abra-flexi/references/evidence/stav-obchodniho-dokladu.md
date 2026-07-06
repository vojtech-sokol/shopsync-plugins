# Stav obchodního dokladu

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `stav-obchodniho-dokladu` |
| **Evidence Type** | `STAV_OBCHODNIHO_DOKLADU` |
| **Import Status** | SUPPORTED |
| **DB Name** | `dStavDoklObchCis` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/stav-obchodniho-dokladu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/stav-obchodniho-dokladu/properties` |

## Vlastnosti (20)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdStavDoklObchCis | ne | ne | - | - | - | - | ID |
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
| `stavUzivK` | Stav dokladu | select | StavUzivK | **ANO** | ANO | 50 | - | - | - | Stav dokladu |
| `standard` | Standard | logic | Standard | ne | ne | - | - | - | - | Standard |
| `poradi` | Pořadí | integer | Poradi | ne | ANO | - | - | - | - | Pořadí |
| `modulPpp` | Poptávky přijaté | logic | ModulPpp | ne | ANO | - | - | - | - | Poptávky přijaté |
| `modulPpv` | Poptávky vydané | logic | ModulPpv | ne | ANO | - | - | - | - | Poptávky vydané |
| `modulNap` | Nabídky přijaté | logic | ModulNap | ne | ANO | - | - | - | - | Nabídky přijaté |
| `modulNav` | Nabídky vydané | logic | ModulNav | ne | ANO | - | - | - | - | Nabídky vydané |
| `modulObp` | Objednávky přijaté | logic | ModulObp | ne | ANO | - | - | - | - | Objednávky přijaté |
| `modulObv` | Objednávky vydané | logic | ModulObv | ne | ANO | - | - | - | - | Objednávky vydané |
