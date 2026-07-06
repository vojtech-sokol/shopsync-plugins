# Souhrnné hlášení k DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `souhrnne-hlaseni-dph` |
| **Evidence Type** | `SOUHRNNE_HLASENI_DPH` |
| **Import Status** | DISALLOWED |
| **DB Name** | `SouhrnneHlaseni` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/souhrnne-hlaseni-dph` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/souhrnne-hlaseni-dph/properties` |

## Vlastnosti (6)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `kodStatu` | Kód země | string |  | ne | ANO | - | - | - | - | Kód země |
| `kodDphStatu` | Kód země (DPH) | string |  | ne | ANO | - | - | - | - | Kód země (DPH) |
| `dic` | DIČ | string |  | ne | ANO | 20 | - | - | - | DIČ |
| `kodPlneni` | Kód plnění | string |  | ne | ANO | - | - | - | - | Kód plnění |
| `pocetPlneni` | Počet plnění | integer |  | ne | ANO | - | - | - | - | Počet plnění |
| `sumZkl` | Základ [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ [Kč] |
