# Raízes de Aruanda — AGENTS

No workspace `projeto-raizes`, leia primeiro `../AGENTS.md`: ele define as regras comuns. Este arquivo acrescenta as convenções web. Em clone isolado, use os workflows locais em `docs/agents/`; não dependa da existência da pasta irmã `api/`.

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
4. API: carregue `.agents/skills/api-endpoints/SKILL.md` antes de consumir ou alterar o contrato. No workspace, consulte também o catálogo compartilhado em `../.agents/skills/api-endpoints/`. Em divergência, confira controllers, DTOs e serviços da API e corrija os catálogos afetados; documentação não substitui o comportamento implementado. Sem acesso à fonte, registre a divergência como não verificada.

## Skills reconhecidas

| Condição | Skill / pack |
| --- | --- |
| UI / tokens / layout | `docs/DESIGN.md` + Pencil MCP em `docs/design/design.pen` |
| Acionamento ou consulta da API (`/api/v1`, auth, erros Nest) | `.agents/skills/api-endpoints/` — obrigatória |
| Schema / SQL / tabelas `tb_*` | `.agents/skills/db-schema/` |
| Knowledge ops | `$nero` |
| Who-calls / imports / path | Pack `nero-code-graph` (`cg_*`) se instalado |

## Agent skills — engineering workflow

### Issue tracker
Issues web pertencem a `rodcordeiro/raizes-de-aruanda`; tarefas API vão para `rodcordeiro/raizes.api`. Ambos usam o Project #16 e o fluxo `ready` → `in progress` → `in review`. Consulte `docs/agents/issue-tracker.md` antes de publicar ou executar tickets.

### Domain docs
Adote contexto único em `CONTEXT.md` e decisões arquiteturais em `docs/adr/`; não crie `CONTEXT-MAP.md` sem sinais reais de monorepo. Consulte `docs/agents/domain.md` e as referências de domínio já existentes antes de alterar termos ou contratos.

### Skills de planejamento
Use `to-spec` para requisitos aprovados e `to-tickets` para entregas com critérios e dependências. Configure triagem apenas se houver skill local de triage, após mapear labels existentes.

## Encerramento

- [ ] Spec WEB e tickets estão neste repositório; dependências API têm links completos.
- [ ] Contrato consumido foi verificado e catálogos afetados estão coerentes.
- [ ] Validação visual e build pertinentes foram executados, ou impedimentos foram informados.
- [ ] Status e associação ao Project foram confirmados, ou a operação pendente foi explicitada.
