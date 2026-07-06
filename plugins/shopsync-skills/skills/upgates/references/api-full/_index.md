# Upgates API v2 - Full Endpoint Index

Extracted 2026-07-06 from docs.upgates.com/api-reference (original embedded OpenAPI data).
Per-resource detail (descriptions, request/response schemas, examples) is in `<slug>.json` in this folder.

| Method | Path | Summary | File |
|--------|------|---------|------|
| GET | `/api/v2/news` | Seznam aktualit | aktuality.json |
| GET | `/api/v2/pricelists` | Seznam ceníků | ceniky.json |
| POST | `/api/v2/pricelists` | Vytvoření ceníků | ceniky.json |
| GET | `/api/v2/pricelists/{id}` | Detail ceník | ceniky.json |
| DELETE | `/api/v2/pricelists/{id}` | Smazání ceníku | ceniky.json |
| GET | `/api/v2/articles` | Seznam článků | clanky.json |
| PUT | `/api/v2/articles` | Aktualizace článků | clanky.json |
| POST | `/api/v2/articles` | Vytvoření článků | clanky.json |
| DELETE | `/api/v2/articles` | Smazání článků | clanky.json |
| GET | `/api/v2/articles/{id}` | Detail článku | clanky.json |
| GET | `/api/v2/availabilities` | Seznam dostupností | dostupnosti.json |
| PUT | `/api/v2/availabilities` | Aktualizace dostupností | dostupnosti.json |
| POST | `/api/v2/availabilities` | Vytvoření dostupností | dostupnosti.json |
| GET | `/api/v2/availabilities/{id}` | Detail dostupnosti | dostupnosti.json |
| DELETE | `/api/v2/availabilities/{id}` | Smazání dostupností | dostupnosti.json |
| GET | `/api/v2/shipments` | Seznam doprav | dopravy.json |
| GET | `/api/v2/shipments/{id}` | Detail dopravy | dopravy.json |
| GET | `/api/v2/shipments/{id}/affiliates` | Seznam poboček dopravy | dopravy.json |
| POST | `/api/v2/shipments/{id}/affiliates` | Vytvoření pobočky dopravy | dopravy.json |
| DELETE | `/api/v2/shipments/{id}/affiliates` | Smazání pobočky dopravy | dopravy.json |
| GET | `/api/v2/shipments/groups` | Seznam skupin dopravy | dopravy.json |
| GET | `/api/v2/invoices` | Seznam faktur | faktury.json |
| GET | `/api/v2/invoices/{invoice_number}` | Detail faktury | faktury.json |
| GET | `/api/v2/invoices/{invoice_number}/pdf` | Faktura v PDF | faktury.json |
| GET | `/api/v2/graphics/code` | Informace o souboru / složce | grafika-editor-kodu.json |
| PUT | `/api/v2/graphics/code` | Aktualizace obsahu souboru | grafika-editor-kodu.json |
| POST | `/api/v2/graphics/code` | Vytvoření souboru / složky | grafika-editor-kodu.json |
| DELETE | `/api/v2/graphics/code` | Smazání souboru / složky | grafika-editor-kodu.json |
| GET | `/api/v2/graphics/backups` | Seznam záloh | grafika-zalohy.json |
| PUT | `/api/v2/graphics/backups` | Obnovení zálohy | grafika-zalohy.json |
| POST | `/api/v2/graphics/backups` | Vytvoření zálohy | grafika-zalohy.json |
| DELETE | `/api/v2/graphics/backups` | Smazání zálohy | grafika-zalohy.json |
| GET | `/api/v2/languages` | Seznam jazyků | jazyky.json |
| GET | `/api/v2/categories` | Seznam kategorií | kategorie.json |
| PUT | `/api/v2/categories` | Aktualizace kategorií | kategorie.json |
| POST | `/api/v2/categories` | Vytvoření kategorií | kategorie.json |
| DELETE | `/api/v2/categories` | Smazání kategorií | kategorie.json |
| GET | `/api/v2/conversion-codes` | Seznam konverzních kódů | konverzni-kody.json |
| PUT | `/api/v2/conversion-codes` | Aktualizace konverzního kódu | konverzni-kody.json |
| POST | `/api/v2/conversion-codes` | Vytvoření konverzního kódu | konverzni-kody.json |
| GET | `/api/v2/conversion-codes/{position}` | Detail konverzního kódu | konverzni-kody.json |
| DELETE | `/api/v2/conversion-codes/{position}` | Smazání konverzního kódu | konverzni-kody.json |
| GET | `/api/v2/carts` | Seznam košíků | kosiky.json |
| GET | `/api/v2/carts/{id}` | Detail košíku | kosiky.json |
| GET | `/api/v2/config` | Nastavení eshopu | nastaveni-eshopu.json |
| GET | `/api/v2/orders` | Seznam objednávek | objednavky.json |
| PUT | `/api/v2/orders` | Aktualizace objednávek | objednavky.json |
| POST | `/api/v2/orders` | Vytvoření objednávek | objednavky.json |
| DELETE | `/api/v2/orders` | Smazání objednávek | objednavky.json |
| GET | `/api/v2/orders/{order_number}` | Detail objednávky | objednavky.json |
| GET | `/api/v2/orders/{order_number}/pdf` | Objednávka v PDF | objednavky.json |
| GET | `/api/v2/orders/{order_number}/history` | Seznam | objednavky-historie.json |
| POST | `/api/v2/orders/{order_number}/history` | Přidání záznamu | objednavky-historie.json |
| POST | `/api/v2/orders/{order_number}/file` | Přidání souboru | objednavky-prilohy.json |
| POST | `/api/v2/orders/{order_number}/urls` | Přidání odkazů | objednavky-prilohy.json |
| DELETE | `/api/v2/orders/{order_number}/attachments` | Smazání přílohy | objednavky-prilohy.json |
| GET | `/api/v2/parameters/{id}` | Detail parametru | parametry.json |
| GET | `/api/v2/parameters` | Seznam parametrů | parametry.json |
| PUT | `/api/v2/parameters` | Aktualizace parametrů | parametry.json |
| POST | `/api/v2/parameters` | Vytvoření parametrů | parametry.json |
| DELETE | `/api/v2/parameters` | Smazání parametrů | parametry.json |
| DELETE | `/api/v2/parameters/values` | Smazání hodnot parametrů | parametry.json |
| GET | `/api/v2/payments` | Seznam plateb | platby.json |
| GET | `/api/v2/payments/{id}` | Detail platby | platby.json |
| PUT | `/api/v2/products` | Aktualizace produktů | produkty.json |
| POST | `/api/v2/products` | Vytvoření produktů | produkty.json |
| DELETE | `/api/v2/products` | Smazání produktů | produkty.json |
| GET | `/api/v2/products/{code}` | Detail produktu | produkty.json |
| GET | `/api/v2/products/{code}/simple` | Detail produktu (zjednodušený) | produkty.json |
| GET | `/api/v2/products/{code}/prices` | Detail produktu (ceny) | produkty.json |
| GET | `/api/v2/products/{code}/parameters` | Detail produktu (parametry) | produkty.json |
| GET | `/api/v2/products/{code}/labels` | Detail produktu (štítky) | produkty.json |
| GET | `/api/v2/products/{code}/files` | Detail produktu (soubory) | produkty.json |
| GET | `/api/v2/products/{code}/related` | Detail produktu (související) | produkty.json |
| POST | `/api/v2/products/{code}/images` | Přidání obrázku | produkty.json |
| GET | `/api/v2/products/images-queue` | Fronta obrázků ke stažení | produkty.json |
| DELETE | `/api/v2/products/variants` | Smazání variant | produkty.json |
| GET | `/api/v2/products` | Kompletní seznam | produkty-seznamy.json |
| GET | `/api/v2/products/simple` | Zjednodušený seznam | produkty-seznamy.json |
| GET | `/api/v2/products/prices` | Ceny | produkty-seznamy.json |
| GET | `/api/v2/products/parameters` | Parametry | produkty-seznamy.json |
| GET | `/api/v2/products/labels` | Štítky | produkty-seznamy.json |
| GET | `/api/v2/products/files` | Soubory | produkty-seznamy.json |
| GET | `/api/v2/products/related` | Související | produkty-seznamy.json |
| GET | `/api/v2/products/variants` | Varianty | produkty-seznamy.json |
| GET | `/api/v2/products/ratings-reviews` | Seznam recenzí a hodnocení | produkty-recenze-a-hodnoceni.json |
| POST | `/api/v2/products/ratings-reviews` | Vytvoření recenze a hodnocení | produkty-recenze-a-hodnoceni.json |
| DELETE | `/api/v2/products/ratings-reviews` | Smazání recenzí a hodnocení | produkty-recenze-a-hodnoceni.json |
| GET | `/api/v2/owner` | Provozovatel eshopu | provozovatel-eshopu.json |
| GET | `/api/v2/redirections` | Seznam přesměrování | presmerovani.json |
| POST | `/api/v2/redirections` | Vytvoření přesměrování | presmerovani.json |
| DELETE | `/api/v2/redirections` | Smazání přesměrování | presmerovani.json |
| GET | `/api/v2/advisor` | Seznam rad | radce.json |
| GET | `/api/v2/stocks/{id}` | Detail skladu | sklady.json |
| GET | `/api/v2/stocks` | Seznam skladů | sklady.json |
| PUT | `/api/v2/stocks` | Aktualizace skladů | sklady.json |
| POST | `/api/v2/stocks` | Vytvoření skladů | sklady.json |
| DELETE | `/api/v2/stocks` | Smazání skladů | sklady.json |
| GET | `/api/v2/groups` | Seznam skupin | skupiny-zakazniku.json |
| PUT | `/api/v2/groups` | Aktualizace skupin | skupiny-zakazniku.json |
| POST | `/api/v2/groups` | Vytvoření skupin | skupiny-zakazniku.json |
| DELETE | `/api/v2/groups` | Smazání skupin | skupiny-zakazniku.json |
| GET | `/api/v2/vouchers` | Seznam kupónů | slevove-kupony.json |
| POST | `/api/v2/vouchers` | Vytvoření kupónů | slevove-kupony.json |
| DELETE | `/api/v2/vouchers` | Smazání kupónů | slevove-kupony.json |
| GET | `/api/v2/files` | Seznam souborů | soubory.json |
| POST | `/api/v2/files` | Nahrání souborů | soubory.json |
| POST | `/api/v2/files/file` | Nahrání souboru | soubory.json |
| GET | `/api/v2/files/{id}` | Soubor | soubory.json |
| DELETE | `/api/v2/files/{id}` | Smazání souboru | soubory.json |
| GET | `/api/v2/files/categories` | Seznam kategorií | soubory.json |
| GET | `/api/v2/order-statuses` | Seznam stavů | stavy-objednavek.json |
| PUT | `/api/v2/order-statuses` | Aktualizace stavu | stavy-objednavek.json |
| POST | `/api/v2/order-statuses` | Vytvoření stavu | stavy-objednavek.json |
| GET | `/api/v2/order-statuses/{id}` | Detail stavu objednávky | stavy-objednavek.json |
| DELETE | `/api/v2/order-statuses/{id}` | Smazání stavu | stavy-objednavek.json |
| GET | `/api/v2/labels` | Seznam štítků | stitky.json |
| POST | `/api/v2/labels` | Vytvoření štítků | stitky.json |
| DELETE | `/api/v2/labels` | Smazání štítků | stitky.json |
| GET | `/api/v2/labels/{id}` | Detail štítku | stitky.json |
| GET | `/api/v2/metas` | Seznam vlastních polí | vlastni-pole.json |
| POST | `/api/v2/metas` | Vytvoření vlastních polí | vlastni-pole.json |
| DELETE | `/api/v2/metas` | Smazání vlastních polí | vlastni-pole.json |
| GET | `/api/v2/manufacturers/{id}` | Detail výrobce | vyrobci.json |
| GET | `/api/v2/manufacturers/` | Seznam výrobců | vyrobci.json |
| DELETE | `/api/v2/manufacturers/` | Smazání výrobců | vyrobci.json |
| GET | `/api/v2/webhooks` | Seznam webhooků | webhooky.json |
| PUT | `/api/v2/webhooks` | Aktualizace webhooku | webhooky.json |
| POST | `/api/v2/webhooks` | Vytvoření webhooku | webhooky.json |
| GET | `/api/v2/webhooks/{id}` | Webhook | webhooky.json |
| DELETE | `/api/v2/webhooks/{id}` | Smazání webhooku | webhooky.json |
| GET | `/api/v2/webhooks/events` | Události webhooků | webhooky.json |
| GET | `/api/v2/customers` | Seznam zákazníků | zakaznici.json |
| PUT | `/api/v2/customers` | Aktualizace zákazníků | zakaznici.json |
| POST | `/api/v2/customers` | Vytvoření zákazníků | zakaznici.json |
| DELETE | `/api/v2/customers` | Smazání zákazníků | zakaznici.json |
| GET | `/api/v2/customers/{customer_id}/agreements` | Seznam souhlasů | zakaznici.json |
| POST | `/api/v2/customers/login` | Ověření přihlášení | zakaznici.json |
| GET | `/api/v2/status` | Stav API | ostatni.json |
