# ABRA Gen API Reference

## Authentication & Connection

- **Protocol:** HTTPS REST API, JSON payloads
- **Auth:** HTTP Basic Auth (`username:password`)
- **Alternative:** API Key as Bearer token in `Authorization` header
- **URL:** `{host}/{database}/{agenda}` (e.g. `https://api.example.com/UDataX/storecards`)
- **Config constants:** `set_pohoda_db` (host), `set_dbfile` (database), `sw_user`, `sw_pass`
- **Content-Type:** `application/json` (send and receive)
- **JSON encoding:** `JSON_UNESCAPED_UNICODE`

## Standard CRUD Pattern (all agendas)

```
GET    /{agenda}                    List records (paginated)
GET    /{agenda}/{id}               Get single record
POST   /{agenda}                    Create record
PUT    /{agenda}/{id}               Update record
DELETE /{agenda}/{id}               Delete record
POST   /{agenda}/query              Complex query (POST body)
GET    /{agenda}/{id}/editlock      Lock for editing
GET    /{agenda}/{id}/externalids   External system mappings
GET    /{agenda}/{id}/relations     Related entities
```

## Query Parameters

| Parameter | Description | Example |
|-----------|-------------|---------|
| `select` | Fields to return | `select=id,code,name` |
| `where` | Filter condition | `where=hidden+eq+false` |
| `orderby` | Sort field | `orderby=code` |
| `skip` | Offset (pagination) | `skip=100` |
| `take` | Limit (pagination) | `take=50` |
| `expand` | Include related objects | `expand=Producer_ID(Name)` |
| `fulltext` | Full-text search | `fulltext=searchterm` |
| `groupby` | Group results | `groupby=field` |

## Query Condition Syntax

Operators are URL-encoded with `+` delimiters:
- `=` → `+eq+` (equals)
- `!=` → `+ne+` (not equals)
- `<` → `+lt+` (less than)
- `>` → `+gt+` (greater than)
- Logic: `and`, `or`
- Date literal: `timestamp'YYYY-MM-DD HH:MM:SS'`
- NULL check: field is `null` / field is not `null`

**Examples:**
```
hidden+eq+false and country_id+eq+'00000CZ000'
tariff+eq+21 and country_id+eq+'00000CZ000' and hidden+eq+false
docdate$date+gt+timestamp'2024-01-01 00:00:00'
```

## HTTP Response Codes

| Code | Meaning |
|------|---------|
| 200 | OK |
| 201 | Created |
| 202 | Accepted |
| 204 | No Content (success, no body) |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |

## API Return Structure (PHP)

`API::read()` and `API::send()` return:
```php
array(
    "error" => bool,
    "errorText" => string,
    "content" => string (JSON body),
    "returnHttpStatus" => int,
    "success" => bool,
)
```

---

# Business Object Reference

## Custom User-Defined Attributes ("x_" attributes)

Most business objects support custom fields prefixed with `x_`. These are defined in ABRA Gen administration per object. They behave like regular fields in the API - usable in `select`, `where`, `expand`, and in POST/PUT data.

Common examples: `x_eshop` (bool - product visible in e-shop), `x_barcode`, `x_custom_note`, etc.

Objects supporting user fields are marked with `User fields: A` in the BO HTML docs.

---

## StoreCard (Skladov karta - Product)

**Agenda:** `storecards`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| Code | dtString | 40 | Product code (SKU) |
| Name | dtString | 100 | Product name |
| EAN | dtString | 30 | EAN barcode |
| Category | dtInteger | 1 | Card class |
| Hidden | dtBoolean | 1 | Suspended/hidden |
| Country_ID | dtString | 10 | Country ref |
| VATRate_ID | dtString | 10 | VAT rate ref |
| Producer_ID | dtString | 10 | Manufacturer (Firm ref) |
| MainSupplier_ID | dtString | 10 | Main supplier ref |
| Picture_ID | dtString | 10 | Main picture ref |
| StoreCardCategory_ID | dtString | 10 | Category ref |
| DealerDiscount_ID | dtString | 10 | Dealer discount ref |
| Components | Collection | - | Macro card components (owned) |
| Pictures | Collection | - | Images (owned) |
| StoreUnits | Collection | - | Units with Weight, Width, Height, Depth, Code, UnitRate (owned) |

