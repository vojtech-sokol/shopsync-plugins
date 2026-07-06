# Atributy

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `atribut` |
| **Evidence Type** | `ATRIBUT` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `cAtribut` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/atribut` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/atribut/properties` |

## Vlastnosti (16)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdAtribut | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `valBoolean` | Logická hodnota | logic | ValBoolean | ne | ANO | - | - | - | - | Logická hodnota |
| `valInteger` | Celé číslo | integer | ValInteger | ne | ANO | - | - | - | - | Celé číslo |
| `valNumeric` | Desetinné číslo | numeric | ValNumeric | ne | ANO | - | - | - | - | Desetinné číslo |
| `valString` | Řetězec | string | ValString | ne | ANO | - | - | - | - | Řetězec |
| `valDatCas` | Datum | datetime | ValDatCas | ne | ANO | - | - | - | - | Datum |
| `hodnota` | Hodnota | string | Hodnota | ne | ANO | - | - | - | - | Hodnota |
| `mj` | MJ | string |  | ne | ne | - | - | - | - | MJ |
| `cenik` | Ceník | relation | IdCenik | ne | ANO | 64 | - | - | `cenik` | Ceník |
| `doklObch` | Obchodní doklad | relation | IdDoklObch | ne | ANO | - | - | - | - | Obchodní doklad |
| `doklFak` | Doklad faktury | relation | IdDoklFak | ne | ANO | - | - | - | - | Doklad faktury |
| `doklSklad` | Příjemka/výdejka | relation | IdDoklSklad | ne | ANO | - | - | - | `skladovy-pohyb` | Příjemka/výdejka |
| `doklInt` | Interní doklad | relation | IdDoklInt | ne | ANO | - | - | - | - | Interní doklad |
| `adresar` | Adresář | relation | IdAdresar | ne | ANO | - | - | - | `adresar` | Adresář |
| `typAtributu` | Typ atributu | relation | IdTypAtribut | **ANO** | ANO | 20 | - | - | `typ-atributu` | Typ atributu |
