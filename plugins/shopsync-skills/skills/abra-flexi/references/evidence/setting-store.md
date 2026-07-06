# Úložiště nastavení

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `setting-store` |
| **Evidence Type** | `SETTING` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wSetting` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/setting-store` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/setting-store/properties` |

## Vlastnosti (4)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSetting | ne | ne | - | - | - | - | ID |
| `klic` | Klíč | string | Klic | ne | ANO | 255 | - | - | - | Klíč |
| `hodnota` | Hodnota | string | Hodnota | ne | ANO | - | - | - | - | Hodnota |
| `uzivatelId` | Uživatel | integer | IdUzivatel | ne | ne | - | - | - | - | Uživatel |
