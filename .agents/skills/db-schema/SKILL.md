---
name: db-schema
description: >
  Schema MySQL compartilhado por raizes.api e raizes-de-aruanda (tabelas tb_*, colunas e tipos).
  Use when writing SQL/PDO, admin CRUD, auth/RBAC/audit, migrations alignment,
  FK checks, or when the user mentions tables, columns, schema, or banco.
---

# DB schema — Raízes de Aruanda

## When to load

Read **[tables.md](references/tables.md)** before inventing column names, types, or joins.
For role CRUD, user-role assignments or permission revocation, read
**[rbac.md](references/rbac.md)** for the application contract and cascade behavior.

Do **not** re-DESCRIBE the live DB for routine CRUD unless the user reports schema drift or asks to refresh the skill.

## Canon

| Layer | Role |
| --- | --- |
| Live MySQL (shared by API and PHP) | Fact for types/keys as of last capture in `references/tables.md` |
| `raizes.api` migrations | Source of schema **changes** |
| This skill | Agent reference for captured columns and source-reviewed contracts |

Legacy `icnt_*` / `config/database/*.sql` are **not** the admin/home contract. Active app uses `tb_*`.

## Active domain map

| Concern | Tables |
| --- | --- |
| Catálogo | `tb_pontos` → `tb_linhas`, `tb_ritmos`; linha → `tb_categorias` |
| Auth | `tb_user` (`password` bcrypt; do not log) |
| RBAC | `tb_user_roles` → `tb_roles` → `tb_role_permissions` → `tb_permissions` |
| Audit | `tb_audit_logs` |

## Rules of use

1. Prefer prepared statements; never concatenate user input into SQL.
2. Catalog FKs: `tb_pontos.linha` → `tb_linhas.id`; `tb_pontos.ritmo` → `tb_ritmos.id`; `tb_linhas.categoria` → `tb_categorias.id`.
3. Delete linha/ritmo only when no pontos reference them (app enforces; FK may be CASCADE in DB — do not rely on CASCADE for UX).
4. `tipo` values for writes: `Chamada` | `Sustentação` | `Subida`.
5. Secrets: never dump `tb_user.password` / `refreshToken` into audit or logs.

## Refresh procedure

For a checkout-only refresh:

1. Consult `$nero` context for `raizes.api` and compare with current migrations,
   entities and affected services. Identify source facts separately from live DB facts.
2. Update the affected reference, recording the review date and source paths.
3. Preserve **Captured** in `references/tables.md` unless a new live query was performed.
4. Verify relative links and `git diff --check -- .agents/skills/db-schema`.

When schema drifts or a live database refresh is requested:

1. `SHOW FULL COLUMNS` for each `tb_*` (via app PDO / Docker, no secrets in output).
   Inspect `SHOW CREATE TABLE` for foreign keys, indexes and cascade actions;
   column output alone does not prove those constraints.
2. Replace the tables in [tables.md](references/tables.md).
3. Bump **Captured** date in `references/tables.md`.
4. Register a Nero snapshot on project `raizes-de-aruanda` noting the refresh.
