# Roční položky dokladové řady

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `rocni-rada` |
| **Evidence Type** | `ROCNI_RADA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dRadyRok` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/rocni-rada` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/rocni-rada/properties` |

## Vlastnosti (10)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdRadyRok | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `cisDelka` | Délka čísla | integer | CisDelka | **ANO** | ANO | - | - | - | - | Délka čísla |
| `zobrazNuly` | Zobrazit nuly | logic | ZobrazNuly | ne | ANO | - | - | - | - | Zobrazit nuly |
| `cisAkt` | Akt.číslo | integer | CisAkt | ne | ANO | - | - | - | - | Akt.číslo |
| `cisPoc` | Počátek | integer | CisPoc | ne | ANO | - | - | - | - | Počátek |
| `prefix` | Prefix | string | Prefix | ne | ANO | 8 | - | - | - | Prefix |
| `postfix` | Postfix | string | Postfix | ne | ANO | 8 | - | - | - | Postfix |
| `rada` | Čís. řada | relation | IdRady | **ANO** | ANO | - | - | - | `rada` | Čís. řada |
| `ucetObdobi` | Účetní období | relation | IdUcetObdobi | **ANO** | ANO | 20 | - | - | `ucetni-obdobi` | Účetní období |
