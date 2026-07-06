# Money S4 / S5 - Library Reference

The single shared library lives at **`lib/moneys4/`** (PHP namespace **`MoneyS4`**) - the same code handles both S4 and S5 installations. There is no separate `lib/moneys5/`.

## File map

```
lib/moneys4/
├── products.php       MoneyS4\Products       - product loader (main entry point)
├── categories.php     MoneyS4\Categories     - category tree loader
├── customers.php      MoneyS4\Customers      - address book loader
├── parameters.php     MoneyS4\Parameters     - parameter definitions
├── images.php         MoneyS4\Images         - product images / attachments
├── pictures.php       (alternate image loader, used by some older projects)
├── settings_gen.php   generator for settings_template.json (drives the shopsync UI)
└── templates/
    ├── orders.php         <S5Data>/ObjednavkaPrijataList template for outbound order import
    └── categories.php     <S5Data>/KategorieArtikluList template for outbound category import
```

Per-project additions (orders to inquiries to product-server pushes) typically live as **scripts** in `scripts/`, `scripts_ps81/`, `scripts_ws/`, etc., with **template overrides** in `scripts*/templates/`.

## `MoneyS4\Products`

The product loader. Reads from `CSW_EObchod_Artikl` and dispatches per-row to the `loadXxx` methods.

### Public properties

| Property | Default | Purpose |
|---|---|---|
| `$con` | (set in ctor) | Active ODBC connection (`odbc_connect(set_pohoda_db, ...)`) |
| `$res` | (set in `load`) | Current main resultset |
| `$variants` | `false` | If `true`, the loader treats rows with `NadrazenyArtikl_ID != null` as variants of their parent |
| `$pair_field` | `"Katalog"` | Column on `CSW_EObchod_Artikl` used as the pair / sync key |
| `$parent_pair_field` | `"parent_katalog"` | Alias in `$select` that exposes the parent's pair field (set by the joined `parent` alias in the default `$select`) |
| `$price_rounding` | `4` | Decimals applied to prices |
| `$filter` | `""` | SQL fragment injected via `[filter]` (wrapped in `and (...)`) |
| `$last_update` | `"1970-01-01"` | Set by constructor; replaces `[last]` for incremental sync |
| `$shop_id` | hard-coded GUID | The `CSW_EObchod_Obchod.ID` for this project's e-shop instance - **must be overridden per project** |
| `$active_codes` | `[]` | Populated by `loadActiveCodes()` - all pair keys currently visible (for cleanup on the e-shop side) |
| `$active_codes_variants` | `[]` | Variant pair keys when `$variants = true` |
| `$select` | (long SELECT) | The main product query - see below |
| `$item` | `[]` | The row currently being assembled (mutated by every `loadXxx` method) |
| `$data` | `[]` | All rows after `load()` finishes |

### The default `$select`

```sql
select  p.*, a.PLU, a.Zkratka20,
        a.Vyrobce_Nazev, vyrobce.Nazev as Vyrobce_Nazev2, vyrobce.ID as Vyrobce_ID,
        parent.Katalog as parent_katalog, parent.Kod as parent_kod,
        parent.CarovyKod as parent_ean, parent.Nazev as parent_name,
        parent.VlastniHmotnost as parent_weight
from    [<dbfile>].[dbo].[CSW_EObchod_Artikl]    as p
join    [<dbfile>].[dbo].[Artikly_Artikl]        as a       on a.ID  = p.ID
join    [<dbfile>].[dbo].[CSW_EObchod_ObchodArtikl] as e    on e.Artikl_ID = p.ID
                                                        and e.Parent_ID = '[shop_id]'
left join [<dbfile>].[dbo].[CSW_EObchod_Vyrobce] as vyrobce on vyrobce.ID = p.Vyrobce_Firma_ID
left join [<dbfile>].[dbo].[CSW_EObchod_Artikl]  as parent  on parent.ID  = p.NadrazenyArtikl_ID
where  (p.Create_Date > [last]
        or p.Modify_Date > [last]
        or (select top 1 Modify_Date from CSW_EObchod_Zasoba        where Artikl_ID = p.ID order by Modify_Date desc) > [last]
        or (select top 1 Modify_Date from CSW_EObchod_PolozkaCeniku where Artikl_ID = p.ID order by Modify_Date desc) > [last])
   and (select top 1 ID from CSW_EObchod_Artikl where NadrazenyArtikl_ID = p.ID) is null  [filter]
   and p.Deleted=0 and p.Hidden=0
order by p.NadrazenyArtikl_ID asc
```

