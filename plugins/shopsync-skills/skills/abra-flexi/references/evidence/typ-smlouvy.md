# Typy odběratelských smluv

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `typ-smlouvy` |
| **Evidence Type** | `TYP_SMLOUVY` |
| **Import Status** | SUPPORTED |
| **DB Name** | `dTypSml` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/typ-smlouvy` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/typ-smlouvy/properties` |

## Vlastnosti (30)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdTypSml | ne | ne | - | - | - | - | ID |
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
| `autoProdl` | Automaticky prodlužovat | logic | AutoProdl | ne | ANO | - | - | - | - | Automaticky prodlužovat |
| `autoZakazka` | Automaticky vytvářet zakázky | logic | AutoZakazka | ne | ANO | - | - | - | - | Automaticky vytvářet zakázky |
| `autoGen` | Automaticky generovat | logic | AutoGen | ne | ANO | - | - | - | - | Automaticky generovat |
| `den` | Obrátkový den | integer | Den | ne | ANO | - | - | - | - | Obrátkový den |
| `mesic` | Obrátkový měsíc | integer | Mesic | ne | ANO | - | - | - | - | Obrátkový měsíc |
| `genPenale` | Generovat penále | logic | GenPenale | ne | ANO | - | - | - | - | Generovat penále |
| `procPenale` | Procento penále | numeric | ProcPenale | ne | ANO | - | 6 | 2 | - | Procento penále |
| `preplatky` | Řešit přeplatky | logic | Preplatky | ne | ANO | - | - | - | - | Řešit přeplatky |
| `zpusFaktK` | Způsob fakturace | select | ZpusFaktK | **ANO** | ANO | 50 | - | - | - | Způsob fakturace |
| `dnyFakt` | Fakturovat dní předem/po | integer | DnyFakt | ne | ANO | - | - | - | - | Fakturovat dní předem/po |
| `autoMail` | Automaticky posílat e-mailem klientovi | logic | AutoMail | ne | ANO | - | - | - | - | Automaticky posílat e-mailem klientovi |
| `varSymFakt` | Variabilní symbol z faktury | logic | VarSymFakt | ne | ANO | - | - | - | - | Variabilní symbol je generován z čísla faktury |
| `datVystZDuzp` | Dat.vyst. z DUZP | logic | DatVystZDuzp | ne | ANO | - | - | - | - | Dat.vyst. z DUZP |
| `generovatNuloveFaktury` | Generovat i nulové faktury | logic | GenerovatNuloveFaktury | ne | ANO | - | - | - | - | Generovat i nulové faktury |
| `workFlow` | Zahájit workflow při založení dokladu | logic | WorkFlow | ne | ANO | - | - | - | - | Zahájit workflow při založení dokladu |
| `typPohybuK` | Typ pohybu | select | TypPohybuK | ne | ANO | 50 | - | - | - | Typ pohybu |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `typDoklFak` | Typ faktury | relation | IdTypDokl | ne | ANO | - | - | - | `typ-faktury-vydane` | Typ faktury |
| `typDoklFakPenale` | Typ penalizační faktury | relation | IdTypDoklPenale | ne | ANO | - | - | - | `typ-dokladu` | Typ penalizační faktury |
