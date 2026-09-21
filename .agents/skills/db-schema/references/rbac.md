# RBAC contract

Reviewed against the raizes.api checkout on 2026-09-21. This is a migration
and application review, not a new live database capture. The capture date
in [tables.md](tables.md) remains unchanged.

## Persistence

- Users receive permissions through roles only. There are no direct user
  grants or per-user deny overrides.
- `tb_roles`: generated integer `id`, unique `slug` (64), `name` (100).
- `tb_permissions`: generated integer `id`, unique `slug` (100).
- `tb_user_roles`: composite primary key `(user_id, role_id)`.
- `tb_role_permissions`: composite primary key `(role_id, permission_id)`.
- Migration `src/core/database/migrations/1788210000000-rbac.ts` declares
  ON DELETE/UPDATE CASCADE for both join tables' foreign keys. Deleting a
  role removes its user and permission assignments, not users or permissions.
- This management flow requires no new migration. Verify deployed foreign
  keys before relying on cascade behavior if database drift is suspected.

## Constraints and authorization

### Foreign keys declared by the migration

| Source | Target | ON DELETE / ON UPDATE |
| --- | --- | --- |
| `tb_user_roles.user_id` | `tb_user.id` | CASCADE / CASCADE |
| `tb_user_roles.role_id` | `tb_roles.id` | CASCADE / CASCADE |
| `tb_role_permissions.role_id` | `tb_roles.id` | CASCADE / CASCADE |
| `tb_role_permissions.permission_id` | `tb_permissions.id` | CASCADE / CASCADE |

The migration adds reverse-lookup indexes on `tb_user_roles.role_id` and
`tb_role_permissions.permission_id`. These are source declarations, not a
new inspection of deployed constraints.

### Effective access

The union of all a user's roles determines effective permissions. Removing
one grant leaves access intact if another role grants the same permission.
Permission checks use exact `resource:action` strings, without wildcards.
New roles start empty and new catalog permissions have no automatic grants.

Management routes require `role:assign`. Access-token authentication reads
current roles and permissions from persistence on each request. Changes take
effect on subsequent API requests, including requests using an older JWT.
This adds a database lookup per authentication. PHP session behavior has not
been changed or validated by this work.

Role slugs may be custom lowercase identifiers, up to 64 characters. Role
names are nonempty, up to 100 characters. Existing admin/editor slugs remain
accepted by POST /api/v1/users/:id/roles.

Deleting roles or removing role:assign can remove the operator's own access.
There is no reserved-role or last-administrator protection in this contract.
Renaming a role may affect external consumers that compare role slugs.

See [the endpoint contract](../../../../docs/rbac-api.md) for routes.
Source: RBAC service/controller, JWT strategy, and existing RBAC migration.
Do not infer production deployment from these files.