Notes:
- The `(select top 1 ID ... NadrazenyArtikl_ID = p.ID) is null` test excludes parent products that have variants - the loader processes the **leaf** rows (each variant) and reconstructs the parent on demand via the joined `parent` alias.
- `[last]`, `[shop_id]`, `[filter]` are template placeholders replaced in `load()` - see SKILL.md.

### Method hooks (override in your subclass)

| Method | What it sets in `$this->item` |
|---|---|
| `loadStoreCard()` | `id`, `parent_id`, `code`, `option`, `producer`, `plu`, `unit`, `weight`, `defweight`, `EAN`, `status`, `width`, `height`, `depth` |
| `loadDescriptions()` | `name`, `desc1`, `desc2`. Variants pull description from the parent (`NadrazenyArtikl_ID`). |
| `loadPrices()` | `defprice`, `price`, `price_novat`, `pricegroup[<key>]` (incl. `def`, `eur`, and numeric group IDs), `discount`, `vat`, `qty_discounts` |
| `loadStock()` | `count`, `storage` - reads `CSW_EObchod_Zasoba` |
| `loadCategories()` | `categories` - walks `CSW_EObchod_ArtiklKategorie` then climbs `CSW_EObchod_Kategorie.NadrazenaKategorie_ID` to the root |
| `loadParameters()` | `params` (non-variant) and `params2` (variant) - joins `CSW_EObchod_ArtiklParametr` + `CSW_EObchod_Parametr` + `Artikly_ParametrArtiklu` (for the `Variantni` flag) |
| `loadRelated()` | `related` (`CSW_EObchod_ArtiklPrislusenstvi`), `related2` (`CSW_EObchod_ArtiklAlternativa`) |

A typical override extends what the parent already set, e.g.:

```php
public function loadStoreCard() {
    parent::loadStoreCard();
    $this->item["label_new"] = ...;       // populated from CSW_EObchodPlus_ArtiklPriznak
    $this->item["freeship_cz"] = ...;
}
```

### `loadActiveCodes()`

Runs the same query with `[last]` forced to `1970-01-01` and `[filter]` empty. Fills `$active_codes` (parent codes) and `$active_codes_variants` (variant codes). Used by per-project cleanup steps to deactivate e-shop products that no longer exist in Money.

## `MoneyS4\Categories`

```php
$select = "
    select k.ID, k.Kod, k.Nazev, k.NadrazenaKategorie_ID, k.Deleted
    from   [<dbfile>].[dbo].[CSW_EObchod_Kategorie] as k
    where  (k.Create_Date > [last] or k.Modify_Date > [last])
    order by k.Create_Date asc";
```

Walks the tree from `NadrazenaKategorie_ID`. Per-row hooks typically set `$this->item["id"]`, `parent_id`, `name`, `desc`.

## `MoneyS4\Customers`

Reads `CSW_EObchod_Zakaznik` and joins `Adresar_*` for addresses + `Spojeni` for email/phone. The `Adresar_TypSpojeni` lookup (Email / Telefon GUID) is shared with the orders template - keep both in sync if you change the contact-type rows.

## `MoneyS4\Parameters`

Lists definitions from `CSW_EObchod_Parametr` plus the `Artikly_ParametrArtiklu.Variantni` flag (which says "this parameter is variant-defining"). For list-type parameters, values come from `CSW_EObchod_HodnotaParametru`.

## `MoneyS4\Images` / `pictures`

Lists product images and attachments. Reads `CSW_EObchodPlus_ArtiklObrazek` (Plus) when present and falls back to the underlying file paths otherwise. Per-project code typically calls a separate downloader to copy the binaries.

## Per-project extension pattern

Project shopsyncs follow a strict layout per the user's convention - **all per-project code in `scripts*/`**:

```
scripts_ps81/
├── products.php              loads from external eshop, syncs to Money via XML
├── products_server.php       loads from Money, syncs to PrestaShop
├── orders.php                pulls orders from PrestaShop, enqueues to Money
├── inquiries.php             pulls inquiries from PrestaShop, enqueues to Money
├── change_state.php          mirrors Money order phase back to PrestaShop
└── templates/
    ├── orders.php
    ├── inquiries.php
    └── ...
```

Inside each script, the pattern is **extend** (not replace):

