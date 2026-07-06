# Upgates Categories XML Structure

Source: https://docs.upgates.com/import-export/xml/categories

- Root: `<CATEGORIES version="1.0">` containing `<CATEGORY>` elements
- Matching key on import: `<CODE>` (auto-generated if omitted on create)
- Language mutations via mandatory `language` attribute (ISO 639-1)

## CATEGORY element

### Identification & hierarchy
- `CODE` - matching key for updates
- `CATEGORY_ID` - unique id, used for tree positioning
- `PARENT_ID` - parent category id/code; special values: `1` = top menu, `2` = left menu, `3` = bottom menu
- `POSITION` - numeric order within parent
- `ACTIVE_YN`, `SHOW_IN_MENU_YN`

Import order matters: parent categories must exist (or appear earlier in file) before their children.

### Type
`TYPE` - one of: `homepage`, `news`, `url` (external link), `site`, `siteWithProducts`, `parametric`, `linkCategory`, `advisor`, `why-us`, `contact`, `manufacturers`, `contactMenu`

`TYPE_OF_ITEMS` - content source: `withoutSubcategories` (manually assigned products), `label` (products filtered by label/štítek), `manufacturer` (filtered by brand)

### Texts (per language)
- `DESCRIPTIONS` > `DESCRIPTION language="cs"` - name/title, description, URL
- `SEO_OPTIMALIZATION` - per-language SEO title/description/URL ending

### Other
- `IMAGES` / `FILES` - with position and per-language selection
- `CUSTOMER_GROUPS` - access restriction
- `METAS` - custom fields (`radio`, `checkbox`, `input`, `date`, `email`, `number`, `select`, `multiselect`, `textarea`, `formatted`)
