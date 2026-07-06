# Money S3 - S3 API Reference

GraphQL API. Base path: `/graphql`. Auth: OAuth2 client_credentials at `/connect/token`. Every GraphQL request carries `Authorization: Bearer <token>` **and** `AgendaID: <agenda-guid>`.

Full schema (source of truth): [s3api.graphql](s3api.graphql) (~21 200 lines).

---

## 1. Authentication

```
POST {moneys3_api_url}/connect/token?AppId=<fixed-app-id>
Content-Type: application/x-www-form-urlencoded

client_id=...&client_secret=...&grant_type=client_credentials&scope=s3api
```

Response: `{ "access_token": "...", "expires_in": 3600, "token_type": "Bearer" }`.

The PHP client in `lib/moneys3_api/inc.php` caches the token in `$GLOBALS['moneys3_token']` and refreshes it 60s before expiry. The `AppId` query-string parameter is a fixed Money S3 integration identifier hard-coded into `inc.php`.

---

## 2. Top-level operations (schema lines 4688 / 5106)

### `type Mutation`

All create/update/delete mutations take a `definitionXMLTransfer: DefinitionXMLTransferRefInput` argument with a default `shortCut` value. Most return `ImportPromise { guid isSuccess }`.

| Mutation group | Default `definitionXMLTransfer.shortCut` |
|----------------|-----------------------------------------|
| `createCashVoucher`, `updateCashVoucher` | `_PD` |
| `createBankStatement`, `updateBankStatement` | `_BD` |
| `createLiability`, `updateLiability`, `createReceivable`, `updateReceivable` | `_PH+ZV` |
| `createInternalDocument`, `updateInternalDocument` | `_ID` |
| `createOperation`, `updateOperation` | `_CIN` |
| `createVatClassification`, `updateVatClassification` | `_CLNDPH` |
| `createVatAccountingAcc/Tr`, `updateVatAccountingAcc/Tr` | `_ZAUCDPH` |
| `createAccountAssignmentAcc/Tr`, `updateAccountAssignmentAcc/Tr` | `_PREDK` |
| `createAccountChart/Movement`, `updateAccountChart/Movement` | `_UCOSN+POH` |
| `createCentre`, `updateCentre` | `_STR` |
| `createBankAccountCashBox`, `updateBankAccountCashBox` | `_BU+POKL` |
| `createParameter`, `updateParameter` | `_PAR` |
| `createJobOrder`, `updateJobOrder` | `_ZAK` |
| `createCompany`, `updateCompany` | `_ADR` |
| `createIssuedInvoice`, `updateIssuedInvoice`, `createReceivedInvoice`, `updateReceivedInvoice` | `_FP+FV` |
| `createIssuedOrder/Offer/Inquiry`, `createReceivedOrder/Offer/Inquiry`, and their `update…` variants | `_O+P+N` |
| `createArticle`, `updateArticle` | `_KK` |
| `createWarehouseStock`, `updateWarehouseStock` | `_ZAS` |
| `createStockTakingDocument`, `updateStockTakingDocument` | `_INVD` |
| `createReceivedSlip/IssuedSlip/SaleSlip/TransferNote/ReceivedDeliveryNote/IssuedDeliveryNote`, and `update…` variants | `_S` |
| `createWage`, `updateWage` | `_MZDY` |

Delete mutations do not take `definitionXMLTransfer` — they accept only `{ id }` (or `{ guid }`) and return `ImportPromise`.

Note on invoice/order definitions used by the current project: `Invoices` uses `_FP+FV1` and `Orders` uses `_O+P+N_1` (project-specific variants of the defaults above — the `1` suffix typically means a different numeric series).

### `type Query`

Every list query has the shape:

```graphql
entityName(
  skip: Int
  take: Int
  where: IEntityFilterInput
  order: [IEntitySortInput!]
): EntityCollectionSegment
```

Returning:

