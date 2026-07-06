# Majetek

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `majetek` |
| **Evidence Type** | `MAJETEK` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `mMajetek` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/majetek` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/majetek/properties` |

## Vlastnosti (68)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdMajetku | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Inv.čís. | string | Kod | **ANO** | ANO | 20 | - | - | - | Inventární číslo |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `platiOd` | Platí od roku | integer | PlatiOd | ne | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | integer | PlatiDo | ne | ANO | - | - | - | - | Platí do |
| `cena` | Cena | numeric | Cena | ne | ANO | - | 15 | 2 | - | Cena při zařazení [Kč] |
| `kusySoubor` | Kusů | integer | KusySoubor | **ANO** | ANO | - | - | - | - | Kusů v souboru |
| `druhK` | Druh | select | DruhK | **ANO** | ANO | 50 | - | - | - | Druh |
| `cidPoriz` | Doklad | string | CidPoriz | ne | ANO | 20 | - | - | - | Doklad pořízení |
| `zpusPor` | Způs.poř. | string | ZpusPor | ne | ANO | 255 | - | - | - | Způsob pořízení |
| `datKoupe` | Koupeno | date | DatKoupe | **ANO** | ANO | - | - | - | - | Datum koupě |
| `datVyroby` | Vyrobeno | date | DatVyroby | ne | ANO | - | - | - | - | Datum výroby |
| `vyrCis` | Výrobní číslo | string | VyrCis | ne | ANO | 20 | - | - | - | Výrobní číslo |
| `mjZarukyK` | MJ záruky | select | MjZarukyK | ne | ANO | 50 | - | - | - | MJ záruky |
| `zaruka` | Záruka | integer | Zaruka | ne | ANO | - | - | - | - | Záruka |
| `datZar` | Zařazeno | date | DatZar | **ANO** | ANO | - | - | - | - | Datum zařazení |
| `stariPor` | Odepsáno měs. | integer | StariPor | ne | ANO | - | - | - | - | Odepsáno při zař. [měsíce] |
| `zustUcet` | Zůst.účet. | numeric | ZustUcet | ne | ANO | - | 15 | 2 | - | Zůstatek účetní [Kč] |
| `zustDan` | Zůst.daň. | numeric | ZustDan | ne | ANO | - | 15 | 2 | - | Zůstatek daňový [Kč] |
| `techZhod` | Tech.zh. | logic | TechZhod | **ANO** | ANO | - | - | - | - | Před zařazením bylo tech. zhod. |
| `datZacDan` | Zač.daň.odp | date | DatZacDan | ne | ANO | - | - | - | - | Začátek daňových odpisů |
| `datZacUcet` | Zač.uč.odp. | date | DatZacUcet | ne | ANO | - | - | - | - | Začátek účetních odpisů |
| `zpusOdpK` | Způs.odp. | select | ZpusOdpK | ne | ANO | 50 | - | - | - | Způsob odpisování |
| `zvysZrychK` | Zvýš.1.rok | select | ZvysZrychK | ne | ANO | 50 | - | - | - | Zvýšení odpisu v 1. roce |
| `nahrUcetOdpK` | Účetní odp.? | select | NahrUcetOdpK | ne | ANO | 50 | - | - | - | Vytvářet úč. odpisy |
| `predpisUcetOdp` | Doba úč.odp. | numeric | PredpisUcetOdp | ne | ANO | - | 12 | 2 | - | Počet měsíců odpisování |
| `eanKod` | EAN | string | EanKod | ne | ANO | 20 | - | - | - | EAN |
| `uctovatZar` | Účtovat zařazení | logic |  | ne | ANO | - | - | - | - | Účtovat zařazení |
| `stariTechZhod` | Stáří tech.zh. | integer | StariTechZhod | ne | ANO | - | - | - | - | Stáří tech. zhod. [měsíce] |
| `datUdalZar` | Zařazeno | date | DatUdalZar | ne | ne | - | - | - | - | Datum události zařazení |
| `datUdalVyr` | Vyřazeno | date | DatUdalVyr | ne | ANO | - | - | - | - | Datum události vyřazení |
| `zamekK` | Zámek | select | ZamekK | ne | ne | 50 | - | - | - | Zámek |
| `skp` | SKP | string | Skp | ne | ANO | 50 | - | - | - | Standardní klasifikace produkce |
| `pocetPriloh` | Přílohy | integer | PocetPriloh | ne | ne | - | - | - | - | Přílohy |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `katastrUzemi` | Katastrální území | string | KatastrUzemi | ne | ANO | 255 | - | - | - | Katastrální území |
| `parcela` | Parcela | string | Parcela | ne | ANO | 255 | - | - | - | Parcela |
| `vozCislo` | Číslo | string | VozCislo | ne | ANO | 255 | - | - | - | Číslo |
| `vozSpz` | SPZ | string | VozSpz | ne | ANO | 255 | - | - | - | SPZ |
| `vozZnacka` | Značka | string | VozZnacka | ne | ANO | 255 | - | - | - | Značka |
| `vozModel` | Model | string | VozModel | ne | ANO | 255 | - | - | - | Model |
| `vozTyp` | Typ vozidla | string | VozTyp | ne | ANO | 255 | - | - | - | Typ vozidla |
| `vozObjem` | Objem | numeric | VozObjem | ne | ANO | - | 15 | 2 | - | Objem |
| `vozHavar` | Havarijní pojištění | string | VozHavar | ne | ANO | 255 | - | - | - | Havarijní pojištění |
| `vozHavarVyse` | Výše havarijního pojištění | numeric | VozHavarVyse | ne | ANO | - | 15 | 2 | - | Výše havarijního pojištění |
| `vozVybava` | Výbava | string | VozVybava | ne | ANO | - | - | - | - | Výbava |
| `sazba` | Odp.skup. | relation | IdSazby | ne | ANO | 20 | - | - | `odpisova-skupina` | Odpisová skupina |
| `mistnost` | Místnost | relation | IdUmisMist | ne | ANO | 20 | - | - | `umisteni` | Místnost |
| `sekce` | Sekce | relation | IdUmisSekce | ne | ANO | 20 | - | - | `umisteni` | Sekce |
| `objekt` | Objekt | relation | IdUmisObj | ne | ANO | 20 | - | - | `umisteni` | Objekt |
| `typMajetku` | Typ | relation | IdTypMaj | **ANO** | ANO | 20 | - | - | `typ-majetku` | Typ |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `stredisko` | Středisko | relation | IdStred | **ANO** | ANO | 20 | - | - | `stredisko` | Středisko |
| `doklFak` | Doklad faktury | relation | IdDoklFak | ne | ANO | - | - | - | `faktura-prijata` | Doklad faktury |
| `dodavatel` | Dodavatel | relation | IdFirmyDod | ne | ANO | 20 | - | - | `adresar` | Dodavatel |
| `vyrobce` | Výrobce | relation | IdFirmyVyr | ne | ANO | 20 | - | - | `adresar` | Výrobce |
| `primarniUcet` | Prim.účet | relation | IdPrimUcet | ne | ANO | 6 | - | - | `ucet` | Primární účet |
| `protiUcetZarazeni` | Protiúč.zař. | relation | IdProtiUcetZar | ne | ANO | 6 | - | - | `ucet` | Protiúčet zařazení |
| `opravnyUcet` | Účet opr. | relation | IdOpravUcet | ne | ANO | 6 | - | - | `ucet` | Účet oprávek |
| `odpisovyUcet` | Účet odp. | relation | IdOdpUcet | ne | ANO | 6 | - | - | `ucet` | Účet odpisu |
| `zustVyrazUcet` | Účet zůstatku vyřazení | relation | IdZustVyrazUcet | ne | ANO | - | - | - | `ucet` | Účet zůstatku vyřazení |
| `uzivatel` | Uživatel | relation | IdUziv | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