**Expand examples:** `StoreUnits(Weight,Width,Height,Depth,Code,UnitRate),Producer_ID(Name)`

**PHP load pattern:**
```php
$result = AbraGen\API::read("storecards", "id,code,name,ean,x_eshop", "x_eshop+eq+true", "StoreUnits(Weight,Code,UnitRate),Producer_ID(Name)");
```

---

## StoreSubCard (Dlc skladov karta - Stock per Store)

**Agenda:** `storesubcards`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| StoreCard_ID | dtString | 10 | Parent store card ref |
| Store_ID | dtString | 10 | Warehouse ref |
| Quantity | dtFloat | 15/6 | Current quantity (evidence units) |
| AvailableQuantity | dtFloat | 15/6 | Available quantity (read-only) |
| AcceptedQuantity | dtFloat | 15/6 | Quantity in receiving |
| BookedQuantity | dtFloat | 15/6 | Quantity in dispatch |
| ReceivedOrderedQuantity | dtFloat | 15/6 | Qty on received orders (confirmed) |
| ReceivedOrderedUnitQuantity | dtFloat | 15/6 | Qty on received orders (user units) |
| IssuedOrderedQuantity | dtFloat | 15/6 | Qty on issued orders |
| PurchasePrice | dtFloat | 15/6 | Purchase price |
| PurchaseFirm_ID | dtString | 10 | Last purchase supplier |
| PurchaseDate$DATE | dtDateTime | 10 | Last purchase date |
| PurchaseCurrency_ID | dtString | 10 | Purchase currency |
| LowLimitQuantity | dtFloat | 15/6 | Reorder point (low limit) |
| HighLimitQuantity | dtFloat | 15/6 | Maximum stock (high limit) |
| Location_ID | dtString | 10 | Warehouse position |

**Stock calculation pattern (from Products class):**
```php
// Available = Quantity - ReceivedOrderedUnitQuantity - Reservations
$available = $subcard["Quantity"] - $subcard["ReceivedOrderedUnitQuantity"];
// Then deduct active reservations from "reservations" agenda
```

---

## ReceivedOrder (Objednvka pijat - Customer Order)

**Agenda:** `receivedorders`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| DocQueue_ID | dtString | 10 | Document queue ref |
| DocDate$DATE | dtDateTime | 10 | Document date |
| ExternalNumber | dtString | 30 | External order number |
| Description | dtString | 240 | Description/note |
| Firm_ID | dtString | 10 | Customer (Firm ref) |
| FirmOffice_ID | dtString | 10 | Delivery branch ref |
| Address_ID | dtString | 10 | Address (owned) |
| Country_ID | dtString | 10 | Delivery country ref |
| VATCountry_ID | dtString | 10 | VAT country ref |
| Currency_ID | dtString | 10 | Currency ref |
| PaymentType_ID | dtString | 10 | Payment method ref |
| TransportationType_ID | dtString | 10 | Shipping method ref |
| BankAccount_ID | dtString | 10 | Bank account ref |
| ConstSymbol_ID | dtString | 10 | Constant symbol ref |
| ResponsibleUser_ID | dtString | 10 | Responsible user ref |
| StoreDocQueue_ID | dtString | 10 | Store document queue |
| PricesWithVAT | dtBoolean | 1 | Prices include VAT |
| IsRowDiscount | dtBoolean | 1 | Row discounts enabled |
| TotalRounding | dtInteger | - | Rounding mode (-33554175 = disabled) |
| TradeType | dtInteger | 1 | Trade type (1=domestic, 7=EU+VAT) |
| Rows | Collection | - | Order line items (owned) |

