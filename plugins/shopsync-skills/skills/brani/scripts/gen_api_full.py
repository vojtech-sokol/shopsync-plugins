# Regenerates references/api-full/*.md from the live Brani OpenAPI spec.
# Usage: python gen_api_full.py [path-to-openapi.json]
# Without an argument it downloads https://api.brani.cz/openapi.json.
import json, os, re, sys, ssl, urllib.request

HERE = os.path.dirname(os.path.abspath(__file__))
OUT = os.path.join(HERE, '..', 'references', 'api-full')

if len(sys.argv) > 1:
    SPEC = json.load(open(sys.argv[1], encoding='utf-8'))
else:
    ctx = ssl.create_default_context()
    with urllib.request.urlopen('https://api.brani.cz/openapi.json', context=ctx) as r:
        SPEC = json.load(r)

os.makedirs(OUT, exist_ok=True)
S = SPEC['components']['schemas']

TAG_FILES = {
    'Nákupní seznamy': ('autoorder.md', 'Autoorder / nákupní seznamy'),
    'Brani Balič': ('balic.md', 'Brani Balič (packing)'),
    'Brani sklad': ('stock.md', 'Brani sklad (stock, movement documents, inventura, purchase orders)'),
    'Brani sprava produktu': ('products.md', 'Products (snapshots, single product CRUD)'),
    'Dopravci': ('carriers.md', 'Carriers (dopravci)'),
    'Custom produkty': ('custom-products.md', 'Custom products'),
    'Objednávky': ('orders.md', 'Orders (upsert, invoices, tags, priority, customs)'),
    'Digitální produkty': ('digital-products.md', 'Digital products'),
    'Brani výroba': ('manufacture.md', 'Manufacture (recipes, orders, log)'),
    'Eshop info': ('eshop-info.md', 'Eshop info'),
    'Webhooky': ('webhooks.md', 'Webhooks'),
}

def ref_name(r):
    return r.split('/')[-1]

def type_str(p):
    if '$ref' in p:
        return ref_name(p['$ref'])
    if 'anyOf' in p:
        return ' | '.join(type_str(a) for a in p['anyOf'])
    t = p.get('type', 'any')
    if t == 'array':
        return 'array of ' + type_str(p.get('items', {}))
    return t

def collect_refs(obj, acc):
    if isinstance(obj, dict):
        for k, v in obj.items():
            if k == '$ref':
                name = ref_name(v)
                if name not in acc:
                    acc.add(name)
                    collect_refs(S.get(name, {}), acc)
            else:
                collect_refs(v, acc)
    elif isinstance(obj, list):
        for v in obj:
            collect_refs(v, acc)

def clean(s):
    if not s:
        return ''
    return re.sub(r'\s+', ' ', str(s)).strip()

def schema_md(name):
    sch = S.get(name)
    if sch is None:
        return f'### {name}\n(not found)\n'
    lines = [f'### {name}']
    if sch.get('description'):
        lines.append(clean(sch['description']))
    if 'enum' in sch:
        lines.append('Enum: ' + ', '.join(f'`{v}`' for v in sch['enum']))
    props = sch.get('properties')
    if props:
        req = set(sch.get('required', []))
        lines.append('')
        lines.append('| Field | Type | Req | Notes |')
        lines.append('|---|---|---|---|')
        for prop, p in props.items():
            notes = []
            if 'enum' in p:
                notes.append('enum: ' + ', '.join(map(str, p['enum'])))
            for a in p.get('anyOf', []):
                if 'enum' in a:
                    notes.append('enum: ' + ', '.join(map(str, a['enum'])))
            if 'default' in p:
                notes.append(f"default `{json.dumps(p['default'], ensure_ascii=False)}`")
            if 'pattern' in p:
                notes.append(f"pattern `{p['pattern']}`")
            desc = clean(p.get('description') or '')
            if not desc and clean(p.get('title', '')).lower() != prop.lower():
                desc = clean(p.get('title') or '')
            if desc:
                notes.append(desc[:300])
            if 'examples' in p and p['examples']:
                notes.append('e.g. `' + json.dumps(p['examples'][0], ensure_ascii=False)[:80] + '`')
            r = 'yes' if prop in req else ''
            t = type_str(p).replace('|', r'\|')
            n = ' — '.join(notes).replace('|', r'\|')
            lines.append(f'| `{prop}` | {t} | {r} | {n} |')
    elif sch.get('type') and not props and 'enum' not in sch:
        lines.append(f"Type: {type_str(sch)}")
    lines.append('')
    return '\n'.join(lines)

