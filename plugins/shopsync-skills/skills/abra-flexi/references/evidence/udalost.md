# Události, aktivity

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `udalost` |
| **Evidence Type** | `ADR_UDALOST` |
| **Import Status** | SUPPORTED |
| **DB Name** | `aUdalosti` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/udalost` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/udalost/properties` |

## Vlastnosti (38)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdUdalost | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `celodenni` | Celodenní | logic | Celodenni | ne | ANO | - | - | - | - | Celodenní |
| `dokonceni` | Čas dokončení | datetime | Dokonceni | ne | ANO | - | - | - | - | Čas dokončení |
| `predmet` | Předmět | string | Predmet | ne | ANO | 255 | - | - | - | Předmět |
| `prioritaK` | Priorita | select | PrioritaK | ne | ANO | 50 | - | - | - | Priorita |
| `stavUdalK` | Stav události | select | StavUdalK | ne | ANO | 50 | - | - | - | Stav události |
| `termin` | Termín realizace | datetime | Termin | ne | ANO | - | - | - | - | Termín realizace |
| `umisteni` | Umístění | string | Umisteni | ne | ANO | 255 | - | - | - | Umístění |
| `volno` | Volno | logic | Volno | ne | ANO | - | - | - | - | Volno |
| `zahajeni` | Čas zahájení | datetime | Zahajeni | ne | ANO | - | - | - | - | Čas zahájení |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `processDefinitionId` | ProcessDefinitionId | string | ProcessDefinitionId | ne | ne | 63 | - | - | - | ProcessDefinitionId |
| `taskDefinitionKey` | TaskDefinitionKey | string | TaskDefinitionKey | ne | ne | 255 | - | - | - | TaskDefinitionKey |
| `actRuTask` | ActRuTask | string | ActRuTask | ne | ne | 63 | - | - | - | ActRuTask |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `firma` | Firma | relation | IdFirmy | ne | ANO | 20 | - | - | `adresar` | Firma |
| `firmaExterni` | Externí firma | relation | IdFirmaExterni | ne | ANO | - | - | - | `adresar` | Externí firma |
| `typAkt` | Typ aktivity | relation | IdTypAkt | ne | ANO | 20 | - | - | `typ-aktivity` | Typ aktivity |
| `zodpPrac` | Zodpovědný pracovník | relation | IdUzivatel | ne | ANO | 254 | - | - | `uzivatel` | Zodpovědný pracovník |
| `uzivatel` | Uživatel | relation | IdUzivatelVytvoril | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `doklFak` | Doklad faktury | relation | IdDoklFak | ne | ANO | - | - | - | - | Doklad faktury |
| `doklInt` | Interní doklad | relation | IdDoklInt | ne | ANO | - | - | - | - | Interní doklad |
| `doklObch` | Obchodní doklad | relation | IdDoklObch | ne | ANO | - | - | - | - | Obchodní doklad |
| `doklSklad` | Příjemka/výdejka | relation | IdDoklSklad | ne | ANO | - | - | - | `skladovy-pohyb` | Příjemka/výdejka |
| `cenik` | Ceník | relation | IdCenik | ne | ANO | 64 | - | - | `cenik` | Ceník |
| `kontakt` | Kontakt | relation | IdKontakt | ne | ANO | - | - | - | `kontakt` | Kontakt |
| `konektor` | Konektor | relation | IdKonektor | ne | ANO | - | - | - | - | Konektor |
| `report` | Report | relation | IdReport | ne | ANO | - | - | - | `report` | Report |
| `smlouva` | Smlouva | relation | IdSmlouvy | ne | ANO | 20 | - | - | `smlouva` | Smlouva |
| `polSmlouvy` | Pol. smlouvy | relation | IdPolSml | ne | ANO | 64 | - | - | `smlouva-polozka` | Pol. smlouvy |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `majetek` | Majetek | relation | IdMajetek | ne | ANO | 20 | - | - | `majetek` | Majetek |
| `createdBy` | Vytvořil | relation | idUzivatelVytvoril | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
