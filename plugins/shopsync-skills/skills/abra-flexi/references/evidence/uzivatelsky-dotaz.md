# Uživatelské dotazy

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `uzivatelsky-dotaz` |
| **Evidence Type** | `UZIVATELSKY_DOTAZ` |
| **Import Status** | SUPPORTED |
| **DB Name** | `wDotazy` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/uzivatelsky-dotaz` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/uzivatelsky-dotaz/properties` |

## Vlastnosti (16)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDotaz | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `dotaz` | Dotaz | string | Dotaz | **ANO** | ANO | - | - | - | - | Dotaz |
| `masterBeanKey` | Primární formulář | string | MasterBeanKey | ne | ANO | 100 | - | - | - | Primární formulář |
| `privatni` | Privátní | logic | Privatni | ne | ANO | - | - | - | - | Privátní |
| `report` | Report | string | Report | ne | ANO | 255 | - | - | - | Report |
| `uuid` | Uuid | string | Uuid | ne | ne | 50 | - | - | - | Univerzální unikátní identifikátor |
| `masterFormId` | ID primární evidence | integer |  | ne | ANO | - | - | - | - | ID primární evidence |
| `uzivatel` | Uživatel | relation | IdUzivatel | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
