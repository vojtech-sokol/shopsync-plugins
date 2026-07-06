# Správa přehledů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `dashboard-panel` |
| **Evidence Type** | `DASHBOARD_PANEL` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wdashboardpanel` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/dashboard-panel` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/dashboard-panel/properties` |

## Vlastnosti (16)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | Idwdashboardpanel | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | ne | ne | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | ne | ne | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ne | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ne | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ne | 255 | - | - | - | Název FR |
| `popis` | Popis | string | Popis | ne | ne | - | - | - | - | Popis |
| `popisA` | Popis EN | string | PopisA | ne | ne | - | - | - | - | Popis EN |
| `popisB` | Popis DE | string | PopisB | ne | ne | - | - | - | - | Popis DE |
| `popisC` | Popis FR | string | PopisC | ne | ne | - | - | - | - | Popis FR |
| `definition` | Definice | string | Definition | ne | ne | - | - | - | - | Definice |
| `visibilityK` | Viditelnost | select | VisibilityK | ne | ne | 255 | - | - | - | Viditelnost |
| `priority` | Pořadí | integer | Priority | ne | ne | - | - | - | - | Pořadí |
| `standard` | Standardní přehled | logic | Standard | ne | ne | - | - | - | - | Standardní přehled |
| `author` | Vytvořil | relation | Idauthor | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
