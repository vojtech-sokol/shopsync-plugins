# Money S4 / S5 - XML Reference

Money S4 / S5 accepts and emits XML in the **`<S5Data>`** envelope. One document can carry multiple agendas - typically a `FirmaList` (address book), an `ObjednavkaPrijataList` (orders) or `PoptavkaPrijataList` (inquiries), and so on. Money matches incoming records by their `ID` GUID; we deterministically derive that GUID with `create_guid($seed)` so re-runs hit the same row.

## Envelope

```xml
<?xml version="1.0" encoding="utf-8"?>
<S5Data>
    <FirmaList>
        <Firma ID="<GUID>"> ... </Firma>
        ...
    </FirmaList>
    <PoptavkaPrijataList>
        <PoptavkaPrijata ID="<GUID>"> ... </PoptavkaPrijata>
        ...
    </PoptavkaPrijataList>
    <ObjednavkaPrijataList>
        <ObjednavkaPrijata ID="<GUID>"> ... </ObjednavkaPrijata>
        ...
    </ObjednavkaPrijataList>
    <!-- and per-agenda lists like KategorieArtikluList, ArtiklList, ZakaznikList, ... -->
</S5Data>
```

The prolog says `encoding="utf-8"` because the file on disk is rendered through PHP's UTF-8 string handling, but when the XML is pushed into the `System_XmlExchangeImport.VstupniXML` column the whole document is converted with `utf2win($xml)` to windows-1250 first. The encoding declared in the prolog and the bytes Money actually sees must match - keep them aligned. (When writing a file on disk and letting Money pick it up via the watched-folder route, you may emit the file as utf-8 and declare it as such; the queue insert is the one that needs windows-1250.)

## Per-agenda root lists (most used)

| List wrapper | Item element | What it imports |
|---|---|---|
| `FirmaList` | `Firma` | Customers / partners (`CSW_EObchod_Zakaznik` / `Adresar_*`) |
| `ObjednavkaPrijataList` | `ObjednavkaPrijata` | Received orders |
| `PoptavkaPrijataList` | `PoptavkaPrijata` | Received inquiries (RFQ) |
| `FakturaVydanaList` | `FakturaVydana` | Issued invoices |
| `FakturaPrijataList` | `FakturaPrijata` | Received invoices |
| `KategorieArtikluList` | `KategorieArtiklu` | Product categories |
| `ArtiklList` | `Artikl` | Products / store cards |
| `ZasobaList` | `Zasoba` | Stock rows |
| `CenovaHladinaList` | `CenovaHladina` | Customer price levels |
| `CenikList` | `Cenik` | Pricelists (header + rows) |
| `SeznamSpojeni` | `Spojeni` | Contact rows (email / phone) - nested inside `Firma` |

The exact tags map 1:1 to the `CSW_EObchod_*` view names with the list prefix dropped, e.g. `KategorieArtikluList` ↔ `CSW_EObchod_Kategorie`. When in doubt, look at the existing templates in `lib/moneys4/templates/` and `scripts*/templates/`.

## Common building blocks

### Reference to an existing record

```xml
<Adresa>
    <Firma ID="<aid>"/>
</Adresa>
<Stat ID="<country_id>" ObjectType="Object" ObjectName="Stat"/>
<Group ID="<group_id>"/>
<Mena ObjectName="Mena" ObjectType="Object" ID="<currency_guid>"/>
```

`ObjectType="Object"` / `ObjectName="<ViewName>"` is the canonical Money cross-reference shape. `ID` is the GUID of the record you point at - it must already exist in Money (for `Stat`, look it up in `Ciselniky_Stat`; for `Mena`, in `CSW_EObchod_Mena`).

### List of nested objects (e.g. contacts on a Firma)

```xml
<SeznamSpojeni ObjectName="Spojeni" ObjectType="List">
    <Spojeni ObjectName="Spojeni" ObjectType="Object" ID="<spoj_guid>">
        <SpojeniCislo><![CDATA[<value>]]></SpojeniCislo>
        <TypSpojeni_ID><?php echo $spoj_id_email; ?></TypSpojeni_ID>
    </Spojeni>
</SeznamSpojeni>
```

`TypSpojeni_ID` is the GUID of the contact-type code from `Adresar_TypSpojeni` - resolve at template time (the existing templates loop `Adresar_TypSpojeni`, find rows named `E-mail` / `Telefon` / `Telefón`, and stash the GUIDs in `$spoj_id_email` / `$spoj_id_tel`).

