# Brani — PHP Integration Patterns (shopsync)

Patterns taken from real projects: `c:\shopsync_dir2\brani_pohoda_lyofio` (newer, namespaced lib) and `c:\shopsync_dir2\brani_sklad_pohoda` (older, global-namespace lib). ERP side is Pohoda in both (see the `pohoda` skill).

## Transport functions (`lib/brani/inc.php`)

Two flavors — always check which one the project has:

| | newer (`namespace Brani;`) | older (global) |
|---|---|---|
| call style | `Brani\api_get(...)` | `api_get(...)` |
| functions | `api_get`, `api_post`, `api_patch`, `api_post_file`, `getStockSupplies`, `getHooks` | `api_get`, `api_post`, `api_post_file` only |

Signatures (identical behavior in both):

```php
api_get($route, $params = array())                 // GET, $params -> query string
api_post($route, $params = array(), $data = array())   // POST, JSON body = json_encode($data)
api_patch($route, $params = array(), $data = array())  // PATCH, JSON body (newer flavor only)
api_post_file($route, $params, $file_path, $field_name = "file") // multipart CURLFile, application/gzip
```

Behavior to remember:
- `brani_url = "https://api.brani.cz"`, `brani_token = getCfg(8, "brani_token")` defined at include time.
- Auth header `Authorization: Bearer <token>`; SSL verification disabled; redirects followed.
- **Never throws.** Non-200/201 (202 also OK for `api_post_file`) just `printf`s `"Pri operaci nastala chyba (HTTP %d): %s"` and the raw body is still returned. Callers must `json_decode` + validate:

```php
$resp = json_decode(Brani\api_get("stock/movement_documents", array("date_from" => date("Y-m-d", strtotime("-7 day")))), true);
if (!$resp || !isset($resp["documents"])) { logln("chyba nacteni dokladu"); return; }
```

- `debug >= 1` (`getCfg(8, "debug")`) echoes every request URL.

## Product snapshot import (async JSONL)

Full flow (inline in `brani_pohoda_lyofio\scripts\brani_products.php`; also as class `Brani\Products` in `lib/brani/products.php` with `save()` / `waitForSnapshotCompletion()` / `mapProductToBraniFormat()`):

```php
// 1. one JSON object per line
foreach ($data as $product) {
    $jsonl_lines[] = json_encode(array(
        "name" => $product["name"],
        "guid" => create_guid("brani" . $product["code"]),   // deterministic GUID from product code
        "type" => "product", "visibility" => "visible",
        "creationTime" => date("c"), "changeTime" => date("c"),
        "images" => array(), "setItems" => array(),
        "variants" => array(array(
            "code" => $product["code"], "name" => $product["name"],
            "weight" => number_format(floatval($product["weight"]), 3, '.', ''), // exactly 3 decimals
            "ean" => $product["EAN"] != null ? $product["EAN"] : null,
            "negativeStockAllowed" => "no", "amountDecimalPlaces" => 3,
            "price" => array("vatRate" => $vatRate, "price" => $priceWithVat),
        )),
    ), JSON_UNESCAPED_UNICODE);
}
// 2. gzip + upload
$gz = gzencode(implode("\n", $jsonl_lines), 9);
file_put_contents($temp_file = temp_dir . '/brani_products_' . date('YmdHis') . '.jsonl.gz', $gz);
$resp = json_decode(Brani\api_post_file("products/snapshots/import/", array(), $temp_file, "file"), true);
$snapshot_id = isset($resp['id']) ? $resp['id'] : $resp['snapshotId'];
// 3. poll status: GET products/snapshots/, find by id, every 10 s, max ~30 attempts
//    success: completed|done|success   failure: failed|error (message in 'error')
```

Products are loaded from Pohoda by a `CustProducts extends Pohoda\Products` class in the script (custom `$select` over `SKz`, pair field `IDS`). Follow-up work that depends on products existing in Brani (e.g. recipe sync) runs only after the snapshot reports success.

