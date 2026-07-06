# Úložiště globálního nastavení

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `global-store` |
| **Evidence Type** | `GLOBAL_SETTING` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wSetting` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/global-store` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/global-store/properties` |

## Vlastnosti (3)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSetting | ne | ne | - | - | - | - | ID |
| `klic` | Klíč | string | Klic | ne | ANO | 255 | - | - | - | Klíč |
| `hodnota` | Hodnota | string | Hodnota | ne | ANO | - | - | - | - | Hodnota |
