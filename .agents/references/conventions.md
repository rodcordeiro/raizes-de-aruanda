# Conventions

## Escopo de mudança

- Home/UI pública → `src/app/page.tsx`, `src/components/*`, `src/styles/*`.
- Admin só com pedido explícito. Não abrir dashboard, giras, uploads ou CRUD de users sem pedido.
- Segredos: nunca em docs, commits ou AGENTS. Só nomes de env.

## Design / CSS

1. Tokens em `src/styles/main.css` `:root`, alinhados a `docs/DESIGN.md`.
2. `src/app/globals.css` importa `main.css` antes de `mobile.css` e `print.css`.
3. Mobile: The Linha Hero Rule + The Ritmo Chip Rule (`docs/DESIGN.md`).
4. Glossário de UI: `CONTEXT.md`.

## Dados

- Leitura e escrita passam por `src/lib/api.ts` e server actions.
- Antes de acionar ou consultar a API, ler a skill `.agents/skills/api-endpoints/` (linha do catálogo do recurso). Não inventar path, método, auth, status ou JSON.
- Função gravável: Chamada, Sustentação, Subida, Demanda. Texto fora disso aparece no form e não pode ser salvo.

## Validação

| Check | Como |
| --- | --- |
| Sobe | `npm run dev` ou `docker compose up --build` |
| Desktop | sidebar, chips, letra |
| Mobile ~370px | sheet, hero da Linha, chips sticky, embed |
| Print | chrome oculto |
| Contraste | brand não em texto miúdo sobre fundo claro |

Sem suíte automatizada. Smoke manual é a barra.
