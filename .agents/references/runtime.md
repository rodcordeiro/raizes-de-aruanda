# Runtime

## Stack

- Next.js 15 App Router, React 19, TypeScript (`package.json`)
- Dados só via HTTP (`src/lib/api.ts`). Sem PDO neste checkout.
- CSS próprio (sem Tailwind). Fonte: `next/font` Source Sans 3.

## Boot

1. `src/app/layout.tsx` (`dynamic = "force-dynamic"`)
2. Home lê `searchParams.buscar` e chama a API
3. Admin: cookie de sessão → `src/lib/session.ts`; 401 tenta refresh em `/api/session/refresh`

## Env (nomes apenas)

| Variável | Uso |
| --- | --- |
| `APP_PORT` | Porta host do Compose (default 8080) |
| `API_BASE_URL` | Base da raizes.api |

Nunca documentar valores reais. Fonte de nomes: `.env.example`.

No Compose, o default de `API_BASE_URL` aponta para o host (`host.docker.internal`), não para um serviço no mesmo compose.

## Local

```bash
npm run dev
# http://localhost:3000

docker compose up --build
# http://localhost:${APP_PORT:-8080}
```

Scripts em `package.json`: `dev`, `build`, `start`. Sem `lint`, `typecheck` ou `test`. Sem lockfile; a imagem usa `npm install`.
