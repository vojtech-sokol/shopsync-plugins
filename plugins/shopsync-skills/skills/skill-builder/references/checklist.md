# Skill Creation Checklist

Use this to validate every skill before finishing.

## Structure
- [ ] Folder named in kebab-case (no spaces, underscores, capitals)
- [ ] `SKILL.md` exists (exact case)
- [ ] No `README.md` inside the skill folder
- [ ] Reference docs in `references/` subdirectory
- [ ] Scripts (if any) in `scripts/` subdirectory
- [ ] Assets/templates (if any) in `assets/` subdirectory

## Frontmatter
- [ ] Opening and closing `---` delimiters
- [ ] `name` field: kebab-case, matches folder name
- [ ] `description` field includes WHAT it does AND WHEN to use it
- [ ] `description` includes trigger phrases users would actually say
- [ ] `description` under 1024 characters
- [ ] No XML angle brackets `< >` anywhere in frontmatter
- [ ] Name does not contain "claude" or "anthropic"
- [ ] `metadata` block with at least `author` and `version` (recommended)

## SKILL.md Body
- [ ] Under 5,000 words (ideally much shorter)
- [ ] Core instructions only - detailed docs moved to `references/`
- [ ] Critical information at the top, not buried
- [ ] References section links all files in `references/`
- [ ] Clear, actionable language (not vague)
- [ ] Specific, not generic

## References
- [ ] Each reference file has clear purpose
- [ ] Large documents (schemas, full API docs) in `references/`, not inline
- [ ] Code examples in `references/` if bulky
- [ ] All reference files linked from SKILL.md

## Quality
- [ ] Would trigger on obvious user requests
- [ ] Would trigger on paraphrased requests
- [ ] Would NOT trigger on unrelated topics
- [ ] Examples provided (inline or in references)
- [ ] Error handling / troubleshooting (inline or in references)
