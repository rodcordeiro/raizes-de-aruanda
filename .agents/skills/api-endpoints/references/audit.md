# Audit

Reviewed 2026-09-21 from `audit.controller.ts`, `audit-query.dto.ts`,
`audit.service.ts`, `audit-log.entity.ts`. List does not write audit rows.

**Audit JSON**

| Field | Meaning |
| --- | --- |
| `id` | string (unsigned bigint) |
| `actorUserId` | int, nullable |
| `actorUsername` | string |
| `action` | e.g. `create` `update` `delete` `login_success` `login_failure` |
| `resourceType` | e.g. `point` `line` `rythm` `auth` |
| `resourceId` | string, nullable |
| `before` / `after` | JSON snapshots or omitted |
| `origin` | e.g. `http` |
| `httpMethod` | string |
| `httpPath` | string |
| `ip` / `userAgent` | nullable |
| `createdAt` | timestamp |

## GET /api/v1/audit-logs

- **Auth:** Bearer + `audit:read`
- **Query:**
  - `page` (positive int, default 1)
  - `limit` (positive int, max 100, default 20)
  - `actorUserId` (positive int, optional)
  - `action` (string, max 50, optional) — exact match
  - `resourceType` (string, max 100, optional)
  - `resourceId` (string, max 255, optional)
  - `from` / `to` (coerced dates, optional) — filter `createdAt`
- **Body:** none
- **200:** `{ data: Audit[], page, limit, total }` newest first
- **400:** Zod failure
- **401 / 403:** authz
