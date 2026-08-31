# Runtime

## Stack

- PHP **8.2** + Apache (`Dockerfile`)
- MySQL via **PDO** (`db/db.class.php`)
- Front: CSS + JS leve (feather-icons CDN + `main.js`)

## Boot home

1. Request → `index.php`
2. Includes: `header.php`, `db.class.php`, `linhas.controller.php`, `pontos.controller.php`
3. Query `?buscar=<Linha>` lista pontos; sem param → apresentação

`config/bootstrap.php` carrega `.env` se legível; **a home não o inclui hoje** — em Docker as vars vêm do `env_file` / ambiente.

## Env (nomes apenas)

| Variável | Uso |
| --- | --- |
| `APP_PORT` | Porta host Compose (default 8080) |
| `CONN_URI` | Host MySQL |
| `ICNT_MYSQL_USER` | Usuário |
| `ICNT_MYSQL_PASSWORD` | Senha |
| `ICNT_MYSQL_DATABASE` | Database |
| `DISCORD_WEBHOOK` | Só `bot.php` |

Nunca documentar valores reais. Fonte de nomes: `.env.example` + código.

## Local

```bash
docker compose up --build
# http://localhost:${APP_PORT:-8080}
```

Volume: `./` → `/var/www/html`.

## Deploy

GitHub Actions → FTP (prod / homolog). Detalhe nos workflows sob `.github/workflows/`.
