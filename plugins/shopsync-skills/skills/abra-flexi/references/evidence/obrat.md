# Obraty

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `obrat` |
| **Evidence Type** | `OBRAT` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `uObraty` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/obrat` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/obrat/properties` |

## Vlastnosti (15)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdObrat | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `obdobi` | Měsíc | integer | Obdobi | ne | ANO | - | - | - | - | Měsíc |
| `rok` | Rok | integer | Rok | ne | ANO | - | - | - | - | Rok |
| `obrDal` | Obrat DAL | numeric | ObrDal | ne | ANO | - | 15 | 2 | - | Obrat DAL |
| `obrMd` | Obrat MD | numeric | ObrMd | ne | ANO | - | 15 | 2 | - | Obrat MD |
| `obrDalBck` | Obrat DAL - původní | numeric | ObrDalBck | ne | ANO | - | 15 | 2 | - | Obrat DAL - původní |
| `obrMdBck` | Obrat MD - původní | numeric | ObrMdBck | ne | ANO | - | 15 | 2 | - | Obrat MD - původní |
| `uzivNastav` | Uživatelská hodnota | logic | UzivNastav | ne | ANO | - | - | - | - | Uživatelská hodnota |
| `rokMesic` | Kalendářní měsíc | date | date_trunc('month',to_date(rok \|\| '-' \|\| to_char(obdobi, '00'), 'YYYY-MM')) | ne | ANO | - | - | - | - | Kalendářní měsíc |
| `mena` | Měna | relation | IdMeny | **ANO** | ANO | - | - | - | `mena` | Měna |
| `ucet` | Účet | relation | IdUcet | **ANO** | ANO | 6 | - | - | `ucet` | Účet |
| `stredisko` | Středisko | relation | IdStred | **ANO** | ANO | - | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation | IdCinnost | ne | ANO | - | - | - | `cinnost` | Činnost |
| `ucetniObdobi` | Účetní období | relation | IdUcetObdobi | ne | ANO | - | - | - | `ucetni-obdobi` | Účetní období |
