# Parametry

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `uzivatelsky-dotaz-parametr` |
| **Evidence Type** | `UZIVATELSKY_DOTAZ_PARAMETR` |
| **Import Status** | NOT_DIRECT |
| **DB Name** | `wDotazyParam` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/uzivatelsky-dotaz-parametr` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/uzivatelsky-dotaz-parametr/properties` |

## Vlastnosti (16)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDotazParam | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 50 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `cisRad` | Pořadí | integer | CisRad | ne | ANO | - | - | - | - | Pořadí |
| `typParamK` | Typ | select | TypParamK | **ANO** | ANO | 50 | - | - | - | Typ |
| `vychozi` | Výchozí hodnota | string | Vychozi | ne | ANO | - | - | - | - | Výchozí hodnota |
| `mohutnostN` | Mohutnost N | logic | MohutnostN | ne | ANO | - | - | - | - | Mohutnost N |
| `beanKey` | Výběr z | string | BeanKey | ne | ANO | 100 | - | - | - | Výběr z |
| `povinny` | Povinný | logic | Povinny | ne | ANO | - | - | - | - | Povinný |
| `dotaz` | Dotaz | relation | IdDotaz | **ANO** | ANO | - | - | - | `uzivatelsky-dotaz` | Dotaz |