def body_schema(op):
    c = op.get('requestBody', {}).get('content', {})
    for ctype, media in c.items():
        return ctype, media.get('schema', {})
    return None, None

def resp_schema(op):
    r = op.get('responses', {}).get('200', {}).get('content', {})
    for ctype, media in r.items():
        return ctype, media.get('schema', {})
    return None, None

groups = {}
order = []
for path, ops in SPEC['paths'].items():
    for method, op in ops.items():
        tag = (op.get('tags') or ['Other'])[0]
        groups.setdefault(tag, []).append((method, path, op))
        if tag not in order:
            order.append(tag)

version = SPEC.get('info', {}).get('version', '?')
index_lines = [
    '# Brani API — Full Reference (generated from openapi.json)',
    '',
    f'Generated from `https://api.brani.cz/openapi.json` (Brani Public API {version}).',
    'Auth for all endpoints: `Authorization: Bearer <token>`. Regenerate with `scripts/gen_api_full.py` when the spec changes.',
    '',
    '| Module | File |',
    '|---|---|',
]

for tag in order:
    fname, title = TAG_FILES.get(tag, (re.sub(r'[^a-z0-9]+', '-', tag.lower()) + '.md', tag))
    used = set()
    out = [f'# {title}', '', f'Brani API module tag: "{tag}". Base URL `https://api.brani.cz`, Bearer auth.', '']
    for method, path, op in groups[tag]:
        out.append(f"## {method.upper()} {path}")
        summary = clean(op.get('summary', ''))
        desc = clean(op.get('description', ''))
        if summary:
            out.append(f'**{summary}**')
        if desc and desc != summary:
            out.append('')
            out.append(desc[:1500])
        params = op.get('parameters', [])
        if params:
            out.append('')
            out.append('| Param | In | Type | Req | Notes |')
            out.append('|---|---|---|---|---|')
            for prm in params:
                sch = prm.get('schema', {})
                notes = []
                if 'default' in sch:
                    notes.append(f"default `{json.dumps(sch['default'], ensure_ascii=False)}`")
                d = clean(prm.get('description') or sch.get('description') or '')
                if d:
                    notes.append(d[:250])
                collect_refs(sch, used)
                t = type_str(sch).replace('|', r'\|')
                n = ' — '.join(notes).replace('|', r'\|')
                out.append(f"| `{prm['name']}` | {prm.get('in','query')} | {t} | {'yes' if prm.get('required') else ''} | {n} |")
        ctype, bsch = body_schema(op)
        if bsch is not None:
            collect_refs(bsch, used)
            out.append('')
            out.append(f'Request body ({ctype}): **{type_str(bsch)}**' + (' — see Schemas below' if ('$ref' in json.dumps(bsch)) else ''))
        rtype, rsch = resp_schema(op)
        if rsch:
            collect_refs(rsch, used)
            out.append('')
            out.append(f'Response 200: **{type_str(rsch)}**')
        out.append('')
    if used:
        out.append('---')
        out.append('')
        out.append('## Schemas')
        out.append('')
        skip = {'HTTPValidationError', 'ValidationError'}
        for name in sorted(used):
            if name in skip:
                continue
            out.append(schema_md(name))
    with open(os.path.join(OUT, fname), 'w', encoding='utf-8') as f:
        f.write('\n'.join(out))
    index_lines.append(f'| {title} ({len(groups[tag])} endpoints) | [{fname}]({fname}) |')
    print(f'{fname}: {len(groups[tag])} ops, {len(used)} schemas')

index_lines.append('')
index_lines.append('Common error response: 422 `HTTPValidationError` — `{"detail": [{"loc": [...], "msg": "...", "type": "..."}]}`. Auth failure: 403 `{"detail": "Not authenticated"}`.')
with open(os.path.join(OUT, 'INDEX.md'), 'w', encoding='utf-8') as f:
    f.write('\n'.join(index_lines))
print('INDEX.md written')
