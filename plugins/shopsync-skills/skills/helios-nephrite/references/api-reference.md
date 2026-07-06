# Helios Nephrite API - Detailed Reference

## Authentication

Login via POST, then use returned credentials as Basic Auth for all requests.

```php
$loginResult = HeliosNephrite\api_login();
// Returns array with userName, userId on success, false on failure
// Credentials stored in $GLOBALS["helios_user"] / $GLOBALS["helios_pass"]
```

Config keys (section 8 in profile JSON):
- `helios_api_url` - Base URL for API endpoints
- `helios_server_url` - Server URL sent in login request
- `helios_db` - Database profile name
- `helios_user` / `helios_pass` - Credentials

## HTTP Functions (HeliosNephrite namespace)

| Function | Signature | Returns |
|----------|-----------|---------|
| `api_get` | `($route, $params = [])` | `string\|false` (JSON) |
| `api_post` | `($route, $params = [], $data = [])` | `string\|false` (JSON) |
| `api_put` | `($route, $params = [], $data = [])` | `string\|false` (JSON) |
| `api_patch` | `($route, $params = [], $data = [])` | `string\|false` (JSON) |
| `api_delete` | `($route, $params = [])` | `string\|false` (JSON) |
| `api_getAll` | `($route, $params = [], $pageSize = 100, $dataKey = null)` | `array` (all pages merged) |
| `api_login` | `($user, $pass, $apiUrl, $serverUrl, $dbProfile)` | `array\|false` |
| `api_logout` | `()` | `bool` |
| `api_getUserInfo` | `()` | `array\|false` |

All functions auto-login if not yet authenticated.

## API Endpoints

### Orders
- `GET api/v1/eshop/orders` - List orders (response key: `orders`)
- `GET api/v1/eshop/orders/{id}` - Get order by ID
- `POST api/v1/eshop/orders` - Create order

### Customers
- `GET api/v1/eshop/customers` - List/search customers (response key: `customers`)
- `POST api/v1/eshop/customers` - Create customer

### Products
- `GET api/v1/eshop/products` - List/search products (response key: `products`)

### Connection
- `POST /api/Connect/LogIn` - Login
- `POST /api/Connect/LogOut` - Logout
- `GET /api/Connect/UserInfo` - Current user info

## Query Parameters

| Parameter | Description | Example |
|-----------|-------------|---------|
| `Top` | Page size | `Top=100` |
| `Skip` | Offset | `Skip=200` |
| `Filter` | OData-style filter | `Filter=name eq '2024000123'` |
| `Timestamp` | Unix timestamp - records modified since | `Timestamp=1712700000` |

**Filter examples:**
```
name eq '2024000123'          // order by name (= shoptet order code)
cin eq '12345678'              // customer by company ID (IC)
tin eq 'CZ12345678'            // customer by tax ID (DIC)
generalEmail eq 'foo@bar.com'  // customer by email
referenceId eq 'SKU001'        // product by code
```

## Rate Limiting

Built into `api_get()` with configurable globals:
- `$GLOBALS["helios_api_delay"]` = 1000ms between requests
- `$GLOBALS["helios_api_retry_count"]` = 3 retries on HTTP 429
- `$GLOBALS["helios_api_retry_delay"]` = 5000ms initial backoff (exponential)

## Data Structures

### Order (from API)
```
id                  - Helios internal ID
name                - External reference (= Shoptet order code)
referenceId         - Helios reference ID
totalPrice          - Order total
customAttributes    - Array of {symbolicName, value} pairs
items               - Order line items
customer            - Customer reference
```

### Order Custom Attributes
```php
foreach ($order["customAttributes"] as $attr) {
    if ($attr["symbolicName"] === "stav_eshop") {
        $value = $attr["value"]; // e.g. "A", "O", "V", "F", "S", "D"
    }
    if ($attr["symbolicName"] === "cislo_baliku") {
        $tracking = $attr["value"];
    }
}
```

### Customer
```
id, name, cin (IC), tin (DIC)
generalEmail, generalPhone
legalFormCode: "legalEntity" | "privatePerson"
addresses[]: {typeCode, name, street, houseNumber, streetNumber, city, postalCode, countryCode}
contacts[]: {firstName, lastName, eMailAddress, telephone}
```

### Order POST Body (create)
```php
$ord = [
    "name" => "2024000123",
    "customer" => ["customerId" => 123, "addresses" => [...]],
    "items" => [
        ["productReferenceId" => "SKU001", "productId" => 456,
         "typeCode" => "product", "quantity" => 2, "measureUnit" => "ks",
         "totalPrice" => 199.90, "warehouseId" => 22057]
    ],
    "totalPrice" => 199.90,
    "noteText" => "customer note",
    "paymentType" => "paymentOrder",
    "transportMethodId" => 5,
    "warehouseId" => 22057,
    "plannedDate" => "2024-01-15T00:00:00",
];
```

Valid `paymentType` values: `paymentOrder`, `postalOrder`, `cash`, `compensation`, `collection`, `cashOnDelivery`, `billOfExchange`, `plan`, `paymentCard`, `paymentAdvance`, `letterOfCredit`, `sipoPayment`, `voucher`, `deliveryNote`, `other`, `personalAccount`, `factoring`

## HeliosNephrite\Orders Class

**Methods:**
- `saveOrder($d)` - Save order (checks duplicates by name, creates customer if needed)
- `loadOrders($last, $params)` - Load orders with optional Timestamp filter
- `getOrder($orderId)` - Get single order by ID
- `findOrderByNumber($number)` - Find by name field (Filter)
- `findProductByCode($code)` - Find product by referenceId (cached)
- `findCustomerByField($field, $value)` - Find customer by cin/tin
- `findCustomerByEmail($email)` - Find customer by email
- `createCustomer($d)` - Create new customer
- `buildCustomer($d)` - Build customer object (find or create)
- `modifyOrderInsert($ord, $d)` - Hook for pre-insert modifications (override in subclass)
- `static splitStreet($street)` - Parse "Street 123/A" into components

**Properties:** `$update_customers`, `$warehouse_id`, `$warehouse_reference_id`, `$default_payment_type`, `$doc_queue_id`, `$page_size`, `$product_cache`

## Script Patterns

### Extending classes
```php
class HeliosOrders extends HeliosNephrite\Orders {
    public function modifyOrderInsert($ord, $d) {
        // Add custom fields, modify addresses, etc.
        return $ord;
    }
}
$heliosOrders = new HeliosOrders();
$heliosOrders->warehouse_id = 22057;
```

### Incremental sync
```php
$last = getLastUpd("task_name", "file");
// ... process data since $last ...
setLastUpd("task_name", "file");
```

### Paginated fetch
```php
$orders = HeliosNephrite\api_getAll("api/v1/eshop/orders", $params, 100, 'orders');
```
