# Upřesnění umístění účtu

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `umisteni-uctu` |
| **Evidence Type** | `UMISTENI_UCTU` |
| **Import Status** | DISALLOWED |
| **DB Name** | `UmisteniUctu` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/umisteni-uctu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/umisteni-uctu/properties` |

## Vlastnosti (2)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `ucet` | Účet | relation |  | **ANO** | ANO | - | - | - | `ucet` | Účet |
| `vybranyRadek` | Vybraný řádek | relation |  | ne | ANO | - | - | - | `radek-sestavy` | Vybraný řádek |
