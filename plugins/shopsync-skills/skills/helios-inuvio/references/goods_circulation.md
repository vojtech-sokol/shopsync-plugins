# Import dokladů oběhu zboží v Helios Inuvio

Converted from: `Import dokladů oběhu zboží(metodologie).doc`

## Metodologie

Data pro import připravte tak, aby je bylo možno zpracovat v rámci uložené procedury MS SQL.

Postup při importu dokladů oběhu zboží do systému Helios Orange je založen na volání distribučních uložených procedur v následujícím pořadí:

1. `dbo.hp_InsertHlavickyOZ` - založení hlavičky dokladu
2. `dbo.hp_InsertPolozkyOZ` - import jednotlivých položek (spustit pro každou položku)
3. `dbo.hp_VypCenOZPolozek_IDDokladu` - výpočet cen dokladu

Nakonec vynutit spuštění triggeru pro tabulku TabDokladyZbozi:

```sql
UPDATE TabDokladyZbozi SET BlokovaniEditoru = NULL WHERE Id = @IdHlavicka;
```

## hp_InsertHlavickyOZ - Založení hlavičky dokladu

```sql
CREATE PROCEDURE [dbo].[hp_InsertHlavickyOZ]
    @Ident INT OUT,              -- ID vytvořené hlavičky
    @Sklad NVARCHAR(30),         -- pro Fa a Do je sklad ignorován
    @DruhPohybu TINYINT,
    @RadaDokladu NVARCHAR(3),
    @Insert BIT = 1,             -- 1: Insertem / 0: Selectem
    @IDPosta INT = NULL,
    @Mena NVARCHAR(3) = NULL,    -- NULL = dle řady nebo HM
    @CisloOrg INT = NULL,        -- NULL = z pošty
    @PC INT = NULL,              -- pořadové číslo, NULL = první volné
    @DatumPorizeni DATETIME = NULL  -- NULL = GETDATE()
```

| Parametr | Popis |
|---|---|
| @Sklad | Číslo skladu bez teček |
| @DruhPohybu | Typ pohybového dokladu (viz tabulka níže) |
| @RadaDokladu | Řada dokladu |
| @Insert | 1=INSERT přímo do tabulky / 0=vrátí SELECT |
| @IDPosta | ID pošty pro dohledání organizace, poznámky, data (vyžaduje modul Pošta) |
| @Mena | Kód měny, NULL=dle řady nebo domácí měna |
| @CisloOrg | Číslo organizace |
| @PC | Pořadové číslo dokladu, NULL=první volné |
| @DatumPorizeni | Datum pořízení, NULL=GETDATE(). Musí existovat otevřené globální období. |

### Hodnoty DruhPohybu

| Hodnota | Typ dokladu |
|---|---|
| 0 | Příjem na sklad |
| 1 | Storno příjmu |
| 2 | Výdej ze skladu |
| 3 | Storno výdeje |
| 4 | Výdej v evid. ceně |
| 6 | Objednávka |
| **9** | **Expediční příkaz** |
| 10 | Rezervace |
| 11 | Nabídka |
| 13 | Faktura vydaná |
| 14 | Dobropis vydaný |
| 18 | Faktura přijatá |
| 19 | Dobropis přijatý |

## hp_InsertPolozkyOZ - Import položek

```sql
CREATE PROC [dbo].[hp_InsertPolozkyOZ]
    @IDENT INT OUT,                          -- 1. ID vytvořené položky
    @IDDoklad INT,                           -- 2. ID hlavičky
    @DruhPohybu INT,                         -- 3. druh pohybu zboží
    @CisloOrg INT,                           -- 4. organizace pro hlídání a cenotvorbu
    @IDZboSklad INT,                         -- 5. skladová karta
    @Mena NVARCHAR(3),                       -- 6. měna dle hlavičky
    @Kurz NUMERIC(19,6),                     -- 7. kurz dle hlavičky
    @JednotkaMeny INT,                       -- 8. jednotka měny
    @KurzEuro NUMERIC(19,6),                 -- 9. kurz euro
    @SazbaSD NUMERIC(19,6),                  -- 10. sazba spotřební daně
    @SazbaDPH NUMERIC(19,6),                 -- 11. sazba DPH
    @ZakazanoDPH TINYINT,                    -- 12. zakázané plnění DPH
    @VstupniCena INT,                        -- 13. druh vstupní ceny
    @Kolik INT = NULL,                       -- 14. NULL=0ks, 0=1ks, 1=k dispozici, 2=množství
    @PovolitDuplicitu BIT = 0,               -- 15.
    @PovolitBlokovane BIT = 0,               -- 16.
    @Mnozstvi NUMERIC(19,6) = NULL,          -- 17. množství položky
    @IDObalovanePolozky INT = NULL,           -- 18.
    @Selectem BIT = 0,                       -- 19. 0=INSERT / 1=SELECT
    @JCbezDaniKC NUMERIC(19,6) = 0,          -- 20. stanovená cena (JC bez daně v Kč)
    @VstupniCenaProPrepocet INT = NULL,       -- 21. NULL=standardní cenotvorba / 0=vlastní cena
    @DotahovatSazby BIT = 1,                 -- 22. 1=sazby z kmene / 0=z parametrů
    @SlevaDokladu NUMERIC(19,6) = NULL,       -- 23. sleva v procentech
    @Nabidka INT = NULL,                     -- 24.
    @DatPorizeni DATETIME = NULL,             -- 25. datum pořízení položky
    @MJ NVARCHAR(10) = NULL,                 -- 26. množstevní jednotka
    @HlidanoProOrg BIT = 0,                  -- 27.
    @OrgProCeny INT = NULL,                  -- 28. odlišná organizace pro cenotvorbu
    @IDOZTxtPol INT = NULL                   -- 29. kolekce zboží na dokladu
```

