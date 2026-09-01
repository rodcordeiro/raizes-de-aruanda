---
name: db-schema
description: >
  Schema MySQL tb_* (colunas, tipos, FKs). Use when writing SQL/PDO,
  admin CRUD, auth/RBAC/audit, migration alignment, or FK checks.
---

# DB schema — Raízes de Aruanda

## When to load

Read **[tables.md](tables.md)** before inventing column names, types, or joins.

Trust `tables.md` for routine CRUD. Re-run DESCRIBE only on reported drift or an explicit refresh request.

## Canon

| Layer | Role |
| --- | --- |
| Live MySQL (shared with `raizes.api`) | Fact for types/keys as of last capture in `tables.md` |
| `raizes.api` migrations | Source of schema **changes** |
| This skill | Agent cache — update when columns change |

Active contract is `tb_*`. Treat `icnt_*` and `config/database/*.sql` as archive.

## Active domain map

| Concern | Tables |
| --- | --- |
| Catálogo | `tb_pontos` → `tb_linhas`, `tb_ritmos`; linha → `tb_categorias` |
| Auth | `tb_user` (`password` bcrypt) |
| RBAC | `tb_user_roles` → `tb_roles` → `tb_role_permissions` → `tb_permissions` |
| Audit | `tb_audit_logs` |

## Rules of use

PDO/prepared-statement habits: `.agents/references/patterns.md`.

1. Catalog FKs: `tb_pontos.linha` → `tb_linhas.id`; `tb_pontos.ritmo` → `tb_ritmos.id`; `tb_linhas.categoria` → `tb_categorias.id`.
2. Refuse delete of linha/ritmo while `tb_pontos` still references them (app gate; UX independent of DB CASCADE).
3. Write `tipo` as `Chamada` | `Sustentação` | `Subida`.
4. Audit and logs: actor + resource metadata only — omit `password` and `refreshToken` values.

## Refresh procedure

When schema drifts:

1. `SHOW FULL COLUMNS` for each `tb_*` (app PDO / Docker; column metadata only).
2. Replace the tables in [tables.md](tables.md).
3. Bump **Captured** date in `tables.md`.
4. Register a Nero snapshot on project `raizes-de-aruanda` noting the refresh.

Done when: `tables.md` matches DESCRIBE, Captured is today, and the Nero snapshot exists.
