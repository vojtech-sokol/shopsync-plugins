# ABRA Gen - E-shop Integration (official Postman collection)

Complete mirror of ABRA's official e-shop integration Postman collection — **all 79 requests**:
https://help.abra.eu/extras/eshop.postman_collection/

This is the canonical end-to-end e-shop flow: find/create firm (customer), delivery offices,
contact persons (osoby), e-shop numbering systems (categories/properties/brands), stock,
pricing, **received orders** (incl. B2C / cross-border / OSS variants), deposit invoices,
payments (other incomes), **order-state workflow**, reports, and document-chain queries.

## Conventions

- `{{url}}/{{alias}}` = `{abraHost}/{abraNazev}` (host + DB alias); docs render it as `localhost:8555/Data/...`.
- `/query` = raw query endpoint — POST `{class, select, where}`. PHP client: `AbraGen\API::customQuery($agenda, $json)`.
  Simple `?select=&where=` style: `AbraGen\API::read()`. Create/update: `AbraGen\API::send()` (POST/PUT). Delete: `AbraGen\API::delete()`.
- `where` operators: `eq`, `ne`, `lt`, `gt`, `like`, `in (...)`, `exists(<coll> WHERE ...)`, null checks `(firm_id = null)`. The PHP client encodes `=`→`+eq+` etc.
- `select` supports dotted paths (`Address_ID.Email`), aliases (`Name as Hodnota`), and nested sub-selects (collections).
- `expand=coll(fields)` inlines owned/related objects. `$date` suffix marks date fields (`datefrom$date`). `?report=<id>` renders a print report; `?auth=<base64>` passes Basic auth in query.
- Many e-shop fields are install-specific `x_` custom attributes (`X_EshopType_ID`, `X_StoreCardType_ID`, `X_ExternID`, …) defined by ABRA's e-shop module template — IDs below are examples.

> Find-or-create person then link to firm (the fix for "osoba se nezaložila → špatné ceny"):
> search `persons` by `Address_ID.Email` + `FirstName`/`LastName`; if none, POST `persons`
> (with owned `Address_ID` carrying e-mail/phone); then POST `firms/{id}/firmpersons` with `{"person_id": ...}`.


## Firmy (Firms) — vyhledání, založení, oprava

**1. Firma, dohledání podle emailu sídla** — POST `{{url}}/{{alias}}/query`

```json
{
	"class":"Firms",
	"select":[
		"ID",
		"Code",
		"ResidenceAddress_ID.email",
		"Name"
		],
	"where":  "((firm_id = null)) and hidden='N' and ResidenceAddress_ID.email = '{{Test_Email}}' "
}
```

**2. Firma, dohledání podle klíče** — GET `{{url}}/{{alias}}/firms?expand=firmoffices(id,name,address_id.street,address_id.city,address_id.countrycode)&select=ID,name,code,k0&skip=0&take=10&where=K0 like '1 1*'`

Podrobnější popis problematiky klíčů: Nápověda ABRA Gen
Množina klíčů a jejich hodnot je uživatelsky definovatelná. Na každé firmě je možné nastavit některé či všechny hodnoty daného klíče. Data klíče tvoří vždy 256 znaků a dle pozice znaku a jeho obsahu lze určit, zda je hodnota klíče nastavena (znak '1') nebo není (znak mezera).
Příklad - pro klíč K0 jsou definovány tři hodnoty:

B2C
B2B
Dodavatel

Pokud jsou ve vlastnostech firmy zatrženy možnosti B2C a Dodavatel, hodnota klíče K0 bude vypadat následovně:
1 1                                                                                                                                                                                                                                                             
Pokud je zatržena pouze možnost B2B:
 1

**3. Firma, dohledání dle IČO** — POST `{{url}}/{{alias}}/query`

```json
{
	"class":"Firms",
	"select":[
		"ID",
		"Code",
		"OrgIdentNumber",
		"Name"
		],
	"where":  "((firm_id = null)) and hidden='N' and OrgIdentNumber = '{{Test_ICO}}'"
}
```

**4. Firma, dohledání podle e-mailu provozovny** — POST `{{url}}/{{alias}}/query`

Dotaz vrátí provozovny firem, na kterých je nastavený dotazovaný e-mail.
Element parent_id = ID firmy.

```json
{
    "class": "AT011EZZ5DFO115YJ1HCZJDXJ4",
    "select": [
        "ID",
        "Name",
        "parent_id"
    ],
    "where":"Address_ID.Email = '{{Test_Email_Provozovny}}'"
}
```

**5. Firma, dohledání podle e-mailu provozovny** — POST `{{url}}/{{alias}}/query`

Tento dotaz vrátí firmu, která má alespoň na jedné provozovně/provozovnách vyplněný dotazovaný e-mail.
Pozor, k firmě vrací všechny provozovny (nejen ty s dotazovaným e-mailem).
Element parent_id = ID firmy.

```json
{
    "class": "Firms",
    "select": [
        "ID",
        "Name",
        {
            "name": "FirmOffices",
            "value": [
                "Address_ID.EMail",
                "ID"
            ]
        }
    ],
    "where": "((Firm_ID = null)) and exists(FirmOffices WHERE Address_ID.EMail = '{{Test_Email_Provozovny}}')"
}
```

**6. Založení firmy** — POST `{{url}}/{{alias}}/firms?select=id`

```json
{
    "Name":"Test firma",
    "VATIdentNumber":"",
    "OrgIdentNumber":"",
    "VATPayor":false,
    "comment": "",
    "wwwaddress": "http://www.abra.eu/",
    "electronicaddress_id": {
        "email": "{{Test_Email}}"
    },
    "residenceaddress_id": {
        "city": "Písek",
        "country": "",
        "countrycode": "CZ",
        "email": "{{Test_Email}}",
        "phonenumber1": "+420 777 666 777",
        "phonenumber2": "",
        "postcode": "",
        "recipient": "Petr Pavel",
        "street": "Vladislavova 250",
        "zip": "397 01"
    }
}
```

**7. Oprava firmy** — PUT `{{url}}/{{alias}}/firms/18B0000101?select=id`

```json
{
    "comment": "",
    "wwwaddress": "http://www.abra.eu/",
    "electronicaddress_id": {
        "email": "{{Test_Email}}"
    },
    "residenceaddress_id": {
        "city": "Písek",
        "country": "",
        "countrycode": "CZ",
        "email": "{{Test_Email}}",
        "phonenumber1": "+420 777 666 777",
        "phonenumber2": "",
        "postcode": "",
        "recipient": "Petr Pavel",
        "street": "Vladislavova 250",
        "zip": "397 01"
    }
}
```

