# Patterns (observados)

| Padrão | Onde |
| --- | --- |
| Página servidor fina: busca + fetch + composição | `src/app/page.tsx` |
| Cliente HTTP único, `cache: "no-store"` | `src/lib/api.ts` |
| Mutação em server action + redirect com `?ok=` | `src/app/admin/actions.ts` |
| Form client com `useActionState` | `src/components/admin/*-form.tsx` |
| Sessão em cookie httpOnly; refresh em route handler | `src/lib/session.ts`, `src/app/api/session/refresh/route.ts` |
| Permissão vazia ou ausente mostra a ação | `src/lib/permissions.ts` |
| Tokens CSS + override mobile | `src/styles/main.css`, `mobile.css` |
| Chips e sheet via DOM no client | `src/components/catalog-client.tsx` |
| Embed YouTube na carga; áudio direto em `<audio>` | `src/components/line-view.tsx`, `src/lib/format.ts` |
| Letra: escape e só `<i>` restaurado | `src/lib/format.ts` |

## Anti-padrões locais

- Hex de brand solto (usar `var(--brand)` / tokens)
- `mobile.css` antes de `main.css`
- Abrir PDO ou SQL neste checkout
- Guardar token no `localStorage`
