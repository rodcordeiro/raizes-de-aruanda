# Uploads

Reviewed 2026-09-21 from `upload.controller.ts`, `upload.services.ts`.
**No `@Auth()`** — these routes do not require JWT. Method is **PATCH**.
Files land in `./uploaded` then FTP `/pontos/{name}`.

Returned `url` is built as `http://raizes.rodrigocordeiro.com.br/pontos/{name}`.

**File JSON:** `{ name, originalName, mime, size, url }`
`name` is `{timestamp}_{random}.{ext}`.

## PATCH /api/v1/uploads/ponto

- **Auth:** none
- **Content-Type:** `multipart/form-data`
- **Body:**
  - `file` (binary) — field name must be `file`
- **200:** `File JSON`

## PATCH /api/v1/uploads/pontos

- **Auth:** none
- **Content-Type:** `multipart/form-data`
- **Body:**
  - `files` (binary array, max 4) — field name must be `files`
- **200:** intended `File JSON[]`

Implementation is `files.map(this.uploadFile)` without awaiting, so the HTTP
body may be an array of unresolved Promises rather than file metadata. Prefer
the single-file route until that path is verified live.
