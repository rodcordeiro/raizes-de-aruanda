# Auth

Reviewed 2026-10-02 from `auth.controller.ts`, `auth.service.ts`,
`local.strategy.ts`, `refreshToken.strategy.ts`.

**Token pair**

| Field | Meaning |
| --- | --- |
| `accessToken` | JWT signed with `JWT_SECRET`; expires per `JWT_EXPIRES` |
| `refreshToken` | JWT signed with `JWT_REFRESH_SECRET`; 10 days |
| `expires` | `Date#setHours(+1)` — epoch **milliseconds**, not JWT expiry |

Access-token validation decrypts the inner payload with `ENC_SECRET` and
reloads roles/permissions from the database on every request.

## POST /api/v1/auth/login

- **Auth:** none (`LocalAuth`). Field is **`username`**, not Swagger's `login`.
- **Body:**
  - `username` (string) — `tb_user.username`
  - `password` (string) — compared with bcrypt; never logged
- **200:** `{ accessToken, refreshToken, expires, authenticated: true }`
- **401:** `username or password invalid`

Persists a new refresh token on the user. Best-effort audit:
`login_success` / `login_failure`.

## POST /api/v1/auth/register

- **Auth:** Bearer + `user:invite`
- **Body** (`CreateUserDTO`, **not** Zod-validated):
  - `name` (string)
  - `username` (string) — unique
  - `password` (string) — hashed on insert
- **201:** `{ accessToken, refreshToken, expires }` (no `authenticated`)
- **400:** `Username {username} already in use`
- **401 / 403:** missing token or permission

## POST /api/v1/auth/refresh

- **Auth:** refresh JWT in the body (`Reauth` / `jwt-refresh`). No access token.
- **Body:**
  - `refreshToken` (string) — the refresh JWT. Swagger `login` is unused.
- **201:** `{ accessToken, refreshToken, expires, authenticated: true }`
- **401:** invalid/expired refresh JWT, or a JWT that does not match the stored `tb_user.refreshToken`

Issues a new pair and overwrites `tb_user.refreshToken`. A password change via
`PATCH /users/me` replaces that stored token, so the previous refresh JWT fails
here. Refresh-strategy claims are **not** re-read from RBAC; the following
access token is.