**8. Zásadní oprava firmy (QR skript)** — POST `{{url}}/{{alias}}/qrexpr`

Druhy oprav firmy (rozdíl mezi zásadní a drobnou opravou) jsou blíže popsány v onlině nápovědě: Nápověda ABRA Gen
V původní verzi záznamu firmy je nastavena položka Firm_ID na ID firmy nové (toto ID vrací funkce). Nejnovější záznam má položku Firm_ID nastavenou na hodnotu Null.
Název skriptu:
eu.abra.API.Function.Firms

Název knihovny:
Firms

Obsah knihovny:
function FxFirm_MajorCorrection(const AReportHelper:TNxQRScriptHelper; const AOID: TNxOID): TNxOID;
var
  mFirm, mFirmNew: TNxFirm;
begin
  Result:='';
  mFirm := TNxFirm(AReportHelper.ObjectSpace.CreateObject(Class_Firm));
  try
    mFirm.Load(AOID, nil);
    mFirmNew := mFirm.MajorCorrection;
    try
      // Změna hodnot nové firmy
      //mFirmNew.SetFieldValueAsString('Code', mFirm.GetFieldValueAsString('Code') + 'New');
      mFirmNew.Save;
      Result := mFirmNew.OID;
    finally
      mFirmNew.Free;
    end;
  finally
    mFirm.Free;
  end;
end;

begin
end.

```json
{
  "expr": "NxScript('eu.abra.API.Function.Firms.FxFirm_MajorCorrection','{{firm_ID}}')"
}
```

**9. Firma vč. provozovny** — GET `{{url}}/{{alias}}/firms?expand=firmoffices(id,name,address_id.street,address_id.city,address_id.countrycode)&select=ID,name,code&skip=0&take=10`

**10. Firma vč. provozovny, všechny položky** — GET `{{url}}/{{alias}}/firms?select=*&expand=firmoffices(*)`


## Provozovny (Firm Offices / dodací adresy)

**11. Přidání provozovny do firmy** — POST `{{url}}/{{alias}}/firms/{{firm_ID}}/firmoffices?select=id`

```json
{
    "Name":"Dodací adresa na sklad",
    "OfficeIdentNumber":"01",
    "SynchronizeAddress":false,
    "electronicaddress_id": {
        "email": "{{Test_Email_Provozovny}}"
    },
    "Address_ID": {
        "city": "Písek",
        "country": "",
        "countrycode": "CZ",
        "email": "{{Test_Email_Provozovny}}",
        "phonenumber1": "+420 777 666 777",
        "phonenumber2": "",
        "postcode": "39701",
        "recipient": "Honza Karel",
        "street": "Vladislavova 249",
        "zip": ""
    }
}
```

**12. Oprava provozovny určité firmy** — PUT `{{url}}/{{alias}}/firms/{{firm_ID}}/firmoffices/{{firmOffice_ID}}?select=*`

```json
{
    "Name":"Dodací adresa na sklad",
    "OfficeIdentNumber":"01",
    "SynchronizeAddress":false,
    "electronicaddress_id": {
        "email": "{{Test_Email_Provozovny}}"
    },
    "Address_ID": {
        "city": "Písek",
        "country": "",
        "countrycode": "CZ",
        "email": "{{Test_Email_Provozovny}}",
        "phonenumber1": "+420 777 666 777",
        "phonenumber2": "",
        "postcode": "39701",
        "recipient": "Honza Karel",
        "street": "Vladislavova 249",
        "zip": ""
    }
}
```

**13. Získání všech provozoven určité firmy** — GET `{{url}}/{{alias}}/firms/{{firm_ID}}/firmoffices?select=id`

**14. Získání konkrétní provozovny určité firmy** — GET `{{url}}/{{alias}}/firms/{{firm_ID}}/firmoffices/{{firmOffice_ID}}?select=*`


## Osoby (Persons) a vazby osoba↔firma (FirmPersons)

**15. Vložení osoby do firmy (vytvoření vazby mezi firmou a osobou)** — POST `{{url}}/{{alias}}/firms/{{firm_ID}}/firmpersons?select=id,person_id`

```json
{
    "person_id": "39F0000101"
}
```

**16. Oprava osoby ve firmě (vazby mezi firmou a osobou)** — POST `{{url}}/{{alias}}/firms/{{firm_ID}}/firmpersons?select=id,person_id`

```json
{
    "person_id": "39F0000101"
}
```

**17. Získání osob přiřazených k firmě** — GET `{{url}}/{{alias}}/firms/{{firm_ID}}/firmpersons?select=id,person_id,note`

```json
{
    "person_id": "39F0000101"
}
```

**18. Osoba, dle emailu** — GET `{{url}}/{{alias}}/Persons?where=Address_id.email eq '{{Test_Email_Provozovny}}'&select=ID,FirstName,LastName,Address_id.email`

**19. Osoba, dle ulice** — GET `{{url}}/{{alias}}/Persons?select=*&expand=address_id&where=Address_id.street eq 'Vladislavova 249'`

**20. Založení osoby** — POST `{{url}}/{{alias}}/Persons?select=id`

```json
{
    "FirstName": "Max2",
    "LastName": "Maximus",
    "Address_ID": {
        "city": "Písek",
        "country": "",
        "countrycode": "CZ",
        "email": "{{Test_Email_Provozovny}}",
        "phonenumber1": "+420 777 666 777",
        "phonenumber2": "",
        "postcode": "39701",
        "recipient": "Honza Karel",
        "street": "Vladislavova 249",
        "zip": ""
    }
}
```

**21. Oprava osoby** — PUT `{{url}}/{{alias}}/Persons/39H0000101?select=id`

```json
{
    "FirstName": "Albert",
    "LastName": "Einstein",
    "Address_ID": {
        "city": "Písek",
        "country": "",
        "countrycode": "CZ",
        "email": "{{Test_Email_Provozovny}}",
        "phonenumber1": "+420 777 666 777",
        "phonenumber2": "",
        "postcode": "39701",
        "recipient": "Honza Karel",
        "street": "Vladislavova 249",
        "zip": ""
    }
}
```

**22. Získání osoby** — GET `{{url}}/{{alias}}/Persons/39H0000101?select=*`

**23. Smazání osoby** — DELETE `{{url}}/{{alias}}/Persons/49H0000101`


## Definovatelné číselníky – e-shop modul (kategorie, vlastnosti, značky)

**24. Typy skladové karty** — GET `{{url}}/{{alias}}/StoreMenuItems?select=ID,text,X_StoreCardType_ID`

