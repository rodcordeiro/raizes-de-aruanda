# RBAC

Reviewed 2026-09-21 from `rbac.controller.ts`, `role.dto.ts`,
`upsert-permission.dto.ts`, `rbac.service.ts`. Class-wide Bearer + `role:assign`.
Cascade semantics: `$db-schema` → `references/rbac.md`. Human notes: `docs/rbac-api.md`.

IDs: positive signed MySQL INT (`1..2147483647`). Link PUT/DELETE are
idempotent while the referenced rows exist.

**Errors:** 400 invalid input; 401; 403; 404 missing user/role/permission;
409 duplicate role slug or concurrent FK miss (`ER_DUP_ENTRY` /
`ER_NO_REFERENCED_ROW_2`).

## GET /api/v1/rbac/roles

- **Auth:** Bearer + `role:assign`
- **Params / body:** none
- **200:** `{ id, slug, name }[]` ordered by slug

## POST /api/v1/rbac/roles

Creates a role with **no** permissions and **no** users.

- **Auth:** Bearer + `role:assign`
- **Body:**
  - `slug` (string, max 64) — `/^[a-z][a-z0-9_-]*$/`
  - `name` (string, trimmed, 1..100)
- **201:** `{ id, slug, name }`
- **409:** `Role slug already exists`

## PATCH /api/v1/rbac/roles/:id

- **Auth:** Bearer + `role:assign`
- **Params:** `id` — role id
- **Body:** nonempty subset of `slug`, `name` (same constraints as create)
- **200:** `{ id, slug, name }`
- **404:** `Role not found`

## DELETE /api/v1/rbac/roles/:id

- **Auth:** Bearer + `role:assign`
- **Params:** `id` — role id
- **Body:** none
- **204:** empty
- **404:** `Role not found`

Join-table rows cascade; users and permissions remain.

## GET /api/v1/rbac/roles/:id/permissions

- **Auth:** Bearer + `role:assign`
- **Params:** `id` — role id
- **Body:** none
- **200:** `{ id, slug }[]` ordered by slug
- **404:** `Role not found`

## PUT /api/v1/rbac/roles/:id/permissions/:permissionId

- **Auth:** Bearer + `role:assign`
- **Params:** `id` role id; `permissionId` permission id
- **Body:** none
- **204:** empty
- **404:** role or permission missing

## DELETE /api/v1/rbac/roles/:id/permissions/:permissionId

Removes this role's grant only. Other roles may still grant the same slug.

- **Auth:** Bearer + `role:assign`
- **Params:** `id` role id; `permissionId` permission id
- **Body:** none
- **204:** empty
- **404:** role or permission missing

## GET /api/v1/rbac/users/:id/authorization

- **Auth:** Bearer + `role:assign`
- **Params:** `id` — user id
- **Body:** none
- **200:** `{ roles: string[], permissions: string[] }` (union of the user's roles)
- **404:** `User not found`

## PUT /api/v1/rbac/users/:id/roles/:roleId

Id-based assign. Slug-based assign: [users.md](users.md) `POST /users/:id/roles`.

- **Auth:** Bearer + `role:assign`
- **Params:** `id` user id; `roleId` role id
- **Body:** none
- **200:** `{ roles: string[], permissions: string[] }`
- **404:** user or role missing

## DELETE /api/v1/rbac/users/:id/roles/:roleId

- **Auth:** Bearer + `role:assign`
- **Params:** `id` user id; `roleId` role id
- **Body:** none
- **200:** `{ roles: string[], permissions: string[] }` after revoke
- **404:** user or role missing

## GET /api/v1/rbac/permissions

- **Auth:** Bearer + `role:assign`
- **Params / body:** none
- **200:** `{ id, slug }[]` ordered by slug

## PUT /api/v1/rbac/permissions

Upsert by unique slug; does not rename and does not grant the slug to any role.

- **Auth:** Bearer + `role:assign`
- **Body:**
  - `slug` (string, max 100) — `resource:action`,
    `/^[a-z][a-z0-9_-]*:[a-z][a-z0-9_-]*$/`
- **200:** `{ id, slug }`
