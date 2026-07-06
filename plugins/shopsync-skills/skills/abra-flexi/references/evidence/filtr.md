# Uživatelské filtry

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `filtr` |
| **Evidence Type** | `FILTR` |
| **Import Status** | SUPPORTED |
| **DB Name** | `wFiltry` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/filtr` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/filtr/properties` |

## Vlastnosti (12)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdFiltru | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | ne | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `beanKey` | Formulář | string | BeanKey | **ANO** | ANO | 50 | - | - | - | Formulář |
| `obsahFiltru` | Obsah filtru | string | ObsahFiltru | ne | ANO | - | - | - | - | Obsah filtru |
| `privatni` | Privátní | logic | Privatni | ne | ANO | - | - | - | - | Privátní |
| `navrhar` | Návrhář | logic | Navrhar | ne | ANO | - | - | - | - | Návrhář |
| `saveColumns` | Uložit nastavení sloupců | logic | SaveColumns | ne | ANO | - | - | - | - | Uložit nastavení sloupců |
| `lastUsage` | Poslední použití | datetime | LastUsage | ne | ANO | - | - | - | - | Poslední použití |
| `usageCnt` | Počet použití | integer | UsageCnt | ne | ANO | - | - | - | - | Počet použití |
| `uzivatel` | Uživatel | relation | IdUzivatel | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