### Důležité parametry pro zadávání vlastní ceny

- Pokud **znáte cenu**: @JCbezDaniKC = vaše cena, @VstupniCenaProPrepocet = 0, @VstupniCena = 0
- Pokud **chcete standardní cenotvorbu**: @JCbezDaniKC = 0, @VstupniCenaProPrepocet = NULL

### Hodnoty VstupniCena

| Hodnota | Popis |
|---|---|
| 0 | JC bez daní |
| 1 | JC s DPH |
| 4 | JC bez daní valuty |
| 5 | JC s DPH valuty |
| 8 | JC se SD |
| 10 | JC se SD valuty |

### Hodnoty ZakazanoDPH

| Hodnota | Popis |
|---|---|
| 0 | DPH povoleno |
| 1 | DPH zakázáno |
| 2 | DPH = 0 |

## hp_VypCenOZPolozek_IDDokladu - Výpočet cen

```sql
CREATE PROCEDURE [dbo].[hp_VypCenOZPolozek_IDDokladu]
    @IDDoklad INT,
    @AktualizaceSlev BIT
```

| Parametr | Popis |
|---|---|
| @IDDoklad | ID hlavičky dokladu |
| @AktualizaceSlev | 1=uplatnit slevy / 0=bez slev |

## Poznámka: #TabTempUziv

Pokud skript spouštíte **mimo prostředí HeO** (přímo na serveru nebo jako HQL/HQ1), musíte nejdříve vytvořit dočasnou tabulku:

```sql
IF OBJECT_ID('tempdb..#TabTempUziv') IS NULL
BEGIN
    CREATE TABLE #TabTempUziv(
        [Tabulka] [varchar](255) NOT NULL,
        [SCOPE_IDENTITY] [int] NULL,
        [Datum] [datetime] NULL
    )
END;
```

## Typický postup vytvoření expedičního příkazu

```sql
-- 0. Vytvořit temp tabulku (pokud mimo HeO)
IF OBJECT_ID('tempdb..#TabTempUziv') IS NULL
BEGIN
    CREATE TABLE #TabTempUziv([Tabulka] varchar(255) NOT NULL, [SCOPE_IDENTITY] int NULL, [Datum] datetime NULL)
END;

-- 1. Založit hlavičku
DECLARE @IdHlavicka INT
EXEC hp_InsertHlavickyOZ
    @Ident=@IdHlavicka OUT,
    @Sklad='01000002',
    @DruhPohybu=9,          -- Expediční příkaz
    @RadaDokladu='EP1',
    @Insert=1,
    @Mena='CZK',
    @CisloOrg=12345,
    @DatumPorizeni='2024-01-15'

-- 2. Přidat položky
DECLARE @IdPolozka INT
EXEC hp_InsertPolozkyOZ
    @IDENT=@IdPolozka OUT,
    @IDDoklad=@IdHlavicka,
    @DruhPohybu=9,
    @CisloOrg=12345,
    @IDZboSklad=@SklID,
    @Mena='CZK', @Kurz=1, @JednotkaMeny=1, @KurzEuro=0,
    @SazbaSD=0, @SazbaDPH=21.00, @ZakazanoDPH=0,
    @VstupniCena=0,
    @PovolitDuplicitu=1,
    @Mnozstvi=2,
    @JCbezDaniKC=100.00,
    @VstupniCenaProPrepocet=0,
    @DotahovatSazby=0

-- 3. Přepočítat ceny
EXEC hp_VypCenOZPolozek_IDDokladu @IDDoklad=@IdHlavicka, @AktualizaceSlev=1

-- 4. Vynutit trigger
UPDATE TabDokladyZbozi SET BlokovaniEditoru = NULL WHERE Id = @IdHlavicka;
```

## Srovnání: Došlé objednávky vs Expediční příkazy

| Aspekt | Došlé objednávky (TabDosleObj) | Expediční příkazy (TabDokladyZbozi) |
|---|---|---|
| Tabulka hlavičky | TabDosleObjH01 / TabDosleObjH02 | TabDokladyZbozi |
| Tabulka položek | TabDosleObjR01 / TabDosleObjR02 | TabPohybyZbozi |
| Procedura hlavičky | hp_DosleObj_NovaHlavicka0{typ} | hp_InsertHlavickyOZ |
| Procedura položky | hp_DosleObj_NovaPolozka0{typ} | hp_InsertPolozkyOZ |
| Přepočet cen | hp_DosleObj_PrepocetPolozek0{typ} | hp_VypCenOZPolozek_IDDokladu |
| DruhPohybu | N/A (typ je v názvu tabulky) | 9 = expediční příkaz |
| Trigger po dokončení | Není potřeba | UPDATE TabDokladyZbozi SET BlokovaniEditoru=NULL |
| #TabTempUziv | Není potřeba | Vyžaduje mimo HeO |
| Typické použití | E-shop objednávky → ERP | ERP → expedice/fakturace |
