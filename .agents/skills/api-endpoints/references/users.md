# Users

Reviewed 2026-10-02 from `users.controller.ts`, `users.service.ts`,
`users.entity.ts`, `update-profile.dto.ts`, `assign-role.dto.ts`,
`jwt.strategy.ts`.

Controller-wide `@Auth()`. `password` and `refreshToken` are `select: false`
and are omitted from user JSON. Token issue stays on `POST /auth/login` and
`POST /auth/refresh`.

**User JSON:** `{ id, name, username, createdAt, updatedAt }`

`GET /users/me` also returns `permissions?: string[]`: the stored slug union for that user, the same set as `permissions` on `GET /rbac/users/:id/authorization`. Slugs are not expanded (`ponto:*` stays `ponto:*`). No new slug. Absent or `[]` is valid. List and profile responses omit `permissions`.

## GET /api/v1/users

- **Auth:** Bearer (any authenticated user; no permission slug)
- **Params / body:** none
- **200:** `User[]`
- **401:** missing/invalid access token

## GET /api/v1/users/me

- **Auth:** Bearer (no `role:assign`)
- **Params / body:** none
- **200:** `{ id, name, username, createdAt, updatedAt, permissions?: string[] }` (`findMe` on `req.user.id`; slugs already loaded by the JWT strategy via `RbacService.getAuthorization`)
- **401:** missing/invalid access token
- **404:** `User not found` (stale token / deleted user)

## PATCH /api/v1/users/me

Updates the authenticated user only (`req.user.id`). No extra permission slug.
Does not change `username`, roles, or another user.

- **Auth:** Bearer
- **Body:**
  - `name` (string, trimmed, 1–255)
  - `currentPassword` (string, required)
  - `newPassword` (string, optional) — omitted or empty changes only `name`
- **200:** `User`
- **400:** `Senha atual incorreta.` or Zod failure (empty/long `name`)
- **401:** missing/invalid access token
- **500:** `audit_write_failed` (mutation rolled back)

Audit `action` `update`, `resourceType` `user`, `resourceId` the user id.
`before` is `{ id, name }`. `after` is `{ id, name, password_changed: boolean }`.
Hash, password and token are not stored in the audit row.

When `newPassword` is set, the password is stored with bcrypt and
`tb_user.refreshToken` is replaced, so the previous refresh JWT no longer
matches `POST /auth/refresh`.

Declared **before** `/:id/roles`; `/me` is not captured as an id.

## POST /api/v1/users/:id/roles

Slug-based assign. Id-based assign is in [rbac.md](rbac.md).

- **Auth:** Bearer + `role:assign`
- **Params:** `id` (int, `ParseIntPipe`) — target `tb_user.id`
- **Body:**
  - `role` (string, max 64) — existing role slug, `/^[a-z][a-z0-9_-]*$/`
- **201:** `{ roles: string[], permissions: string[] }` for that user
- **400:** invalid slug
- **401 / 403:** authz
- **404:** `User not found` or `Role not found`

Custom slugs are accepted, not only `admin` / `editor`.
