# Stavy zakázek

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `stav-zakazky` |
| **Evidence Type** | `STAV_ZAKAZKY` |
| **Import Status** | SUPPORTED |
| **DB Name** | `uStavZakazky` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/stav-zakazky` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/stav-zakazky/properties` |

## Vlastnosti (10)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdStavZakazky | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `druhStavuZakK` | Druh stavu | select | DruhStavuZakK | ne | ANO | 50 | - | - | - | Druh stavu |
