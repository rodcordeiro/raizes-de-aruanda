# Tech debt

Gaps vs `$nero` → `references/guidelines/front-guidelines.md`. Revisão estática em 2026-10-02. Sem gap de severidade alta.

| Item | Evidência | Prioridade |
| --- | --- | --- |
| Sem testes, ESLint, `lint` / `typecheck` / `test` | `package.json` | Média — aceito (smoke manual) |
| Contraste brand em texto pequeno sobre fundo claro | `docs/DESIGN.md` Contrast Caution; `.nav-category-title`, `.linha-playlist` | Média — monitorar; não repetir |
| Listas admin (tabela, filtro, permissão) no arquivo da rota | `src/app/admin/(panel)/*/page.tsx` | Média — aceito; extrair seria reestruturação |
| Sheet, filtro e chips via `getElementById` | `src/components/catalog-client.tsx` | Baixa — aceito |
| Tipos da API entram na UI; só `User` é mapeado na borda | `src/lib/types.ts` | Baixa — aceito |
| `.is-invalid` sem uso; forms sem `aria-invalid` | `src/styles/admin.css`, forms admin | Baixa |
| Paginação com `20` literal em vez de `PAGE_SIZE` | `src/components/admin/list.tsx`, `src/lib/format.ts` | Baixa |
| `form.css` não importado | `src/styles/form.css` | Baixa — não estender |
| Sem `package-lock.json` | `Dockerfile` usa `npm install` | Baixa |

Feito (2026-10-02): `loading.tsx` e `error.tsx` na raiz e em `src/app/admin/(panel)/`. No painel, espera e falha ficam dentro do chrome; na raiz, cobrem a página pública. O contrato HTTP não mudou.

Não reestruturar listas nem reescrever o catálogo em estado React sem pedido.