Příklad z konkrétní implementace. Číselník je použit v "Eshop - Typy skladové karty" pro určení vlastníka kategorie a z toho plynoucí vazby na další údaje.

**25. 1. Typ e-shopu** — GET `{{url}}/{{alias}}/FutureDealEshopType?select=ID,Code,Name`

Příklad z konkrétní implementace. Číselník je použit v "Eshop - Typy skladové karty" pro určení vlastníka kategorie a z toho plynoucí vazby na další údaje.

**26. 2. Eshop - typy sklad. karet (kategorie)** — GET `{{url}}/{{alias}}/StoreCardTypes?select=ID,Code,Name,X_ExternID,X_EshopType_ID&skip=0&take=100&where=X_EshopType_ID eq 'S1NB000101'`

Kategorie vlastností/parametrů.

**27. 3. Eshop - vlastnosti** — GET `{{url}}/{{alias}}/Properties?select=ID,Code,Name,X_ExternID,X_StoreCardType_ID&skip=0&take=100&where=X_StoreCardType_ID eq 'DGL3000101'`

Vlastnosti/parametry kategorie.

**28. 4. Eshop - hodnoty** — GET `{{url}}/{{alias}}/StoreCardRollValues?select=ID,Name as Hodnota,X_VALUE_CS as Name,X_Property_ID&skip=0&take=100`

Hodnoty vlastností/parametrů

**29. Eshop - Vlastnosti sklad. karet** — GET `{{url}}/{{alias}}/StoreCardProperties?select=ID,X_ROLLVALUE.X_VALUE_CS as Hodnota,X_Property_ID.Code,X_Property_ID.Name,X_STORECARDTYPE_ID,X_STORECARDTYPE_ID.Code,X_STORECARDTYPE_ID.Name,X_StoreCard_ID&where=X_StoreCard_ID eq 'GA00000101'`

Propojovací tabulka vlastností ke skladové kartě.

**30. Eshop - Limity poštovného (ID)** — GET `{{url}}/{{alias}}/PostalLimits?select=ID,Code,Name,X_Postal_Limit,X_Postal_value,X_Country_ID,X_Currency_ID,X_TransportationType_ID,X_Paymenttype_ID`

Získání seznamu kombinací poštovného pro země, měnu, způsob úhrady a celkovou cenu.

**31. Eshop - Značky** — GET `{{url}}/{{alias}}/MallBrands?select=ID,Code,Name&skip=0&take=100`

Příklad z konkrétní implementace. Vrácení seznamu značek produktů.
Pozor, číselník může obsahovat tisíce záznamů. Je vhodné použít listování.
Skladová karta byla rozšířena o pole s odkazem na brand.


## Sklady – disponibilní stav

**32. Disponibilní stav skladu** — POST `{{url}}/{{alias}}/query`

OrderQTY = Číselný údaj zahrnuje nevyřízené objednávky. Tedy takové, které dosud nejsou čerpány. Plus potvrzené objednávky, které se budou dříve nebo později expedovat, ale ještě neexistuje čerpání ze skladového dokladu.
Quantity = Aktuální stav skladu.

```json
{
  "class": "storesubcards",
  "select": [
    "storecard_id",
    "store_id",
    {
      "name": "OrderQTY",
      "value": {
        "class": "05CPMINJW3DL342X01C0CX3FCC",
        "select": [{ "name": "OrderQTY", "value": "Sum(Quantity) - Sum(DeliveredQuantity)" }],
        "where": "Storecard_ID eq :storecard_id and Store_ID eq :store_id and Quantity gt DeliveredQuantity and Parent_ID.Confirmed eq true and Parent_ID.Closed eq false"
      }
    },
    "Quantity"
  ],
  "where": "Store_id eq '{{Store_ID}}'"
}
```

**33. Disponibilní stav skladu - DynSQL (rychlé)** — POST `{{url}}/{{alias}}/script/eu.abra.API.Function/Stores/Stock_SETS`

Vstupní parametry jsou case sensitive:
Store_ID: ID obalujeme dvojitými uvozovkami, oddělené čárkou bez uvozovek. Nepovinný parametr.
StoreCard_ID: ID obalujeme dvojitými uvozovkami, oddělené čárkou bez uvozovek. Rovněž nepovinný parametr.
Výstupní parametr:
Quantity = Aktuální stav skladu - nedodané platné rezervace.

```json
{
     "Store_ID": "1000000101",
     "StoreCard_ID": "1200000101"
}
```

**34. Disponibilní stav skladu (ad-hoc dle ID karty)** — POST `{{url}}/{{alias}}/query`

OrderQTY = Údaj zahrnuje nevyřízené objednávky, které dosud nebyly čerpány ze skladového dokladu - včetně objednávek potvrzených, které se budou dříve nebo později expedovat, ale v tuto chvíli čerpání neexistuje.
Quantity = Aktuální stav skladu.

```json
{
  "class": "storesubcards",
  "select": [
    "storecard_id",
    "store_id",
    {
      "name": "OrderQTY",
      "value": {
        "class": "05CPMINJW3DL342X01C0CX3FCC",
        "select": [{ "name": "OrderQTY", "value": "Sum(Quantity) - Sum(DeliveredQuantity)" }],
        "where": "Storecard_ID eq :storecard_id and Store_ID eq :store_id and Quantity gt DeliveredQuantity and Parent_ID.Confirmed eq true and Parent_ID.Closed eq false"
      }
    },
    "Quantity"
  ],
  "where": "Store_id eq '{{Store_ID}}'  and (storecard_id in ('2700000101','1200000101','D200000101'))"
}
```


## Ceníky (Price Lists)

**35. Ceník funkce CSV - omezení dle jedné karty 20014 FROZEN 3D BAG ANNA AND ELSA** — POST `{{url}}/{{alias}}/qrexpr`

Návratové hodnoty:
STORECARD_ID CHAR(10), SLOUPEC 1
PRICE_ID CHAR(10), SLOUPEC 2
AMOUNT NUMERIC (15,3), SLOUPEC 3  cena vždy pro hlavní jednotku
PRICEWITHVAT char(1), SLOUPEC 4 A/N
Vstupy:
IN_FIRM_ID CHAR(10), id firmy, jinak null
IN_PRICELIST_ID CHAR(10), ID ceníku, který chcete načíst, pokud není, bere se z firmy, jinak NULL = základní
IN_PRICE_ID CHAR(10), id ceny, pokud není, bere se z firmy, jinak NULL = vše
IN_STORECARD_ID CHAR(10), ID skladové karty, pokud není, vrací se vše, pro co se najdou ceny v rámci ceníku
DOCDATE$date numeric (18,0)) aktuální v číselném formátu  ekvivalent current_date - cast('30.12.1899' as date)
Data se vracejí ve formátu base64.

