# Příkaz k úhradě

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `prikaz-k-uhrade` |
| **Evidence Type** | `PRIKAZ_K_UHRADE` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dPrikazUhr` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/prikaz-k-uhrade` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/prikaz-k-uhrade/properties` |

## Vlastnosti (20)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPrikazUhr | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `datVytvor` | Datum vytvoření | date | DatVytvor | ne | ne | - | - | - | - | Datum vytvoření |
| `datSplat` | Splatnost | date | DatSplat | **ANO** | ANO | - | - | - | - | Splatnost |
| `celCastka` | Celková částka | numeric | CelCastka | ne | ne | - | 15 | 2 | - | Celková částka |
| `jmenoSoub` | Jméno souboru | string | JmenoSoub | ne | ne | 255 | - | - | - | Jméno souboru |
| `poradiPrikaz` | Pořadové číslo ve dni | integer | PoradiPrikaz | ne | ne | - | 4 | - | - | Pořadové číslo ve dni |
| `stavPrikazK` | Stav příkazu | select | StavPrikazK | ne | ne | 50 | - | - | - | Stav příkazu |
| `nazFirmy` | Název firmy nebo jméno osoby | string | NazFirmy | ne | ANO | 255 | - | - | - | Název firmy - jméno |
| `faUlice` | Pošt. ulice | string | FaUlice | ne | ANO | 255 | - | - | - | Ulice |
| `faMesto` | Pošt. město | string | FaMesto | ne | ANO | 255 | - | - | - | Město |
| `faPsc` | Pošt. PSČ | string | FaPsc | ne | ANO | 255 | - | - | - | PSČ |
| `konSym` | Konstantní symbol | string | KonSym | ne | ANO | 20 | - | - | - | Konstantní symbol |
| `zahranicni` | Zahraniční | logic | Zahranicni | ne | ANO | - | - | - | - | Zahraniční |
| `bezPopisu` | Skrýt popis a příjemce platby při exportu | logic | BezPopisu | ne | ANO | - | - | - | - | Skrýt popis a příjemce platby při exportu |
| `datSplatZHlavicky` | Datum splatnosti z hlavičky příkazu | logic | DatSplatZHlavicky | ne | ANO | - | - | - | - | Datum splatnosti z hlavičky příkazu |
| `mena` | Měna | relation | IdMeny | **ANO** | ANO | - | - | - | `mena` | Měna |
| `banka` | Účet | relation | IdBanka | **ANO** | ANO | - | - | - | `bankovni-ucet` | Účet |
| `faStat` | Pošt. stát | relation | IdFaStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `faRegion` | Pošt. kraj | relation | IdFaRegionu | ne | ANO | - | - | - | `region` | Kraj |
