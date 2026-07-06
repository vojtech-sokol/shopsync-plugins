---
name: skill-builder
description: Create new Claude Code skills following official guidelines. Use when user asks to "create a skill", "build a skill", "make a new skill", or "new slash command".
metadata:
  author: Vojtech Sokol
  version: 1.0.0
---

# Skill Builder

Interactive guide for creating new skills. Follow these steps in order.

## Step 1: Gather Requirements

Ask the user:
1. What should the skill do? (purpose)
2. When should it trigger? (trigger phrases, context)
3. What reference material exists? (docs, schemas, APIs)
4. Where to place it? (`~/.claude/skills/` for personal, `.claude/skills/` for project)

## Step 2: Create Directory

```
skill-name/          # kebab-case, no spaces/underscores/capitals
├── SKILL.md          # Required - core instructions only
└── references/       # Optional - detailed docs, schemas, examples
```

CRITICAL rules:
- Folder name = kebab-case only
- File must be exactly `SKILL.md` (case-sensitive)
- No `README.md` inside the skill folder
- No "claude" or "anthropic" in the name

## Step 3: Write Frontmatter

```yaml
---
name: skill-name
description: What it does. Use when [trigger phrases].
metadata:
  author: Author Name
  version: 1.0.0
---
```

Description MUST include:
- WHAT it does (first sentence)
- WHEN to use it - be specific about trigger conditions:
  - Keywords user would say: `Use when user mentions "X" or asks to "Y"`
  - File/project context: `or works in project containing lib/some_lib/`
  - Combine both: `Use when user mentions "helios" and "inuvio", or works in project containing lib/helios_inuvio/`
- Under 1024 chars, no XML `< >`

## Step 4: Write Body

Keep SKILL.md **short and focused** (under 5,000 words, ideally much less). Move detailed docs, large schemas, code examples to `references/`.

Structure: Key concepts → References section linking all files in `references/`.

## Step 5: Validate

Run through `references/checklist.md` before finishing.

## References

Consult these while building:

- `references/guide-summary.md` - Full official guide summary with all rules and patterns
- `references/checklist.md` - Validation checklist for every skill
- `references/example-skill.md` - Template and anti-patterns