### Document line

Line items inside `Polozky` for orders / inquiries:

```xml
<Polozky>
    <PolozkaObjednavkaPrijate ID="<line_guid>">
        <CisloPolozky>1</CisloPolozky>
        <DokladObjectName>ObjednavkaPrijata</DokladObjectName>
        <FormatPolozky>0</FormatPolozky>

        <JednCena><?php echo $item["price"] * $currency_rate; ?></JednCena>
        <JednCenaCM><?php echo $item["price"]; ?></JednCenaCM>
        <CelkovaCena><?php echo $item["price"] * $item["count"] * $currency_rate; ?></CelkovaCena>
        <CelkovaCenaCM><?php echo $item["price"] * $item["count"]; ?></CelkovaCenaCM>

        <Mnozstvi><?php echo $item["count"]; ?></Mnozstvi>
        <Nazev><?php echo xmlStr($name); ?></Nazev>
        <Poradi>1</Poradi>
        <Sleva><?php echo number_format($item["discount"] ?? 0, 2, ".", ""); ?></Sleva>
        <TypCeny>0</TypCeny>
        <TypObsahu>1</TypObsahu>    <!-- 1 = matched store-card / 0 = free text -->
        <TypPolozky>0</TypPolozky>
        <ObsahPolozky>
            <Artikl ID="<artikl_guid>"/>
            <Sklad  ID="<sklad_guid>"/>
        </ObsahPolozky>
        <DPH><Sazba><?php echo round($item["vat"] * 100); ?></Sazba></DPH>
    </PolozkaObjednavkaPrijate>
</Polozky>
```

For `PoptavkaPrijata` the line wrapper is `PolozkaPoptavkaPrijate`; for `FakturaVydana` it is `PolozkaFakturaVydana`. The inner blocks stay the same shape.

### Money in two currencies

When the document currency differs from the home currency, you must emit **both**:

- `JednCena` / `CelkovaCena` - in **home** currency (CZK) = foreign-currency value × `$currency_rate`
- `JednCenaCM` / `CelkovaCenaCM` - in **document (CM = "cizí měna")** currency

Plus an `UcetniKurz` block on the document header:

```xml
<UcetniKurz>
    <Kurz><?php echo $currency_rate; ?></Kurz>
    <Mnozstvi>1.000000</Mnozstvi>
</UcetniKurz>
```

Resolve the rate from `Meny_KurzListek` + `Meny_KurzListekPolozka` (`order by Datum desc, take ValutyStred`). If the document is in the home currency, omit `UcetniKurz` and `CM` fields are equal to the non-CM fields.

### Line-level discount (`<Sleva>`)

`<Sleva>` on a `Polozka*` is a **percentage** with two decimals. `<JednCena>` / `<JednCenaCM>` is the **pre-discount** unit price, and Money applies `Sleva%` on top - so `final = JednCena × (1 - Sleva/100)`. Send `0.00` when there is no discount. The document-level `<Sleva>` on the header is also a percentage and applies on top of any line-level discount unless the line sets `<NepodlehatSleveDokladu>True</NepodlehatSleveDokladu>`.

### VAT

`<DPH><Sazba>21</Sazba></DPH>` - just the percentage as an integer. `DPHEditovanoRucne` controls whether Money respects a manually overridden rate (`False` lets Money recalc from the store-card and the OSS rules).

### Group / segment GUID (B2B routing)

When orders need to route to a specific Money group (e.g. CZK customers vs EUR customers, retail vs wholesale), the template emits `<Group ID="..."/>`. The GUID must already exist as a `CSW_EObchod_Skupiny` row - typical shopsync projects hardcode it per currency:

```php
if ($id_currency == 1) {       // CZK
    $inq["group_id"] = "F1C3711F-260C-411F-9801-7C3DC0DAAF51";
} elseif ($id_currency == 2) { // EUR
    $inq["group_id"] = "6007B8C1-7EF2-4B12-8603-EB32FF20A768";
}
```

Don't make up group GUIDs - confirm against the customer's Money installation.

## Helpers

