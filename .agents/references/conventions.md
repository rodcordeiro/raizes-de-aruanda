# Conventions

## Escopo de mudança

- Pedido de home/UI → `index.php`, `assets/css/*`, `assets/js/main.js`, controllers de leitura.
- Admin/dash só com pedido explícito.
- Segredos: nunca em docs, commits ou AGENTS; usar só nomes de env.

## Design / CSS

1. Tokens em `assets/css/main.css` `:root` alinhados a `docs/DESIGN.md` / Pencil `$color.*`.
2. Ordem de links: `main.css` → `mobile.css` → `print.css`.
3. Mobile: The Linha Hero Rule + The Ritmo Chip Rule (`docs/DESIGN.md`).
4. Glossário UI: `CONTEXT.md` (não “música/playlist”).

## Dados

- Controllers usam SQL string + PDO; mudanças de schema → `config/database/` com cuidado (produtivo).
- Parser YouTube atual: `youtu.be/...` (não `watch?v=` sem evidência de suporte).

## Validação

| Check | Como |
| --- | --- |
| Sobe | `docker compose up --build` |
| Desktop | sidebar 240, chips wrap, letra legível |
| Mobile ~370px | hamburger → sheet; hero Linha; chips sticky; salto ritmos; YT iframe |
| Print | chrome/nav ocultos; letra preta |
| Contraste | The Contrast Caution Rule — brand não em texto miúdo sobre branco |

Sem `npm test` / PHPUnit no checkout — smoke manual é a barra.
