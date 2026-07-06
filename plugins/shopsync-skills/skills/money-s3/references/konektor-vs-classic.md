# Money S3 — classic mode vs E-shop konektor

Money S3 supports two mutually-exclusive ways of talking to external systems. **Ask the user (or read the project's `settings.json`) which mode the target Money instance is running before you touch any template.** The wrong mode silently succeeds — it writes XML, the import passes — but pairing breaks, so stock doesn't sync and duplicates pile up.

## Mode A — classic (no konektor module)

Money's built-in XML transfer. No extra license needed. Pairing has to ride on an external field because Money doesn't expect us to know its internal GUIDs.

- **Stock export profile:** `E_ZAS` → `ExpZkratka="_ZAS"`
- **Stock import profile:** `I_ZAS` → `ExpZkratka="_ZAS"`
- **Pairing fields (configured in the Money profile's `Key`):**
  - Stock cards: `UzivCode` (user code) is the most common — corresponds to the shop's product code. Alternatives: `Katalog`, `Zkrat`, `BarCode` (EAN).
  - Documents: `Doklad` (Money's own document number) or `CObjednavk` (customer-order number we send in).
  - Partners: `KodPartn` (10-char code, we hash it from `ic+email`) or `ICO`.
- **`<eshop>` / `<eSkup>` / `<eKategorie>` blocks:** absent from `Zasoba`. Categories and parameters are not exported alongside stock — they live in different agendas.
- **Internally in our database:** we still store Money's GUID (`sync_storecards.guid`) so our own orders can reference it, but we don't rely on Money to pair on GUID — Money pairs on whatever `Key` the profile has.
- **Library default:** `lib/moneys3/products.php::$pair_field = "UzivCode"`. A project that uses `Katalog` must subclass in `scripts/products.php` and set `$this->pair_field = "Katalog"` before `load()`.

### What classic-mode stock XML looks like

Reference file: `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys3\zasoby_money.xml`.

```xml
<MoneyData ExpZkratka="_ZAS" ...>
  <SeznamZasoba>
    <Zasoba>
      <KmKarta>
        <Popis>...</Popis>
        <UzivCode>020001</UzivCode>   <!-- the pair key -->
        <Katalog>...</Katalog>
        <BarCode>...</BarCode>
        <GUID>{7A72...}</GUID>
      </KmKarta>
      <Sklad><Nazev>HL</Nazev><KodSkladu>HL</KodSkladu></Sklad>
      <PC>...</PC>
      <!-- no <eshop> block -->
    </Zasoba>
  </SeznamZasoba>
</MoneyData>
```

### What the orders/invoices templates do under classic mode

They match each line against `sync_storecards.code` (which holds `UzivCode` / `Katalog` values, populated by the product sync). When a match is found, they fill `<KmKarta><GUID>...</GUID></KmKarta>` on the line so Money can bind the line to a store card internally. If no match is found they fall back to `<NesklPolozka>` — a non-stock line item.

## Mode B — E-shop konektor (the optional module)

Money S3's **E-shop konektor** is a paid add-on that turns Money into a shop-aware back-end. It exports a richer, single-file XML containing stock, categories and parameters, and it expects us to exchange GUIDs as the primary key.

- **Stock export profile:** `E_eShopEZas` (or similar — each Money install may name it differently) → `ExpZkratka="_eShopEZas"`
- **Stock import profile:** typically `I_eShopEZas` → `ExpZkratka="_eShopEZas"`
- **Pairing field (in the Money profile's `Key`):** `GUID`, always. We must send back the **same** GUID Money originally emitted, wrapped in `{...}`.
- **`<eshop>` block in each `Zasoba`:** present, carrying `IN_Export` (the konektor's export flag), `IN_Changed`, `CisKarty`, `CisSkladu`, and an `<eSkup>` sub-tree that places the card into the konektor's category hierarchy.
- **Categories and parameters:** exported alongside stock in the same file — `SeznamKategorii/eKategorie` and `SeznamParametru`.
- **Document pairing:** orders and invoices are still paired by `Doklad` — the konektor only changes stock/category/parameter pairing, not documents. (Confirm against the vendor PDF for the specific konektor version the customer uses.)

### What konektor-mode stock XML looks like

Reference file: `C:\Users\Vojtech Sokol\Documents\share\podklady\moneys3\Zasoby - vystup z eshop konektoru.xml`.

```xml
<MoneyData ICAgendy="48187810" ExpZkratka="_eShopEZas" ...>
  <SeznamParametru/>
  <SeznamKategorii>
    <eKategorie>
      <ID>12</ID>
      <Name>WWW</Name>
      <eShopInfo>
        <eShopID>6</eShopID>
        <eShopName>E-shop konektor</eShopName>
      </eShopInfo>
      <SeznamPodrKategorii/>
    </eKategorie>
  </SeznamKategorii>
  <SeznamZasoba>
    <Zasoba>
      <konfigurace>...</konfigurace>
      <StavZasoby>...</StavZasoby>
      <eshop>
        <IN_Export>6</IN_Export>
        <IN_Changed>0</IN_Changed>
        <CisKarty>99</CisKarty>
        <CisSkladu>1</CisSkladu>
        <eSkup>
          <ID>12</ID>
          <Name>WWW</Name>
          <Public>1</Public>
          <Parent>...</Parent>
        </eSkup>
      </eshop>
      <KmKarta>
        <UzivCode>020001</UzivCode>
        <GUID>{7A723278-3159-4214-8A69-5C9B0E57125A}</GUID>   <!-- the pair key -->
      </KmKarta>
      <Sklad>
        <GUID>{8736BDFB-02F1-4408-927C-0BA5ADA0DCEA}</GUID>
      </Sklad>
    </Zasoba>
  </SeznamZasoba>
</MoneyData>
```

Note the Zasoba still carries `UzivCode`, `Katalog`, `BarCode` — they're still present, they just aren't the pair key any more. The konektor's pair contract is GUID.

### What to do in order/invoice templates when in konektor mode

- **Do** include `<KmKarta><GUID>{...}</GUID></KmKarta>` on every line for Money to bind it to a store card. Read the GUID from `sync_storecards.guid`.
- **Do** include `<Sklad><GUID>{...}</GUID></Sklad>` — the warehouse is also GUID-keyed.
- **Do** include `<DodOdb><GUID>{...}</GUID></DodOdb>` with a **deterministic** GUID derived from `ic+email` (or the extended key when `moneys3_rozsirene_parovani_zakazniku==1`). We generate this on our side because we don't receive partner GUIDs back from Money — we need our own stable identity for the partner, and Money stores whatever we send on first import.
- Don't omit the `<eshop>` block on product uploads back to Money — konektor uses it to track `IN_Changed` / `IN_Export` flags.

## How to tell which mode a project is in

1. **Look for an exported stock file in `temp_dir/`.**
   - `zasoby_money.xml` with `ExpZkratka="_ZAS"` → classic.
   - Any file with `ExpZkratka="_eShopEZas"` or a `SeznamKategorii` + `<eShopInfo>` block → konektor.
2. **Look at the Money profile names referenced in `scripts/`.** `E_ZAS` / `I_O+P+N` → classic. `E_eShopEZas` or any `_eShop*` profile → konektor.
3. **Look at `settings.json`** for a switch like `moneys3_konektor` or equivalent (naming has varied per project).
4. **Ask the customer** — the konektor module is a visible paid extra in Money; they'll know whether they paid for it.

## Our sqlite pair cache works the same in both modes

`temp_dir/money.sqlite::sync_storecards` stores `(code, guid, storage_guid, storage_code, storage_name, last_price, last_stock)` regardless of mode. `code` is whatever `$pair_field` is set to — `UzivCode` by default, `Katalog` / `Zkrat` / `BarCode` if overridden. `guid` is always Money's store-card GUID.

- Classic mode: we emit `<KmKarta><UzivCode>$code</UzivCode><GUID>$guid</GUID></KmKarta>`; Money pairs on `UzivCode`.
- Konektor mode: we emit `<KmKarta><GUID>{$guid}</GUID></KmKarta>`; Money pairs on `GUID`.

Either way, our internal persistence is identical — only the XML emitted to Money differs.
