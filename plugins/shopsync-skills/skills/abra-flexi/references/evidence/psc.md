# Poštovní směrovací čísla

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `psc` |
| **Evidence Type** | `PSC` |
| **Import Status** | DISALLOWED |
| **DB Name** | `aPsc` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/psc` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/psc/properties` |

## Vlastnosti (17)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPsc | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Pošta | string | Nazev | **ANO** | ANO | 255 | - | - | - | Pošta |
| `nazevA` | Pošta EN | string | NazevA | ne | ANO | 255 | - | - | - | Pošta EN |
| `nazevB` | Pošta DE | string | NazevB | ne | ANO | 255 | - | - | - | Pošta DE |
| `nazevC` | Pošta FR | string | NazevC | ne | ANO | 255 | - | - | - | Pošta FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `visible` | Zobrazovat | logic | Show | ne | ANO | - | - | - | - | Zobrazovat |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `castObce` | Část obce | string | CastObce | ne | ANO | - | - | - | - | Část obce |
| `kodOkresu` | Kód okresu | string | KodOkresu | ne | ANO | - | - | - | - | Kód okresu |
| `okres` | Okres | string | Okres | ne | ANO | - | - | - | - | Okres |
| `obec` | Obec | string | Obec | ne | ANO | - | - | - | - | Obec |
| `stat` | Stát | relation | IdStatu | **ANO** | ANO | 20 | - | - | `stat` | Stát |
