# Structure (checkout factual)

Next.js App Router em `src/`. Cliente HTTP de raizes.api. Sem PHP no tree.

## Ativo — público

| Path | Papel |
| --- | --- |
| `src/app/page.tsx` | Home: `?buscar=` → Linha, chips, Pontos |
| `src/app/ordem-ritualistica/page.tsx` | Texto estático da ordem |
| `src/app/layout.tsx` | Root layout, fonte, `force-dynamic` |
| `src/components/public-shell.tsx` | Header + nav por categoria |
| `src/components/catalog-client.tsx` | Menu, filtro, chips (client) |
| `src/components/line-view.tsx` | Hero, saudação, letra, YouTube/áudio |
| `src/styles/main.css` | Tokens `:root` + desktop |
| `src/styles/mobile.css` | ≤768px |
| `src/styles/print.css` | Impressão |
| `src/app/globals.css` | Importa `main` → `mobile` → `print` |
| `public/` | Favicons e logo |
| `docs/DESIGN.md` | Design system |
| `docs/design/` | `design.pen` |
| `CONTEXT.md` | Glossário |

## Ativo — admin

| Path | Papel |
| --- | --- |
| `src/app/admin/login/` | Login |
| `src/app/admin/(panel)/layout.tsx` | Gate de sessão + chrome |
| `src/app/admin/(panel)/pontos/` | Lista, novo, edição, exclusão |
| `src/app/admin/(panel)/linhas/` | Idem |
| `src/app/admin/(panel)/ritmos/` | Idem |
| `src/app/admin/(panel)/auditoria/` | Lista read-only |
| `src/app/admin/(panel)/perfil/` | Nome e senha |
| `src/app/admin/actions.ts` | Server actions |
| `src/app/api/session/refresh/route.ts` | Renova sessão |
| `src/components/admin/` | Forms e lista |
| `src/styles/admin.css` | Shell admin |
| `src/styles/login.css` | Login |
| `src/middleware.ts` | Header `x-pathname` para nav ativa |

## Lib

| Path | Papel |
| --- | --- |
| `src/lib/api.ts` | Cliente HTTP |
| `src/lib/session.ts` | Cookies httpOnly |
| `src/lib/permissions.ts` | `can` / `canReadCatalog` |
| `src/lib/types.ts` | Tipos e Funções |
| `src/lib/format.ts` | Paginação, YouTube, letra |

## Presente — fora do foco

| Path | Nota |
| --- | --- |
| `src/styles/form.css` | Não importado |
| `.github/workflows/` | Deploy legado; conferir antes de usar |
| `config/database/` | SQL histórico; o app não migra |

## Ausente vs guideline `front`

Sem `loading.tsx` / `error.tsx`, sem suíte de testes, sem ESLint. Ver `tech-debt.md`.