```json
{
  "expr": "NxScript('eu.abra.API.Function.PriceLists.FxPriceListsCSV','','','','','11.12.2019')"
}
```

**36. Ceník - funkce QR** — POST `{{url}}/{{alias}}/qrexpr`

NxGetStoreCardUnitPriceDef
Syntaxe:
NxGetStoreCardUnitPriceDef(<Str1>:String, <Str2>:String, <Str3>:String, <Str4>:String, <Str5>:String, <Bool6>:Boolean, <Str7>:String, [<Num8>:Numeric], [<Str9>:String], [<Str10>:String], [<Bool11>:Boolean], [<Num12>:Numeric], [<Str13>:String]):Numeric
Popis:
Vrátí jednotkovou cenu v požadované měně s DPH nebo bez DPH pro zadanou skladovou kartu, sklad, jednotku, definici ceny a firmu:
<Str1> - ID firmy
<Str2> - ID skladu
<Str3> - ID skladové karty
<Str4> - ID definice ceny
<Str5> - jednotka (Pokud zadaná jednotka není na skladové kartě definovaná, je vrácena cena z jednotky hlavní.)
<Bool6> - True/False vrátit cenu s DPH nebo bez DPH
<Str7> - ID měny, ve které se má cena vrátit
Přepočet se provede k datu <Num8> - Datum platnosti ceny (Číslo nebo řetězec. Pokud není zadáno nebo je zadán prázdný řetězec, použije se aktuální datum.)
<Str9> - Název parametru, do kterého se má vrátit ID řádku ceny z ceníku (Hodnota parametru se zjistí pomocí funkce NxGetParamValue.)
<Str10> - Název parametru, do kterého se má vrátit pakovaný CLSID ceníku (pro odlišení použitého ceníku). Hodnota parametru se zjistí pomocí funkce NxGetParamValue.
<Bool11> - True/False aplikovat slevu přímo do výsledné ceny
<Num12> - Množství pro aplikace množstevní slevy (při aplikaci slev je povinný)
<Str13> - Název parametru, do kterého se má vrátit procento slevy
Příklady:
NxGetStoreCardUnitPriceDef(Firm_ID, Store_ID, StoreCard_ID, PriceDefinition_ID, StoreUnit_ID.Code, False, NxGetCompanyCurrencyID, Date)
NxGetStoreCardUnitPriceDef(NxGetFirmIDForName('Autosalon SuperCar s.r.o.'),'2100000101',ID,'1000000101',MainUnitCode,False,'0000CZK000',Date,'PRICEROWID','PRICELISTCLSID')
Hodnoty parametrů se zjistí pomocí funkce NxGetParamValue('PRICEROWID') a NxGetParamValue('PRICELISTCLSID').

```json
{
  "expr": "NxGetStoreCardUnitPriceDef('F011000000','2100000101','2J00000101','2100000101','mel',true,'0000CZK000');"
}
```

**37. Ceník - funkce QR bez definice ceny** — POST `{{url}}/{{alias}}/qrexpr`

NxGetStoreCardUnitPriceDef
Syntaxe:
NxGetStoreCardUnitPriceDef(<Str1>:String, <Str2>:String, <Str3>:String, <Str4>:String, <Str5>:String, <Bool6>:Boolean, <Str7>:String, [<Num8>:Numeric], [<Str9>:String], [<Str10>:String], [<Bool11>:Boolean], [<Num12>:Numeric], [<Str13>:String]):Numeric
Popis:
Vrátí jednotkovou cenu v požadované měně s DPH nebo bez DPH pro zadanou skladovou kartu, sklad, jednotku, definici ceny a firmu.
<Str1> - ID firmy
<Str2> - ID skladu
<Str3> - ID skladové karty
<Str4> - ID definice ceny
<Str5> - Jednotka. (Pokud zadaná jednotka není na skladové kartě definovaná, je vrácena cena z jednotky hlavní.)
<Bool6> - True/False vrátit cenu s DPH nebo bez DPH
<Str7> - ID měny, ve které se má cena vrátit.
Přepočet se provede k datu <Num8> - Datum platnosti ceny (Číslo nebo řetězec. Pokud není zadáno nebo je zadán prázdný řetězec, použije se aktuální datum.)
<Str9> - Jméno parametru, do kterého se má vrátit ID řádku ceny z ceníku. Hodnota parametru se zjistí pomocí funkce NxGetParamValue.
<Str10> - Jméno parametru, do kterého se má vrátit pakovaný CLSID ceníku (pro odlišení použitého ceníku). Hodnota parametru se zjistí pomocí funkce NxGetParamValue.
<Bool11> - True/False aplikovat slevu přímo do výsledné ceny
<Num12> - Množství pro aplikace množstevní slevy (při aplikaci slev je povinný)
<Str13> - Název parametru, do kterého se má vrátit procento slevy
Příklady:
NxGetStoreCardUnitPriceDef(Firm_ID, Store_ID, StoreCard_ID, PriceDefinition_ID, StoreUnit_ID.Code, False, NxGetCompanyCurrencyID, Date)
NxGetStoreCardUnitPriceDef(NxGetFirmIDForName('Autosalon SuperCar s.r.o.'),'2100000101',ID,'1000000101',MainUnitCode,False,'0000CZK000',Date,'PRICEROWID','PRICELISTCLSID')
Hodnoty parametrů se zjistí pomocí funkce NxGetParamValue('PRICEROWID') a NxGetParamValue('PRICELISTCLSID').

```json
{
  "expr": "NxGetStoreCardUnitPriceDef('','','Z100000101','1000000101','',true,'0000CZK000');"
}
```

**38. Získání seznamu definic cen** — GET `{{url}}/{{alias}}/PriceDefinitions`

Definice ceny viz Nápověda ABRA Gen.


## Zařazení skladové karty do menu

**39. Zařazení skladové karty do menu dle kódu** — POST `{{url}}/{{alias}}/query`

Vrátí seznam obsahující menu, ve kterém se vyskytuje skladová karta specifikovaná kódem uvedeným v požadavku (nicméně doporučujeme místo kódu používat ID - díky indexům bude zpracování požadavků rychlejší).

```json
{
    "class": "StoreCardMenuItemLinks",
    "select": [
        "StoreCard_ID", {
        	"class": "StoreMenuItem",	
            "name": "StoreMenuItem_ID",
            "value": {
                "select": [
                    "ID",
                    "Text",
                    "Fullpath"
                ]
            }
        }   
    ],
    "where": "StoreCard_ID.code = '{{Test_StoreCard_Code}}'"
}
```


