# Objekt doplňku

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `objekt-doplnku` |
| **Evidence Type** | `OBJEKT_DOPLNKU` |
| **Import Status** | DISALLOWED |
| **DB Name** | `waddonobject` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/objekt-doplnku` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/objekt-doplnku/properties` |

## Vlastnosti (5)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | Idaddonobject | ne | ne | - | - | - | - | ID |
| `objektId` | ID objektu | integer | Objektid | ne | ANO | 20 | - | - | - | ID objektu |
| `beanResourceKey` | Zdrojová tabulka | string | Beanresourcekey | ne | ANO | 255 | - | - | - | Zdrojová tabulka |
| `isOwner` | Je vlastníkem | logic | Isowner | ne | ANO | - | - | - | - | Je vlastníkem |
| `doplnek` | Doplněk | relation | Idaddon | ne | ANO | - | - | - | `doplnek` | Doplněk |