```graphql
type EntityCollectionSegment {
  totalCount: Int!
  items: [Entity!]
  pageInfo: CollectionSegmentInfo
}
```

Main query fields (abridged):

```
journalAccs, journalTrs, cashVouchers, bankStatements, liabilities, receivables,
internalDocuments, agendas, years, currencies, centres, operations, jobOrderTypes,
addressKeys, banks, shippings, combinedNomenclatures, municipalityPostalCodes,
countries, parameters, vatClassifications, accountCharts, accountMovements,
vatAccountingTrs, vatAccountingAccs, accountAssignmentTrs, accountAssignmentAccs,
numericalSeries, exchangeLists, bankAccountCashBoxes, nonMonetaryPayments,
constantSymbols, definitionXMLTransfers, priceLevels, jobOrders, activities,
vatPurposes, eshops, employmentType, employmentCode, companies, employees,
warehouses, issuedInvoices, receivedInvoices, receivedOrders, issuedOrders,
receivedOffers, issuedOffers, receivedInquiries, issuedInquiries, services,
repairs, articles, warehouseStocks, receivedSlips, issuedSlips, saleSlips,
transferNotes, productionNotes, receivedDeliveryNotes, issuedDeliveryNotes,
stockTakingDocuments, stockTakings, stockTakingTypes

importStatus(importGuid: UUID!): IImportData    # poll async mutations
```

### `type Subscription`

```
importPromiseResultAdded: ImportPromiseResult   # push updates for async imports
```

---

## 3. Filter / sort / pagination

HotChocolate-style. Comparison operators on any field:

```graphql
where: {
  documentNumber: { eq: "20250001" }
  dateOfIssue:    { gte: "2025-01-01" }
  isDeleted:      { eq: false }
  and: [{ ... }, { ... }]
  or:  [{ ... }, { ... }]
}
order: [{ dateOfIssue: DESC }, { documentNumber: ASC }]
skip: 0
take: 50
```

Typical operators: `eq`, `neq`, `in`, `nin`, `contains`, `ncontains`, `startsWith`, `endsWith`, `gt`, `gte`, `lt`, `lte`. Boolean fields support `eq`. Nested object filters allow drilling into sub-fields (e.g. `businessAddress: { municipalityPostalCode: { postalCode: { eq: "..." } } }`).

---

## 4. Key input types (find the full definition in the schema)

| Input | Schema line | Notes |
|-------|-------------|-------|
| `IssuedInvoiceInput` | 2695 | Sales invoice (header + items + addresses) |
| `ReceivedOrderInput` | 3509 | Customer order |
| `ArticleInput` | 3952 | Catalog card |
| `WarehouseStockInput` | 4361 | Per-warehouse stock |
| `CompanyInput` | 1943 | Address book partner |
| `BankStatementInput` | 1421 | Bank statement |
| `CashVoucherInput` | 1527 | Cash voucher |

Common sub-structures (used in many inputs):

- `PartnerAddressInput` — `{ guid?, email, phoneNumber, identificationNumber (IČ), vatIdentificationNumber (DIČ), vatIdentificationNumberSk, billingAddress, businessAddress, deliveryAddress, company? }`
- `AddressInput` — `{ name, street, municipality, municipalityPostalCode: { postalCode }, country: { code } }`
- `StockItemInput` — `{ article: { guid, catalogue }, warehouse: { guid, code } }`
- Line item (invoice/order): `{ amount, catalogue, description, vatRate, unitPrice, unitPriceHc, priceType, stockItem? | article? | warehouse? }`

Common ref wrappers (when you only want to point at an existing entity):
`CountryRefInput { code }`, `CurrencyRefInput { code }`, `CentreRefInput { shortCut }`, `AccountAssignmentRefInput { shortCut }`, `VatClassificationRefInput { shortCut }`, `BankAccountCashBoxRefInput { shortCut }`, `DefinitionXMLTransferRefInput { shortCut }`.

---

## 5. Example GraphQL requests

