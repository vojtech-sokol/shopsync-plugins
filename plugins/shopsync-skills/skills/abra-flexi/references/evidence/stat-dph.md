# Státy DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `stat-dph` |
| **Evidence Type** | `STAT_DPH` |
| **Import Status** | DISALLOWED |
| **DB Name** | `aStaty` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/stat-dph` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/stat-dph/properties` |

## Vlastnosti (21)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdStatu | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Kód (ISO 3166-1) | string | Kod | **ANO** | ANO | 3 | - | - | - | alpha-2 |
| `nazev` | Název státu | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název státu |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `kodDph` | Kód (DPH) | string | KodDph | **ANO** | ANO | 3 | - | - | - | Kód (DPH) |
| `kodNum` | Kód (ISO 3166-1 - číselný) | string | KodNum | ne | ANO | 3 | - | - | - | numeric |
| `kodAlpha3` | Kód (ISO 3166-1 - alpha-3) | string | KodAlpha3 | ne | ANO | 3 | - | - | - | alpha-3 |
| `nazZemeC25` | Název státu zkrácený | string | NazZemeC25 | ne | ANO | 25 | - | - | - | Název státu zkrácený |
| `clenEu` | Člen EU | logic | ClenEu | ne | ANO | - | - | - | - | Člen EU |
| `vatId` | IČ DPH | string | VatId | ne | ANO | 20 | - | - | - | IČ DPH |
| `telPredvolba` | Mezinárodní tel. předvolba | string | TelPredvolba | ne | ANO | 10 | - | - | - | Mezinárodní tel. předvolba |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
| `fuKraj` | Krajský finanční úřad | relation | Idfukraj | ne | ANO | - | - | - | `adresar` | Krajský finanční úřad |
| `fuUzPrac` | Územní pracoviště | relation | Idfuuzprac | ne | ANO | - | - | - | `adresar` | Územní pracoviště |
