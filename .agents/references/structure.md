# Structure (checkout factual)

## Ativo — home pública

| Path | Papel |
| --- | --- |
| `index.php` | Entrypoint home: Linha → chips Ritmo → Pontos |
| `components/metadata/header.php` | Meta + ordem CSS (`main` → `mobile` → `print`) |
| `controllers/linhas.controller.php` | Categorias / linhas (leitura) |
| `controllers/pontos.controller.php` | Pontos por linha (leitura) |
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

## Presente — fora do foco atual

| Path | Nota |
| --- | --- |
| `admin/` | Login + ritmos; adiado por decisão Nero |
| `dash/` | Dashboard; adiado |
| `bot.php` | Anúncio Discord + saudação; fora do foco home |
| `controllers/session.controller.php` | Sessão admin |
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
