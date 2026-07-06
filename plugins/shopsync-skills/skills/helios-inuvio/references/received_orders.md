# Doporučený postup tvorby došlých objednávek v Helios Inuvio

Converted from: `doporučený postup tvorby došlých objednávek.doc`

## Uloženka na nové pořadové číslo došlé objednávky

```sql
ALTER PROCEDURE [dbo].[hp_DosleObj_PoradoveCislo]
    @Rada NVARCHAR(3),
    @DatumPripadu DATETIME OUT,
    @Cislo NVARCHAR(17) OUT,
    @ErrorCode INT OUT
```

| Parametr | Popis |
|---|---|
| @Rada | Řada dokladů došlých objednávek |
| @DatumPripadu | Datum případu došlé objednávky, NULL = aktuální datum |
| @Cislo | Návratový parametr pořadového čísla |
| @ErrorCode | Kód případné chyby |

## Uloženka na novou hlavičku došlé objednávky

Existují dvě varianty: `hp_DosleObj_NovaHlavicka01` a `hp_DosleObj_NovaHlavicka02` (pro různé typy objednávek).

```sql
ALTER PROCEDURE [dbo].[hp_DosleObj_NovaHlavicka01]
    @Rada NVARCHAR(3),
    @DatumPripadu DATETIME,
    @Cislo NVARCHAR(17),
    @Sklad NVARCHAR(30),
    @ErrorCode INT OUT,
    @ZpusobRET INT = 1,
    @CisloOrg INT = NULL
```

| Parametr | Popis |
|---|---|
| @Rada | Řada dokladů došlých objednávek |
| @DatumPripadu | Datum případu došlé objednávky |
| @Cislo | Číslo objednávky |
| @Sklad | Číslo skladu (beztečkové) |
| @ErrorCode | Kód případné chyby |
| @ZpusobRET | 1=Selectem/vše ostatní=zápis do DB |
| @CisloOrg | Číslo organizace |

Hodnota ID nově založené hlavičky je vrácena v direktivě RETURN volané procedury.

## Uloženka na novou položku došlé objednávky

Existují dvě varianty: `hp_DosleObj_NovaPolozka01` a `hp_DosleObj_NovaPolozka02`.

```sql
ALTER PROCEDURE [dbo].[hp_DosleObj_NovaPolozka01]
    @IdDoklad INT,
    @IdZboSklad INT,
    @BarCode NVARCHAR(50),
    @NewID INT OUT,
    @ErrorCode INT OUT,
    @ZpusobRET INT = 2,
    @PovolitDuplicitu BIT = 0,
    @PovolitBlokovane BIT = 0,
    @TypMnozstvi INT = NULL,
    @Mnozstvi NUMERIC(19,6) = NULL,
    @IDVyrobek INT = NULL,
    @StinJeVyrobek TINYINT = NULL,
    @PomerDV FLOAT = 1,
    @Cena NUMERIC(19,6) = NULL,
    @VstupniCena INT = NULL,
    @DotahovatSazbuDPH BIT = 1,
    @VnucenaSazbaDPH NUMERIC(5,2) = NULL,
    @VnucenaSazbaSD NUMERIC(19,6) = NULL
```

| Parametr | Popis |
|---|---|
| @IdDoklad | ID Hlavičky |
| @IdZboSklad | ID Skladové karty |
| @BarCode | Čárový kód |
| @NewID | ID vzniklé položky (OUT) |
| @ErrorCode | Kód případné chyby |
| @ZpusobRET | 1=Selectem/2=zápis do DB |
| @PovolitDuplicitu | Povolit duplicitní položku |
| @PovolitBlokovane | Povolit blokovanou položku |
| @TypMnozstvi | 0=množství obalu / 1=k dispozici / 2=na skladě / jiná hodnota=výchozí |
| @Mnozstvi | Zadávané množství (má přednost před TypMnozství) |
| @IDVyrobek, @StinJeVyrobek | Stínové položky: NULL,NULL/0=normální; NULL,1=výrobek do stínu; NOT NULL,(0,1)=dílec |
| @PomerDV | Poměr přepočtu množství dílce a výrobku |
| @Cena | Cena položky pro daný druh vstupní ceny, NULL = standardní cenotvorba |
| @VstupniCena | Druh vstupní ceny (viz VstupniCena tabulka níže) |
| @DotahovatSazbuDPH | 1=dotahovat sazbu DPH z kmene / 0=Ne |
| @VnucenaSazbaDPH | Požadovaná sazba DPH (DotahovatSazbuDPH musí být 0) |
| @VnucenaSazbaSD | Požadovaná sazba SD |

