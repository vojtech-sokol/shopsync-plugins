# Formy úhrady

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `forma-uhrady` |
| **Evidence Type** | `FORMA_UHRADY` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `dFormaUhradyCis` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/forma-uhrady` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/forma-uhrady/properties` |

## Vlastnosti (22)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdFormaUhradyCis | ne | ne | - | - | - | - | ID |
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
| `formaUhrK` | Forma úhrady | select | FormaUhrK | **ANO** | ANO | - | - | - | - | Forma úhrady |
| `kurz` | Kurz | numeric | Kurz | ne | ANO | - | 19 | 6 | - | Kurz |
| `kurzMnozstvi` | Kurz. množství | numeric | KurzMnozstvi | ne | ANO | - | 19 | 6 | - | Kurz. množství |
| `limitVratky` | Limit vrácení | numeric | LimitVratky | ne | ANO | - | 15 | 2 | - | Limit vrácení |
| `vsbFak` | Nabízet na fakturách | logic | VsbFak | ne | ANO | - | - | - | - | Nabízet na fakturách |
| `vsbPok` | Nabízet na pokladně | logic | VsbPok | ne | ANO | - | - | - | - | Nabízet na pokladně |
| `vsbKasa` | Nabízet na kase | logic | VsbKasa | ne | ANO | - | - | - | - | Nabízet na kase |
| `metodaZaokrDoklK` | Metoda zaokrouhlení | select | MetodaZaokrDoklK | ne | ANO | 50 | - | - | - | Metoda zaokrouhlení |
| `zaokrNaSumK` | Řád zaokrouhlení - Celkem | select | ZaokrNaSumK | ne | ANO | 50 | - | - | - | Celkem (řády) |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
| `mena` | Měna | relation | IdMeny | ne | ANO | - | - | - | `mena` | Měna |
