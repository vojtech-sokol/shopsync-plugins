# Doplněk

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `doplnek` |
| **Evidence Type** | `DOPLNEK` |
| **Import Status** | DISALLOWED |
| **DB Name** | `waddon` |
| **Ext ID Supported** | true |
| **API URL** | `https://demo.flexibee.eu/c/demo/doplnek` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/doplnek/properties` |

## Vlastnosti (21)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | Idaddon | ne | ne | - | - | - | - | ID |
| `kod` | Zkratka | string | Kod | **ANO** | ANO | 40 | - | - | - | Zkratka |
| `nazev` | Název | string | Nazev | **ANO** | ANO | 255 | - | - | - | Název |
| `integratorAddonId` | ID doplňku u integrátora | string | Integratoraddonid | ne | ANO | 20 | - | - | - | ID doplňku u integrátora |
| `statusK` | Status | select | Statusk | ne | ANO | 50 | - | - | - | Status |
| `version` | Verze | string | Version | ne | ANO | 20 | - | - | - | Verze |
| `price` | Cena | numeric | Price | ne | ANO | - | - | - | - | Cena |
| `priceUrl` | URL s cenou | string | Priceurl | ne | ANO | 500 | - | - | - | URL s cenou |
| `activateUrl` | Aktivační URL | string | Activateurl | ne | ANO | 500 | - | - | - | Aktivační URL |
| `configUrl` | Konfigurační URL | string | Configurl | ne | ANO | 500 | - | - | - | Konfigurační URL |
| `pauseUrl` | URL pro pozastavení | string | Pauseurl | ne | ANO | 500 | - | - | - | URL pro pozastavení |
| `unpauseUrl` | URL pro opětovné spuštění | string | Unpauseurl | ne | ANO | 500 | - | - | - | URL pro opětovné spuštění |
| `statusUrl` | Status URL | string | Statusurl | ne | ANO | 500 | - | - | - | Status URL |
| `deactivateUrl` | Deaktivační URL | string | Deactivateurl | ne | ANO | 500 | - | - | - | Deaktivační URL |
| `cenikKodFakturace` | Kód ceníku fakturace | string | Cenikkodfakturace | ne | ANO | 20 | - | - | - | Kód ceníku fakturace |
| `addonStoreId` | ID doplňku z obchodu doplňků | integer | Addonstoreid | ne | ANO | - | - | - | - | ID doplňku z obchodu doplňků |
| `createdDate` | Datum vytvoření | datetime | CreatedDate | ne | ne | - | - | - | - | Datum vytvoření |
| `integrace` | Integrace | relation | Idintegration | ne | ANO | - | - | - | `integrace` | Integrace |
| `apiUser` | API Uživatel | relation | Apiuserid | ne | ANO | - | - | - | `uzivatel` | API Uživatel |
| `updatedBy` | Upravil | relation | IdUpdatedBy | ne | ne | 254 | - | - | `uzivatel` | Upravil |
| `createdBy` | Vytvořil | relation | IdCreatedBy | ne | ne | 254 | - | - | `uzivatel` | Vytvořil |
