# Štítky

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `stitek` |
| **Evidence Type** | `STITEK` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wVybKlice` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/stitek` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/stitek/properties` |

## Vlastnosti (32)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdVybKlice | ne | ne | - | - | - | - | ID |
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
| `vsbAdr` | Adresář | logic | VsbAdr | ne | ANO | - | - | - | - | Adresář |
| `vsbKatalog` | Ceník | logic | VsbKatalog | ne | ANO | - | - | - | - | Ceník |
| `vsbSkl` | Sklad | logic | VsbSkl | ne | ANO | - | - | - | - | Sklad |
| `vsbFav` | Vydané faktury | logic | VsbFav | ne | ANO | - | - | - | - | Vydané faktury |
| `vsbPhl` | Pohledávky | logic | VsbPhl | ne | ANO | - | - | - | - | Pohledávky |
| `vsbFap` | Přijaté faktury | logic | VsbFap | ne | ANO | - | - | - | - | Přijaté faktury |
| `vsbZav` | Závazky | logic | VsbZav | ne | ANO | - | - | - | - | Závazky |
| `vsbTxz` | Uplatnění daně - závazky | logic | VsbTxz | ne | ANO | - | - | - | - | Uplatnění daně - závazky |
| `vsbBan` | Banka | logic | VsbBan | ne | ANO | - | - | - | - | Banka |
| `vsbPok` | Pokladna | logic | VsbPok | ne | ANO | - | - | - | - | Pokladna |
| `vsbInt` | Interní doklady | logic | VsbInt | ne | ANO | - | - | - | - | Interní doklady |
| `vsbMaj` | Majetek | logic | VsbMaj | ne | ANO | - | - | - | - | Majetek |
| `vsbObp` | Objednávky přijaté | logic | VsbObp | ne | ANO | - | - | - | - | Objednávky přijaté |
| `vsbNav` | Nabídky vydané | logic | VsbNav | ne | ANO | - | - | - | - | Nabídky vydané |
| `vsbPpp` | Poptávky přijaté | logic | VsbPpp | ne | ANO | - | - | - | - | Poptávky přijaté |
| `vsbObv` | Objednávky vydané | logic | VsbObv | ne | ANO | - | - | - | - | Objednávky vydané |
| `vsbNap` | Nabídky přijaté | logic | VsbNap | ne | ANO | - | - | - | - | Nabídky přijaté |
| `vsbPpv` | Poptávky vydané | logic | VsbPpv | ne | ANO | - | - | - | - | Poptávky vydané |
| `vsbMzd` | Mzdy | logic | VsbMzd | ne | ANO | - | - | - | - | Mzdy |
| `vsbCis` | Číselníky | logic | VsbCis | ne | ANO | - | - | - | - | Číselníky |
| `skupVybKlic` | Skupina štítků | relation | IdSkupVybKlic | ne | ANO | - | - | - | `skupina-stitku` | Skupina štítků |
