# Subjekt

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `subjekt` |
| **Evidence Type** | `SUBJEKT` |
| **Import Status** | DISALLOWED |
| **DB Name** | `wSubjekt` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/subjekt` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/subjekt/properties` |

## Vlastnosti (8)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | Idsubjekt | ne | ne | - | - | - | - | ID |
| `platiOd` | Platí od roku | date | PlatiOd | **ANO** | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | date | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `typVztahuK` | Typ vztahu | select | TypVztahuK | **ANO** | ANO | 50 | - | - | - | Typ vztahu |
| `definice` | Definice | string | Definice | **ANO** | ANO | - | - | - | - | Definice |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `tretiZeme` | Údaje jsou předávány do třetí země | logic | TretiZeme | **ANO** | ANO | - | - | - | - | Údaje jsou předávány do třetí země |
| `adresar` | Adresář | relation | Idadresar | ne | ANO | - | - | - | `adresar` | Adresář |