- `create_guid($seed)` - deterministic GUID (md5-derived) used everywhere a stable cross-reference is needed: address book records (`getCfg(1,"id_prefix") . "_" . $email . "_" . $company`), documents (`<prefix>_poptavka_<idord>`), line GUIDs (`<prefix>_poptavka_<number>_<serialize($item)>_<i>`), queue dedup keys (`xml_ins_<agenda>_<id>`), and contact rows (`SPOJ<aid><typguid>`). Same seed → same GUID across reruns.
- `xmlStr($value)` / `xmlStr($value, $maxlen)` - XML-escapes a string and (optionally) truncates to a max length. Use on every string that goes into an element value or attribute.
- `utf2win($value)` - converts UTF-8 → windows-1250. Wrap the **entire** generated XML before inserting into `System_XmlExchangeImport.VstupniXML`. Also use it on individual strings going into SQL `INSERT`s that target the queue's `Kod` / `Nazev` columns.
- `convertRes($odbcResult)` - the read-side counterpart (windows-1250 → UTF-8) when pulling text out of `odbc_result()`.
- `sqlSafe($value)` - escapes single quotes for SQL string literals. Always wrap before splicing into a query string.
- `maxLen($value, $n)` - truncate to `$n` chars; templates use this for SQL-side `Kod` / `Nazev` columns with hard size limits.
- `getCfg($section, $key)` - reads the merged config; sections used in templates: `1` (header defaults like `id_prefix`, `stredisko`, `cinnost`, `zakazka`, `vychozi_sklad`), `4` (price-side toggles), `8` (debug).
- `applyTemplate($data, $template_path[, $out_file])` - renders a PHP template against `$data` (the loop variable inside the template is `$data` if you pass an array, or the template iterates `foreach ($data as $d) { ... }`). When `$out_file` is given the result is written to disk; otherwise returned as a string.

## Rendering pattern (queue path)

```php
// 1. Build a single-doc dataset and render it
$xml    = applyTemplate([0 => $d], "./scripts_ps81/templates/orders.php");

// 2. Deterministic dedup GUID
$xml_id = create_guid("xml_ins_obj_" . $d["id"]);

// 3. Skip if already queued
$resx = odbc_exec($con, "select ID from [" . set_dbfile . "].[dbo].[System_XmlExchangeImport] where ID='" . $xml_id . "'");
if (odbc_fetch_row($resx)) { continue; }

// 4. Insert with windows-1250 payload
odbc_exec($con, "insert into [" . set_dbfile . "].[dbo].[System_XmlExchangeImport]
    (ID, Create_ID, Create_Date, KodImportu, VstupniXML, Kod, Nazev)
    values
    ('" . $xml_id . "',
     '880C4CD2-5A95-4851-8607-67604587CAEF', getdate(),
     'obj2_test',                     /* KodImportu - see queue-reference.md */
     '" . utf2win($xml) . "',
     '" . $d["number"] . "',
     '" . maxLen(sqlSafe(utf2win($d["invoice"]["name"])), 30) . "')");
```

## Things that bite

- **Element order matters in some Money agendas.** When in doubt, match the field order of an existing working template rather than reorganizing.
- **`<Group ID="..."/>`** must reference an existing `CSW_EObchod_Skupiny` row. A non-existent GUID rejects the whole document.
- **`<Mena>` and `<UcetniKurz>` go together.** Either emit both (foreign currency) or neither (home currency). Half-set produces an inconsistent doc that Money won't import cleanly.
- **`CDATA` for free text.** Strings that may contain `<`, `>`, `&`, or quote characters belong in `<![CDATA[ ... ]]>` (`Nazev` on `Firma`, line notes, etc.). `xmlStr()` handles escaping if you don't want CDATA.
- **Bool values are literally `True` / `False`** with that capitalization - not `1` / `0`, not lowercase. `<FyzickaOsoba>True</FyzickaOsoba>`, `<PriznakVyrizeno>False</PriznakVyrizeno>`.
- **Decimal separator is `.`** in XML even though Money's UI shows `,`. Use `number_format($n, 2, ".", "")` to avoid locale surprises.
- **Don't fabricate `ID` GUIDs.** Either reference an existing one or derive a new one with `create_guid()` from a stable seed - never `uniqid()` / `Uuid::random()`. Re-run safety depends on determinism.
- **Encoding alignment.** XML prolog `encoding="utf-8"` is fine when the payload was utf-8 at write time; the `utf2win()` call at queue-insert time switches the bytes to windows-1250, and Money reads it accordingly. Don't double-convert.
