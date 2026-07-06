# Seznam sestav

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `sestava` |
| **Evidence Type** | `SESTAVA` |
| **Import Status** | SUPPORTED |
| **DB Name** | `uSestavy` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/sestava` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/sestava/properties` |

## Vlastnosti (65)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdSestavy | ne | ne | - | - | - | - | ID |
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
| `typSesK` | Typ sestavy | select | TypSesK | **ANO** | ANO | 50 | - | - | - | Typ sestavy |
| `standard` | Standardní sestava | logic | Standard | ne | ne | - | - | - | - | Standardní sestava |
| `vypMinObd` | Počítat minulé období | logic | VypMinObd | ne | ANO | - | - | - | - | Počítat minulé období |
| `nazevSloup1` | Název sloupce 1 | string | NazevSloup1 | ne | ANO | 255 | - | - | - | Název sloupce 1 |
| `nazevSloupA1` | Název sloupce 1 EN | string | NazevSloupA1 | ne | ANO | 255 | - | - | - | Název sloupce 1 EN |
| `nazevSloupB1` | Název sloupce 1 DE | string | NazevSloupB1 | ne | ANO | 255 | - | - | - | Název sloupce 1 DE |
| `nazevSloupC1` | Název sloupce 1 FR | string | NazevSloupC1 | ne | ANO | 255 | - | - | - | Název sloupce 1 FR |
| `zobrazit1` | Zobrazit sloupec 1 | logic | Zobrazit1 | ne | ANO | - | - | - | - | Zobrazit |
| `nazevSloup2` | Název sloupce 2 | string | NazevSloup2 | ne | ANO | 255 | - | - | - | Název sloupce 2 |
| `nazevSloupA2` | Název sloupce 2 EN | string | NazevSloupA2 | ne | ANO | 255 | - | - | - | Název sloupce 2 EN |
| `nazevSloupB2` | Název sloupce 2 DE | string | NazevSloupB2 | ne | ANO | 255 | - | - | - | Název sloupce 2 DE |
| `nazevSloupC2` | Název sloupce 2 FR | string | NazevSloupC2 | ne | ANO | 255 | - | - | - | Název sloupce 2 FR |
| `zobrazit2` | Zobrazit sloupec 2 | logic | Zobrazit2 | ne | ANO | - | - | - | - | Zobrazit |
| `nazevSloup3` | Název sloupce 3 | string | NazevSloup3 | ne | ANO | 255 | - | - | - | Název sloupce 3 |
| `nazevSloupA3` | Název sloupce 3 EN | string | NazevSloupA3 | ne | ANO | 255 | - | - | - | Název sloupce 3 EN |
| `nazevSloupB3` | Název sloupce 3 DE | string | NazevSloupB3 | ne | ANO | 255 | - | - | - | Název sloupce 3 DE |
| `nazevSloupC3` | Název sloupce 3 FR | string | NazevSloupC3 | ne | ANO | 255 | - | - | - | Název sloupce 3 FR |
| `zobrazit3` | Zobrazit sloupec 3 | logic | Zobrazit3 | ne | ANO | - | - | - | - | Zobrazit |
| `nazevSloup4` | Název sloupce 4 | string | NazevSloup4 | ne | ANO | 255 | - | - | - | Název sloupce 4 |
| `nazevSloupA4` | Název sloupce 4 EN | string | NazevSloupA4 | ne | ANO | 255 | - | - | - | Název sloupce 4 EN |
| `nazevSloupB4` | Název sloupce 4 DE | string | NazevSloupB4 | ne | ANO | 255 | - | - | - | Název sloupce 4 DE |
| `nazevSloupC4` | Název sloupce 4 FR | string | NazevSloupC4 | ne | ANO | 255 | - | - | - | Název sloupce 4 FR |
| `zobrazit4` | Zobrazit sloupec 4 | logic | Zobrazit4 | ne | ANO | - | - | - | - | Zobrazit |
| `nazevSloup5` | Název sloupce 5 | string | NazevSloup5 | ne | ANO | 255 | - | - | - | Název sloupce 5 |
| `nazevSloupA5` | Název sloupce 5 EN | string | NazevSloupA5 | ne | ANO | 255 | - | - | - | Název sloupce 5 EN |
| `nazevSloupB5` | Název sloupce 5 DE | string | NazevSloupB5 | ne | ANO | 255 | - | - | - | Název sloupce 5 DE |
| `nazevSloupC5` | Název sloupce 5 FR | string | NazevSloupC5 | ne | ANO | 255 | - | - | - | Název sloupce 5 FR |
| `zobrazit5` | Zobrazit sloupec 5 | logic | Zobrazit5 | ne | ANO | - | - | - | - | Zobrazit |
| `nazevSloup6` | Název sloupce 6 | string | NazevSloup6 | ne | ANO | 255 | - | - | - | Název sloupce 6 |
| `nazevSloupA6` | Název sloupce 6 EN | string | NazevSloupA6 | ne | ANO | 255 | - | - | - | Název sloupce 6 EN |
| `nazevSloupB6` | Název sloupce 6 DE | string | NazevSloupB6 | ne | ANO | 255 | - | - | - | Název sloupce 6 DE |
| `nazevSloupC6` | Název sloupce 6 FR | string | NazevSloupC6 | ne | ANO | 255 | - | - | - | Název sloupce 6 FR |
| `zobrazit6` | Zobrazit sloupec 6 | logic | Zobrazit6 | ne | ANO | - | - | - | - | Zobrazit |
| `sloupec3Sum12` | Sloupec 3 je součtem sloupce 1 a 2 | logic | Sloupec3Sum12 | ne | ANO | - | - | - | - | Sloupec 3 je součtem sloupce 1 a 2 |
| `sloupec6Sum45` | Sloupec 6 je součtem sloupce 4 a 5 | logic | Sloupec6Sum45 | ne | ANO | - | - | - | - | Sloupec 6 je součtem sloupce 4 a 5 |
| `rokOd` | Rok od | integer | RokOd | ne | ANO | - | - | - | - | Rok od |
| `rokDo` | Rok do | integer | RokDo | ne | ANO | - | - | - | - | Rok do |
| `mesicOd` | Měsíc od | integer | MesicOd | ne | ANO | - | - | - | - | Měsíc od |
| `mesicDo` | Měsíc do | integer | MesicDo | ne | ANO | - | - | - | - | Měsíc do |
| `predRokOd` | Před. rok od | integer | PredRokOd | ne | ANO | - | - | - | - | Před. rok od |
| `predRokDo` | Před. rok do | integer | PredRokDo | ne | ANO | - | - | - | - | Před. rok do |
| `predMesicOd` | Před. měsíc od | integer | PredMesicOd | ne | ANO | - | - | - | - | Před. měsíc od |
| `predMesicDo` | Před. měsíc do | integer | PredMesicDo | ne | ANO | - | - | - | - | Před. měsíc do |
| `datVypocet` | Datum výpočtu | date | DatVypocet | ne | ANO | - | - | - | - | Datum výpočtu |
| `typVypSestavyK` | Typ výpočtu sestavy | select | TypVypSestavyK | ne | ANO | 50 | - | - | - | Typ výpočtu sestavy |
| `typJednotkyMikro` | Mikro účetní jednotka | logic | TypJednotkyMikro | **ANO** | ANO | - | - | - | - | Mikro účetní jednotka |
| `typOrganizace` | Typ organizace | relation | IdTypOrg | **ANO** | ANO | 6 | - | - | `typ-organizace` | Typ organizace |
| `radkaCil` | Cílová řádka | relation | IdRadCil | ne | ANO | - | - | - | `radek-sestavy` | Cílová řádka |
| `sestavaZdroj` | Zdrojová sestava | relation | IdSesZdroj | ne | ANO | - | - | - | `sestava` | Zdrojová sestava |
| `radkaZdroj` | Zdrojová řádka | relation | IdRadZdroj | ne | ANO | - | - | - | `radek-sestavy` | Zdrojová řádka |
| `radkaRozdil1` | Řádka rozdílu 1 | relation | IdRadRozdil1 | ne | ANO | - | - | - | `radek-sestavy` | Řádka rozdílu 1 |
| `radkaRozdil2` | Řádka rozdílu 2 | relation | IdRadRozdil2 | ne | ANO | - | - | - | `radek-sestavy` | Řádka rozdílu 2 |
| `radkaZaokr1` | Kontrola zaokrouhlení 1 | relation | IdRadZaokr1 | ne | ANO | - | - | - | `radek-sestavy` | Kontrola zaokrouhlení 1 |
| `radkaZaokr2` | Kontrola zaokrouhlení 2 | relation | IdRadZaokr2 | ne | ANO | - | - | - | `radek-sestavy` | Kontrola zaokrouhlení 2 |
