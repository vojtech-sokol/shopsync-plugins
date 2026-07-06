# Shoptet API - Detailed Reference

## Authentication

OAuth token-based. Token obtained automatically via `api_getToken()` using `shoptet_id` from profile config (section 8). Token cached in `$GLOBALS["shoptet_token"]`.

Config keys (section 8):
- `shoptet_id` - Shoptet addon ID for OAuth

## HTTP Functions (Shoptet namespace, inc.php)

| Function | Signature | Notes |
|----------|-----------|-------|
| `api_get` | `($route, $params = [])` | Auto-retry on 429, returns JSON string |
| `api_post` | `($route, $params, $data)` | 2.5s delay, returns JSON string |
| `api_put` | `($route, $params, $data)` | 2.5s delay, returns JSON string |
| `api_patch` | `($route, $params, $data)` | Returns JSON string |
| `api_delete` | `($route, $params)` | 2.5s delay, returns JSON string |
| `api_getToken` | `()` | Auto-called, caches token |
| `getHooks` | `($entity, $from)` | Get change notifications |
| `getJobStatus` | `($job_id)` | Returns `["status" => "completed"/"processing", "result" => url]` |
| `prepareProductData` | `($data, $categories)` | Transform product array for upload |

## Shoptet\Orders Class

**Properties:**
- `$data` - Loaded orders array
- `$order` - Current order being processed
- `$shipping_i`, `$payment_i`, `$coupon_i`, `$wrapping_i` - Item indices
- `$rounding_name` - Name for rounding item (default "Zaokruhleni")
- `$perpage` - Orders per page (default 100)
- `$statuses` / `$statuses_exclude` - Status filters
- `$orders_download_snapshot` - Use snapshot method (default true)

**Methods:**
- `changeStatus($order_number, $status, $tracking_number, $dont_change_if_current_state_in, $suppress_notification)` - Change order status with optional tracking
- `load($days_back, $date_from, $updates, $number, $statuses_exclude, $statuses)` - Load orders
- `loadOrder($data)` - Parse single order data
- `modifyOrder($data)` - Hook for order modification (override in subclass)

**changeStatus flow:**
1. GET order to check current status and tracking
2. If tracking changed: PATCH notes with new tracking number
3. If status differs and not in skip list: PATCH status

**Order data structure (after loadOrder):**
```
number, id, symvar, status, date, datedue, paid
email, note, note2, payment, payment_orig, carrier, carrier_orig
invoice: {company, name, street, city, postcode, phone, country, ic, dic, firstname, lastname}
delivery: {company, name, street, city, postcode, phone, country, firstname, lastname}
items[]: {id, code, ean, name, price, count, vat, withvat}
total_incl_vat, total_excl_vat, currency_code, currency_rate
```

## Shoptet\Products Class

**Properties:**
- `$update_related_products` - Update related products (default false)
- `$batch_process_update` - Use batch API (default true)
- `$map_variant` - Field mapping for variant data

**Methods:**
- `init()` - Initialize (load existing products from Shoptet)
- `save($data)` - Save products (create/update with batch)
- `updateBatchPriceExclVat($data, $pricelist_id)` - Batch price update for pricelist

## Shoptet\Categories Class

**Methods:**
- `saveCategories($categories)` - Sync categories (create/update/reorder)
- `getExistingCategoriesPaths()` - Get current categories from Shoptet

**Category data structure:**
```
id, code, name, description, parent, sequence, active, level, picture, path
```

## Shoptet\Pictures Class

**Methods:**
- `updatePictures($data, $force)` - Upload/sync product images

**Picture data structure:**
```
code: "PRODUCT_CODE"
picts[]: {path, cover, order, desc, dest}
```

## Shoptet\Invoices / CreditNotes / ProformaInvoices

All follow similar pattern:
- `load($days_back, $date_from)` - Load documents
- `loadInvoice/loadCreditNote($data)` - Parse single document

## Snapshot Pattern (async bulk export)

Used for large data sets (orders, products, customers):
```php
// 1. Request snapshot
$reqdata = json_decode(api_get("api/orders/snapshot", array(
    "changeTimeFrom" => date("c", strtotime($last)),
    "include" => "notes,shippingDetails"
)), true);
$job_id = $reqdata["data"]["jobId"];

// 2. Poll for completion
sleep(10);
while (true) {
    $job = getJobStatus($job_id);
    if ($job["status"] == "completed") {
        downloadFile($job["result"], temp_dir . "/data.json.gz");
        file_put_contents(temp_dir . "/data.json",
            gzdecode(file_get_contents(temp_dir . "/data.json.gz")));
        break;
    }
    sleep(5);
}

// 3. Process line-by-line JSON
$lines = explode("\n", file_get_contents(temp_dir . "/data.json"));
foreach ($lines as $line) {
    $data = json_decode($line, true);
    // process...
}
```

## Order Status IDs

Common Shoptet status IDs (project-specific, check via `GET api/orders/statuses`):
- Negative IDs are system statuses (e.g. -1, -2, -3, -4)
- Positive IDs are custom statuses

## Extending Classes

```php
class CustOrders extends Shoptet\Orders {
    public $orders_download_snapshot = true;
    public $rounding_name = "Zaokruhleni";

    public function loadOrder($data) {
        parent::loadOrder($data);
        // Custom logic: map shipping codes, modify items, etc.
    }
}
```

## Utility Functions (inc.php)

- `maxLen($string, $length)` - Truncate string to max length
- `urlencode2($s)` - Custom URL encoding for filenames
- `build_post_fields($data, $existingKeys, &$returnArray)` - Build multipart form data
- `downloadFile($url, $dest)` - Download file from URL