```php
class CustProducts extends MoneyS4\Products {
    public $pair_field        = "Katalog";
    public $parent_pair_field = "parent_katalog";
    public $variants          = true;
    public $shop_id           = "<this-eshop-Obchod-GUID>";

    public function loadStoreCard() {
        parent::loadStoreCard();
        $this->item["label_new"] = ...;
    }
}
```

Per the user's global rules:
- **Stay in `scripts*/`** unless the change is clearly general or a bug fix - in that case ask first before touching `lib/moneys4/`.
- **Extend in the same script** that consumes the class; don't create a new file just to add a class extension.
- **Match the surrounding code style** when modifying existing code.

## Templates

PHP templates that produce `<S5Data>` documents. Use `applyTemplate($data, $template_path[, $output_xml_path])` from `lib/functions.php`. Inside the template the dataset is iterated as `foreach ($data as $d) { ... }` and PHP `<?= ... ?>` / `<?php echo xmlStr(...); ?>` is used to splice values.

The base templates (`lib/moneys4/templates/`) are reused as-is for many projects; per-project overrides live next to the consuming script (`scripts*/templates/`). When both exist, the script's `applyTemplate(... "./scripts_ps81/templates/orders.php" ...)` call picks the project version.

## Config keys

| Key | Source | Used for |
|---|---|---|
| `set_pohoda_db` | profile | SQL Server DSN (name kept from Pohoda for legacy reasons) |
| `set_dbfile` | profile | DB name used as `[<dbfile>].[dbo].<obj>` qualifier in every query |
| `getSqlUid()` / `getSqlPwd()` | profile (`sw_*`) | SQL Server credentials |
| `set_homecurrency` | profile | Default currency code (typically `CZK`) |
| `set_vat`, `set_vatlow`, `set_vatthird` | profile | VAT percent values |
| `set_url` | profile | E-shop URL referenced in note/description fields |
| `getCfg(1, "id_prefix")` | section 1 | Prefix fed into `create_guid()` for all derived IDs |
| `getCfg(1, "stredisko")` | section 1 | Cost center GUID stamped on documents |
| `getCfg(1, "cinnost")` | section 1 | Activity GUID |
| `getCfg(1, "zakazka")` | section 1 | Job/contract GUID |
| `getCfg(1, "vychozi_sklad")` | section 1 | Default warehouse GUID for line `<Sklad>` |
| `getCfg(1, "vychozi_skupina_zakazniku")` | section 1 | Default customer group for new Firma records |
| `getCfg(1, "vychozi_cena")` | section 1 | Default pricelist row type |
| `getCfg(4, "typ_slevy")` | section 4 | Discount strategy on the product-write side (`prepis` = absolute price override vs percentage) |
| `getCfg(4, "importovat_nizsi_ceniky")` | section 4 | Whether to emit pricelist rows that are higher than the base price |
| `getCfg(8, "debug")` | section 8 | Debug verbosity - when `>= 2`, the loader prints the rendered SQL and forces `[last]` to `1970-01-01` |

## Naming the e-shop side

The shopsync convention is to keep `set_pohoda_db`, `set_sw`, etc. named after Pohoda even when the back-end is Money S4/S5. Don't rename these - many projects share configs and renames would cascade. Inside Money templates, the equivalent of Pohoda's per-document Group is `<Group ID="..."/>` from `CSW_EObchod_Skupiny`.

## Pitfalls

- **Forgetting to set `$shop_id`.** The default GUID is a placeholder. Without a real `CSW_EObchod_Obchod.ID`, the `e.Parent_ID = '[shop_id]'` filter yields zero rows.
- **`variants = true` without `parent_pair_field`.** The pairing logic in `loadStoreCard` checks `parent_pair_field` to identify variants vs roots - if it's empty or doesn't exist in the SELECT, every variant gets paired by its own `Katalog` and you lose the parent linkage.
- **Forgetting `Deleted=0 and Hidden=0`.** The default `$select` has it; custom queries (especially per-project overrides that build their own SELECT for cleanup or stock sync) often miss it and return ghost rows.
- **Reading from `CSWBA_EShop_*` directly when the `CSW_EObchodPlus_*` view exists.** The view is the supported API; the underlying tables can and do change shape between Money versions.
- **Calling `loadActiveCodes()` after `load()` without resetting `$last_update`.** `loadActiveCodes()` overrides `[last]` to `1970-01-01` internally, so it's safe, but be aware it does a **full** scan - don't call it in a tight loop.
