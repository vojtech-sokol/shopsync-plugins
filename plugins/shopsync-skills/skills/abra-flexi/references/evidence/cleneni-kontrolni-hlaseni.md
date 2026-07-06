# Řádky kontrolního hlášení DPH

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `cleneni-kontrolni-hlaseni` |
| **Evidence Type** | `CLEN_KON_VYK_DPH` |
| **Import Status** | DISALLOWED |
| **DB Name** | `uClenKonVykDph` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/cleneni-kontrolni-hlaseni` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/cleneni-kontrolni-hlaseni/properties` |

## Vlastnosti (17)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdClenKonVykDPH | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `vyplnCisKod` | Vyplňovat číselný kód zboží | logic | VyplnCisKod | ne | ANO | - | - | - | - | Vyplňovat číselný kód zboží |
| `vyplnDruh` | Vyplňovat druh zboží | logic | VyplnDruh | ne | ANO | - | - | - | - | Vyplňovat druh zboží |
| `kodTransakce` | Zkratka XML transakce | string | KodTransakce | ne | ANO | 20 | - | - | - | Zkratka XML transakce |
| `typPohybuK` | Typ pohybu | select | TypPohybuK | ne | ANO | 50 | - | - | - | Typ pohybu |
| `uuid` | Uuid | string | Uuid | ne | ne | 50 | - | - | - | Univerzální unikátní identifikátor |
| `stat` | Stát | relation | IdStatu | ne | ANO | 3 | - | - | `stat` | Stát |
