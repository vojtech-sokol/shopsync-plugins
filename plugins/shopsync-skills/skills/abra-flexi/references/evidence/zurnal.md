# Žurnál

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `zurnal` |
| **Evidence Type** | `ZURNAL` |
| **Import Status** | DISALLOWED |
| **DB Name** | `wZurnal` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/zurnal` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/zurnal/properties` |

## Vlastnosti (10)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdZurnal | ne | ne | - | - | - | - | ID |
| `tabulka` | Tabulka | string | Tabulka | **ANO** | ANO | 255 | - | - | - | Tabulka |
| `idZaznamu` | ID řádky | integer | IdZaznamu | **ANO** | ANO | - | - | - | - | ID řádky |
| `sloupec` | Sloupec | string | Sloupec | ne | ANO | 255 | - | - | - | Sloupec |
| `novaHod` | Nová hodnota | string | NovaHod | ne | ANO | - | - | - | - | Nová hodnota |
| `staraHod` | Původní hodnota | string | StaraHod | ne | ANO | - | - | - | - | Původní hodnota |
| `op` | Operace | string | Op | ne | ANO | 50 | - | - | - | Operace |
| `transakceK` | Transakce | select | TransakceK | ne | ANO | 50 | - | - | - | Transakce |
| `uziv` | Uživatel | string | Uziv | ne | ANO | 63 | - | - | - | Uživatel |
| `datCas` | Čas změny | datetime | DatCas | **ANO** | ANO | - | - | - | - | Čas změny |
