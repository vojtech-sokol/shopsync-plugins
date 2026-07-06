# Example: Well-Structured Skill

This is a template showing the correct form for a skill.

## Directory Structure

```
my-skill-name/
├── SKILL.md
└── references/
    ├── detailed-docs.md
    └── examples.md
```

## Example SKILL.md

```yaml
---
name: my-skill-name
description: Brief what-it-does. Use when user asks to [trigger phrase 1], [trigger phrase 2], or works with [relevant context].
metadata:
  author: Your Name
  version: 1.0.0
---
```

```markdown
# My Skill Name

One sentence overview.

## Instructions

- Key concept 1
- Key concept 2
- Key concept 3

## References

Consult these for details:

- `references/detailed-docs.md` - Full documentation
- `references/examples.md` - Code examples and patterns
```

## Anti-Patterns to Avoid

### Too much in SKILL.md
```markdown
# BAD: 2000 lines of documentation, code examples, full API reference all inline
```
Fix: Move to `references/`.

### Vague description
```yaml
# BAD
description: Helps with stuff.
```
Fix: Be specific about WHAT and WHEN.

### Missing trigger phrases
```yaml
# BAD
description: Advanced workflow automation system for enterprise data pipelines.
```
Fix: Add "Use when user asks to...", "Use when working with..."

### README.md in skill folder
```
# BAD
my-skill/
├── SKILL.md
├── README.md    # <-- don't do this
```

### Wrong naming
```
# BAD
My Cool Skill/       # spaces, capitals
my_cool_skill/       # underscores
```
