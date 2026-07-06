# Položky inventur

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `inventura-polozka` |
| **Evidence Type** | `INVENTURA_POLOZKA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `sPolInventura` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/inventura-polozka` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/inventura-polozka/properties` |

## Vlastnosti (24)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPolInventura | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `mnozMjReal` | Reálný stav | numeric | MnozMjReal | ne | ANO | - | 19 | 6 | - | Reálný stav |
| `mnozMjKarta` | Programový stav | numeric | MnozMjKarta | ne | ne | - | 19 | 6 | - | Programový stav |
| `mnozMjReal2` | Reálný stav č. 2 | numeric | MnozMjReal2 | ne | ANO | - | 19 | 6 | - | Reálný stav č. 2 |
| `mnozMjReal3` | Reálný stav č. 3 | numeric | MnozMjReal3 | ne | ANO | - | 19 | 6 | - | Reálný stav č. 3 |
| `mnozMjRealVlna2` | Reálný stav ve 2. vlně | numeric | MnozMjRealVlna2 | ne | ANO | - | 19 | 6 | - | Reálný stav ve 2. vlně |
| `mnozMjReal2Vlna2` | Reálný stav č. 2 ve 2. vlně | numeric | MnozMjReal2Vlna2 | ne | ANO | - | 19 | 6 | - | Reálný stav č. 2 ve 2. vlně |
| `mnozMjReal3Vlna2` | Reálný stav č. 3 ve 2. vlně | numeric | MnozMjReal3Vlna2 | ne | ANO | - | 19 | 6 | - | Reálný stav č. 3 ve 2. vlně |
| `mnozMjRealVlna3` | Reálný stav ve 3. vlně | numeric | MnozMjRealVlna3 | ne | ANO | - | 19 | 6 | - | Reálný stav ve 3. vlně |
| `mnozMjReal2Vlna3` | Reálný stav č. 2 ve 3. vlně | numeric | MnozMjReal2Vlna3 | ne | ANO | - | 19 | 6 | - | Reálný stav č. 2 ve 3. vlně |
| `mnozMjReal3Vlna3` | Reálný stav č. 3 ve 3. vlně | numeric | MnozMjReal3Vlna3 | ne | ANO | - | 19 | 6 | - | Reálný stav č. 3 ve 3. vlně |
| `mnozMjRealVlna4` | Reálný stav ve 4. vlně | numeric | MnozMjRealVlna4 | ne | ANO | - | 19 | 6 | - | Reálný stav ve 4. vlně |
| `mnozMjReal2Vlna4` | Reálný stav č. 2 ve 4. vlně | numeric | MnozMjReal2Vlna4 | ne | ANO | - | 19 | 6 | - | Reálný stav č. 2 ve 4. vlně |
| `mnozMjReal3Vlna4` | Reálný stav č. 3 ve 4. vlně | numeric | MnozMjReal3Vlna4 | ne | ANO | - | 19 | 6 | - | Reálný stav č. 3 ve 4. vlně |
| `sarze` | Šarže | string | Sarze | ne | ANO | 100 | - | - | - | Šarže |
| `expirace` | Expirace | date | Expirace | ne | ANO | - | - | - | - | Expirace |
| `skladKarta` | Skladová karta | relation | IdKarty | **ANO** | ANO | - | - | - | `skladova-karta` | Skladová karta |
| `cenik` | Ceník | relation | IdCenik | **ANO** | ANO | - | - | - | `cenik` | Ceník |
| `sklad` | Sklad | relation | IdSklad | **ANO** | ANO | - | - | - | `sklad` | Sklad |
| `inventura` | Hlavička inventury | relation | IdInventury | ne | ANO | - | - | - | `inventura` | Hlavička inventury |
| `mj` | MJ | relation | IdMj | ne | ANO | - | - | - | `merna-jednotka` | MJ |
| `mj2` | MJ č. 2 | relation | IdMj2 | ne | ANO | - | - | - | `merna-jednotka` | MJ č. 2 |
| `mj3` | MJ č. 3 | relation | IdMj3 | ne | ANO | - | - | - | `merna-jednotka` | MJ č. 3 |
