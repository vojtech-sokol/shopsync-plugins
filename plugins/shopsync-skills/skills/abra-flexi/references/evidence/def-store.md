# Úložiště definic

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `def-store` |
| **Evidence Type** | `DEF_STORE` |
| **Import Status** | SUPPORTED |
| **DB Name** | `defstore` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/def-store` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/def-store/properties` |

## Vlastnosti (15)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDefStore | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `privatni` | Privátní | logic | Privatni | ne | ANO | - | - | - | - | Privátní |
| `data` | Data | string | Data | ne | ANO | - | - | - | - | Data |
| `klic` | Klíč | string | Klic | ne | ANO | - | - | - | - | Klíč |
| `showBeanKeys` | Místa použití | string | ShowBeanKeys | ne | ANO | - | - | - | - | Místa použití |
| `definitionTypeK` | Typ definice | select | DefinitionTypeK | ne | ANO | - | - | - | - | Typ definice |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `uzivatel` | Vlastník definice | relation | Uzivatel | ne | ne | 254 | - | - | `uzivatel` | Vlastník definice |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
