# Giras

Reviewed 2026-09-21 from `giras.controller.ts`, `create.dto.ts`, `update.dto.ts`,
`assign.dto.ts`, `giras.service.ts`. Controller `@Auth()`. Mutations have **no**
permission slug and **no** audit helper.

**Gira JSON:** `{ id, gira, fechada, createdAt, updatedAt }`
`gira` is the date column. Detail adds `linhas`: `GiraLine[]`.

**GiraLine JSON:** `{ id, festa, gira, linha, createdAt, updatedAt }`
with eager `gira` / `linha` objects.

Zod field for the date is **`gira`** (`YYYY-MM-DD`). Swagger `date` and
`2024/05/04` are stale. Assign body is a **JSON array**, not `{ items: [] }`.
The array type is TypeScript-only; there is no `z.array()` DTO.

## GET /api/v1/giras

- **Auth:** public
- **Params / body:** none
- **200:** `Gira[]` without `linhas` (`find()`; relation is not eager)

## GET /api/v1/giras/:id

- **Auth:** Bearer (not `@Public()`)
- **Params:** `id`
- **Body:** none
- **200:** `Gira` with `linhas`
- **500:** missing row (`findOneOrFail` uncaught)

## POST /api/v1/giras

- **Auth:** Bearer
- **Body:**
  - `gira` (string date `YYYY-MM-DD`)
  - `fechada` (boolean)
- **201:** `Gira`
- **400:** Zod failure

## PUT /api/v1/giras/:id

- **Auth:** Bearer
- **Params:** `id`
- **Body:** optional `gira` (`YYYY-MM-DD`), `fechada`
- **200:** `Gira`
- **400:** Zod failure or `Entity not found`

## DELETE /api/v1/giras/:id

- **Auth:** Bearer
- **Params:** `id`
- **Body:** none
- **204:** empty (BaseService `destroy` deletes by id even when the row is missing)

## POST /api/v1/giras/:id/assign

- **Auth:** Bearer
- **Params:** `id` — gira id (stored as `gira` on the join row)
- **Body:** array of:
  - `festa` (boolean) — whether the gira was a festa for that line
  - `linha` (number) — `tb_linhas.id`
- **201:** `GiraLine[]`
- **400:** `Line not found` wrapped in `BadRequestException`

Does not replace existing assigns; it inserts additional join rows.

## PUT /api/v1/giras/:id/assign

Deletes all join rows for the gira, then inserts the given array.

- **Auth:** Bearer
- **Params:** `id`
- **Body:** array of optional `festa`, `linha` (`UpdateAssignLineDTO`)
- **200:** `GiraLine[]`
- **400:** missing line or persist error wrapped as `BadRequestException`
