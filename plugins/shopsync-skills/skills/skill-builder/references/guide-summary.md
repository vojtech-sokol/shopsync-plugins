# The Complete Guide to Building Skills for Claude - Summary

Source: https://resources.anthropic.com/hubfs/The-Complete-Guide-to-Building-Skill-for-Claude.pdf

## What is a Skill?

A folder containing:
- `SKILL.md` (required) - Instructions in Markdown with YAML frontmatter
- `scripts/` (optional) - Executable code (Python, Bash, etc.)
- `references/` (optional) - Documentation loaded as needed
- `assets/` (optional) - Templates, fonts, icons used in output

## Progressive Disclosure (Three Levels)

1. **YAML frontmatter** - Always loaded in system prompt. Just enough for Claude to know when to use it.
2. **SKILL.md body** - Loaded when Claude thinks the skill is relevant. Full instructions.
3. **Linked files** - Additional files in the skill directory, loaded only as needed.

## Critical Rules

### SKILL.md naming
- Must be exactly `SKILL.md` (case-sensitive)
- No variations (SKILL.MD, skill.md, etc.)

### Folder naming
- Use kebab-case: `notion-project-setup`
- No spaces, underscores, or capitals

### No README.md
- Don't include README.md inside the skill folder
- All documentation goes in SKILL.md or `references/`

## YAML Frontmatter

### Required fields

```yaml
---
name: skill-name-in-kebab-case
description: What it does and when to use it. Include specific trigger phrases.
---
```

### name
- kebab-case only, no spaces or capitals
- Should match folder name

### description
- MUST include BOTH: what it does AND when to use it (trigger conditions)
- Under 1024 characters
- No XML tags (< or >)
- Include specific tasks users might say
- Mention file types if relevant

### Optional fields

```yaml
license: MIT
compatibility: "Requires network access, Python 3.10+"
metadata:
  author: Company Name
  version: 1.0.0
  mcp-server: server-name
  category: productivity
  tags: [project-management, automation]
```

Other optional fields:
- `allowed-tools` - Restrict tool access (e.g., `"Bash(python:*) WebFetch"`)
- `disable-model-invocation` - true = only user can invoke (for side-effect workflows)
- `user-invocable` - false = only Claude can invoke (background knowledge)
- `context` - `fork` = run in isolated subagent
- `agent` - Subagent type when context: fork
- `paths` - Glob patterns to limit when skill activates
- `argument-hint` - Autocomplete hint (e.g., `[issue-number]`)

### Security restrictions
- No XML angle brackets (< >) in frontmatter
- No "claude" or "anthropic" in skill name (reserved)

## Description Field - The Most Important Part

Structure: `[What it does] + [When to use it] + [Key capabilities]`

Good examples:
```yaml
# Good - specific and actionable
description: Analyzes Figma design files and generates developer handoff documentation. Use when user uploads .fig files, asks for "design specs", "component documentation", or "design-to-code handoff".

# Good - includes trigger phrases
description: Manages Linear project workflows including sprint planning, task creation, and status tracking. Use when user mentions "sprint", "Linear tasks", "project planning", or asks to "create tickets".
```

Best pattern - keyword + project context triggers:
```yaml
# Keyword triggers + file path context
description: Helios Inuvio (Orange/Easy) ERP - tables, stored procedures, order import. Use when user mentions "helios" and "inuvio" or "easy" in same prompt, or works in project containing `lib/helios_inuvio/`.

# Keyword triggers only
description: Create new Claude Code skills following official guidelines. Use when user asks to "create a skill", "build a skill", "make a new skill", or "new slash command".
```

Bad examples:
```yaml
# Too vague
description: Helps with projects.

# Missing triggers
description: Creates sophisticated multi-page documentation systems.

# Too technical, no user triggers
description: Implements the Project entity model with hierarchical relationships.
```

## SKILL.md Body - Recommended Structure

```markdown
---
name: your-skill
description: [...]
---

# Your Skill Name

## Instructions
### Step 1: [First Major Step]
Clear explanation of what happens.

### Step 2: [Next Step]
...

## Examples
### Example 1: [common scenario]
User says: "..."
Actions: 1. ... 2. ...
Result: ...

## Troubleshooting
### Error: [Common error message]
Cause: [Why]
Solution: [How to fix]
```

## Best Practices

### Be specific and actionable
Good: `Run python scripts/validate.py --input {filename}` with expected output.
Bad: `Validate the data before proceeding.`

### Reference bundled resources clearly
```markdown
Before writing queries, consult `references/api-patterns.md` for rate limiting, pagination, error codes.
```

### Use progressive disclosure
Keep SKILL.md focused on core instructions. Move detailed documentation to `references/`.

### Keep SKILL.md under 5,000 words
Move large docs, schemas, examples to `references/`.

### Instructions not followed?
Common causes:
1. Too verbose - use bullet points, move detail to references
2. Critical instructions buried - put important things at top
3. Ambiguous language - be specific, use CRITICAL: headers
4. For critical validations, consider bundling scripts instead of language instructions

## Three Skill Categories

### Category 1: Document & Asset Creation
Creating consistent output (docs, designs, code). Techniques: style guides, templates, quality checklists.

### Category 2: Workflow Automation
Multi-step processes. Techniques: step-by-step with validation gates, templates, review loops.

### Category 3: MCP Enhancement
Workflow guidance on top of MCP tool access. Techniques: coordinate MCP calls, embed domain expertise, error handling.

## Common Patterns

### Pattern 1: Sequential Workflow
Multi-step in specific order. Explicit dependencies, validation at each stage, rollback for failures.

### Pattern 2: Multi-MCP Coordination
Workflows spanning services. Phase separation, data passing between MCPs, validation before next phase.

### Pattern 3: Iterative Refinement
Output improves with iteration. Quality criteria, validation scripts, know when to stop.

### Pattern 4: Context-Aware Tool Selection
Same outcome, different tools depending on context. Decision trees, fallbacks, transparency.

### Pattern 5: Domain-Specific Intelligence
Specialized knowledge beyond tool access. Domain expertise in logic, compliance checks, audit trails.

## Testing Checklist

### Before upload
- [ ] Folder named in kebab-case
- [ ] SKILL.md exists (exact spelling)
- [ ] YAML frontmatter has `---` delimiters
- [ ] name field: kebab-case, no spaces, no capitals
- [ ] description includes WHAT and WHEN
- [ ] No XML tags (< >) anywhere
- [ ] Instructions are clear and actionable
- [ ] Error handling included
- [ ] Examples provided
- [ ] References clearly linked

### Triggering tests
- [ ] Triggers on obvious tasks
- [ ] Triggers on paraphrased requests
- [ ] Doesn't trigger on unrelated topics
