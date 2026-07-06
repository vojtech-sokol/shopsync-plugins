# Zálohy k odpočtu

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `zaloha-k-odpoctu` |
| **Evidence Type** | `ZALOHA_K_ODPOCTU` |
| **Import Status** | DISALLOWED |
| **DB Name** | `ZalohaKOdpoctu` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/zaloha-k-odpoctu` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/zaloha-k-odpoctu/properties` |

## Vlastnosti (12)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `zaloha` | Záloha | relation |  | ne | ANO | - | - | - | - | Záloha |
| `ucetni` | Účetní | logic |  | ne | ANO | - | - | - | - | Účetní |
| `sumOsv` | Osvob., bez DPH [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | 0 % |
| `sumZklZakl` | Základ DPH zákl. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ DPH zákl. [Kč] |
| `sumZklSniz` | Základ DPH sníž. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ DPH sníž. [Kč] |
| `sumZklSniz2` | Základ DPH 2. sníž. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Základ DPH 2. sníž. [Kč] |
| `sumDphZakl` | DPH základní [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH základní |
| `sumDphSniz` | DPH snížená [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH snížená |
| `sumDphSniz2` | DPH 2. snížená [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | DPH 2. snížená |
| `sumCelkZakl` | Celkem vč. DPH - zákl. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - zákl. [Kč] |
| `sumCelkSniz` | Celkem vč. DPH - sníž. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - sníž. [Kč] |
| `sumCelkSniz2` | Celkem vč. DPH - 2. sníž. [Kč] | numeric |  | ne | ANO | - | 15 | 2 | - | Celkem vč. DPH - 2. sníž. [Kč] |
