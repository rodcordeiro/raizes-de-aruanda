# Patterns (observados)

| Padrão | Onde |
| --- | --- |
| Página PHP inclui controllers + DB | `index.php` |
| Controller class + `filter`/`getCategories` | `controllers/*.controller.php` |
| PDO + `getenv` | `db/db.class.php` |
| Tokens CSS + override mobile | `main.css` / `mobile.css` |
| Chips Ritmo: um por ritmo, `data-ritmo`, scroll `#ponto-{id}` | `index.php` + `main.js` |
| Nav sheet mobile + sidebar desktop | `#nav-sheet`, `main.js` `initMenu` |
| Embed YT na carga | `iframe.yt-embed` em `index.php` |
| Divisor pontos | `.ponto + .ponto { border-top }` |

## Anti-padrões locais (evitar)

- Hex de brand solto (usar `var(--brand)` / tokens DESIGN)
- `nl2br` na letra com `white-space: pre-wrap` (quebra duplicada)
- `mobile.css` antes de `main.css` (mata media queries)
- Expandir `.old/` ou `teste.php` como produto
