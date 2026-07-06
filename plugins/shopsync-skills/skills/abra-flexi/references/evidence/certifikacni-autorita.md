# Certifikační autority

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `certifikacni-autorita` |
| **Evidence Type** | `CERTIFIKACNI_AUTORITA` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wAutCert` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/certifikacni-autorita` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/certifikacni-autorita/properties` |

## Vlastnosti (7)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | IdAutCert | ne | ne | - | - | - | - | ID |
| `lastUpdate` | Poslední změna | datetime | lastUpdate | ne | ne | - | - | - | - | Poslední změna |
| `uzivNazev` | Poznámka | string | UzivNazev | ne | ANO | 255 | - | - | - | Poznámka |
| `certNazev` | Název certifikátu | string | CertNazev | **ANO** | ANO | 255 | - | - | - | Název certifikátu |
| `certOrgan` | Organizace certifikátu | string | CertOrgan | **ANO** | ANO | 255 | - | - | - | Organizace certifikátu |
| `platiOd` | Platí od roku | date | PlatiOd | **ANO** | ANO | - | - | - | - | Platí od |
| `platiDo` | Platí do roku | date | PlatiDo | **ANO** | ANO | - | - | - | - | Platí do |
