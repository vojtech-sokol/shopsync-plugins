# Stav skladu k datu

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `stav-skladu-k-datu` |
| **Evidence Type** | `STAV_SKLADU_K_DATU` |
| **Import Status** | DISALLOWED |
| **DB Name** | `StavSkladu` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/stav-skladu-k-datu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/stav-skladu-k-datu/properties` |

## Vlastnosti (11)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `stavMJ` | Stav zásob v MJ | numeric |  | **ANO** | ANO | - | 19 | 6 | - | Stav zásob v MJ |
| `stavMJPozad` | Stav zásob v MJ s požadavky | numeric |  | **ANO** | ANO | - | 19 | 6 | - | Stav zásob v MJ s požadavky |
| `pozadavkyMJ` | Požadavky MJ | numeric |  | **ANO** | ANO | - | 19 | 6 | - | Požadavky MJ |
| `tuz` | V tuz. měně | numeric |  | **ANO** | ANO | - | 15 | 2 | - | Stav v tuzemské měně |
| `nazev` | Název | string |  | **ANO** | ANO | 255 | - | - | - | Název |
| `eanKod` | EAN | string |  | ne | ANO | 20 | - | - | - | EAN |
| `prumCena` | Prům. cena | numeric |  | **ANO** | ANO | - | 15 | 2 | - | Průměrná cena |
| `cenik` | Ceník | relation |  | ne | ANO | 64 | - | - | `cenik` | Ceník |
| `mj1` | MJ | relation |  | ne | ANO | - | - | - | `merna-jednotka` | Měrná jednotka |
| `skupZboz` | Skupina zboží | relation |  | ne | ANO | - | - | - | `skupina-zbozi` | Skupina zboží |
| `stitky` | Štítky | string |  | ne | ANO | - | - | - | - | Štítky |