### ReceivedOrderRow (dek objednvky - Order Line)

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| RowType | dtInteger | 1 | Row type: 2=text, 3=store card |
| Text | dtString | 160 | Line item description |
| StoreCard_ID | dtString | 10 | Product ref (if RowType=3) |
| Store_ID | dtString | 10 | Warehouse ref (if RowType=3) |
| Quantity | dtFloat | 15/6 | Quantity (evidence units) |
| UnitQuantity | dtFloat | 15/3 | Quantity (user units) |
| QUnit | dtString | 5 | Unit code (e.g. "ks") |
| UnitPrice | dtFloat | 15/5 | Unit price |
| TotalPrice | dtFloat | 15/5 | Total price |
| TAmount | dtFloat | 13/2 | Total amount |
| TAmountWithoutVAT | dtFloat | 13/2 | Total without VAT |
| VATRate_ID | dtString | 10 | VAT rate ref |
| VATRate | dtFloat | 10/2 | VAT percentage (read-only) |
| Division_ID | dtString | 10 | Cost center ref |
| IncomeType_ID | dtString | 10 | Income type ref |
| BusTransaction_ID | dtString | 10 | Business transaction ref |
| BusOrder_ID | dtString | 10 | Business order ref |
| RowDiscount | dtFloat | 10/2 | Row discount % |
| DeliveryDate$DATE | dtDateTime | 10 | Delivery date |
| ExternalNumber | dtString | 30 | External line number |

**PHP order creation pattern:**
```php
$rows = array();
foreach ($items as $item) {
    $row = array(
        "rowtype" => 2,  // 2=text, 3=storecard
        "text" => $item["name"],
        "unitprice" => $item["price"],
        "quantity" => $item["qty"],
        "qunit" => "ks",
        "vatrate_id" => $vatRateId,
        "division_id" => $divisionId,
    );
    // If product matched to store card:
    if ($storecardId) {
        $row["rowtype"] = 3;
        $row["storecard_id"] = $storecardId;
        $row["store_id"] = $storeId;
    }
    $rows[] = $row;
}

$order = array(
    "docqueue_id" => $queueId,
    "externalnumber" => $orderNumber,
    "docdate\$date" => date("Y-m-d"),
    "firm_id" => $firmId,
    "firmoffice_id" => $firmOfficeId,
    "paymenttype_id" => $paymentId,
    "PricesWithVAT" => 1,
    "country_id" => $countryId,
    "IsRowDiscount" => 1,
    "totalrounding" => -33554175,
    "rows" => $rows,
);

$result = AbraGen\API::send("receivedorders", $order);
```

---

## IssuedInvoice (Faktura vydan - Issued Invoice)

**Agenda:** `issuedinvoices`

Same structure as ReceivedOrder with these differences:
- Lookup by `varsymbol` instead of `externalnumber`
- Additional fields: `AccDate$DATE`, `DueDate$DATE`, `Period_ID`, `AccDocQueue_ID`, `AccPresetDef_ID`
- Amount fields: `Amount`, `AmountWithoutVAT`, `VATAmount`, `PaidAmount`, `CreditAmount`, `LocalAmount`
- No `BusTransaction_ID` / `BusOrder_ID` on invoice rows

### IssuedInvoiceRow

Same as ReceivedOrderRow plus:
- `VATIndex_ID` (dtString 10) - VAT index ref
- `VATDeposit_ID` (dtString 10) - Deposit invoice ref
- `RCreditAmount` (dtFloat 13/2) - Credited amount
- `ESLDate$DATE` (dtDateTime) - ESL reporting date

---

## Firm (Firma - Company/Customer)

**Agenda:** `firms`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| Code | dtString | 20 | Company code |
| Name | dtString | 220 | Company name |
| OrgIdentNumber | dtString | 15 | Business ID (ICO) |
| TAXIdentNumber | dtString | 20 | Tax ID (ICD) |
| VATIdentNumber | dtString | 20 | VAT ID (DIC) |
| VATPayor | dtBoolean | 1 | Is VAT payer |
| LegalPerson | dtBoolean | 1 | Is legal entity |
| Country_ID | dtString | 10 | Country ref |
| Currency_ID | dtString | 10 | Default currency ref |
| BankAccount_ID | dtString | 10 | Bank account ref |
| PaymentType_ID | dtString | 10 | Default payment ref |
| TransportationType_ID | dtString | 10 | Default shipping ref |
| Store_ID | dtString | 10 | Default warehouse ref |
| PriceList_ID | dtString | 10 | Price list ref |
| Price_ID | dtString | 10 | Price definition ref |
| DealerCategory_ID | dtString | 10 | Dealer class ref |
| ResidenceAddress_ID | dtString | 10 | Billing address (owned) |
| ElectronicAddress_ID | dtString | 10 | Electronic address (owned) |
| Picture_ID | dtString | 10 | Picture (owned) |
| FirmOffices | Collection | - | Branches/offices (owned) |
| FirmPersons | Collection | - | Contact persons (owned) |
| Rows | Collection | - | Bank accounts (owned) |

