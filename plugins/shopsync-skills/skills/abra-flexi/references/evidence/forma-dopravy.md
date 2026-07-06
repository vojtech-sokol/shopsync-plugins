# Formy dopravy

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `forma-dopravy` |
| **Evidence Type** | `FORMA_DOPRAVY` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dFormaDopravy` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/forma-dopravy` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/forma-dopravy/properties` |

## Vlastnosti (30)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdFormaDopravy | ne | ne | - | - | - | - | ID |
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
| `exportEshop` | Exportovat na E-Shop | logic | ExportEshop | ne | ANO | - | - | - | - | Exportovat na E-Shop |
| `cisBal` | Vytvářet čísla balíků | logic | CisBal | ne | ANO | - | - | - | - | Vytvářet čísla balíků |
| `cisBalPrefix` | Čís.prefix | string | CisBalPrefix | ne | ANO | 30 | - | - | - | Tvar čísla - začátek |
| `cisBalPostfix` | Čís.postfix | string | CisBalPostfix | ne | ANO | 30 | - | - | - | Ukončení |
| `cisBalCislic` | Číslic | integer | CisBalCislic | ne | ANO | - | - | - | - | Číslic |
| `cisBalOd` | Čís. od | integer | CisBalOd | ne | ANO | - | - | - | - | Vytvářet od |
| `cisBalDo` | Čís. do | integer | CisBalDo | ne | ANO | - | - | - | - | do |
| `cisBalAkt` | Aktuální číslo | integer | CisBalAkt | ne | ANO | - | - | - | - | Aktuální číslo |
| `cisBalOdBud` | Čís.bud. od | integer | CisBalOdBud | ne | ANO | - | - | - | - | Poté vytvářet od |
| `cisBalDoBud` | Čís.bud. do | integer | CisBalDoBud | ne | ANO | - | - | - | - | do |
| `cisBalKodZak` | Kód zákazníka | string | CisBalKodZak | ne | ANO | 100 | - | - | - | Kód zákazníka |
| `cisBalDepo` | Depo zákazníka | string | CisBalDepo | ne | ANO | 100 | - | - | - | Depo zákazníka |
| `formaDopravyK` | Formát exportu | select | FormaDopravyK | ne | ANO | - | - | - | - | Formát exportu |
| `specialniSluzby` | Speciální služby | string | SpecialniSluzby | ne | ANO | 100 | - | - | - | Speciální služby |
| `cisBalIdZak` | ID/Typ zákazníka | string | CisBalIdZak | ne | ANO | 30 | - | - | - | ID/Typ zákazníka |
| `poradoveCislo` | Pořadové číslo souboru | integer | PoradoveCislo | ne | ANO | - | - | - | - | Pořadové číslo souboru |
| `cisBalKonCis` | Kontrolní číslo | logic | CisBalKonCis | ne | ANO | - | - | - | - | Kontrolní číslo |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `dopravne` | Dopravné | relation | IdDopravne | ne | ANO | - | - | - | `cenik` | Dopravné |
