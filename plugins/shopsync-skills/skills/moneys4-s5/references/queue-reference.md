# Money S4 / S5 - XML Import Queue Reference

Money S4 / S5 imports XML asynchronously via the DB table **`System_XmlExchangeImport`**. Insert a row containing the windows-1250 XML payload and Money picks it up on its next poll.

This is the preferred path in shopsync projects. The alternative - dropping XML files into Money's watched import folder - works too, but the DB queue gives us atomic inserts, easy dedup, and lets us run on machines that don't share a filesystem with Money.

## Column layout (the columns we write)

| Column | Type | What goes there |
|---|---|---|
| `ID` | `uniqueidentifier` | The dedup key. **Always** `create_guid("xml_ins_<agenda>_<source_id>")`. SELECT before insert to skip if already present. |
| `Create_ID` | `uniqueidentifier` | The shopsync integration's identity inside Money. **Hard-coded**: `880C4CD2-5A95-4851-8607-67604587CAEF`. Same value in every project. |
| `Create_Date` | `datetime` | `getdate()` (server time). |
| `KodImportu` | `varchar` | Code identifying which import "profile" Money should use - see table below. |
| `VstupniXML` | `varbinary` / `text` | The XML payload **as windows-1250 bytes**. Always `utf2win($xml)` at insert time. |
| `Kod` | `varchar` | Short human-readable key (used by Money's UI). Typical content: the source-system document number (`$d["number"]`). |
| `Nazev` | `varchar(30)` | Display label. Typical content: customer name. Always `maxLen(sqlSafe(utf2win(...)), 30)` to fit. |

Money writes additional columns back after processing (status / response / error log) - don't touch those.

## The fixed `Create_ID`

The GUID `880C4CD2-5A95-4851-8607-67604587CAEF` represents the shopsync integration as an actor inside Money. Every project uses the same value - it must already be configured on the Money side as a known user/integration. **Don't randomize it** - rows with an unknown `Create_ID` may be silently dropped by Money's audit policy.

## `KodImportu` codes used by shopsync

`KodImportu` selects which Money import profile (which agendas the XML is allowed to write to). Profiles are configured inside Money; the code is the **name** Money matches against. Common shopsync values:

| `KodImportu` | What the XML carries |
|---|---|
| `obj2_test` | Received orders (`ObjednavkaPrijataList`) - the long-running profile name in current shopsync projects |
| `popt` | Received inquiries (`PoptavkaPrijataList`) |
| `kat` | Categories (`KategorieArtikluList`) |
| `art` | Products / store cards (`ArtiklList`) |
| `adr` | Address book (`FirmaList`) |

> The exact code is **per-Money-installation** - if you're working in a project, the existing scripts already use the correct code. Stick with what `git grep KodImportu` shows for that project. If a profile is missing in Money, the user has to add it on the Money side; no amount of XML tweaking will work around it.

## Dedup pattern

The integration is idempotent through `ID`. Each script computes a deterministic `xml_id` for the row and SELECTs before inserting:

```php
$xml_id = create_guid("xml_ins_obj_" . $d["id"]);

$resx = odbc_exec($con, "select ID from [" . set_dbfile . "].[dbo].[System_XmlExchangeImport]
                         where ID='" . $xml_id . "'");
if (odbc_fetch_row($resx)) {
    continue;            // already queued - skip
}

odbc_exec($con, "insert into [" . set_dbfile . "].[dbo].[System_XmlExchangeImport]
    (ID, Create_ID, Create_Date, KodImportu, VstupniXML, Kod, Nazev)
    values
    ('" . $xml_id . "',
     '880C4CD2-5A95-4851-8607-67604587CAEF', getdate(),
     '" . $importCode . "',
     '" . utf2win($xml) . "',
     '" . $d["number"] . "',
     '" . maxLen(sqlSafe(utf2win($d["invoice"]["name"])), 30) . "')");
```

The seed should encode both the agenda and the source-side primary key:

```php
create_guid("xml_ins_obj_"   . $orderId)         // orders
create_guid("xml_ins_2_"     . $orderId)         // some older projects use this seed
create_guid("xml_ins_popt_"  . $inquiryId)       // inquiries
create_guid("xml_ins_kat_"   . $categoryId)      // categories
```

Don't mix sources in the seed. If you derive the same seed for an order and an inquiry, the second insert silently no-ops.

> **Re-queueing forces a fresh GUID.** If you've edited the XML logic and need Money to re-import a specific document, delete the existing row first (`delete from System_XmlExchangeImport where ID = '...'`) - inserting won't replace it, and changing the seed creates a new row without removing the old one.

## Doing a separate "after" action via ODBC

Some scripts also write directly to business tables after the queue insert - e.g. flagging a paid order:

```php
odbc_exec($con, "update Objednavky_ObjednavkaPrijata
                 set Uhrazeno_UserData=1
                 where Odkaz='" . $d["idord"] . "'");
```

`Uhrazeno_UserData` is a **custom user field** (the `_UserData` suffix convention - see [db-reference.md](db-reference.md)) - which means it's **not** exposed by the `CSW_EObchod_*` views, only on the base table. Direct UPDATE on the base table is the only way to set it.

This is fine when the field is a user-data flag that doesn't trigger Money's own business logic. For anything that does (status changes, document phase, ...), prefer an XML import even if it feels heavier - the import path runs Money's recompute logic; a raw UPDATE can leave the document in an inconsistent state.

## Failure handling

The insert itself either succeeds or fails - if SQL Server rejects the row (constraint, encoding, ...), the `odbc_exec` returns `false` and the call throws nothing by default. **Check the return** when the data path is critical.

After Money processes the row, the response goes back into the **same row** (status + response columns the docs don't expose by name). If you need to surface failures to the operator, poll the queue table for rows where the response indicates an error - the exact column to read on depends on the Money version, so check the live DB schema first. The shopsync default is fire-and-forget; the operator watches Money's UI for failed imports.

## When to bypass the queue and write a file instead

The file route - `applyTemplate($data, $template, "<path>/orders.xml")` followed by hand-off to Money's watched-folder importer - is still around in older shopsync projects. Use it only when:

- The Money DB isn't directly reachable from the script host, OR
- You need to hand the XML to an operator for manual review before import.

In every other case, prefer the queue: it's transactional, deduplicates cleanly, and survives script crashes (the row is either in or it isn't). The queue insert is also what makes incremental re-runs safe - the dedup check on `ID` is the entire correctness story.
