# Uživatelské vazby

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `uzivatelska-vazba` |
| **Evidence Type** | `VAZBA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `VazbaView` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/uzivatelska-vazba` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/uzivatelska-vazba/properties` |

## Vlastnosti (12)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdVazba | ne | ne | - | - | - | - | ID |
| `vazbaTyp` | Typ vazby | relation | IdVazbaTyp | ne | ANO | 20 | - | - | `typ-uzivatelske-vazby` | Typ vazby |
| `modul` | Modul | string |  | ne | ne | - | - | - | - | Modul |
| `kod` | Zkratka | string | Kod | ne | ne | 255 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | ne | ne | 255 | - | - | - | Název |
| `castka` | Částka | numeric |  | ne | ne | - | 15 | 2 | - | Částka |
| `datum` | Datum | date |  | ne | ne | - | - | - | - | Datum |
| `popis` | Popis vazby | string | Popis | ne | ANO | - | - | - | - | Popis vazby |
| `poznam` | Poznámka k vazbě | string | Poznam | ne | ANO | - | - | - | - | Poznámka k vazbě |
| `evidenceType` | Evidence | string |  | ne | ANO | - | - | - | - | Evidence |
| `objectId` | ID navázaného objektu | integer |  | ne | ne | - | - | - | - | ID navázaného objektu |
| `object` | Navázaný objekt | relation |  | ne | ANO | - | - | - | - | Navázaný objekt |
