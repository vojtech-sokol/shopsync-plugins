# Integrace

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `integrace` |
| **Evidence Type** | `INTEGRACE` |
| **Import Status** | DISALLOWED |
| **DB Name** | `wintegrace` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/integrace` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/integrace/properties` |

## Vlastnosti (9)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | Idintegration | ne | ne | - | - | - | - | ID |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 20 | - | - | - | Zkratka |
| `registerUrl` | Registrační URL | string | Registerurl | ne | ANO | 500 | - | - | - | Registrační URL |
| `authTokenPart` | Část autentizačního tokenu | string | Authtokenpart | ne | ANO | 255 | - | - | - | Část autentizačního tokenu |
| `orgId` | Identifikátor firmy | string | Orgid | ne | ANO | 50 | - | - | - | Identifikátor firmy |
| `instanceId` | Identifikátor instance | string | Instanceid | ne | ANO | 50 | - | - | - | Identifikátor instance |
| `addonStoreId` | ID integrátora z obchodu doplňků | integer | Addonstoreid | ne | ANO | - | - | - | - | ID integrátora z obchodu doplňků |
| `statusK` | Status | select | Statusk | ne | ANO | 50 | - | - | - | Status |
