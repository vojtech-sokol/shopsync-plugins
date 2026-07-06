# Práva viditelnosti dat

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `pravo-viditelnosti` |
| **Evidence Type** | `PRAVO_VIDITELNOSTI` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wDataPrava` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/pravo-viditelnosti` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/pravo-viditelnosti/properties` |

## Vlastnosti (6)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdDataPrava | ne | ne | - | - | - | - | ID |
| `idUzivatel` | uživatel | integer | IdUzivatel | ne | ANO | - | - | - | - | uživatel |
| `typDatK` | typ dat | select | TypDatK | ne | ANO | 50 | - | - | - | typ dat |
| `modulK` | modul | select | ModulK | ne | ANO | 50 | - | - | - | modul |
| `idObjektu` | objekt | integer | IdObjektu | ne | ANO | - | - | - | - | objekt |
| `editovat` | editovat | logic | Editovat | ne | ANO | - | - | - | - | editovat |
