# Přístupová práva

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `pristupove-pravo` |
| **Evidence Type** | `PRISTUPOVE_PRAVO` |
| **Import Status** | DISALLOWED |
| **DB Name** | `wPristPrava` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/pristupove-pravo` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/pristupove-pravo/properties` |

## Vlastnosti (6)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPristPrava | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `typeK` | Typ přístupu | select | TypeK | **ANO** | ANO | 50 | - | - | - | Typ přístupu |
| `groupKey` | Klíč přístupového práva | string | GroupKey | ne | ANO | - | - | - | - | Klíč přístupového práva |
| `role` | Role uživatele | relation | IdRole | ne | ne | - | - | - | `role` | Role uživatele |
| `featureK` | Upřesňující přístupová práva | array | string_to_array(features, ',') | ne | ANO | - | - | - | - | Upřesňující přístupová práva |
