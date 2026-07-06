# Výrobní čísla

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `vyrobni-cislo` |
| **Evidence Type** | `VYROBNI_CISLA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `sVyrobniCislo` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/vyrobni-cislo` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/vyrobni-cislo/properties` |

## Vlastnosti (17)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | Idvyrobnicislo | ne | ne | - | - | - | - | ID |
| `kod` | Výrobní číslo | string | Kod | **ANO** | ANO | 255 | - | - | - | Výrobní číslo |
| `cenik` | Ceník | relation | IdCenik | ne | ne | 64 | - | - | `cenik` | Ceník |
| `sklad` | Sklad | relation | IdSkladu | ne | ne | - | - | - | `sklad` | Sklad |
| `idPolSkladPrijem` | Položka příjemky | relation | IdPolSkladPrijem | ne | ne | - | - | - | `skladovy-pohyb-polozka` | Položka příjemky |
| `idPolSkladVydej` | Položka výdejky | relation | IdPolSkladVydej | ne | ne | - | - | - | `skladovy-pohyb-polozka` | Položka výdejky |
| `idPolFakPrijem` | Položka přijaté faktury | relation | IdPolFakPrijem | ne | ne | - | - | - | - | Položka přijaté faktury |
| `idPolFakVydej` | Položka vydané faktury | relation | IdPolFakVydej | ne | ne | - | - | - | - | Položka vydané faktury |
| `idPolIntPrijem` | Pokladní položka přijímající | relation | IdPolIntPrijem | ne | ne | - | - | - | - | Pokladní položka přijímající |
| `idPolIntVydej` | Pokladní položka vydávající | relation | IdPolIntVydej | ne | ne | - | - | - | - | Pokladní položka vydávající |
| `vyrobniCisloHlav` | Hlavička výrobního čísla | relation | IdVyrobniCisloHlav | ne | ne | 20 | - | - | - | Hlavička výrobního čísla |
| `doklFakPrijem` | Přijato fakturou | relation |  | ne | ne | - | - | - | - | Přijato fakturou |
| `doklFakVydej` | Vydáno fakturou | relation |  | ne | ne | - | - | - | - | Vydáno fakturou |
| `doklIntPrijem` | Přijato pokl. dokladem | relation |  | ne | ne | - | - | - | - | Přijato pokl. dokladem |
| `doklIntVydej` | Vydáno pokl. dokladem | relation |  | ne | ne | - | - | - | - | Vydáno pokl. dokladem |
| `doklSkladPrijem` | Naskladněno dokladem | relation |  | ne | ne | - | - | - | `skladovy-pohyb` | Naskladněno dokladem |
| `doklSkladVydej` | Vyskladněno dokladem | relation |  | ne | ne | - | - | - | `skladovy-pohyb` | Vyskladněno dokladem |
