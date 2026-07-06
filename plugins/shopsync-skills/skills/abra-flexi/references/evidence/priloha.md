# Příloha

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `priloha` |
| **Evidence Type** | `PRILOHA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wPriloha` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/priloha` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/priloha/properties` |

## Vlastnosti (33)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdPriloha | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `nazSoub` | Název souboru | string | NazSoub | **ANO** | ANO | 255 | - | - | - | Název souboru |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `contentType` | Typ dat | string | ContentType | **ANO** | ANO | 127 | - | - | - | Typ dat |
| `typK` | Typ přílohy | select | TypK | ne | ne | 50 | - | - | - | Typ přílohy |
| `prilozit` | Přiložit | logic | Prilozit | **ANO** | ANO | - | - | - | - | Přiložit |
| `pictureRate` | Poměr stran | numeric | PictureRate | ne | ne | - | 6 | 2 | - | Poměr stran obrázku |
| `dataSize` | Velikost | integer | DataSize | ne | ANO | - | - | - | - | Velikost |
| `exportNaEshop` | Export na E-shop | logic | ExportNaEshop | ne | ANO | - | - | - | - | Export na E-shop |
| `link` | Odkaz | string | Link | ne | ANO | - | - | - | - | Odkaz |
| `linkPicture` | Odkaz na obrázek | logic | LinkPicture | ne | ANO | - | - | - | - | Odkaz na obrázek |
| `mainAttachment` | Hlavní příloha | logic | MainAttachment | ne | ANO | - | - | - | - | Hlavní příloha |
| `dataHash` | Otisk dat přílohy (MD5 součet) | string | DataHash | ne | ANO | 50 | - | - | - | Otisk dat přílohy (MD5 součet) |
| `pictureWidth` | Šířka obrázku | integer | PictureWidth | ne | ANO | - | - | - | - | Šířka obrázku |
| `pictureHeight` | Výška obrázku | integer | PictureHeight | ne | ANO | - | - | - | - | Výška obrázku |
| `uzivatel` | Uživatel | relation | IdUziv | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
| `doklFak` | Doklad faktury | relation | IdDoklFak | ne | ne | - | - | - | - | Doklad faktury |
| `doklInt` | Interní doklad | relation | IdDoklInt | ne | ne | - | - | - | - | Interní doklad |
| `doklObch` | Obchodní doklad | relation | IdDoklObch | ne | ne | - | - | - | - | Obchodní doklad |
| `doklSklad` | Příjemka/výdejka | relation | IdDoklSklad | ne | ne | - | - | - | `skladovy-pohyb` | Příjemka/výdejka |
| `nastaveni` | Nastavení | relation | IdNastav | ne | ne | - | - | - | `nastaveni` | Nastavení |
| `cenik` | Ceník | relation | IdCenik | ne | ne | 64 | - | - | `cenik` | Ceník |
| `adresar` | Adresář | relation | IdAdresar | ne | ANO | - | - | - | `adresar` | Adresář |
| `kontakt` | Kontakt | relation | IdKontakt | ne | ANO | - | - | - | `kontakt` | Kontakt |
| `konektor` | Konektor | relation | IdKonektor | ne | ne | - | - | - | - | Konektor |
| `report` | Report | relation | IdReport | ne | ne | - | - | - | `report` | Report |
| `zakazka` | Zakázka | relation | IdZakazky | ne | ANO | 30 | - | - | `zakazka` | Zakázka |
| `smlouva` | Smlouva | relation | IdSmlouvy | ne | ANO | 20 | - | - | `smlouva` | Smlouva |
| `polSmlouvy` | Pol. smlouvy | relation | IdPolSml | ne | ANO | 64 | - | - | `smlouva-polozka` | Pol. smlouvy |
| `uzel` | Strom | relation | IdUzel | ne | ne | - | - | - | `strom` | Strom |
| `adrUdalost` | Událost | relation | IdAdrUdalost | ne | ANO | - | - | - | `udalost` | Událost |
| `content` | Obsah | blob |  | ne | ANO | - | - | - | - | Obsah |