## Číselníky a reference data (doklady, doprava, úhrady, období, střediska, sklady, karty, DPH, měny)

**40. Řady dokladů - Zálohové listy vydané** — GET `{{url}}/{{alias}}/docqueues?select=ID,Code&where=DocumentType eq 'RO'`

Vrácení řady dokladů dle typu dokladu. Podrobnější informace o řadách dokladů viz Nápověda ABRA Gen.
Výsledek může záviset na právech uživatele.

**41. Typy dokladů** — GET `{{url}}/{{alias}}/DocumentTypes?select=ID,Code,name`

Vrácení typu dokladu. Podrobnější informace o typech dokladů viz Nápověda ABRA Gen.

**42. Způsob dopravy** — GET `{{url}}/{{alias}}/TransportationTypes?select=ID,Code,name`

Získání způsobů dopravy. Podrobnější informace o způsobech dopravy viz Nápověda ABRA Gen.

**43. Způsob úhrady** — GET `{{url}}/{{alias}}/PaymentTypes?select=ID,Code,name,PaymentKind`

Získání způsobů úhrady. Podrobnější informace o způsobech úhrady viz Nápověda ABRA Gen.

**44. Období** — GET `{{url}}/{{alias}}/periods?select=ID,Code&where=code eq '2019'`

Získání ID období dle kódu období. Typicky bývá kód shodný s rokem. Například 2019. Podrobnější informace o obdobích viz Nápověda ABRA Gen.

**45. Období dle data** — GET `{{url}}/{{alias}}/periods?select=ID,Code&where=datefrom$date le timestamp'2019-12-31T23:49:00' and dateto$date gt timestamp'2019-12-31T23:49:00'`

Získání období z data. Typicky bývá kód shodný s rokem, například 2019.

**46. Střediska** — GET `{{url}}/{{alias}}/Divisions?select=ID,Code,Name`

Získání seznamu středisek. Podrobnější informace o střediscích viz Nápověda ABRA Gen.
Výsledek může být závislý na právech uživatele.

**47. Sklady** — GET `{{url}}/{{alias}}/Stores?select=ID,Code,Name`

Získání seznamu skladů. Podrobnější informace o skladech viz Nápověda ABRA Gen.
Výsledek může být závislý na právech uživatele.

**48. Skladové karty** — GET `{{url}}/{{alias}}/Storecards/5300000101`

Seznam skladových karet. Podrobnější informace ke skladovým kartám viz Nápověda ABRA Gen.

**49. Skladové karty (query)** — POST `{{url}}/{{alias}}/query?skip=0&take=20`

Získání seznamu skladových karet pomocí rozšířeného dotazování (query).

```json
{
    "class": "Storecards",
    "select": [
        "ID",
        "Code",
        "Name",
        "MainUnitCode",
        "VATRate_ID",
        "Note",
        "StoreMenuItem_ID",
        "correctedat$date",
        {
            "name": "StoreUnits",
            "value": {
                "select": [
                    "Code",
                    "UnitRate",
                    "Depth",
                    "Width",
                    "Height",
                    "SizeUnit",
                    
                    "EAN",
                    {
                        "name": "StoreEans",
                        "value": [
                            "EAN"
                        ]
                    }
                ]
            }
        },
        {
            "name": "VATRates",
            "value": {
                "select": [
                    "VATRate_ID",
                    "Country_ID"
                ]
            }
        }
        
        
    ],
    "where": "hidden='N' and correctedat$date gt timestamp'2020-04-09T12:11:23.835Z'   "
}
```

**50. EANy hledání s kódem skladové karty** — POST `{{url}}/{{alias}}/query`

Vyhledání skladové karty podle zadaného EAN.

```json
{
    "class": "INAGBOXEEW14ND0OFCQTJ5PH20",
    "select": [
        "EAN",
        "Parent_ID"
    ],
    "where": "EAN='{{Test_EAN}}'"
}
```

**51. Skladové menu** — GET `{{url}}/{{alias}}/StoreMenuItems`

Skladové menu obsahuje stromovou strukturu položek, strukturu určuje Parent_ID. Podrobnější informace ke skladovému menu viz Nápověda ABRA Gen.

**52. Skladové menu podle nadřazeného uzlu** — GET `{{url}}/{{alias}}/StoreMenuItems?where=parent_id eq '1250000101'`

**53. Skladové karty opravené po určitém čase - příklad 1** — GET `{{url}}/{{alias}}/StoreCards?skip=0&take=100&where=correctedat$date > timestamp'2020-04-09T14:32:11.135Z'`

Seznam skladových karet vyhovujících určité podmínce. Více informací o skladových kartách viz Nápověda ABRA Gen.

**54. Skladové karty zařazené do skladového menu** — GET `{{url}}/{{alias}}/StoreCardMenuItemLinks?select=ID,StoreCard_ID,StoreMenuItem_ID`

**55. DPH sazby podle země** — GET `{{url}}/{{alias}}/divisions?select=ID,Code,name&where=code eq '000'`

Získání sazeb DPH Nápověda ABRA Gen.

**56. Měny** — GET `{{url}}/{{alias}}/Currencies?select=ID,Code,name&where=code eq 'CZK'`

Získání seznamu měn Nápověda ABRA Gen.


## Objednávky přijaté (Received Orders) – založení a získání

**57. Založení Objednávky přijaté - tuzemsko** — POST `{{url}}/{{alias}}/receivedOrders?select=id`

Důležité upozornění: Jako datum dokladu je zapotřebí uvádět samotné datum (bez časové složky). Důvodem je mechanismus rezervací, který s tímto údajem pracuje a pokud by datum dokladu obsahovalo jiný čas než 00:00:00, došlo by k posunu rezervace o jeden den oproti očekávání.
Založení dokladu v ABRA Gen obecně vyžaduje nastavení položek navázaných na číselníky:

Řada dokladu
Období
Firma
Provozovna (nepovinné)
Měna
Způsob úhrady (nepovinné)
Způsob dopravy (nepovinné)
Vlastní bankovní účet (nepovinné)
Konstantní symbol (nepovinné)