## Orders into Brani (`order/upsert`)

`brani_pohoda_lyofio\scripts\orders.php` — eshop order mapped to the order model and posted as `{"data": $order}`:

```php
$brani_order = array(
    "code" => $order_number, "creationTime" => date("c", $ts), // must be in the past
    "email" => ..., "phone" => ..., "paid" => true/false,
    "billingAddress" => array("fullName" => ..., "street" => ..., "city" => ..., "zip" => ..., "countryCode" => "CZ"),
    "deliveryAddress" => array(...), "notes" => array("eshopRemark" => ...),
    "price" => array("currencyCode" => "CZK", "withVat" => "1210.00", "toPay" => "1210.00"), // strings
    "status" => array("id" => $status_id),           // ids must match those sent via POST eshop/info
    "shippingGuid" => create_guid(...), "paymentMethodGuid" => create_guid(...),
    "items" => array(array(
        "itemId" => $i, "itemType" => "product", "code" => $code, "name" => $name,
        "amount" => "1", "amountUnit" => "ks", "weight" => "0.500",       // strings
        "itemPriceWithVat" => "605.00", "productGuid" => create_guid("brani" . $code),
    )),
);
Brani\api_post("order/upsert", array(), array("data" => $brani_order));
```

Dedup pattern: md5 of the JSON payload stored per document — re-send only when the hash changes. Shipping/payment methods and order statuses are registered first via `Brani\api_post("eshop/info", array(), $data)` (`scripts/eshopinfo.php`).

## Warehouse results back to ERP (movement documents)

`brani_sklad_pohoda` scripts — poll closed documents, generate Pohoda XML, import via `Pohoda\CallImport`:

```php
// list, filtered by date (not paginated in practice)
$mvt = json_decode(api_get("stock/movement_documents?date_from=" . date("Y-m-d", strtotime("-7 day"))), true);
foreach ($mvt["documents"] as $mv) {
    if ($mv["status"] != "closed" || $mv["document_type_id"] != 394) continue;  // type ids are account-specific
    // dedup: synthetic number in Pohoda, e.g. Cislo = "PPRI" . $mv["document_id"] checked with SELECT before import
    $doc = json_decode(api_get("stock/movement_documents/" . $mv["document_id"]), true);
    foreach ($doc["products"] as $p) {
        // USE amount_processed (actually processed qty), not amount
        $items[] = array("code" => $p["product_code"], "cnt" => $p["amount_processed"]);
    }
    // $doc["product_prices"]: [{product_code, price}] -> code=>price map
}
```

- `brani_prijemka.php`: closed type-394 docs → Pohoda příjemky (dedup `Cislo = "PPRI".document_id` in `SKPP`); days back from `getCfg(8, "brani_prijemka_days_back", 7)`.
- `brani_vydejka.php`: doc-type→prefix map (e.g. `350→VLIK, 392→VZAM, 393→VDAR, 396→VINF`) → Pohoda výdejky (`SKPV`).
- `brani_inventura.php`: paginated `stock/inventura?page=&per_page=50` (loop `page < total_pages`), detail `changes[]` `{code, before_amount, after_amount}` — delta>0 příjemka `BIP<id>`, delta<0 výdejka `BIV<id>`.
- Creating documents INTO Brani (orders as expected receipts): `api_post("stock/movement_documents", array(), array("document_type_id" => 1, "document_number" => ..., "order_number" => ..., "status" => "open", "products" => array(array("amount" => 2, "product_code" => "ABC"))))`; sent-set kept in a JSON state file (`temp_dir/sent_orders.json`).

## Purchase orders + shoplists → ERP issued orders

