# Přehled všech dokladů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `doklad` |
| **Evidence Type** | `DOKLAD_VIEW` |
| **Import Status** | DISALLOWED |
| **DB Name** | `DokladView` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/doklad` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/doklad/properties` |

## Vlastnosti (13)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `idDokladView` | ID (náhled) | integer |  | ne | ANO | - | - | - | - | ID (náhled) |
| `idDokl` | ID dokladu | integer |  | ne | ANO | - | - | - | - | ID dokladu |
| `kod` | Zkratka | string |  | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `popis` | Popis | string |  | ne | ANO | - | - | - | - | Popis |
| `varSym` | Variabilní symbol | string |  | ne | ANO | 30 | - | - | - | Variabilní symbol |
| `sumCelkem` | Celkem [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem [Kč] |
| `nazFirmy` | Název firmy nebo jméno osoby | string |  | ne | ANO | 255 | - | - | - | Název firmy - jméno |
| `ic` | IČO | string |  | ne | ANO | 20 | - | - | - | IČO |
| `dic` | DIČ | string |  | ne | ANO | 20 | - | - | - | DIČ |
| `faNazev` | Pošt. jméno firmy | string |  | ne | ANO | 255 | - | - | - | Firma |
| `modul` | Modul | string |  | ne | ANO | - | - | - | - | Modul |
| `evdName` | Název evidence | string |  | ne | ANO | - | - | - | - | Název evidence |
| `subModul` | Podmodul (zápočet, prodejka) | logic |  | ne | ANO | - | - | - | - | Podmodul (zápočet, prodejka) |
