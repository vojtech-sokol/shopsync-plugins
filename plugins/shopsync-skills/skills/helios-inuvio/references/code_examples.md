# Helios Inuvio - ShopSync Code Examples

## Reading products from Helios
```php
$this->con = odbc_connect(set_pohoda_db, getSqlUid(), getSqlPwd());
$res = odbc_exec($this->con, "SELECT * FROM TabKmenZbozi AS p
    JOIN TabKmenZbozi_EXT AS p2 ON p.ID = p2.ID
    LEFT JOIN TabCisOrg AS v ON v.CisloOrg = p.Vyrobce
    WHERE p.DatZmeny > '[last]'");
```

## Getting available stock
```php
$res = odbc_exec($this->con, "SELECT SUM(Mnozstvi - MnozNaDObjKVyrizeni - MnozNaGPrUMZKVyrizeni - MnozZPrKVazKVyrizeni) AS cnt
    FROM TabStavSkladu WHERE IDKmenZbozi = $id AND IDSklad = '$store'");
```

## Creating a received order (full flow)
```php
// 1. Get next number
odbc_exec($con, "DECLARE @Cislo VARCHAR(10)
    EXEC hp_DosleObj_PoradoveCislo @Rada='$rada', @DatumPripadu='$date', @Cislo=@Cislo OUTPUT, @ErrorCode=''
    SELECT @Cislo AS Result");

// 2. Create header
odbc_exec($con, "EXEC hp_DosleObj_NovaHlavicka02 @Rada='$rada', @DatumPripadu='$date', @Cislo='$cislo', @ErrorCode='', @Sklad='$store', @ZpusobRet=0, @CisloOrg=$cisloOrg");

// 3. Find header ID
$id = "SELECT TOP 1 ID FROM TabDosleObjH02 WHERE CisloOrg=$cisloOrg AND Rada='$rada' AND Cislo='$cislo' ORDER BY ID DESC";

// 4. Update header fields
odbc_exec($con, "UPDATE TabDosleObjH02 SET ExterniCislo='$number', IDFormaUhrady=$payment, MistoUrceni='$deliveryCisloOrg' WHERE ID=$id");

// 5. Add stock items
odbc_exec($con, "EXEC hp_DosleObj_NovaPolozka02 @IDDoklad=$id, @IDZboSklad=$sklId, @BarCode=null,
    @NewID=null, @ErrorCode=null, @ZpusobRET=2,
    @PovolitDuplicitu=1, @PovolitBlokovane=1,
    @Mnozstvi='$qty', @Cena='$price', @VstupniCena=$priceType,
    @DotahovatSazbuDPH=0, @VnucenaSazbaDPH='$vatRate'");

// 6. Add text items (shipping, etc.)
odbc_exec($con, "EXEC hp_DosleObj_NovaTxtPolozka02 @IDDoklad=$id, @IDPolozky=null, @ErrorCode=null,
    @Cena='$price', @VstupniCena=$priceType,
    @Popis='$name', @SazbaDPH='$vat',
    @Mnozstvi='$qty', @MJ='ks', @TypSlevy=0, @Sleva=0");

// 7. Reset discounts on item
odbc_exec($con, "EXEC hp_DosleObj_NastavSlevuMnozstviDPHPolozky02
    @IDPolozka=$polId, @ErrorCode=null,
    @ZmenaMnozstvi=0, @NewMnozstvi=0,
    @ZmenaSozna=1, @NewSlevaSozna=0,
    @ZmenaSkupZbo=1, @NewSlevaSkupZbo=0,
    @ZmenaZboKmen=1, @NewSlevaZboKmen=0,
    @ZmenaZboSklad=1, @NewSlevaZboSklad=0,
    @ZmenaOrg=1, @NewSlevaOrg=0,
    @ZmenaTermin=1, @NewSlevaTermin=0,
    @ZmenaCastka=1, @NewSlevaCastka=0,
    @ZmenaDPH=0, @NewSazbaDPH=0");

// 8. Foreign currency (if needed)
odbc_exec($con, "EXEC hp_DosleObj_ZmenaMenaKurz02
    @IDDoklad=$id, @Mena='$currency', @DatumKurzu='$date',
    @Kurz=null, @JednotkaMeny=1, @KurzEuro=0,
    @ErrorCode=null, @CoDelat=1");
```

## Creating a customer (TabCisOrg)
```php
// Insert organization
odbc_exec($con, "INSERT INTO TabCisOrg
    (CisloOrg, Nazev, Misto, IdZeme, Ulice, PSC, ICO, DIC, JeOdberatel, Fakturacni, CenovaUroven, Mena, PravniForma, Jmeno, Prijmeni)
    VALUES
    ((SELECT MAX(CisloOrg)+1 FROM TabCisOrg WHERE CisloOrg<9999999999),
    '$company', '$city', '$country', '$street', '$postcode', '$ico', '$dic',
    1, 1, 1, '$currency', '$pravniForma', '$firstname', '$lastname')");

// Add contacts
odbc_exec($con, "INSERT INTO TabKontakty (IDOrg, Druh, Spojeni) VALUES ($aid, 2, '$phone')");  // phone
odbc_exec($con, "INSERT INTO TabKontakty (IDOrg, Druh, Spojeni) VALUES ($aid, 6, '$email')");  // email
```