- `brani2.php`: paginated `stock/purchase_orders?page=$p&items_per_page=50&with_closed=true` (loop while `page*items_per_page < total_items`); joins PO `movement_document.document_id` to movement docs client-side (no server filter).
- `brani3.php`: `autoorder/shoplist/list` (filter `shoplist_state=="ordered" && shoplist_archived`), items via `autoorder/shoplist/items/{id}` → `{product_code, amount, price, in_stock}`.

## Stock supplies

```php
$stock = Brani\getStockSupplies();   // GET stock/supplies, sums amount per code across locations
// returns array(code => total_qty)
```

## Webhook bridge (packed orders → invoices)

Brani webhook events are captured by esync and polled from a **separate host** (no Bearer token):

```php
// lib/brani/inc.php (newer flavor)
$hooks = Brani\getHooks("orders", $from, "balic_packed");
// GET https://brani.esync.cz/gethook.php?id_eshop=<brani_eshop_id>&hash=md53(<id>."_8x7A9bLJfrQL5R6a")&from=&entity=&event=
// returns array(order_number => payload)
```

`scripts/order_states.php` pattern: `$from = getLastUpd("order_states", "file")` → `getHooks(...)` → match each order_number to Pohoda `OBJ.Cislo` → generate invoice XML → `setLastUpd("order_states", "file")`.

The native API also offers registered webhooks (`POST /webhook` + poll `GET /webhook/events/{id}`) — the gethook.php bridge predates this and is what existing projects use.

## Manufacture recipes sync

`brani_pohoda_lyofio\scripts\brani_products.php` — Pohoda výrobek cards (`SKz.RelSkTyp = 5`, components in `SKzPol`) → assembly recipes, after product snapshot succeeds:

1. List existing: `Brani\api_get("manufacture/recipes", array("recipe_types" => "assembly", "page" => $p, "items_per_page" => 100))`, index by code prefix of `name` (`"<code> - <name>"` convention — recipes have no external code).
2. Missing → `api_post("manufacture/recipes", array(), $payload)`; existing → fetch detail (`GET manufacture/recipes/{id}`, list rows lack inputs/outputs), compare normalized inputs/outputs, `api_patch("manufacture/recipes/{id}", ...)` only when changed.
3. `receipt_document_type_id` / `issue_document_type_id` from `getCfg(8, "brani_receipt_doc_type_id")` / `brani_issue_doc_type_id`, sent as `null` when unset. No DELETE — orphaned recipes are only logged.

## Config keys (profile settings, section 8 "Ostatní")

| Key | Meaning |
|---|---|
| `brani_token` | Bearer token for api.brani.cz |
| `brani_eshop_id` | Eshop id for the gethook.php webhook bridge |
| `debug` | ≥1 log request URLs/responses, ≥2 log payloads |
| `brani_prijemka_days_back` / `brani_vydejka_days_back` | List window for movement docs (default 7) |
| `brani_inventura_days_back` | Inventura window (default 30) |
| `brani_receipt_doc_type_id` / `brani_issue_doc_type_id` | Document type ids for recipe auto-receipt/issue |

ERP-side output settings (číselné řady, sklad) come from section 1 (`getCfg(1, "rada_prijemek")`, `vychozi_sklad`, ...), used in the Pohoda XML templates, not by the Brani client.

## Gotchas

- Older scripts (`brani.php`, `brani2.php`, `brani3.php`, `brani_obj.php` in `brani_sklad_pohoda`) have **inlined transport functions with a hardcoded JWT token** instead of using `lib/brani/inc.php` — don't copy that pattern; use the lib + `brani_token` setting.
- Document type ids (`document_type_id`, recipe doc types) differ per Brani account — never hardcode without checking `GET /stock/document_types`.
- `amount` vs `amount_processed` on document details: closed documents report the actually processed quantity in `amount_processed`.
- Numbers as strings: order prices/amounts/weights and variant `weight` (3 decimals) are strings in the API schemas; movement document product `amount` is numeric.
- The transport prints errors with a broken `%sn` format (missing newline) — grep logs for `Pri operaci nastala chyba`.
