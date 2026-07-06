# Pokročilá parametrizace pomocí parametrů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `parametr` |
| **Evidence Type** | `PARAM` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wParam` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/parametr` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/parametr/properties` |

## Vlastnosti (14)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdParam | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `paramK` | Parametr | select | ParamK | **ANO** | ANO | 50 | - | - | - | Parametr |
| `hodnota` | Hodnota | string | Hodnota | ne | ANO | - | - | - | - | Hodnota |
| `kodReportu` | Kód reportu | string | KodReportu | ne | ANO | 255 | - | - | - | Kód reportu |
| `enabled` | Zapnutí pokročilých parametrů | logic | Enabled | ne | ANO | - | - | - | - | Zapnutí pokročilých parametrů |
| `uzivatel` | Uživatel | relation | IdUzivatel | ne | ANO | 254 | - | - | `uzivatel` | Uživatel |
| `role` | Role uživatele | relation | IdRole | ne | ANO | - | - | - | `role` | Role uživatele |
| `stredisko` | Středisko | relation | IdStred | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `bsp` | Banka/pokladna/sklad | relation | IdBsp | ne | ANO | - | - | - | `bankovni-ucet-sklad-pokladna` | Banka/pokladna/sklad |
| `typDokl` | Typ dokladu | relation | IdTypDokl | ne | ANO | - | - | - | `typ-dokladu` | Typ dokladu |
| `firma` | Firma | relation | IdFirmy | ne | ANO | 20 | - | - | `adresar` | Firma |
| `skupFir` | Skupina | relation | IdSkupFir | ne | ANO | - | - | - | `skupina-firem` | Skupina |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