**PHP firm search/create pattern:**
```php
// Search by business ID (ICO)
$result = AbraGen\API::read("firms", "id,name", "orgidentnumber+eq+'" . $ico . "'");

// Search by email + address
$result = AbraGen\API::read("firms", "id", "ElectronicAddress_ID.email+eq+'" . $email . "' and ResidenceAddress_ID.street+eq+'" . $street . "'");

// Create new firm
$firm = array(
    "name" => maxLen($company, 100),
    "orgidentnumber" => $ico,
    "vatidentnumber" => $dic,
    "ResidenceAddress_ID" => array(
        "street" => maxLen($street, 60),
        "city" => maxLen($city, 60),
        "postcode" => maxLen($postcode, 10),
        "country" => maxLen($countryName, 40),
        "countrycode" => $countryCode,
        "phonenumber1" => $phone,
        "email" => $email,
        "recipient" => maxLen($name, 30),
    ),
);
$result = AbraGen\API::send("firms", $firm);
```

---

## FirmOffice (Provozovna - Delivery Branch)

**Agenda:** `firmoffices`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| Parent_ID | dtString | 10 | Owner Firm ref |
| Name | dtString | 100 | Office name |
| OfficeIdentNumber | dtString | 15 | Office ID (ICP) |
| Hidden | dtBoolean | 1 | Suspended |
| Address_ID | dtString | 10 | Physical address (owned) |
| ElectronicAddress_ID | dtString | 10 | Electronic address (owned) |
| DealerCategory_ID | dtString | 10 | Dealer class ref |
| Store_ID | dtString | 10 | Default warehouse ref |

**Delivery address as FirmOffice pattern:**
```php
// Read existing offices for a firm
$offices = AbraGen\API::read("firms/" . $firmId . "/firmoffices", "id,Address_ID(Street,City,PostCode)");

// Create office via firm expand
$firmUpdate = array(
    "firmoffices" => array(
        array(
            "Address_ID" => array(
                "street" => $street,
                "city" => $city,
                "postcode" => $postcode,
                "countrycode" => $countryCode,
                "recipient" => $name,
                "phonenumber1" => $phone,
            ),
        ),
    ),
);
AbraGen\API::send("firms/" . $firmId . "?expand=firmoffices", $firmUpdate, false, "PUT");
```

---

## Address (Adresa)

Embedded object (owned by Firm, FirmOffice, etc.), not a standalone agenda.

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| Street | dtString | 60 | Street |
| City | dtString | 60 | City |
| PostCode | dtString | 10 | Postal code |
| Country | dtString | 40 | Country name |
| CountryCode | dtString | 3 | ISO country code |
| Recipient | dtString | 30 | Recipient name |
| Location | dtString | 60 | Department/location |
| EMail | dtString | 320 | Email address |
| PhoneNumber1 | dtString | 30 | Phone 1 |
| PhoneNumber2 | dtString | 30 | Phone 2 |
| FaxNumber | dtString | 30 | Fax |
| GLN | dtString | 30 | Global Location Number |
| GPS | dtString | 40 | GPS coordinates |
| Databox | dtString | 20 | Data box ID |
| ZIP | dtString | 20 | ZIP code |

---

## VATRate (DPH sazba - VAT Rate)

**Agenda:** `vatrates`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| Name | dtString | 20 | Name |
| Description | dtString | 50 | Description |
| Tariff | dtFloat | 10/2 | VAT percentage |
| VATRateType | dtInteger | 1 | Rate type |
| Country_ID | dtString | 10 | Country ref |
| Hidden | dtBoolean | 1 | Suspended |
| Account_ID | dtString | 10 | Accounting ref |
| OSSGoodVATIndex_ID | dtString | 10 | OSS goods VAT index |
| OSSServiceVATIndex_ID | dtString | 10 | OSS service VAT index |
| Rows | Collection | - | VAT rate rows (owned) |

**VAT rate lookup pattern:**
```php
$result = AbraGen\API::read("vatrates", "id,tariff",
    "tariff+eq+" . $rate . " and country_id+eq+'" . $countryId . "' and hidden+eq+false");
```

---

## DocQueue (ada doklad - Document Queue)

