# Řádky přiznání DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `cleneni-dph` |
| **Evidence Type** | `CLENENI_DPH` |
| **Import Status** | DISALLOWED |
| **DB Name** | `uClenDph` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/cleneni-dph` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/cleneni-dph/properties` |

## Vlastnosti (19)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdClenDPH | ne | ne | - | - | - | - | ID |
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
| `typPlneniK` | Typ plnění | select | TypPlneniK | ne | ANO | 50 | - | - | - | Typ plnění |
| `typObchoduK` | Typ obchodu | select | TypObchoduK | ne | ANO | 50 | - | - | - | Typ obchodu |
| `kodPlneniK` | Kód plnění | select | KodPlneniK | ne | ANO | 50 | - | - | - | Kód plnění |
| `jeDph` | Je DPH | logic | JeDph | ne | ANO | - | - | - | - | Je DPH |
| `poradi` | Pořadí | integer | Poradi | ne | ANO | - | - | - | - | Pořadí |
| `kodPlneniSH` | Kód plnění pro souhrnné hlášení | string | KodPlneniSH | ne | ANO | 20 | - | - | - | Kód plnění pro souhrnné hlášení |
| `typPlneniEetK` | Typ plnění EET | select | TypPlneniEetK | ne | ANO | 50 | - | - | - | Typ plnění EET |
| `stat` | Stát | relation | IdStatu | **ANO** | ANO | - | - | - | `stat` | Stát |
