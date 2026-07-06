# Sdílení přehledů

| Vlastnost | Hodnota |
|---|---|
| **Evidence Path** | `dashboard-sharing` |
| **Evidence Type** | `DASHBOARD_SHARING` |
| **Import Status** | NOT_DOCUMENTED |
| **DB Name** | `wdashboardsharing` |
| **Ext ID Supported** | false |
| **API URL** | `https://demo.flexibee.eu/c/demo/dashboard-sharing` |
| **Properties URL** | `https://demo.flexibee.eu/c/demo/dashboard-sharing/properties` |

## Vlastnosti (5)

| Vlastnost | Název | Typ | DB | Povinné | Zápis | Max. délka | Číslice | Des. místa | FK evidence | Popis |
|---|---|---|---|---|---|---|---|---|---|---|
| `id` | ID | integer | Idwdashboardsharing | ne | ne | - | - | - | - | ID |
| `hidden` | Skrytý | logic | Hidden | ne | ANO | - | - | - | - | Skrytý |
| `priority` | Pořadí | integer | Priority | ne | ANO | - | - | - | - | Pořadí |
| `user` | Uživatel | relation | Iduser | **ANO** | ANO | 254 | - | - | `uzivatel` | Uživatel |
| `dashboardpanel` | Dashboard panel | relation | Iddashboardpanel | **ANO** | ANO | - | - | - | `dashboard-panel` | Dashboard panel |