```json
{
    
    "docqueue_id": "{{RO_docqueue_id}}",
    "period_id": "{{period_id}}",
    "FrozenDiscounts": true,
    "externalnumber": "ExterníČíslo",
    "firm_id": "{{firm_ID}}",
    "firmOffice_ID": "{{firmOffice_ID}}",
    "description": "Testovací, vlastní cena, zmražené slevy",
    "DocDate$DATE": "2019-10-01T00:00:00.000",
    "TradeType": 1,
    "Currency_ID": "0000CZK000",
    "Country_ID": "00000CZ000",
    "VATCountry_ID": "00000CZ000",
    "VATDocument": true,
    "PricesWithVAT": true,
    "VATFromAbovePrecision": 0,
    "VATFromAboveType": 0,
    "VATRounding": 0,
    "PaymentType_ID": "",
    "TransportationType_ID": "",
    "Rows": [
        {
            "DeliveryDate$DATE": "2019-10-02T00:00:00.000",
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepovinné",
            "RowType": 3,
            "StoreCard_ID": "{{StoreCard_ID}}",
            "Store_ID": "{{Store_ID}}",
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000"
        },
         {
            "DeliveryDate$DATE": "2019-10-02T00:00:00.000",
            "Division_ID": "{{Division_ID}}",
            "RowType": 0,
            "text":"Text na řádek"
        },
        {
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepovinné",
            "RowType": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000",
            "text":"Text na řádek"
        },
        {
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepovinné",
            "RowType": 2,
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000"
        }
    ]
}
```

**58. Založení Objednávky přijaté - tuzemsko, B2C** — POST `{{url}}/{{alias}}/receivedOrders?select=id`

```json
{
    "docqueue_id": "{{RO_docqueue_id}}",
    "period_id": "{{period_id}}",
    "FrozenDiscounts": true,
    "externalnumber": "ExterníČíslo",
    "firm_id": "{{firm_ID}}",
    "firmOffice_ID": "{{firmOffice_ID}}",
    "description": "Testovací, vlastní cena, zmrařené slevy",
    "DocDate$DATE": "2019-10-01T00:00:00.000",
    "TradeType": 1,
    "Currency_ID": "0000CZK000",
    "Country_ID": "00000CZ000",
    "VATCountry_ID": "00000CZ000",
    "VATDocument": true,
    "PricesWithVAT": true,
    "VATFromAbovePrecision": 4,
    "VATFromAboveType": 0,
    "VATRounding": 0,
    "Rows": [
        {
            "DeliveryDate$DATE": "2019-10-02T00:00:00.000",
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 3,
            "StoreCard_ID": "{{StoreCard_ID}}",
            "Store_ID": "{{Store_ID}}",
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000"
        },
         {
            "DeliveryDate$DATE": "2019-10-02T00:00:00.000",
            "Division_ID": "{{Division_ID}}",
            "RowType": 0,
            "text":"Text na řádek"
        },
        {
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000",
            "text":"Text na řádek"
        },
        {
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 2,
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000"
        }
    ]
}
```

**59. Založení Objednávky přijaté - dodání do SK (neplátcům DPH), přiznání v CZK** — POST `{{url}}/{{alias}}/receivedOrders?select=id`

```json
{
    "docqueue_id": "{{RO_docqueue_id}}",
    "period_id": "{{period_id}}",
    "FrozenDiscounts": true,
    "externalnumber": "ExterníČíslo",
    "firm_id": "{{firm_ID}}",
    "firmOffice_ID": "{{firmOffice_ID}}",
    "description": "Testovací, vlastní cena, zmrařené slevy",
    "DocDate$DATE": "2019-10-01T00:00:00.000",
    "TradeType": 4,
    "Currency_ID": "0000EUR000",
    "CurrRate": 23.5,
    "Country_ID": "00000SK000",
    "VATDocument": true,
    "PricesWithVAT": true,
    "VATFromAbovePrecision": 0,
    "VATFromAboveType": 0,
    "VATRounding": 0,
    "Rows": [
        {
            "DeliveryDate$DATE": "2019-10-02T00:00:00.000",
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 3,
            "StoreCard_ID": "{{StoreCard_ID}}",
            "Store_ID": "{{Store_ID}}",
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000"
        },
         {
            "DeliveryDate$DATE": "2019-10-02T00:00:00.000",
            "Division_ID": "{{Division_ID}}",
            "RowType": 0,
            "text":"Text na řádek"
        },
        {
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000",
            "text":"Text na řádek"
        },
        {
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 2,
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000"
        }
    ]
}
```

**60. Založení Objednávky přijaté - dodání do SK (plátcům DPH), osvobozeno** — POST `{{url}}/{{alias}}/receivedOrders?select=id`

```json
{
	
    "docqueue_id": "{{RO_docqueue_id}}",
    "period_id": "{{period_id}}",
    "FrozenDiscounts": true,
    "externalnumber": "ExterníČíslo",
    "firm_id": "{{firm_ID}}",
    "firmOffice_ID": "{{firmOffice_ID}}",
    "description": "Testovací, vlastní cena, zmrařené slevy",
    "DocDate$DATE": "2019-10-01T00:00:00.000",
    "TradeType": 2,
    "Currency_ID": "0000EUR000",
    "CurrRate": 23.5,
    "Country_ID": "00000SK000",
    "VATCountry_ID": "00000CZ000",
    "VATDocument": true,
    "PricesWithVAT": true,
    "VATFromAbovePrecision": 0,
    "VATFromAboveType": 0,
    "VATRounding": 0,
    "Rows": [
        {
            "DeliveryDate$DATE": "2019-10-02T00:00:00.000",
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 3,
            "StoreCard_ID": "{{StoreCard_ID}}",
            "Store_ID": "{{Store_ID}}",
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000"
        },
         {
            "DeliveryDate$DATE": "2019-10-02T00:00:00.000",
            "Division_ID": "{{Division_ID}}",
            "RowType": 0,
            "text":"Text na řádek"
        },
        {
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000",
            "text":"Text na řádek"
        },
        {
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 2,
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000"
        }
    ]
}
```

**61. Založení Objednávky přijaté - dodání do SK, přiznání v SK** — POST `{{url}}/{{alias}}/receivedOrders?select=id`

V jiné zemi EU se musíme registrovat k DPH v případě, že dodáváme zboží neplátcům DPH a překročíme limit pro registraci dané země.  Do limitů pro registraci v jiných členských státech EU se započítává pouze zboží, které jsme dodali osobám, pro které pořízení tohoto zboží není předmětem daně, tedy převážně běžným (nepodnikajícím) občanům.
Limity jednotlivých zemí najdeme v pokynech k přiznání k DPH.
DPH index na řádku je zapotřebí upravit dle potřeby.

