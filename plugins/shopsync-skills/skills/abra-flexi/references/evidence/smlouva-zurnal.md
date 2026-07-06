# Žurnál pro smlouvy

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `smlouva-zurnal` |
| **Evidence Type** | `SMLOUVA_ZURNAL` |
| **Import Status** | DISALLOWED |
| **DB Name** | `dZurnalSml` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/smlouva-zurnal` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/smlouva-zurnal/properties` |

## Vlastnosti (8)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdZurnalSml | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `datCas` | Datum a čas | datetime | DatCas | **ANO** | ANO | - | - | - | - | Datum a čas |
| `transakceK` | Operace | select | TransakceK | **ANO** | ANO | 50 | - | - | - | Operace |
| `pocetOk` | Počet vygenerovaných faktur | integer | PocetOk | ne | ANO | - | - | - | - | Počet vygenerovaných faktur |
| `pocetErr` | Počet nevygenerovaných faktur | integer | PocetErr | ne | ANO | - | - | - | - | Počet nevygenerovaných faktur |
| `chyby` | Seznam chyb | string | Chyby | ne | ANO | - | - | - | - | Seznam chyb |
| `uzivatel` | Uživatel | relation | IdUziv | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