## Textová položka došlé objednávky

Pro položky, které nejsou na skladě (doprava, balné apod.):

```sql
ALTER PROCEDURE [dbo].[hp_DosleObj_NovaTxtPolozka01]
    @IDDoklad INT,
    @IDPolozky INT OUT,
    @ErrorCode INT OUT,
    @Cena NUMERIC(19,6) = NULL,
    @VstupniCena INT = NULL,
    @Popis NVARCHAR(255) = NULL,
    @SazbaDPH NUMERIC(5,2) = NULL,
    @Mnozstvi NUMERIC(19,6) = NULL,
    @MJ NVARCHAR(10) = NULL,
    @TypSlevy INT = 0,
    @Sleva NUMERIC(19,6) = 0
```

## Uloženka na změnu organizace

```sql
ALTER PROCEDURE [dbo].[hp_DosleObj_ZmenaOrganizace01]
    @IDDoklad INT,
    @CisloOrg INT,
    @ErrorCode INT OUT,
    @CoDelat INT = 1
```

@CoDelat: 1=Provede update a vrátí selectem / jiná hodnota=jen update. Přidá místo určení, příjemce, IDBankovního spojení a Konstantní symbol.

## Uloženka na změnu ceníku

```sql
ALTER PROCEDURE [dbo].[hp_DosleObj_ZmenaCeniku01]
    @IDDoklad INT,
    @IDCenik INT,
    @ErrorCode INT OUT,
    @Selectem BIT = 1
```

## Uloženka na přepočet množství a slev na položce

```sql
ALTER PROCEDURE [dbo].[hp_DosleObj_NastavSlevuMnozstviDPHPolozky01]
    @IDPolozka INT,
    @ErrorCode INT OUT,
    @ZmenaMnozstvi BIT,
    @NewMnozstvi NUMERIC(19,6),
    @ZmenaSozna BIT = 0,
    @NewSlevaSozna NUMERIC(5,2) = 0,
    @ZmenaSkupZbo BIT = 0,
    @NewSlevaSkupZbo NUMERIC(5,2) = 0,
    @ZmenaZboKmen BIT = 0,
    @NewSlevaZboKmen NUMERIC(5,2) = 0,
    @ZmenaZboSklad BIT = 0,
    @NewSlevaZboSklad NUMERIC(5,2) = 0,
    @ZmenaOrg BIT = 0,
    @NewSlevaOrg NUMERIC(5,2) = 0,
    @ZmenaTermin BIT = 0,
    @NewSlevaTermin NUMERIC(5,2) = 0,
    @ZmenaCastka BIT = 0,
    @NewSlevaCastka NUMERIC(19,6) = 0,
    @ZmenaDPH BIT = 0,
    @NewSazbaDPH NUMERIC(5,2) = NULL
```

Všechny parametry kromě @IDPolozka a @ErrorCode mají default, jsou nepovinné.

## Uloženka na změnu měny a kurzu

```sql
ALTER PROCEDURE [dbo].[hp_DosleObj_ZmenaMenaKurz01]
    @IDDoklad INT,
    @Mena NVARCHAR(3),
    @DatumKurzu DATETIME,
    @Kurz NUMERIC(19,6) = NULL,
    @JednotkaMeny INT = 1,
    @KurzEuro NUMERIC(19,6) = 0,
    @ErrorCode INT OUT,
    @CoDelat INT = 1
```

