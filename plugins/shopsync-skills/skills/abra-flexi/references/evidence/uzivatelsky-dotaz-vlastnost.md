# Vlastnosti

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `uzivatelsky-dotaz-vlastnost` |
| **Evidence Type** | `UZIVATELSKY_DOTAZ_VLASTNOST` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `wDotazyProp` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/uzivatelsky-dotaz-vlastnost` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/uzivatelsky-dotaz-vlastnost/properties` |

## Vlastnosti (17)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDotazProp | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 50 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `cisRad` | Pořadí | integer | CisRad | ne | ANO | - | - | - | - | Pořadí |
| `typPropK` | Typ | select | TypPropK | **ANO** | ANO | 50 | - | - | - | Typ |
| `hideColumn` | Skrýt sloupec | logic | HideColumn | ne | ANO | - | - | - | - | Skrýt sloupec |
| `beanKeyOpen` | Klíč pro tabulku | string | BeanKeyOpen | ne | ANO | 100 | - | - | - | Klíč pro tabulku |
| `width` | Šířka | integer | Width | **ANO** | ANO | - | - | - | - | Šířka |
| `resourceBeanKey` | Zdrojová tabulka | string | ResourceBeanKey | ne | ANO | 100 | - | - | - | Zdrojová tabulka |
| `resourcePropName` | Zdrojové pole | string | ResourcePropName | ne | ANO | 100 | - | - | - | Zdrojové pole |
| `dotaz` | Dotaz | relation | IdDotaz | **ANO** | ANO | - | - | - | `uzivatelsky-dotaz` | Dotaz |
