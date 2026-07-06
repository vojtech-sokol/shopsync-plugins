# Řádek sestavy

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `radek-sestavy` |
| **Evidence Type** | `RADEK_SESTAVY` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `uSesRadky` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/radek-sestavy` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/radek-sestavy/properties` |

## Vlastnosti (19)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSesRadky | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `cisRad` | Číslo řádku | integer | CisRad | ne | ANO | - | 4 | - | - | Číslo řádku |
| `kodRad` | Kód řádku | string | KodRad | ne | ANO | 20 | - | - | - | Kód řádku |
| `cisRadXml` | Číslo řádku pro XML | integer | CisRadXml | ne | ANO | - | 4 | - | - | Číslo řádku pro XML |
| `oznaceni` | Označení | string | Oznaceni | ne | ANO | 255 | - | - | - | Označení |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `hod1` | Hodnota 1 | numeric | Hod1 | ne | ANO | - | 15 | 2 | - | Hodnota 1 |
| `hod2` | Hodnota 2 | numeric | Hod2 | ne | ANO | - | 15 | 2 | - | Hodnota 2 |
| `hod3` | Hodnota 3 | numeric | Hod3 | ne | ANO | - | 15 | 2 | - | Hodnota 3 |
| `hod4` | Hodnota 4 | numeric | Hod4 | ne | ANO | - | 15 | 2 | - | Hodnota 4 |
| `hod5` | Hodnota 5 | numeric | Hod5 | ne | ANO | - | 15 | 2 | - | Hodnota 5 |
| `hod6` | Hodnota 6 | numeric | Hod6 | ne | ANO | - | 15 | 2 | - | Hodnota 6 |
| `ucetniSestava` | Účetní sestava | relation | IdSestavy | ne | ne | 6 | - | - | `sestava` | Účetní sestava |
