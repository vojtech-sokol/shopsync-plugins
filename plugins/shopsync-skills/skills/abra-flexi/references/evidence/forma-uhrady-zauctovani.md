# Zaúčtování formy úhrady

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `forma-uhrady-zauctovani` |
| **Evidence Type** | `FORMA_UHRADY_ZAUCTOVANI` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dFormaUhradyZauc` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/forma-uhrady-zauctovani` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/forma-uhrady-zauctovani/properties` |

## Vlastnosti (5)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdFormaUhradyZauc | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `formaUhradyCis` | Forma úhrady | relation | IdFormaUhradyCis | **ANO** | ANO | - | - | - | `forma-uhrady` | Forma úhrady |
| `typDokl` | Typ dokladu | relation | IdTypDokl | **ANO** | ANO | - | - | - | `typ-dokladu` | Typ dokladu |
| `kasa` | Prodejní kasa | relation | IdKasa | ne | ANO | - | - | - | `typ-dokladu` | Prodejní kasa |