**Agenda:** `docqueues`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| Code | dtString | 10 | Queue code |
| Name | dtString | 60 | Queue name |
| DocumentType | dtString | 2 | Document type |
| Account_ID | dtString | 10 | Account ref |
| FirstOpenPeriod_ID | dtString | 10 | First open period |
| LastOpenPeriod_ID | dtString | 10 | Last open period |

---

## Country (Zem)

**Agenda:** `countries`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| Code | dtString | 3 | ISO code (CZ, SK, DE...) |
| AlternateCode | dtString | 3 | Alt code |
| NumCode | dtString | 3 | Numeric code |
| Name | dtString | 50 | Country name |
| Currency_ID | dtString | 10 | Default currency ref |
| Hidden | dtBoolean | 1 | Suspended |

---

## PaymentType (Zpsob hrady)

**Agenda:** `paymenttypes`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| Code | dtString | 2 | Code |
| Name | dtString | 30 | Name |
| PaymentKind | dtInteger | 4 | Kind |
| Hidden | dtBoolean | 1 | Suspended |

---

## TransportationType (Zpsob dopravy)

**Agenda:** `transportationtypes`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| Code | dtString | 10 | Code |
| Name | dtString | 30 | Name |
| Hidden | dtBoolean | 1 | Suspended |

---

## Store (Sklad - Warehouse)

**Agenda:** `stores`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| Code | dtString | 5 | Warehouse code |
| Name | dtString | 30 | Warehouse name |
| FIFO | dtBoolean | 1 | FIFO or average pricing |
| IsLogistic | dtBoolean | 1 | Has positions |
| OutOfStockDelivery | dtInteger | 1 | Allow negative stock |
| Address_ID | dtString | 10 | Address (owned) |
| PriceList_ID | dtString | 10 | Price list ref |
| RefundStore_ID | dtString | 10 | Return warehouse ref |

---

## StoreMenuItem (Skladov menu - Product Category)

**Agenda:** `storemenuitems`

| Field | Type | Length | Description |
|-------|------|--------|-------------|
| ID | dtString | 10 | Internal ID |
| Text | dtString | 150 | Category name |
| Parent_ID | dtString | 10 | Parent category ref |
| FULLPATH | dtString | 608 | Full category path |
| Hidden | dtBoolean | 1 | Suspended |
| PosIndex | dtInteger | 6 | Sort order |

Product-to-category mapping via `storemenuitemlinks` agenda (StoreCard_ID + StoreMenuItem_ID).

---

## StorePrice / StorePriceRow (Cenkov - Pricing)

**Agenda:** `storeprices`

Price list entries. Each StorePrice has PriceRows collection.

**Price loading pattern:**
```php
// Load prices for a price list
$result = AbraGen\API::read("storeprices",
    "id,StoreCard_ID,PriceRows",
    "pricelist_id+eq+'" . $priceListId . "'",
    "PriceRows");

// In PriceRows, match by Price_ID and QUnit
foreach ($priceRows as $row) {
    if ($row["Price_ID"] == $mainPriceId && $row["QUnit"] == "ks") {
        $price = $row["UnitPrice"];  // price without VAT
    }
}
```

---

# Product Sync Flow (Products class)

1. `init()` - preload prices, stock, categories
2. `loadAllPrices()` - query `storeprices` with price list ID, cache by StoreCard_ID
3. `loadAllStoreSubCards()` - query `storesubcards` paginated (1000/page), calculate available qty, deduct `reservations`
4. `load()` - query `storecards` paginated (100/page) with expand, match to cached prices/stock
5. Output product array with: id, code, name, EAN, weight, producer, count, price (with VAT), price_novat, vat%, categories

# Order Export Flow (Orders class)

1. Check if order already exists: `receivedorders` by `externalnumber` + `docqueue_id`
2. Search/create Firm: `firms` by `orgidentnumber` or email+address
3. Optionally create FirmOffice for delivery address
4. Resolve country ID: `countries` by ISO code
5. Resolve VAT rate IDs: `vatrates` by tariff + country
6. Match products to store cards: `storesubcards` by code
7. Build order with rows array
8. POST to `receivedorders`

# Invoice Export Flow (Invoices class)

Same as Order Export but:
- Endpoint: `issuedinvoices` instead of `receivedorders`
- Lookup field: `varsymbol` instead of `externalnumber`
- Additional date fields: `accdate$date`, `duedate$date`
