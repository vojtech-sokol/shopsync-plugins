# Úhrada

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `prodejka-platba` |
| **Evidence Type** | `PRODEJKA_PLATBA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dFormaUhrady` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/prodejka-platba` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/prodejka-platba/properties` |

## Vlastnosti (15)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdFormaUhrady | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kurz` | Kurz | numeric | Kurz | ne | ANO | - | 19 | 6 | - | Kurz |
| `kurzMnozstvi` | Kurz. množství | numeric | KurzMnozstvi | ne | ANO | - | 19 | 6 | - | Kurz. množství |
| `castka` | Částka | numeric | Castka | ne | ANO | - | 15 | 2 | - | Částka |
| `castkaMen` | Částka [měna] | numeric | CastkaMen | ne | ANO | - | 15 | 2 | - | Částka [měna] |
| `mnozCenin` | Množství cenin | integer | MnozCenin | ne | ANO | - | - | - | - | Množství cenin |
| `castkaCenin` | Částka ceniny | numeric | CastkaCenin | ne | ANO | - | 15 | 2 | - | Částka ceniny |
| `strojParamUhr` | Strojové parametry úhrady | string | StrojParamUhr | ne | ANO | 255 | - | - | - | Strojové parametry úhrady |
| `cisloKarty` | Číslo karty | string | CisloKarty | ne | ANO | 100 | - | - | - | Číslo karty |
| `vratit` | Vrátit | numeric | Vratit | ne | ANO | - | 15 | 2 | - | Vrátit |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `formaUhradyCis` | Forma úhrady | relation | IdFormaUhradyCis | **ANO** | ANO | - | - | - | `forma-uhrady` | Forma úhrady |
| `doklFak` | Doklad faktury | relation | IdDoklFak | ne | ANO | - | - | - | - | Doklad faktury |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
