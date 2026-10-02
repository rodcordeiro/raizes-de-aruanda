# Points

Reviewed 2026-10-02 from `points.controller.ts`, `get.dto.ts`, `create.dto.ts`,
`update.dto.ts`, `points.service.ts`, `points.entity.ts`. Controller `@Auth()`.
Writes use `ponto:*` and transactional audit. Snapshots include `tipo` and
`gravar_audio`.

**Point JSON:** `{ id, letra, tipo, gravar_audio, audio_url?, linha, ritmo, createdAt, updatedAt }`
`gravar_audio` is boolean. Eager `linha` (Line) and `ritmo` (Rythm object despite a `number` type).

## GET /api/v1/points

- **Auth:** public
- **Query:**
  - `linha` (string, optional) — when set, `findBy` uses `linha: { id: +linha }`
  - `pendente_gravar` (string, optional) — Zod turns a non-empty value into a boolean (`"true"` → `true`, any other non-empty string → `false`) and filters `gravar_audio`. Omitted or empty skips this filter. With `linha`, both apply together
- **Body:** none
- **200:** `Point[]` (all rows, or the active filters; empty array if none)

## GET /api/v1/points/:id

- **Auth:** public
- **Params:** `id`
- **Body:** none
- **200:** `Point`
- **400:** `Entity not found`

## POST /api/v1/points

- **Auth:** Bearer + `ponto:create`
- **Body:**
  - `letra` (string) — lyrics
  - `tipo` (string) — exactly `Chamada` | `Sustentação` | `Demanda` | `Subida`
  - `linha` (number) — `tb_linhas.id`
  - `ritmo` (number) — `tb_ritmos.id`
  - `audio_url` (url string, optional)
  - `gravar_audio` (boolean, optional) — omitted stores false
- **201:** `Point` (reloaded after insert)
- **400:** Zod failure, including `tipo` outside the enum
- **500:** `audit_write_failed`

## PUT /api/v1/points/:id

- **Auth:** Bearer + `ponto:update`
- **Params:** `id`
- **Body:** optional `letra`, `tipo` (same enum), `linha`, `ritmo`, `audio_url` (url), `gravar_audio` (boolean). Omitted `tipo` or `gravar_audio` keeps the current value.
- **200:** `Point`
- **400:** Zod failure or missing row (`findOneOrFail`)
- **500:** `audit_write_failed`

## DELETE /api/v1/points/:id

- **Auth:** Bearer + `ponto:delete`
- **Params:** `id`
- **Body:** none
- **204:** empty
- **500:** missing row or `audit_write_failed`
