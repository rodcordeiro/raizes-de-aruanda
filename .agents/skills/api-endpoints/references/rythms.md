# Rythms

Reviewed 2026-09-21 from `rythms.controller.ts`, DTOs, `rythms.service.ts`.
Path is **`/rythm`**, not `/rythms` or `/ritmos`. Controller `@Auth()` with
**no** `@Public()` — list and get require JWT.

Mutations require `ritmo:*` and write audit in the same transaction.

**Rythm JSON:** `{ id, nome, createdAt, updatedAt }`

## GET /api/v1/rythm

- **Auth:** Bearer
- **Params / body:** none
- **200:** `Rythm[]`

## GET /api/v1/rythm/:id

- **Auth:** Bearer
- **Params:** `id`
- **Body:** none
- **200:** `Rythm`
- **400:** `Entity not found` (`BaseService.findOneBy`)

## POST /api/v1/rythm

- **Auth:** Bearer + `ritmo:create`
- **Body:**
  - `nome` (string)
- **201:** `Rythm`
- **400:** Zod failure
- **500:** `audit_write_failed`

## PUT /api/v1/rythm/:id

- **Auth:** Bearer + `ritmo:update`
- **Params:** `id`
- **Body:**
  - `nome` (string) — required in the Zod schema (not partial)
- **200:** `Rythm`
- **400:** `Entity not found` or Zod failure
- **500:** `audit_write_failed`

## DELETE /api/v1/rythm/:id

Delete only when no pontos reference the ritmo; the app checks that, not FK CASCADE.

- **Auth:** Bearer + `ritmo:delete`
- **Params:** `id`
- **Body:** none
- **204:** empty
- **500:** missing row (`findOneOrFail`) or `audit_write_failed`
