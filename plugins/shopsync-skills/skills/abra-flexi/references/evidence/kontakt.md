# Kontakty

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `kontakt` |
| **Evidence Type** | `ADR_KONTAKT` |
| **Import Status** | SUPPORTED |
| **DB Name** | `aKontakty` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/kontakt` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/kontakt/properties` |

## Vlastnosti (40)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdKontakt | ne | ne | - | - | - | - | ID |
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
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `prijmeni` | Příjmení | string | Prijmeni | ne | ANO | 255 | - | - | - | Příjmení |
| `jmeno` | Jméno | string | Jmeno | ne | ANO | 255 | - | - | - | Jméno |
| `osloveni` | Oslovení | string | Osloveni | ne | ANO | - | - | - | - | Oslovení |
| `titul` | Titul | string | Titul | ne | ANO | 255 | - | - | - | Titul |
| `titulZa` | Titul za jménem | string | TitulZa | ne | ANO | 255 | - | - | - | Titul za jménem |
| `funkce` | Funkce | string | Funkce | ne | ANO | 255 | - | - | - | Funkce |
| `oddeleni` | Oddělení | string | Oddeleni | ne | ANO | - | - | - | - | Oddělení |
| `primarni` | Primární kontakt | logic | Primarni | ne | ANO | - | - | - | - | Primární kontakt |
| `odesilatFak` | Odesílat faktury | logic | OdesilatFak | ne | ANO | - | - | - | - | Odesílat faktury |
| `odesilatObj` | Odesílat objednávky | logic | OdesilatObj | ne | ANO | - | - | - | - | Odesílat objednávky |
| `odesilatNab` | Odesílat nabídky | logic | OdesilatNab | ne | ANO | - | - | - | - | Odesílat nabídky |
| `odesilatPpt` | Odesílat poptávky | logic | OdesilatPpt | ne | ANO | - | - | - | - | Odesílat poptávky |
| `odesilatSkl` | Odesílat skladové doklady | logic | OdesilatSkl | ne | ANO | - | - | - | - | Odesílat skladové doklady |
| `odesilatPok` | Odesílat pokladní doklady | logic | OdesilatPok | ne | ANO | - | - | - | - | Odesílat pokladní doklady |
| `datNaroz` | Datum narození | date | DatNaroz | ne | ANO | - | - | - | - | Datum narození |
| `rodCis` | Rodné číslo | string | RodCis | ne | ANO | 20 | - | - | - | Rodné číslo |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `username` | Uživatelské jméno | string | Username | ne | ANO | 255 | - | - | - | Uživatelské jméno |
| `password` | Heslo | string | Password | ne | ANO | 255 | - | - | - | Heslo |
| `blocked` | Příznak zablokování autentizace | logic | Blocked | ne | ANO | - | - | - | - | Příznak zablokování autentizace |
| `blockedText` | Důvod zablokování autentizace | string | BlockedText | ne | ANO | - | - | - | - | Důvod zablokování autentizace |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `firma` | Firma | relation | IdFirmy | ne | ANO | 20 | - | - | `adresar` | Firma |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
