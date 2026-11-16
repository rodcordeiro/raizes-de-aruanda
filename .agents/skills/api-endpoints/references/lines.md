# Lines

Reviewed 2026-10-02 from `lines.controller.ts`, `create.dto.ts`, `update.dto.ts`,
`lines.service.ts`, `lines.entity.ts`. Controller `@Auth()`.

Mutations require `linha:*` and write `tb_audit_logs` in the same transaction.
Line snapshots include `saudacao`.

**Line JSON:** `{ id, nome, saudacao, canal_youtube?, categoria, createdAt, updatedAt }`
`saudacao` is `string | null` (null when empty). `categoria` is the eager
`Category` object (typed as number in the entity).

## GET /api/v1/lines

- **Auth:** public
- **Params / body:** none
- **200:** `Line[]`

## GET /api/v1/lines/:id

- **Auth:** Bearer (not `@Public()`)
- **Params:** `id`
- **Body:** none
- **200:** `Line`
- **400:** `Line not found`

## POST /api/v1/lines

- **Auth:** Bearer + `linha:create`
- **Body:**
  - `nome` (string) — unique
  - `categoria` (number) — `tb_categorias.id`
  - `canal_youtube` (string url, optional)
  - `saudacao` (string, optional, trimmed, max 100) — empty or null stores NULL
- **201:** `Line`
- **400:** `Line {nome} already exists` or Zod failure
- **500:** `audit_write_failed`

## PUT /api/v1/lines/:id

- **Auth:** Bearer + `linha:update`
- **Params:** `id`
- **Body:** any subset of `nome`, `categoria`, `canal_youtube`, `saudacao` (same types as create). Omitted `saudacao` keeps the current value.
- **200:** `Line`
- **400 / 500:** missing row or audit failure

## DELETE /api/v1/lines/:id

Delete only when no pontos reference the linha; the app checks that, not FK CASCADE.

- **Auth:** Bearer + `linha:delete`
- **Params:** `id`
- **Body:** none
- **204:** empty
- **500:** missing row or `audit_write_failed`
