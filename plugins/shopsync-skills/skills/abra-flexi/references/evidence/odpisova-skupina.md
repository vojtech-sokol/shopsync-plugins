# Odpisové skupiny

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `odpisova-skupina` |
| **Evidence Type** | `ODPISOVE_SKUPINY` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `mSazby` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/odpisova-skupina` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/odpisova-skupina/properties` |

## Vlastnosti (22)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSazby | ne | ne | - | - | - | - | ID |
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
| `typOdpK` | Způsob odp. | select | TypOdpK | **ANO** | ANO | 50 | - | - | - | Způsob odp. |
| `dobaOdp` | Doba | integer | DobaOdp | ne | ANO | - | 4 | - | - | Doba odpisu |
| `minDobaOdp` | Min. doba odpisu | integer | MinDobaOdp | ne | ANO | - | 4 | - | - | Min. doba odpisu |
| `koefZrOdp1` | 1.rok zrych. | integer | KoefZrOdp1 | ne | ANO | - | 4 | - | - | První rok |
| `koefZrOdpDalsi` | Další r.zrych. | integer | KoefZrOdpDalsi | ne | ANO | - | 4 | - | - | Další roky |
| `koefZrOdpZvCeny` | Zvýšení zrych. | integer | KoefZrOdpZvCeny | ne | ANO | - | 4 | - | - | Zvýšení vst. ceny |
| `prcRoOdp1` | 1.rok rovn. | numeric | PrcRoOdp1 | ne | ANO | - | 6 | 2 | - | První rok |
| `prcRoOdpDalsi` | Další r.rovn. | numeric | PrcRoOdpDalsi | ne | ANO | - | 6 | 2 | - | Další roky |
| `prcRoOdpZvCeny` | Zvýšení rovn. | numeric | PrcRoOdpZvCeny | ne | ANO | - | 6 | 2 | - | Zvýšení vst.ceny |
| `zamek` | Zámek | logic | Zamek | ne | ANO | - | - | - | - | Zámek |
| `zmena` | Vytvořena už. | logic | Zmena | **ANO** | ANO | - | - | - | - | Vytvořena uživatelem |
