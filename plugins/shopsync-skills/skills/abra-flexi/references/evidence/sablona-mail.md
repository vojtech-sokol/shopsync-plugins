# Uživatelské e-mailové šablony

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `sablona-mail` |
| **Evidence Type** | `SABLONA_MAIL` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wSablonaMail` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/sablona-mail` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/sablona-mail/properties` |

## Vlastnosti (13)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | Idsablona | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `nazevA` | Název EN | string | NazevA | ne | ANO | 255 | - | - | - | Název EN |
| `nazevB` | Název DE | string | NazevB | ne | ANO | 255 | - | - | - | Název DE |
| `nazevC` | Název FR | string | NazevC | ne | ANO | 255 | - | - | - | Název FR |
| `poznam` | Poznámka | string | Poznam | ne | ANO | - | - | - | - | Poznámka |
| `popis` | Popis | string | Popis | ne | ANO | - | - | - | - | Popis |
| `beanKeys` | Místa použití | string | BeanKeys | ne | ANO | - | - | - | - | Místa použití |
| `textSablona` | Text | string | TextSablona | **ANO** | ANO | - | - | - | - | Text |
| `defaultFrom` | Odesílatel | string | DefaultFrom | ne | ANO | 255 | - | - | - | Odesílatel |
| `subject` | Předmět | string | Subject | ne | ANO | 255 | - | - | - | Předmět |
