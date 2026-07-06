# Vazby dokladu

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `vazba` |
| **Evidence Type** | `VAZBA_MEZI_DOKLADY` |
| **Import Status** | DISALLOWED |
| **DB Name** | `dVazebTab` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/vazba` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/vazba/properties` |

## Vlastnosti (4)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdVazby | ne | ne | - | - | - | - | ID |
| `typVazbyK` | Typ vazby | select | TypVazbyK | ne | ANO | 50 | - | - | - | Typ vazby |
| `castka` | Spárovaná částka | numeric | Castka | ne | ANO | - | 15 | 2 | - | Spárovaná částka |
| `storno` | Storno | logic | Storno | ne | ANO | - | - | - | - | Storno |
