# shopsync-plugins

Claude Code plugin marketplace with dev helper skills for Czech ERP and e-shop integration development.

## Plugins

### shopsync-skills

Skills that give Claude Code detailed API references, PHP client patterns and data structures for:

| Skill | System |
|-------|--------|
| `pohoda` | Pohoda (Stormware) ERP — ODBC read + XML import |
| `money-s3` | Money S3 classic XML/COM integration + E-shop konektor |
| `moneys3-api` | Money S3 GraphQL S3 API |
| `moneys4-s5` | Money S4 / S5 — CSW_EObchod views + S5Data XML import |
| `abra-flexi` | ABRA Flexi (FlexiBee) REST API |
| `abra-gen` | ABRA Gen API |
| `helios-inuvio` | Helios Inuvio (Orange/Easy) ERP |
| `helios-nephrite` | Helios Nephrite ERP API |
| `shoptet-api` | Shoptet e-commerce API |
| `prestashop` | PrestaShop 8.1 database integration |
| `woocommerce` | WooCommerce — direct DB + REST API |
| `creativesites` | CREATIVE sites e-shop REST API |
| `base` | base / base.com (BaseLinker) marketplace hub API |
| `brani` | Brani (brani.cz) warehouse/fulfillment WMS API |
| `skill-builder` | Helper for creating new Claude Code skills |

## Install

```
/plugin marketplace add <github-user>/claude_plugin
/plugin install shopsync-skills@shopsync-plugins
```

## Update

```
/plugin marketplace update shopsync-plugins
```
