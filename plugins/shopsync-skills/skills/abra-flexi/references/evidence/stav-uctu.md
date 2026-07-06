# Stavy účtů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `stav-uctu` |
| **Evidence Type** | `STAV_UCTU` |
| **Import Status** | DISALLOWED |
| **DB Name** | `StavyUctu` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/stav-uctu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/stav-uctu/properties` |

## Vlastnosti (126)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `ucet` | Účet | relation |  | ne | ANO | - | - | - | `ucet` | Účet |
| `mena` | Měna | relation |  | ne | ANO | - | - | - | `mena` | Měna |
| `ucetniObdobi` | Účetní období | relation |  | ne | ANO | - | - | - | `ucetni-obdobi` | Účetní období |
| `nazevUctu` | Název účtu | string |  | ne | ANO | - | - | - | - | Název účtu |
| `stredisko` | Středisko | relation |  | ne | ANO | 20 | - | - | `stredisko` | Středisko |
| `cinnost` | Činnost | relation |  | ne | ANO | - | - | - | `cinnost` | Činnost |
| `pocatek` | Počátek | numeric |  | ne | ANO | - | 15 | 2 | - | Počátek |
| `pocatekMD` | Počátek MD | numeric |  | ne | ANO | - | 15 | 2 | - | Počátek MD |
| `pocatekDal` | Počátek Dal | numeric |  | ne | ANO | - | 15 | 2 | - | Počátek Dal |
| `zustatekMD` | Zůstatek MD | numeric |  | ne | ANO | - | 15 | 2 | - | Zůstatek MD |
| `zustatekDal` | Zůstatek Dal | numeric |  | ne | ANO | - | 15 | 2 | - | Zůstatek Dal |
| `obratMd01` | Obrat MD 01 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 01 |
| `obratDal01` | Obrat DAL 01 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 01 |
| `stavMd01` | Stav MD 01 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 01 |
| `stavDal01` | Stav DAL 01 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 01 |
| `stav01` | Stav 01 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 01 |
| `obratMd02` | Obrat MD 02 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 02 |
| `obratDal02` | Obrat DAL 02 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 02 |
| `stavMd02` | Stav MD 02 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 02 |
| `stavDal02` | Stav DAL 02 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 02 |
| `stav02` | Stav 02 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 02 |
| `obratMd03` | Obrat MD 03 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 03 |
| `obratDal03` | Obrat DAL 03 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 03 |
| `stavMd03` | Stav MD 03 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 03 |
| `stavDal03` | Stav DAL 03 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 03 |
| `stav03` | Stav 03 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 03 |
| `obratMd04` | Obrat MD 04 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 04 |
| `obratDal04` | Obrat DAL 04 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 04 |
| `stavMd04` | Stav MD 04 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 04 |
| `stavDal04` | Stav DAL 04 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 04 |
| `stav04` | Stav 04 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 04 |
| `obratMd05` | Obrat MD 05 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 05 |
| `obratDal05` | Obrat DAL 05 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 05 |
| `stavMd05` | Stav MD 05 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 05 |
| `stavDal05` | Stav DAL 05 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 05 |
| `stav05` | Stav 05 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 05 |
| `obratMd06` | Obrat MD 06 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 06 |
| `obratDal06` | Obrat DAL 06 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 06 |
| `stavMd06` | Stav MD 06 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 06 |
| `stavDal06` | Stav DAL 06 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 06 |
| `stav06` | Stav 06 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 06 |
| `obratMd07` | Obrat MD 07 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 07 |
| `obratDal07` | Obrat DAL 07 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 07 |
| `stavMd07` | Stav MD 07 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 07 |
| `stavDal07` | Stav DAL 07 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 07 |
| `stav07` | Stav 07 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 07 |
| `obratMd08` | Obrat MD 08 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 08 |
| `obratDal08` | Obrat DAL 08 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 08 |
| `stavMd08` | Stav MD 08 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 08 |
| `stavDal08` | Stav DAL 08 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 08 |
| `stav08` | Stav 08 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 08 |
| `obratMd09` | Obrat MD 09 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 09 |
| `obratDal09` | Obrat DAL 09 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 09 |
| `stavMd09` | Stav MD 09 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 09 |
| `stavDal09` | Stav DAL 09 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 09 |
| `stav09` | Stav 09 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 09 |
| `obratMd10` | Obrat MD 10 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 10 |
| `obratDal10` | Obrat DAL 10 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 10 |
| `stavMd10` | Stav MD 10 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 10 |
| `stavDal10` | Stav DAL 10 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 10 |
| `stav10` | Stav 10 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 10 |
| `obratMd11` | Obrat MD 11 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 11 |
| `obratDal11` | Obrat DAL 11 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 11 |
| `stavMd11` | Stav MD 11 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 11 |
| `stavDal11` | Stav DAL 11 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 11 |
| `stav11` | Stav 11 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 11 |
| `obratMd12` | Obrat MD 12 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 12 |
| `obratDal12` | Obrat DAL 12 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 12 |
| `stavMd12` | Stav MD 12 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 12 |
| `stavDal12` | Stav DAL 12 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 12 |
| `stav12` | Stav 12 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 12 |
| `obratMd13` | Obrat MD 13 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 13 |
| `obratDal13` | Obrat DAL 13 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 13 |
| `stavMd13` | Stav MD 13 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 13 |
| `stavDal13` | Stav DAL 13 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 13 |
| `stav13` | Stav 13 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 13 |
| `obratMd14` | Obrat MD 14 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 14 |
| `obratDal14` | Obrat DAL 14 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 14 |
| `stavMd14` | Stav MD 14 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 14 |
| `stavDal14` | Stav DAL 14 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 14 |
| `stav14` | Stav 14 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 14 |
| `obratMd15` | Obrat MD 15 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 15 |
| `obratDal15` | Obrat DAL 15 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 15 |
| `stavMd15` | Stav MD 15 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 15 |
| `stavDal15` | Stav DAL 15 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 15 |
| `stav15` | Stav 15 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 15 |
| `obratMd16` | Obrat MD 16 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 16 |
| `obratDal16` | Obrat DAL 16 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 16 |
| `stavMd16` | Stav MD 16 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 16 |
| `stavDal16` | Stav DAL 16 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 16 |
| `stav16` | Stav 16 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 16 |
| `obratMd17` | Obrat MD 17 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 17 |
| `obratDal17` | Obrat DAL 17 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 17 |
| `stavMd17` | Stav MD 17 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 17 |
| `stavDal17` | Stav DAL 17 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 17 |
| `stav17` | Stav 17 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 17 |
| `obratMd18` | Obrat MD 18 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 18 |
| `obratDal18` | Obrat DAL 18 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 18 |
| `stavMd18` | Stav MD 18 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 18 |
| `stavDal18` | Stav DAL 18 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 18 |
| `stav18` | Stav 18 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 18 |
| `obratMd19` | Obrat MD 19 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 19 |
| `obratDal19` | Obrat DAL 19 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 19 |
| `stavMd19` | Stav MD 19 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 19 |
| `stavDal19` | Stav DAL 19 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 19 |
| `stav19` | Stav 19 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 19 |
| `obratMd20` | Obrat MD 20 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 20 |
| `obratDal20` | Obrat DAL 20 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 20 |
| `stavMd20` | Stav MD 20 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 20 |
| `stavDal20` | Stav DAL 20 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 20 |
| `stav20` | Stav 20 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 20 |
| `obratMd21` | Obrat MD 21 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 21 |
| `obratDal21` | Obrat DAL 21 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 21 |
| `stavMd21` | Stav MD 21 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 21 |
| `stavDal21` | Stav DAL 21 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 21 |
| `stav21` | Stav 21 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 21 |
| `obratMd22` | Obrat MD 22 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 22 |
| `obratDal22` | Obrat DAL 22 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 22 |
| `stavMd22` | Stav MD 22 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 22 |
| `stavDal22` | Stav DAL 22 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 22 |
| `stav22` | Stav 22 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 22 |
| `obratMd23` | Obrat MD 23 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD 23 |
| `obratDal23` | Obrat DAL 23 | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL 23 |
| `stavMd23` | Stav MD 23 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav MD 23 |
| `stavDal23` | Stav DAL 23 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav DAL 23 |
| `stav23` | Stav 23 | numeric |  | ne | ANO | - | 15 | 2 | - | Stav 23 |
