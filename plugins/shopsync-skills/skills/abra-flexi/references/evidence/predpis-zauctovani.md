# Předpisy zaúčtování

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `predpis-zauctovani` |
| **Evidence Type** | `PREDPIS_ZAUCTOVANI` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `uTypUcOp` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/predpis-zauctovani` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/predpis-zauctovani/properties` |

## Vlastnosti (29)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdTypUcOp | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `ucetObdobiOd` | Platí od | relation | IdUcetObdobiOd | ne | ANO | - | - | - | `ucetni-obdobi` | Platí od |
| `ucetObdobiDo` | Platí do | relation | IdUcetObdobiDo | ne | ANO | - | - | - | `ucetni-obdobi` | Platí do |
| `modulFav` | Faktury vydané | logic | ModulFav | ne | ANO | - | - | - | - | vydané |
| `modulFap` | Faktury přijaté | logic | ModulFap | ne | ANO | - | - | - | - | přijaté |
| `modulPhl` | Ostatní pohledávky | logic | ModulPhl | ne | ANO | - | - | - | - | pohledávky |
| `modulZav` | Ostatní závazky | logic | ModulZav | ne | ANO | - | - | - | - | závazky |
| `modulTxz` | Uplatnění daně - závazky | logic | ModulTxz | ne | ANO | - | - | - | - | závazky |
| `modulBanP` | Banka - příjem | logic | ModulBanP | ne | ANO | - | - | - | - | příjem |
| `modulBanV` | Banka - výdej | logic | ModulBanV | ne | ANO | - | - | - | - | výdej |
| `modulPokP` | Pokladna - příjem | logic | ModulPokP | ne | ANO | - | - | - | - | příjem |
| `modulPokV` | Pokladna - výdej | logic | ModulPokV | ne | ANO | - | - | - | - | výdej |
| `modulSklP` | Sklad - příjem | logic | ModulSklP | ne | ANO | - | - | - | - | příjem |
| `modulSklV` | Sklad - výdej | logic | ModulSklV | ne | ANO | - | - | - | - | výdej |
| `modulInt` | Interní doklady | logic | ModulInt | ne | ANO | - | - | - | - | Interní doklady |
| `kodPlneniK` | Kód plnění pro DPH | select | KodPlneniK | ne | ANO | 50 | - | - | - | Kód plnění pro DPH |
| `protiUcetPrijem` | Účet pro příjem [DAL] | relation | IdProtiUcetP | ne | ANO | 6 | - | - | `ucet` | Účet pro příjem [DAL] |
| `protiUcetVydej` | Účet pro výdej [MD] | relation | IdProtiUcetV | ne | ANO | 6 | - | - | `ucet` | Účet pro výdej [MD] |
| `dphSnizUcet` | Účet DPH snížená sazba | relation | IdDphSnizUcet | ne | ANO | 6 | - | - | `ucet` | DPH snížená |
| `dphSniz2Ucet` | Účet DPH 2. snížená sazba | relation | IdDphSniz2Ucet | ne | ANO | 6 | - | - | `ucet` | DPH 2. snížená |
| `dphZaklUcet` | Účet DPH základní sazba | relation | IdDphZaklUcet | ne | ANO | 6 | - | - | `ucet` | DPH základní |
