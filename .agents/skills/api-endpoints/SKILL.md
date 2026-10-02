---
name: api-endpoints
description: >
  HTTP contract of raizes.api: path, method, auth, params/body and response.
  Use when implementing, consuming or documenting routes (rota, DTO, payload,
  Swagger, /api/v1).
---

# API endpoints — Raízes de Aruanda

Checkout controllers, DTOs and services are the fact. This skill is the agent
cache of that HTTP contract. Column types live in `$db-schema`.

## Procedure

1. Pick the catalog row whose **Load when** matches the task.
2. Read that file. Done when every affected endpoint has path, method, auth,
   params/body (each argument) and success status. If the work invents columns,
   types or FKs, also load `$db-schema`.
3. Preserve prefix, version, auth, status and JSON unless the task asks to
   change the contract. PHP/PDO compatibility is an explicit analysis.
4. After a contract change, update the same reference (reviewed date + source
   paths) and run `git diff --check -- .agents/skills/api-endpoints`.
   Endpoint work is not done until that file matches the new HTTP.

## Shared contract

| Rule | Fact |
| --- | --- |
| Prefix | `/api` + URI version `v1` → `/api/v1/...` except health |
| Auth header | `Authorization: Bearer <accessToken>` |
| Public | Handler `@Public()` skips JWT; other handlers on an `@Auth()` controller need Bearer |
| Permissions | `@RequirePermissions('resource:action')` — exact slug, all listed, no wildcards |
| Validation | Global `ZodValidationPipe` on Zod DTOs; invalid input → **400** |
| Exceptions | Nest JSON `{ statusCode, message, error }` |
| Throttle | 10 requests / 30s (`ThrottlerGuard`) → **429** |
| Timestamps | JSON uses `createdAt` / `updatedAt`, not `created_at` |
| Secrets | Name env vars (`JWT_SECRET`, `JWT_REFRESH_SECRET`, `ENC_SECRET`); never dump values, passwords or tokens into this skill |

Missing JWT → **401**. Missing permission → **403** `Insufficient permissions`.
Catalog writes that fail audit insert → **500** `audit_write_failed` and the
mutation is rolled back.

DELETE is **200** with an empty body unless the resource file says **204**.

## Catalog

| Resource | Load when |
| --- | --- |
| [health.md](references/health.md) | Liveness, `/health` |
| [auth.md](references/auth.md) | Login, register, refresh, tokens |
| [users.md](references/users.md) | `/users`, `/me`, profile, role assign by slug |
| [rbac.md](references/rbac.md) | `/rbac`, role CRUD, permission grants, assign by id |
| [categories.md](references/categories.md) | `/categories` |
| [lines.md](references/lines.md) | `/lines` |
| [rythms.md](references/rythms.md) | `/rythm` (singular) |
| [points.md](references/points.md) | `/points` |
| [giras.md](references/giras.md) | `/giras`, assign lines to a gira |
| [uploads.md](references/uploads.md) | Multipart, FTP audio |
| [audit.md](references/audit.md) | `/audit-logs` |

Swagger UI: `/swagger`. This catalog wins when annotations disagree with Zod
or Passport.

## Gotchas

- Controller `path` is the URL, not the folder name (`rythms` → `/rythm`).
- `@Public()` is per handler: a public list can sit beside an authenticated `GET /:id`.

## Refresh

Controllers under `src/modules/*/controllers/`, DTOs beside them, return
values from the called service. Record the review date on the file you change.
Every path, method, auth, DTO, status or JSON change updates this catalog in
the same lote.
