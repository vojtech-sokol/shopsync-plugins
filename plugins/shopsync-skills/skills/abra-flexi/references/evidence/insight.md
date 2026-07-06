# Insight

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `insight` |
| **Evidence Type** | `INSIGHT` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wInsight` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/insight` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/insight/properties` |

## Vlastnosti (13)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdInsight | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `data` | Data | string | Data | **ANO** | ANO | - | - | - | - | Data |
| `lastRun` | Poslední spuštění | datetime | LastRun | ne | ANO | - | - | - | - | Poslední spuštění |
| `resultKey` | Klíč výsledku | string | ResultKey | ne | ANO | 255 | - | - | - | Klíč výsledku |
| `state` | Stav | string | State | ne | ANO | 20 | - | - | - | Stav |
