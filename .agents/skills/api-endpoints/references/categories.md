# Categories

Reviewed 2026-09-21 from `categories.controller.ts`, `create.dto.ts`,
`categories.service.ts`. Controller `@Auth()`. Mutations have **no**
`RequirePermissions` slug.

**Category JSON:** `{ id, nome, createdAt, updatedAt }`

## GET /api/v1/categories

- **Auth:** public
- **Params / body:** none
- **200:** `Category[]`

## GET /api/v1/categories/:id

- **Auth:** Bearer (not `@Public()`)
- **Params:** `id` — category id (string at runtime; TypeORM coerces)
- **Body:** none
- **200:** `Category`
- **400:** `Category not found`

## POST /api/v1/categories

- **Auth:** Bearer
- **Body:**
  - `nome` (string) — unique display name
- **201:** `Category`
- **400:** `Categoria {nome} já existe`

## PUT /api/v1/categories/:id

- **Auth:** Bearer
- **Params:** `id`
- **Body:**
  - `nome` (string)
- **200:** `Category`
- **400 / 500:** missing row (`findOneOrFail` uncaught → 500 on some paths)

## DELETE /api/v1/categories/:id

- **Auth:** Bearer
- **Params:** `id`
- **Body:** none
- **200:** empty (`undefined` body)
- **500:** missing row (`findOneOrFail` uncaught)