## Hodnoty VstupniCena

| Hodnota | Popis |
|---|---|
| 0 | JC bez daní (KC) |
| 1 | JC s DPH (KC) |
| 4 | JC bez daní valuty |
| 5 | JC s DPH valuty |
| 8 | JC se SD |
| 10 | JC se SD valuty |

## Typický postup vytvoření došlé objednávky

```sql
-- 1. Získat pořadové číslo
DECLARE @Cislo NVARCHAR(17), @DatPr DATETIME, @ErrCode INT
EXEC hp_DosleObj_PoradoveCislo @Rada='750', @DatumPripadu=@DatPr OUT, @Cislo=@Cislo OUT, @ErrorCode=@ErrCode OUT

-- 2. Vytvořit hlavičku
EXEC hp_DosleObj_NovaHlavicka02 @Rada='750', @DatumPripadu='2024-01-15', @Cislo=@Cislo, @ErrorCode=@ErrCode OUT, @Sklad='01000002', @ZpusobRet=0, @CisloOrg=12345

-- 3. Získat ID hlavičky
SELECT TOP 1 @ID = ID FROM TabDosleObjH02 WHERE CisloOrg=12345 AND Rada='750' AND Cislo=@Cislo ORDER BY ID DESC

-- 4. Upravit hlavičku (externí číslo, forma úhrady, doprava, poznámky)
UPDATE TabDosleObjH02 SET
    ExterniCislo='ORD-001',
    IDFormaUhrady=1,
    IDFormaDopravy=2,
    MistoUrceni='67890',
    VerejnaPoznamka2='Poznámka zákazníka'
WHERE ID=@ID

-- 5. Přidat skladové položky
EXEC hp_DosleObj_NovaPolozka02
    @IDDoklad=@ID, @IDZboSklad=@SklID, @BarCode=null,
    @NewID=null, @ErrorCode=@ErrCode OUT, @ZpusobRET=2,
    @PovolitDuplicitu=1, @PovolitBlokovane=1,
    @Mnozstvi=2, @Cena=100.00, @VstupniCena=1,
    @DotahovatSazbuDPH=0, @VnucenaSazbaDPH=21.00

-- 6. Resetovat slevy na položce
EXEC hp_DosleObj_NastavSlevuMnozstviDPHPolozky02
    @IDPolozka=@PolID, @ErrorCode=@ErrCode OUT,
    @ZmenaMnozstvi=0, @NewMnozstvi=0,
    @ZmenaSozna=1, @NewSlevaSozna=0,
    -- ... all discount types set to change=1, value=0

-- 7. Přidat textovou položku (doprava)
EXEC hp_DosleObj_NovaTxtPolozka02
    @IDDoklad=@ID, @IDPolozky=null, @ErrorCode=@ErrCode OUT,
    @Cena=99.00, @VstupniCena=1,
    @Popis='Doprava PPL', @SazbaDPH=21.00,
    @Mnozstvi=1, @MJ='ks', @TypSlevy=0, @Sleva=0

-- 8. Změna měny (pokud cizí měna)
EXEC hp_DosleObj_ZmenaMenaKurz02
    @IDDoklad=@ID, @Mena='EUR', @DatumKurzu='2024-01-15',
    @Kurz=null, @JednotkaMeny=1, @KurzEuro=0,
    @ErrorCode=@ErrCode OUT, @CoDelat=1
```

## Důležité poznámky

- Procedury existují v párech: `01` a `02` - odpovídají typům objednávek (TabDosleObjH01/H02, TabDosleObjR01/R02)
- IDZboSklad se získá z tabulky TabStavSkladu (JOIN s TabKmenZbozi na kód produktu)
- CisloOrg se získá z tabulky TabCisOrg
- Pro nalezení IDFormaUhrady a IDFormaDopravy je třeba podívat se do příslušných číselníků
