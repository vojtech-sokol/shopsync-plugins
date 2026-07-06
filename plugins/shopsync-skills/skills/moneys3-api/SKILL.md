---
name: moneys3-api
description: Dev helper for Money S3 (S3 API) ERP GraphQL integration. Use when working on shopsync projects that integrate with Money S3 via its GraphQL S3 API - orders, invoices, articles, warehouse stocks, companies, cash vouchers, bank statements. Provides API reference, PHP client patterns, GraphQL request builder, authentication and dedup patterns. Use when user mentions "moneys3", "money s3", "s3api", and (!) works in project containing `lib/moneys3_api/`.
user-invocable: true
argument-hint: [topic]
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# Money S3 (S3 API) - Dev Helper

Money S3 is a Czech ERP / accounting system (Solitea / Seyfor). The **S3 API** is a GraphQL endpoint exposed by the Money S3 server. The PHP client library is in `lib/moneys3_api/` under the `MoneyS3` namespace.

- Full GraphQL schema (21k lines, all types, inputs, queries, mutations): [references/s3api.graphql](references/s3api.graphql)
- Curated API reference (endpoints, common entities, definitionXMLTransfer codes, patterns): [references/api-reference.md](references/api-reference.md)

## Key Files

- `lib/moneys3_api/inc.php` - auth (`getToken`), GraphQL transport (`query`), idempotent `request` / `request2` helpers, GraphQL builder (`buildRequest`), SQLite dedup table
- `lib/moneys3_api/orders.php` - `MoneyS3\Orders` class (saveOrder, deleteOrder)
- `lib/moneys3_api/invoices.php` - `MoneyS3\Invoices` class (saveInvoice)

## Script Bootstrap Pattern

```php
include "./config.php";
include "./lib/functions.php";
init();
include "./lib/moneys3_api/inc.php";
include "./lib/moneys3_api/orders.php";
// Token is obtained automatically on the first query() call
```

Project-specific logic lives in `scripts*` folders, typically as a subclass of `MoneyS3\Orders` / `MoneyS3\Invoices` overriding `modifyOrder` / `modifyInvoice`.

## Core API Functions (`MoneyS3` namespace, `inc.php`)

| Function | Signature | Purpose |
|----------|-----------|---------|
| `getToken()` | `getToken()` | OAuth2 client-credentials flow against `/connect/token`. Caches token + expiry in `$GLOBALS['moneys3_token']` / `$GLOBALS['moneys3_token_validity']` (auto-refreshes 60s before expiry) |
| `query($q)` | `query(string $gql)` | POST raw GraphQL string to `/graphql`. Returns `json_decode(...,true)` array (keys: `data`, `errors`). Retries up to 5 times on HTTP != 200; sleeps 300ms between successful calls |
| `request($id, $data, $mutation, $definition, $objectName)` | | Idempotent mutation wrapper: builds GraphQL from PHP array via `buildRequest()`, wraps in `mutation { $mutation(definitionXMLTransfer:{shortCut:"$definition"}, $objectName:{...}) { guid isSuccess } }`, skips if `$id` already in `sync_api_reqs` SQLite table |
| `request2($id, $req, $mutation)` | | Same dedup behavior for pre-built GraphQL strings (used by `deleteOrder` etc.) |
| `buildRequest($data, $level=0)` | | Converts nested PHP array → GraphQL literal. Int/float/bool/string handled natively. **`@` prefix on string = raw token** (used for enums). Numeric-keyed (list) arrays → `[...]`, assoc arrays → `{...}` |

**Request headers for every GraphQL call:**
- `Authorization: Bearer <token>`
- `Content-Type: application/json`
- `AgendaID: <getCfg(8,"moneys3_agenda")>`  ← selects which Money S3 accounting agenda (client company) to write into

## Config Keys (section 8)

All Money S3 settings are in config section 8:

| Key | Purpose |
|-----|---------|
| `moneys3_api_url` | Base URL of the Money S3 server (no trailing slash). `/connect/token` and `/graphql` are appended. |
| `moneys3_client` | OAuth2 `client_id` |
| `moneys3_secret` | OAuth2 `client_secret` |
| `moneys3_agenda` | `AgendaID` header — the Money S3 agenda/year GUID |
| `moneys3_ignore_history` | `1` = bypass the `sync_api_reqs` dedup table (reprocess already-sent IDs). Can also be toggled per-run via `$GLOBALS['ignore_moneys3_history'] = 1` |

Section 1 keys used by `Orders` / `Invoices` defaults: `stredisko` (centre), `predkontace` (accountAssignment), `bank_ucet` (payOn), `kod_dph`, `kod_dph_oss`, `oss`, `oss_hlavni_zeme`, `ceny_s_dani`.

## Idempotency / Dedup

`inc.php` creates `temp_dir/money.sqlite` with table:
```sql
create table if not exists sync_api_reqs (id text primary key, response text)
```

Every `request()` / `request2()` call first checks if `$id` already exists. If yes, it returns `false` without sending. If no, it sends, then inserts `(id, json_encode(response))`. `request()` also dumps the GraphQL it's about to send to `temp_dir/req_<id>.txt` for debugging.

Standard ID conventions from the library:
- Orders: `ORD_<documentNumber>`, deletes: `DEL_<documentNumber>`
- Invoices: `INV_<documentNumber>`

## `buildRequest` — the `@` prefix trick

Because GraphQL enums are unquoted identifiers but strings are quoted, `buildRequest()` uses a leading `@` in a PHP string to mean "emit verbatim, no quotes":

```php
$item_req['priceType'] = "@WITH_VAT";   // → priceType: WITH_VAT   (enum)
$item_req['description'] = "foo";        // → description: "foo"    (string)
```

