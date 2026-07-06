# Certifikáty

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `certifikat` |
| **Evidence Type** | `CERTIFIKAT` |
| **Import Status** | DISALLOWED |
| **DB Name** | `wOsCert` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/certifikat` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/certifikat/properties` |

## Vlastnosti (9)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdOsCert | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `uzivNazev` | Poznámka | string | UzivNazev | ne | ANO | 255 | - | - | - | Poznámka |
| `certNazev` | Název certifikátu | string | CertNazev | **ANO** | ANO | 255 | - | - | - | Název certifikátu |
| `certOrgan` | Organizace certifikátu | string | CertOrgan | **ANO** | ANO | 255 | - | - | - | Organizace certifikátu |
| `platiOd` | Platí od roku | datetime | PlatiOd | **ANO** | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | datetime | PlatiDo | **ANO** | ANO | - | - | - | - | Platí do |
| `uzivatel` | Uživatel | relation | IdUzivatel | ne | ne | 254 | - | - | `uzivatel` | Uživatel |
| `ucelCertK` | Účel certifikátu | select | UcelCertK | **ANO** | ANO | 50 | - | - | - | Účel certifikátu |
