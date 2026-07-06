# Obratová předvaha

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `obratova-predvaha` |
| **Evidence Type** | `OBRATOVA_PREDVAHA` |
| **Import Status** | DISALLOWED |
| **DB Name** | `ObratovaPredvaha` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/obratova-predvaha` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/obratova-predvaha/properties` |

## Vlastnosti (16)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `idObratovaPredvaha` | ID | integer |  | ne | ANO | - | - | - | - | ID |
| `ucet` | Účet | relation |  | ne | ANO | - | - | - | `ucet` | Účet |
| `mena` | Měna | relation |  | ne | ANO | - | - | - | `mena` | Měna |
| `ucetniObdobi` | Účetní období | relation |  | ne | ANO | - | - | - | `ucetni-obdobi` | Účetní období |
| `nazevUctu` | Název účtu | string |  | ne | ANO | - | - | - | - | Název účtu |
| `pocatek` | Počátek vše | numeric |  | ne | ANO | - | 15 | 2 | - | Počátek vše |
| `pocatekMd` | Počátek MD za vybr. obd. | numeric |  | ne | ANO | - | 15 | 2 | - | Počátek MD za vybr. obd. |
| `pocatekDal` | Počátek DAL za vybr. obd. | numeric |  | ne | ANO | - | 15 | 2 | - | Počátek DAL za vybr. obd. |
| `pocatekMesic` | Počátek za vybr. obd. | numeric |  | ne | ANO | - | 15 | 2 | - | Počátek za vybr. obd. |
| `zustatek` | Zůstatek za vybr. obd. | numeric |  | ne | ANO | - | 15 | 2 | - | Zůstatek za vybr. obd. |
| `zustatekMd` | Zůstatek MD za vybr. obd. | numeric |  | ne | ANO | - | 15 | 2 | - | Zůstatek MD za vybr. obd. |
| `zustatekDal` | Zůstatek DAL za vybr. obd. | numeric |  | ne | ANO | - | 15 | 2 | - | Zůstatek DAL za vybr. obd. |
| `obratMdVse` | Obrat MD vše | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD vše |
| `obratDalVse` | Obrat DAL vše | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL vše |
| `obratMdVyb` | Obrat MD za vybr. obd. | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat MD za vybrané období |
| `obratDalVyb` | Obrat DAL za vybr. obd. | numeric |  | ne | ANO | - | 15 | 2 | - | Obrat DAL za vybrané období |
