# Raízes de Aruanda — AGENTS

Next.js (App Router, `src/`) cliente HTTP de raizes.api. Home pública: `/`. Foco atual: catálogo público de Pontos; **admin** em `/admin` — sessão em cookie httpOnly + **CRUD Pontos/Linhas/Ritmos** (+ **Auditoria** quando a API permitir); dashboard/giras/users e demais adiados. API: `API_BASE_URL` (padrão `http://localhost:3333`).

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

1. Mudanças na home: preferir `src/app/page.tsx`, `src/styles/*`, `src/components` — **não** expandir dashboard/giras/users sem pedido.
2. CSS: `src/app/globals.css` carrega `main.css` **antes** de `mobile.css`; tokens em `:root` / `docs/DESIGN.md` — sem hex solto de brand.
3. Validar: `npm run dev` → `http://localhost:3000`, ou `docker compose up --build` → `http://localhost:${APP_PORT:-8080}`; smoke mobile ~370px (sheet, chips sticky, embed YT; admin pontos/linhas/ritmos ~370px). Sem suite de testes automatizados no checkout.
4. API: qualquer acionamento ou consulta à raizes.api carrega a skill `.agents/skills/api-endpoints/` antes de implementar. O catálogo vence o código se o path, o método, a auth ou o JSON divergirem.

## Skills reconhecidas

| Condição | Skill / pack |
| --- | --- |
| UI / tokens / layout | `docs/DESIGN.md` + Pencil MCP em `docs/design/design.pen` |
| Acionamento ou consulta da API (`/api/v1`, auth, erros Nest) | `.agents/skills/api-endpoints/` — obrigatória |
| Schema / SQL / tabelas `tb_*` | `.agents/skills/db-schema/` |
| Knowledge ops | `$nero` |
| Who-calls / imports / path | Pack `nero-code-graph` (`cg_*`) se instalado |
| Domain Skills de lib interna | omitido — sem evidência no checkout |
