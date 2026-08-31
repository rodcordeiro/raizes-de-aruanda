# Raízes de Aruanda — AGENTS

PHP procedural + MySQL (PDO). Home pública: `index.php`. Foco atual: catálogo público de Pontos; **admin auth** (login/sessão/RBAC) em `admin/` — CRUD de catálogo e dashboard adiados.

## Como usar este contexto

| Quando | Onde |
| --- | --- |
| Glossário (Linha, Ritmo, Ponto…) | `CONTEXT.md` |
| Design system (tokens, Named Rules) | `docs/DESIGN.md` |
| Visual / Pencil | `docs/design/design.pen` |
| Estrutura do checkout | `.agents/references/structure.md` |
| Boot, env, Docker | `.agents/references/runtime.md` |
| Domínio do produto | `.agents/references/domain.md` |
| Como mudar / validar | `.agents/references/conventions.md` |
| Padrões locais observados | `.agents/references/patterns.md` |
| Dívida vs guideline front | `.agents/references/tech-debt.md` |
| Índice das refs | `.agents/references/index.md` |
| Guideline domínio `front` | `$nero` → `references/guidelines/front-guidelines.md` |
| Knowledge / decisões | `$nero` MCP projeto `raizes-de-aruanda` |

## Regras rápidas

1. Mudanças na home: preferir `index.php`, `assets/css/*`, `assets/js/main.js`, controllers de leitura — **não** expandir admin sem pedido.
2. CSS: carregar `main.css` **antes** de `mobile.css`; tokens em `:root` / `docs/DESIGN.md` — sem hex solto de brand.
3. Validar: `docker compose up --build` → `http://localhost:${APP_PORT:-8080}`; smoke mobile ~370px (sheet, chips sticky, embed YT). Sem suite de testes automatizados no checkout.

## Skills condicionais

| Condicao | Skill / pack |
| --- | --- |
| UI / tokens / layout | `docs/DESIGN.md` + Pencil MCP em `docs/design/design.pen` |
| Knowledge ops | `$nero` |
| Who-calls / imports / path | Pack `nero-code-graph` (`cg_*`) se instalado |
| Domain Skills de lib interna | omitido — sem evidência no checkout |