### List issued invoices by variable symbol
```graphql
query {
  issuedInvoices(where: { variableSymbol: { eq: "2025000123" } }) {
    totalCount
    items { id documentNumber isDeleted dateOfIssue }
  }
}
```

### Create a received order
```graphql
mutation {
  createReceivedOrder(
    definitionXMLTransfer: { shortCut: "_O+P+N_1" }
    receivedOrder: {
      dateOfIssue: "2025-04-19"
      documentNumber: "20250042"
      variableSymbol: "20250042"
      description: "Objednávka"
      partnerAddress: {
        email: "a@b.cz"
        billingAddress: {
          name: "ACME s.r.o."
          street: "Dlouhá 1"
          municipality: "Praha"
          municipalityPostalCode: { postalCode: "11000" }
          country: { code: "CZ" }
        }
      }
      items: [
        {
          amount: 2
          catalogue: "ABC-001"
          description: "Produkt"
          vatRate: 2100
          unitPrice: 100
          priceType: WITHOUT_VAT
        }
      ]
    }
  ) {
    guid
    isSuccess
  }
}
```

### Delete a received order (note: just `{ id }`, no definition)
```graphql
mutation {
  deleteReceivedOrder(receivedOrder: { id: 123 }) { isSuccess }
}
```

---

## 6. PHP client cheat-sheet (`lib/moneys3_api/`)

### `MoneyS3\query($gql)`

Raw GraphQL. Returns decoded associative array or `false`. Auto-fetches token, auto-retries up to 5× on HTTP errors (5s backoff), sleeps 300ms after success.

### `MoneyS3\request($id, array $data, $mutation, $definition, $objectName)`

1. Check `sync_api_reqs.id = $id` in SQLite — skip if already processed (unless `moneys3_ignore_history=1`).
2. Convert `$data` → GraphQL body with `buildRequest()`.
3. Wrap in:
   ```graphql
   mutation {
     <mutation>(
       definitionXMLTransfer: { shortCut: "<definition>" }
       <objectName>: { <body> }
     ) { guid isSuccess }
   }
   ```
4. Dump request to `temp_dir/req_<id>.txt`.
5. Send via `query()`, record in `sync_api_reqs`.

### `MoneyS3\request2($id, $gqlString, $mutation)`

Same dedup, but you pass a fully-formed GraphQL string (needed for deletes and anything exotic).

### `MoneyS3\buildRequest($data, $level=0)`

- Sequential (list-indexed) arrays → `[ ... , ... ]`
- Associative arrays / objects → `{ key: value, key: value }`
- Scalars → int literal / bool literal / `"quoted string"`
- **Strings starting with `@`** → emit `substr($v,1)` verbatim (no quotes). Use this for enums, numeric literals that should stay unquoted, or pre-built GraphQL fragments.

Example:

```php
$data = [
  'dateOfIssue' => '2025-04-19',
  'priceType'   => '@WITHOUT_VAT',        // enum, unquoted
  'items'       => [
    ['amount' => 1, 'catalogue' => 'X-1'],
    ['amount' => 2, 'catalogue' => 'X-2'],
  ],
];
// → dateOfIssue: "2025-04-19" priceType: WITHOUT_VAT items: [{ amount: 1, catalogue: "X-1" }, { amount: 2, catalogue: "X-2" }]
```

---

## 7. Extension pattern (shopsync convention)

Keep the base `MoneyS3\Orders` / `MoneyS3\Invoices` generic. Project-specific behaviour goes into a subclass under `scripts*/` that overrides `modifyOrder($d)` / `modifyInvoice($d)` — these are no-op hooks called right before `request()` is invoked, so you can mutate `$this->request` freely (add custom fields, rewrite amounts, plug in a custom `definitionXMLTransfer`, etc.).

Example:

```php
namespace MyProject;

class Orders extends \MoneyS3\Orders {
    public function modifyOrder($d) {
        $this->request['note'] = ($this->request['note'] ?? '') . "\nZdroj: eshop";
    }
}
```
