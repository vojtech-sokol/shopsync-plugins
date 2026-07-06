# Místa určení

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `misto-urceni` |
| **Evidence Type** | `MISTO_URCENI` |
| **Import Status** | SUPPORTED |
| **DB Name** | `aMistUrc` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/misto-urceni` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/misto-urceni/properties` |

## Vlastnosti (25)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdMur | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `ulice` | Ulice | string | Ulice | ne | ANO | 255 | - | - | - | Ulice |
| `mesto` | Město | string | Mesto | ne | ANO | 255 | - | - | - | Město |
| `psc` | PSČ | string | Psc | ne | ANO | 255 | - | - | - | PSČ |
| `stat` | Stát | relation | IdStatu | ne | ANO | 3 | - | - | `stat` | Stát |
| `region` | Kraj | relation | Idregion | ne | ANO | - | - | - | `region` | Kraj |
| `tel` | Telefon | string | Tel | ne | ANO | 255 | - | - | - | Telefon |
| `mobil` | Mobil | string | Mobil | ne | ANO | 255 | - | - | - | Mobil |
| `fax` | Fax | string | Fax | ne | ANO | 255 | - | - | - | Fax |
| `email` | E-mail | string | Email | ne | ANO | 255 | - | - | - | E-mail |
| `www` | WWW | string | Www | ne | ANO | 255 | - | - | - | WWW |
| `eanKod` | EAN | string | EanKod | ne | ANO | 20 | - | - | - | EAN |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `nazev2` | Název - druhá řádka | string | Nazev2 | ne | ANO | 255 | - | - | - | Název - druhá řádka |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `primarni` | Primární místo určení | logic | Primarni | ne | ANO | - | - | - | - | Primární místo určení |
| `mistoPlneni` | Místo plnění | logic | MistoPlneni | **ANO** | ANO | - | - | - | - | Místo plnění |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `firma` | Firma | relation | IdFirmy | **ANO** | ANO | - | - | - | `adresar` | Firma |
| `kontaktOsoba` | Kontaktní osoba | relation | IdKontaktOsoba | ne | ANO | - | - | - | `kontakt` | Kontaktní osoba |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
