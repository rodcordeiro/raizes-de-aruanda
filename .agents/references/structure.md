# Structure (checkout factual)

## Ativo — home pública

| Path | Papel |
| --- | --- |
| `index.php` | Entrypoint home: Linha → chips Ritmo → Pontos |
| `components/metadata/header.php` | Meta + ordem CSS (`main` → `mobile` → `print`) |
| `controllers/linhas.controller.php` | Categorias / linhas (leitura) |
| `controllers/pontos.controller.php` | Pontos por linha (leitura pública; `filter`) |
| `db/db.class.php` | PDO MySQL via `getenv` |
| `assets/css/main.css` | Tokens `:root` + layout desktop |
| `assets/css/mobile.css` | ≤768px (sheet, hero, chips sticky) |
| `assets/css/print.css` | Impressão |
| `assets/js/main.js` | Menu sheet, filtro nav, chips Ritmo |
| `assets/favicon/` | Ícones / manifest |
| `docs/DESIGN.md` | Design system |
| `docs/design/` | `design.pen` + PNGs de referência |
| `CONTEXT.md` | Glossário |
| `compose.yml` / `Dockerfile` | PHP 8.2 Apache + `pdo_mysql` |
| `.env.example` | Nomes de variáveis (sem segredos) |

## Ativo — admin (auth + CRUD Pontos/Linhas/Ritmos + Auditoria)

| Path | Nota |
| --- | --- |
| `admin/login/` | Login UI (`tb_user` + sessão PHP) |
| `admin/logout.php` | Logout |
| `admin/_bootstrap.php` | Boot PDO + sessão/RBAC/audit + admin_pontos/linhas/ritmos/audit |
| `admin/_shell.php` | Chrome admin (header/nav/flash) |
| `admin/index.php` | Redirect `/admin/pontos/` se `canReadCatalog`; senão `/admin/auditoria/` se `audit:read` |
| `admin/pontos/` | `index.php` list; `form.php` create/edit; `delete.php` GET confirm + POST |
| `admin/linhas/` | `index.php` list; `form.php` create/edit; `delete.php` GET confirm + POST |
| `admin/ritmos/` | `index.php` list; `form.php` create/edit; `delete.php` GET confirm + POST |
| `admin/auditoria/` | `index.php` list read-only (`audit:read`) |
| `admin/styles.css` | Shell admin (tokens via CSS vars) |
| `controllers/session.controller.php` | Sessão, CSRF, `attemptLogin` |
| `controllers/rbac.controller.php` | Roles/perms na sessão |
| `controllers/audit.controller.php` | Login best-effort + `writeAuditMutation` (strict) |
| `controllers/admin_pontos.controller.php` | CRUD PDO `tb_pontos` + selects linha/ritmo |
| `controllers/admin_linhas.controller.php` | CRUD PDO `tb_linhas` |
| `controllers/admin_ritmos.controller.php` | CRUD PDO `tb_ritmos` |
| `controllers/admin_audit.controller.php` | Listagem read-only `tb_audit_logs` |

## Presente — fora do foco atual

| Path | Nota |
| --- | --- |
| `dash/` | Dashboard; adiado |
| `bot.php` | Anúncio Discord + saudação; fora do foco home |
| `config/bootstrap.php` | Loader `.env` (home atual não inclui explicitamente) |
| `config/database/` | Scripts SQL |
| `.github/workflows/` | Deploy FTP / homologação |

## Legado / helper

| Path | Nota |
| --- | --- |
| `.old/` | Código antigo — não estender |
| `teste.php` | Sandbox — não tratar como produto |
| `assets/css/form.css` | Formulários (uso residual) |
| `utils/functions.php` | Helpers |

## Ausente vs guideline `front` típico

Sem `app/`/`pages` React, sem package manager JS de app, sem componentes compartilhados tipo design-system npm. Ver `tech-debt.md`.
