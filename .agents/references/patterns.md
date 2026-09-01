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

## Admin auth + CRUD Pontos (observado)

| Padrão | Onde |
| --- | --- |
| Boot admin compartilhado | `admin/_bootstrap.php` → DB + session/RBAC/audit + admin_pontos |
| Shell UI | `admin/_shell.php` + `admin/styles.css` (`main` → `mobile` → admin) |
| Auth `tb_user` + `password_verify` | `controllers/session.controller.php` |
| RBAC em sessão pós-login | `hasPermission` / `requirePermission` / `canReadCatalog` |
| Listagem / form / delete | `admin/pontos/` — CSRF em POST; CTAs gated por perm |
| CRUD PDO `tb_pontos` | `controllers/admin_pontos.controller.php` (não altera `Pontos::filter`) |
| Audit login best-effort | `writeAuditLogin` (`login_success` \| `login_failure`) |
| Audit mutação same-tx (strict) | `writeAuditMutation` — falha → rollback + `audit_write_failed` |
| Actor de audit | Só de `$_SESSION` via `admin_actor()` |
| Redirects relativos ao host | `/admin/login/`, `/admin/`, `/admin/pontos/` |

## Anti-padrões locais (evitar)

- Hex de brand solto (usar `var(--brand)` / tokens DESIGN)
- `nl2br` na letra com `white-space: pre-wrap` (quebra duplicada)
- `mobile.css` antes de `main.css` (mata media queries)
- Expandir `.old/` ou `teste.php` como produto
- Auth via `icnt_users` / MD5 / SQL concatenado (legado)
- Mutar `tb_pontos` sem audit na mesma transação
