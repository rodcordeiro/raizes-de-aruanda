# Tech debt

Gaps vs `$nero` → `references/guidelines/front-guidelines.md`. Revisão estática em 2026-11-16. Severidade e aceitação de riscos exigem avaliação própria; esta revisão não é uma auditoria de produção.

| Item | Evidência | Prioridade |
| --- | --- | --- |
| Sem scripts `lint` / `typecheck` / `test` | `package.json` | Média — lacuna de verificação automatizada |
| Contraste brand em texto pequeno sobre fundo claro | `docs/DESIGN.md` Contrast Caution; `.nav-category-title`, `.linha-playlist` | Média — monitorar; não repetir |
| Listas admin (tabela, filtro, permissão) no arquivo da rota | `src/app/admin/(panel)/*/page.tsx` | Média — aceito; extrair seria reestruturação |
| Sheet, filtro e chips via `getElementById` | `src/components/catalog-client.tsx` | Baixa — aceito |
| Tipos da API entram na UI; só `User` é mapeado na borda | `src/lib/types.ts` | Baixa — aceito |
| `.is-invalid` sem uso; forms sem `aria-invalid` | `src/styles/admin.css`, forms admin | Baixa |
| Paginação com `20` literal em vez de `PAGE_SIZE` | `src/components/admin/list.tsx`, `src/lib/format.ts` | Baixa |
| `form.css` não importado | `src/styles/form.css` | Baixa — não estender |
| README ainda descreve PHP/MySQL | `README.md` versus `package.json`, `Dockerfile`, `src/lib/api.ts` | Média — documentação fora do escopo deste playbook |

Confirmado no checkout: `loading.tsx` e `error.tsx` na raiz e em `src/app/admin/(panel)/`; `package-lock.json` presente e Dockerfile usa `npm ci` em build multi-stage. Os demais itens da tabela são observações históricas, não revalidadas integralmente nesta revisão.

Não reestruturar listas nem reescrever o catálogo em estado React sem pedido.