```json
{
    "docqueue_id": "{{RO_docqueue_id}}",
    "period_id": "{{period_id}}",
    "FrozenDiscounts": true,
    "externalnumber": "ExterníČíslo",
    "firm_id": "{{firm_ID}}",
    "firmOffice_ID": "{{firmOffice_ID}}",
    "description": "Testovací, vlastní cena, zmrařené slevy",
    "DocDate$DATE": "2019-10-01T00:00:00.000",
    "TradeType": 5,
    "Currency_ID": "0000EUR000",
    "CurrRate": 23.5,
    "Country_ID": "00000SK000",
    "VATCountry_ID": "00000CZ000",
    "VATDocument": true,
    "PricesWithVAT": true,
    "VATFromAbovePrecision": 0,
    "VATFromAboveType": 0,
    "VATRounding": 0,
    "Rows": [
        {
            "DeliveryDate$DATE": "2019-10-02T00:00:00.000",
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 3,
            "StoreCard_ID": "{{StoreCard_ID}}",
            "Store_ID": "{{Store_ID}}",
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000"
        },
         {
            "DeliveryDate$DATE": "2019-10-02T00:00:00.000",
            "Division_ID": "{{Division_ID}}",
            "RowType": 0,
            "text":"Text na řádek"
        },
        {
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000",
            "text":"Text na řádek"
        },
        {
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepoviné",
            "RowType": 2,
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02100X0000"
        }
    ]
}
```

**62. Jednoduchý příklad pro založení objednávky přijaté s typem obchodu OSS** — POST `{{url}}/{{alias}}/receivedOrders?select=id,DisplayName`

V případě využívaní režimu OSS nebo IOSS je potřebné vytvořit registraci k danému režimu v agendě DPH registrace zemí EU. Následně je možné pomocí typu obchodu 7 – OSS a 8 – IOSS na výstupních dokladech vybírat použití těchto režimů.
DPH index na řádku je zapotřebí upravit dle potřeby.

```json
{
    "docqueue_id": "{{RO_docqueue_id}}",
    "period_id": "{{period_id}}",
    "FrozenDiscounts": true,
    "firm_id": "{{firm_ID}}",
    "firmOffice_ID": "{{firmOffice_ID}}",
    "description": "Testovací, vlastní cena, zmražené slevy",
    "DocDate$DATE": "2021-11-06T00:00:00.000",
    "TradeType": 7,
    "Currency_ID": "0000HUF000",
    "CurrRate": 23.5,
    "Country_ID": "00000HU000",
    "VATCountry_ID": "00000CZ000",
    "VATDocument": true,
    "PricesWithVAT": true,
    "VATFromAbovePrecision": 0,
    "VATFromAboveType": 0,
    "VATRounding": 0,
    "externalnumber": "ExterníČíslo",
    "Rows": [
        {
            "RowType": 3,
            "Store_ID": "{{Store_ID}}",
            "StoreCard_ID": "{{StoreCard_ID}}",
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "00500XHU00",
            "Division_ID": "{{Division_ID}}",
            "DeliveryDate$DATE": "2021-11-06T00:00:00.000",
            "ExternalNumber": "externíIDŘádkuNepovinné",
            "OSSSupplyType": "2"
        },
        {
            "RowType": 0,
            "Division_ID": "{{Division_ID}}",
            "text": "Text na řádek",
            "DeliveryDate$DATE": "2019-10-02T00:00:00.000"
        },
        {
            "RowType": 1,
            "text": "Text na řádek",
            "UnitPrice": 505,
            "VATRate_ID": "02700XHU00",
            "Division_ID": "{{Division_ID}}",
            "ExternalNumber": "externíIDŘádkuNepovinné",
            "OSSSupplyType": "1"
        },
        {
            "RowType": 2,
            "Text": "Radektyp2",
            "Division_ID": "{{Division_ID}}",
            "Quantity": 1,
            "UnitPrice": 505,
            "VATRate_ID": "02700XHU00",
            "ExternalNumber": "externíIDŘádkuNepovinné",
            "OSSSupplyType": "1"
        }
    ]
}
```

**63. Získání objednávky přijaté - podle ID** — GET `{{url}}/{{alias}}/receivedOrders/O400000101?select=*`


## Zálohové listy a ostatní příjmy (platby)

**64. Založení Zálohového listu importem z objednávky přijaté** — POST `{{url}}/{{alias}}/issueddepositinvoices/import/receivedorders/I9I5000101?select=ID`

Importní manažer je nástroj pro import dokladu určitého typu do dokladu jiného typu, viz Nápověda ABRA Gen.
Příklad úpravy výstupního dokladu prostřednictvím API, viz Nápověda ABRA Gen.

```json
{
	"params": {
		"docqueue_id": "{{10_docqueue_id}}"
	},
	"output_document_update": {
		"VarSymbol": "P600000101"
	}
}
```

**65. Oprava Zálohového listu, nastavení VS** — PUT `{{url}}/{{alias}}/issueddepositinvoices/6210000101?select=ID`

Editace záznamu vyžaduje uvedení ID v URL. V těle požadavku specifikujeme editovanou položku.

```json
{
	"VarSymbol":"102030"
}
```

**66. Založení ostatního příjmu jako platby zálohového listu** — POST `{{url}}/{{alias}}/otherincomes?select=ID`

Založení dokladu typu ostatní příjem, který je platbou jiného dokladu. Více informací o OSP: Nápověda ABRA Gen.
Poznámky k vybraným položkám:

PDocumentType: 10 = Zálohový list vydaný
PDocument_ID: ID dokladu, který je placený
Příznak elektronická platba ("ElectronicPayment"), viz Nápověda ABRA Gen

```json
{
	"docqueue_id": "{{01_docqueue_id}}",
	"period_id": "1200000101",
	"docdate$date": "2019-10-02T00:00:00.000",
	"firm_id": "{{firm_ID}}",
	"firmOffice_ID":"{{firmOffice_ID}}",
	"VATDocument": false,
	"PDocumentType": "10",
	"PDocument_ID": "{{10_docqueue_id}}",
	"EET": false,
	"rows": [
		{
		"TAmount": 500,
		"division_id": "{{Division_ID}}"
		}
	]
}
```

**67. Získání ostatního příjmu podle ID** — GET `{{url}}/{{alias}}/otherincomes?where=id eq '4200000101'&expand=rows(*)&select=*`


## Procesní řízení – stavy objednávek (order-state workflow)

**68. Procesní řízení - Procesní stavy** — GET `{{url}}/{{alias}}/PMStates/?select=id,code,description,sequencenumber,systemstate&where=clsid eq '01CPMINJW3DL342X01C0CX3FCC'`

Další informace k procesnímu řízení:

Metodická příručka
Online nápověda

**69. Procesní řízení - Přechody mezi procesními stavy** — GET `{{url}}/{{alias}}/PMStatesTransitions/?select=id,displayname&where=clsid eq '01CPMINJW3DL342X01C0CX3FCC'`

**70. Procesní řízení - Změna stavu objednávky** — PUT `{{url}}/{{alias}}/receivedOrders/2906000101/?select=id,PMState_ID.Code`

