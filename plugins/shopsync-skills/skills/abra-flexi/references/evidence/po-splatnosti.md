# Neuhrazené pohledávky/závazky po splatnosti

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `po-splatnosti` |
| **Evidence Type** | `PO_SPLATNOSTI` |
| **Import Status** | DISALLOWED |
| **DB Name** | `PoSplatnosti` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/po-splatnosti` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/po-splatnosti/properties` |

## Vlastnosti (5)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `fakturovano` | Fakturováno | numeric |  | ne | ANO | - | - | - | - | Fakturováno |
| `sumCelkemAkt` | Suma celkem aktuální | numeric |  | ne | ANO | - | - | - | - | Suma celkem aktuální |
| `uhrazeno` | Uhrazeno | numeric |  | ne | ANO | - | - | - | - | Uhrazeno |
| `symbolSplatnostiK` | Symbol splatnosti | select |  | ne | ANO | - | - | - | - | Symbol splatnosti |
| `firma` | Firma | relation |  | ne | ANO | 20 | - | - | `adresar` | Firma |
