# Webhooks

Brani API module tag: "Webhooky". Base URL `https://api.brani.cz`, Bearer auth.

## GET /webhook
**Výpis Registrovaných Webhooků**

Endpoint pro získání všech registrovaných webhooků pro eshop

Response 200: **Webhook_url_list**

## POST /webhook
**Registrace Nového Webhooku**

Endpoint pro registraci nového webhooku. Je nutné předat jaký typ eventů, bude webhook sledovat (event_type) a dále URL, na kterou se bude webhook zasílat.

Request body (application/json): **Body_Registrace_nov_ho_webhooku_webhook_post** — see Schemas below

## DELETE /webhook/{webhook_id}
**Smazání Registrovaného Webhooku**

Endpoint smaže registovaný webhook dle jeho ID.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `webhook_id` | path | integer | yes |  |

## PATCH /webhook/{webhook_id}
**Aktualizace Url Webhooku**

Endpoint pro změnu URL u již registrovaného webhooku dle jeho ID.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `webhook_id` | path | integer | yes |  |

Request body (application/json): **Body_Aktualizace_URL_webhooku_webhook__webhook_id__patch** — see Schemas below

## GET /webhook/events/{webhook_id}
**Výpis Objednávkových Eventů Pro Webhook**

Vrací eventy z **objednávkové (order)** fronty eventů pro zadaný `webhook_id`. **Tento endpoint je určen jen pro eventy:** - `added_to_cart, order_history, status_change, shipping_change, balic_packed, package_number, balic_picked` Pro všeobecné eventy (`task_assigned, task_created, inventory_check_completed, movement_document_created, personal_pickup_stored, personal_pickup_issued, task_status_changed, movement_document_updated`) použijte endpoint: **GET /webhook/events/general/{webhook_id}**.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `webhook_id` | path | integer | yes |  |
| `from_date` | query | string \| null |  | default `"2001-01-01 01:01:01"` |
| `inverted` | query | boolean \| null |  | default `false` |
| `page_number` | query | integer | yes |  |
| `items_per_page` | query | integer | yes |  |
| `only_failed` | query | boolean \| null |  | default `false` |

Response 200: **Events_response**

## GET /webhook/events/general/{webhook_id}
**Výpis Všeobecných Eventů Pro Webhook**

Vrací eventy z **general** fronty eventů pro zadaný `webhook_id`. **Tento endpoint je určen jen pro eventy:** - `task_assigned, task_created, inventory_check_completed, movement_document_created, personal_pickup_stored, personal_pickup_issued, task_status_changed, movement_document_updated` Pro objednávkové eventy (`added_to_cart, order_history, status_change, shipping_change, balic_packed, package_number, balic_picked`) použijte endpoint: **GET /webhook/events/{webhook_id}**.

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `webhook_id` | path | integer | yes |  |
| `from_date` | query | string \| null |  | default `"2001-01-01 01:01:01"` |
| `inverted` | query | boolean \| null |  | default `false` |
| `page_number` | query | integer | yes |  |
| `items_per_page` | query | integer | yes |  |
| `only_failed` | query | boolean \| null |  | default `false` |

Response 200: **GeneralEventsResponse**

## GET /webhook/events/{webhook_id}/xml
**Výpis Objednávkových Eventů Pro Webhook (Xml)**

Vrací eventy z objednávkové (order) fronty pro zadaný `webhook_id` ve formátu XML. Tento endpoint je určen pouze pro objednávkové eventy: - added_to_cart, order_history, status_change, shipping_change, balic_packed, package_number, balic_picked Query parametry: - from_date: eventy vytvořené od zadaného data - inverted: obrátí pořadí řazení (standardně od nejnovějších) - only_failed: zobrazí pouze neúspěšně zpracované eventy

| Param | In | Type | Req | Notes |
|---|---|---|---|---|
| `webhook_id` | path | integer | yes |  |
| `from_date` | query | string \| null |  |  |
| `inverted` | query | boolean \| null |  | default `false` |
| `only_failed` | query | boolean \| null |  | default `false` |

---

## Schemas

### Body_Aktualizace_URL_webhooku_webhook__webhook_id__patch

| Field | Type | Req | Notes |
|---|---|---|---|
| `url` | string | yes |  |

### Body_Registrace_nov_ho_webhooku_webhook_post

| Field | Type | Req | Notes |
|---|---|---|---|
| `event_type` | Event_type | yes |  |
| `url` | string | yes |  |

### ErrorDetail

| Field | Type | Req | Notes |
|---|---|---|---|
| `message` | string \| null |  |  |
| `status_code` | integer \| null |  | Status Code |

### Event_type
Enum: `balic_packed`, `balic_picked`, `package_number`, `order_history`, `status_change`, `added_to_cart`, `shipping_change`, `movement_document_created`, `movement_document_updated`, `inventory_check_completed`, `personal_pickup_stored`, `personal_pickup_issued`, `task_created`, `task_assigned`, `task_status_changed`

### Events_order_schema

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes |  |
| `webhook_id` | integer | yes | Webhook Id |
| `event_creation` | string | yes | Event Creation |
| `order_code` | string | yes | Order Code |
| `event_status_id` | integer \| null |  | Event Status Id |
| `event_package_number` | string \| null |  | Event Package Number |
| `event_order_history` | string \| null |  | Event Order History |
| `date_successful` | string \| null |  | Date Successful |
| `date_last_failed` | string \| null |  | Date Last Failed |
| `last_errors` | ErrorDetail \| null |  |  |
| `fail_counter` | integer \| null |  | Fail Counter |
| `processed` | integer \| null |  |  |

### Events_response

| Field | Type | Req | Notes |
|---|---|---|---|
| `webhook_events` | array of Events_order_schema | yes | Webhook Events |
| `total_items` | integer | yes | Total Items |
| `items_per_page` | integer | yes | Items Per Page |
| `page` | integer | yes |  |
| `items_on_current_page` | integer | yes | Items On Current Page |

### GeneralEventSchema

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes |  |
| `webhook_id` | integer | yes | Webhook Id |
| `created_at` | string | yes | Created At |
| `event_type` | string | yes | Event Type |
| `status` | string | yes | enum: pending, processing, delivered, failed |
| `attempt_count` | integer | yes | Attempt Count |
| `last_status_code` | integer \| null |  | Last Status Code |
| `last_error` | string \| null |  | Last Error |
| `delivered_at` | string \| null |  | Delivered At |
| `last_attempt_at` | string \| null |  | Last Attempt At |
| `next_attempt_at` | string \| null |  | Next Attempt At |
| `payload` | object | yes |  |

### GeneralEventsResponse

| Field | Type | Req | Notes |
|---|---|---|---|
| `webhook_events` | array of GeneralEventSchema | yes | Webhook Events |
| `total_items` | integer | yes | Total Items |
| `items_per_page` | integer | yes | Items Per Page |
| `page` | integer | yes |  |
| `items_on_current_page` | integer | yes | Items On Current Page |

### Webhook_url

| Field | Type | Req | Notes |
|---|---|---|---|
| `id` | integer | yes | Webhook id |
| `event_type` | Event_type | yes | Event type |
| `webhook_url` | string | yes | Webhook url |

### Webhook_url_list

| Field | Type | Req | Notes |
|---|---|---|---|
| `webhook_urls` | array of Webhook_url | yes | Webhook Urls |