```json
{
	"pmstate_id": "2000000001"
}
```


## Soubory ve folderu skladové karty

**71. Získání stáří souborů ve folderu skladové karty** — POST `{{url}}/{{alias}}/qrexpr`

Získání dat o stáří souborů přiřazených ke skladové kartě (v kořenovém adresáři) ve formátu jpeg, jpg, png. Soubory jsou uloženy v adresářové struktuře propojené s kartou přes kód produktu.
Seznam je seřazen podle názvu. První obrázek je považován za hlavní. Správce obrázků může název souboru s hlavním obrázkem uvodit například znakem "_" a pořadí tak ovlivnit.
Pokud bude stáří souboru rozdílné od zadaného, zavoláte funkci pro získání odkazu.
Název skriptu:eu.abra.API.Function.Files
Název knihovny:FxFile_FileAge

```json
{
  "expr": "NxScript('eu.abra.API.Function.Files.FxFile_FilesAge','{{Test_StoreCard_Code}}')"
}
```

**72. Získání adresy souboru ve folderu skladové karty** — POST `{{url}}/{{alias}}/qrexpr`

Navrácení url adresy obsažených souborů (v adresáři thumbl) ve formátu jpeg, jpg, png. V případě, že je identifikován rozdíl stáří souborů v adresáři thumbl a v podřízené složce, pak dojde k dogenerování souborů adresáře thumbl (maximální rozměry 2000x2000, maximální velikost 1500 KB). Následně jsou vráceny adresy pro přístup k souborům.
Seznam je seřazen podle názvu. První obrázek je považován za hlavní. Správce obrázků může název souboru s hlavním obrázkem uvodit například znakem "_" a pořadí tak ovlivnit.
Pokud bude stáří souboru rozdílné od zadaného, zavoláte funkci pro získání odkazu.
Název skriptu:eu.abra.API.Function.Files
Název knihovny:FxFile_FilesAddress

```json
{
  "expr": "NxScript('eu.abra.API.Function.Files.FxFile_FilesAddress','{{Test_StoreCard_Code}}')"
}
```


## OpenAPI / Swagger endpoint

**73. OpenAPI** — GET `{{url}}/{{alias}}/api-docs/swagger.json?auth=QVBJOkFQSQ%3D%3D`

Open API je standardní definice Web API, pomocí níž je API podrobně popsáno, tj. jaké obsahuje zdroje (resources), jaké podporují metody atd.
Obsahuje také specifická pole přidaná uživatelem do ABRA Gen.
Více informací viz Nápověda ABRA Gen.
Heslo do API ve formátu uživatel:heslo převeďte na řetězec kódovaný v Base64 formátu pomocí nástroje base64encode.

Vstup: ABRA:API
Výstup: QUJSQTpBUEk=

Následně použijte ještě nástroj urlencoder pro převod na řetězec, který je možné použít v URL adrese.

Vstup: QUJSQTpBUEk=
Výstup: QUJSQTpBUEk%3D

URL adresu (http://.....) zadáte do nástroje Swagger-UI.


## Tiskové sestavy (reporty)

**74. Tisková sestava - jeden záznam** — GET `{{url}}/{{alias}}/receivedOrders/O400000101?select=id&report=9700000001`

Pozor na nutnost přidat Headers pro specifikaci výstupního formátu prostřednictvím Content negotiation:

Accept: application/pdf
Accept: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
Accept: text/csv

Alternativou je v URL doplnit za ID příponu, například:
..receivedOrders/4930000101.pdf?select=id&report=W400000001
vrátí sestavu s ID W400000001 (obsahující data z dokladu s ID 4930000101) ve formátu PDF.

**75. Tisková sestava - více záznamů** — GET `{{url}}/{{alias}}/receivedOrders?select=id&report=9700000001&where=id+eq+'O400000101'`


## Řádky dokladů a navazující doklady (objednávka → DL → FV)

**76. 1. Získání řádků objednávky přijaté podle ID** — GET `{{url}}/{{alias}}/receivedOrders/89D5000101/rows?select=id`

**77. 2. Získání řádků DL čerpajících doklad objednávky - podle ID řádku objednávky** — POST `{{url}}/{{alias}}/query`

Požadavek vrací řádky dodacích listů. Návratová hodnota ID může být použita pro získání vazby na fakturu vydanou.
Do ostrého provozu doporučujeme odstranit načítání .DisplayName. Jedná se o nepersistentní položku, jejíž sestavení a získání je pomalejší.
Provide_ID = Odkaz na doklad objednávky, podle kterého filtrujeme
ID = Řádek dodacího listu
ProvideRow_ID = Odkaz na řádek objednávky
DocumentType = 21 = Dodací list

```json
{
  "class": "0H0I5SAOS3DL3ACU03KIU0CLP4",
  "select": [
  	"ID",
  	"Parent_ID.DisplayName",
    "Provide_ID",
    "ProvideRow_ID",
    "ProvideRowType"
  ],
  "where": "ProvideRow_ID in ('GALF200101','FALF200101') and Parent_ID.DocumentType eq 21"
}
```

**78. 2b. Získání řádků DL čerpajících doklad objednávky - podle ID objednávky (nedoporučujeme)** — POST `{{url}}/{{alias}}/query`

```json
{
  "class": "0H0I5SAOS3DL3ACU03KIU0CLP4",
  "select": [
  	"ID",
  	"Parent_ID.DisplayName",
    "Provide_ID",
    "ProvideRow_ID",
    "ProvideRowType"
  ],
  "where": "Provide_ID eq '89D5000101' and Parent_ID.DocumentType eq 21"
}
```

**79. 3. Získání řádků FV čerpajících doklad dodacího listu** — POST `{{url}}/{{alias}}/query`

Požadavek vrací  faktury vydané s vazbou na řádky dokladu dodacího listu. Návratová hodnota Parent_ID se odkazuje na fakturu/faktury!
Do ostrého provozu doporučujeme odstranit načítání .DisplayName. Jedná se o nepersistentní položku, jejíž sestavení a získání je pomalejší.
Provide_ID = Odkaz na hlavičku dodacího listu
ID = Řádek faktury vydané
ProvideRow_ID = Odkaz na řádek dodacího listu

```json
{
  "class": "OBBDOKTWEFD13ACM03KIU0CLP4",
  "select": [
  	"ID",
  	"Parent_ID",
  	"Parent_ID.DisplayName",
    "Provide_ID",
    "ProvideRow_ID"
  ],
  "where": "ProvideRow_ID in ('KPD5000101','JPD5000101')"
}
```

