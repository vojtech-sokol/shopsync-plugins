# Předdefinované texty

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `text` |
| **Evidence Type** | `TEXT` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wTexty` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/text` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/text/properties` |

## Vlastnosti (27)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdText | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `popis` | Text | string | Popis | ne | ANO | - | - | - | - | Text |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `vsbFav` | Vydané faktury | logic | VsbFav | ne | ANO | - | - | - | - | Vydané faktury |
| `vsbPhl` | Pohledávky | logic | VsbPhl | ne | ANO | - | - | - | - | Pohledávky |
| `vsbFap` | Přijaté faktury | logic | VsbFap | ne | ANO | - | - | - | - | Přijaté faktury |
| `vsbZav` | Závazky | logic | VsbZav | ne | ANO | - | - | - | - | Závazky |
| `vsbTxp` | Uplatnění daně - pohledávky | logic | VsbTxp | ne | ANO | - | - | - | - | Uplatnění daně - pohledávky |
| `vsbTxz` | Uplatnění daně - závazky | logic | VsbTxz | ne | ANO | - | - | - | - | Uplatnění daně - závazky |
| `vsbSkl` | Sklad | logic | VsbSkl | ne | ANO | - | - | - | - | Sklad |
| `vsbBan` | Banka | logic | VsbBan | ne | ANO | - | - | - | - | Banka |
| `vsbPok` | Pokladna | logic | VsbPok | ne | ANO | - | - | - | - | Pokladna |
| `vsbInt` | Interní doklady | logic | VsbInt | ne | ANO | - | - | - | - | Interní doklady |
| `vsbObp` | Objednávky přijaté | logic | VsbObp | ne | ANO | - | - | - | - | Objednávky přijaté |
| `vsbNav` | Nabídky vydané | logic | VsbNav | ne | ANO | - | - | - | - | Nabídky vydané |
| `vsbPpp` | Poptávky přijaté | logic | VsbPpp | ne | ANO | - | - | - | - | Poptávky přijaté |
| `vsbObv` | Objednávky vydané | logic | VsbObv | ne | ANO | - | - | - | - | Objednávky vydané |
| `vsbNap` | Nabídky přijaté | logic | VsbNap | ne | ANO | - | - | - | - | Nabídky přijaté |
| `vsbPpv` | Poptávky vydané | logic | VsbPpv | ne | ANO | - | - | - | - | Poptávky vydané |
| `vsbPopis` | Popis | logic | VsbPopis | ne | ANO | - | - | - | - | Popis |
| `vsbPoznamka` | Poznámka | logic | VsbPoznamka | ne | ANO | - | - | - | - | Poznámka |
| `vsbDoprava` | Doprava a vyskladnění | logic | VsbDoprava | ne | ANO | - | - | - | - | Doprava a vyskladnění |
| `vsbUvod` | Úvod | logic | VsbUvod | ne | ANO | - | - | - | - | Úvod |
| `vsbZaver` | Závěr | logic | VsbZaver | ne | ANO | - | - | - | - | Závěr |
| `vsbNazevPol` | Název položky | logic | VsbNazevPol | ne | ANO | - | - | - | - | Název položky |
| `vsbPoznamPol` | Poznámka položky | logic | VsbPoznamPol | ne | ANO | - | - | - | - | Poznámka položky |