Use `@` for enum values (e.g. `@WITH_VAT`, `@WITHOUT_VAT`, `@ONLY_BASE`, `@ONLY_VAT`) and for any raw GraphQL you want to splice in.

## Main GraphQL Entities (most-used)

| Query / Mutation | Entity | Typical use |
|------------------|--------|-------------|
| `issuedInvoices` / `createIssuedInvoice` / `updateIssuedInvoice` / `deleteIssuedInvoice` | IssuedInvoice | Sales invoices (definition `_FP+FV` or `_FP+FV1`) |
| `receivedOrders` / `createReceivedOrder` / `updateReceivedOrder` / `deleteReceivedOrder` | ReceivedOrder | Customer orders (definition `_O+P+N` or `_O+P+N_1`) |
| `articles` / `createArticle` / `updateArticle` | Article | Catalog card (definition `_KK`) |
| `warehouseStocks` / `createWarehouseStock` / `updateWarehouseStock` | WarehouseStock | Per-warehouse stock card (definition `_ZAS`) — use to look up `article.guid` + `warehouse.guid` by catalogue code |
| `companies` / `createCompany` / `updateCompany` | Company | Address book partner (definition `_ADR`) — look up existing by email before insert to avoid duplicates |
| `cashVouchers` / `createCashVoucher` | CashVoucher | Cash receipts (definition `_PD`) |
| `bankStatements` / `createBankStatement` | BankStatement | Bank statements (definition `_BD`) |
| `receivables` / `liabilities` | Receivable / Liability | Other claims / obligations (definition `_PH+ZV`) |
| `receivedSlips` / `issuedSlips` / `saleSlips` / `transferNotes` / `receivedDeliveryNotes` / `issuedDeliveryNotes` | InStoreDocument | Stock movements (definition `_S`) |

All list queries follow the same shape:
```graphql
entityName(skip: Int, take: Int, where: IEntityFilterInput, order: [IEntitySortInput!]) {
  totalCount
  items { ... }
}
```

Mutations return `ImportPromise { guid isSuccess }`. Use `importStatus(importGuid: UUID!)` to poll async import status if needed.

## Common Patterns

### Existence check before insert
```php
$test = query('query { receivedOrders(where:{ documentNumber:{ eq:"'.$num.'" } }, take:1) { totalCount items{ id documentNumber } } }');
if ($test["data"]["receivedOrders"]["totalCount"] > 0) { /* skip */ }
```

### Look up partner by email, reuse GUID
```php
$res = query('query { companies(where:{ email:{ eq:"'.$email.'" } }, take:1) { items{ guid } } }');
if (isset($res["data"]["companies"]["items"][0]["guid"])) {
    $request['partnerAddress']['guid'] = $res["data"]["companies"]["items"][0]["guid"];
}
```

### Look up article + warehouse by catalogue code
```php
$res = query('query { warehouseStocks(where:{ catalogue:{ eq:"'.$code.'" } }, take:1) {
    items { article{ guid catalogue } warehouse{ guid code id } } } }');
```
Then attach `article: { guid, catalogue }` and `warehouse: { guid, code }` to the line item (or to `stockItem` on invoice lines).

### Filter syntax (HotChocolate-style)
`where` inputs use comparison wrappers: `{ field: { eq: "x" } }`, `neq`, `in: [..]`, `contains`, `startsWith`, `gt`, `lt`, `gte`, `lte`. Combine with `and: [...]`, `or: [...]`. `order` uses `{ field: ASC }` / `DESC`.

## Important Conventions

- **`AgendaID` header is mandatory** on every GraphQL call — without it the server has no accounting agenda context
- **Dates** on inputs are ISO `YYYY-MM-DD` strings (e.g. `date("Y-m-d", strtotime($d["date"]))`)
- **Prices**: `priceType` enum (`WITH_VAT` / `WITHOUT_VAT` / `ONLY_BASE` / `ONLY_VAT`) controls interpretation of `unitPrice`. `unitPriceHc` is the "home currency" equivalent (multiply by `currency_rate`)
- **VAT**: `vatRate` is percentage × 100 in the library (`$item["vat"] * 100` → e.g. 21 → 2100)
- **OSS**: when `getCfg(1,"oss")==1` and delivery country differs from `oss_hlavni_zeme`, set `ossCountry.code` and switch `vatClassification.shortCut` to `kod_dph_oss`
- **Empty company name**: the helpers fall back to `name` when `company` is blank (always pre-set both)
- **Delivery GUID fallback**: `Orders::saveOrder` generates a `create_guid(serialize(...))` when no matching delivery company is found — this avoids collapsing multiple deliveries into one
- **`definitionXMLTransfer`** selects the XML import definition that governs numeric series, behaviours, and field defaults; wrong code ⇒ document goes to the wrong folder or gets rejected
- **Response shape**: `{ "data": { ... }, "errors": [...] }` — the transport logs the first `errors[0].message` and returns `false` on error
- **Rate limiting**: the transport sleeps `usleep(300000)` (300 ms) after each successful call — do not remove when batching

## Topic Index (for the optional `[topic]` argument)

- `auth` / `token` → OAuth2 flow, AgendaID header
- `orders` / `invoices` / `articles` / `stocks` / `companies` → entity-specific patterns
- `dedup` / `history` → `sync_api_reqs` table, `moneys3_ignore_history`
- `buildrequest` / `builder` → `buildRequest()` and the `@` prefix
- `definitions` → full list of `definitionXMLTransfer` shortCut codes
- `schema` → point to [references/s3api.graphql](references/s3api.graphql)
