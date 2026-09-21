# Tables (MySQL)

**Captured:** 2026-09-01 via `SHOW FULL COLUMNS` on the shared DB used by this checkout.  
**Engine context:** InnoDB-style app DB (`u766359255_raizes`). Refresh this file when migrations change columns.

Notation: **Null** YES/NO · **Key** PRI / UNI / MUL · **Extra** as MySQL reports.

---

## tb_pontos

Catálogo de pontos (letra + FKs).

| Column | Type | Null | Key | Default | Extra |
| --- | --- | --- | --- | --- | --- |
| id | int(11) | NO | PRI | NULL | auto_increment |
| linha | int(11) | NO | MUL | NULL |  |
| ritmo | int(11) | NO | MUL | NULL |  |
| letra | text | NO | MUL | NULL |  |
| audio_url | varchar(255) | YES |  | NULL |  |
| created_at | timestamp | NO |  | current_timestamp() |  |
| updated_at | timestamp | NO |  | current_timestamp() | on update current_timestamp() |
| tipo | varchar(255) | YES |  | NULL |  |
| gravar_audio | tinyint(1) | YES |  | 0 |  |

**Notes:** `linha` / `ritmo` are FKs to `tb_linhas.id` / `tb_ritmos.id`. Admin CRUD writes `letra`, `tipo`, `audio_url`, `linha`, `ritmo` — does not expose `gravar_audio` in current UI.

---

## tb_linhas

Linhas (falanges) + playlist URL opcional.

| Column | Type | Null | Key | Default | Extra |
| --- | --- | --- | --- | --- | --- |
| id | int(11) | NO | PRI | NULL | auto_increment |
| nome | varchar(255) | NO | UNI | NULL |  |
| categoria | int(11) | NO | MUL | NULL |  |
| created_at | timestamp | NO |  | current_timestamp() |  |
| updated_at | timestamp | NO |  | current_timestamp() | on update current_timestamp() |
| canal_youtube | varchar(255) | YES |  | NULL |  |
| saudacao | varchar(100) | YES |  | NULL |  |

**Notes:** Home playlist link uses `canal_youtube` when non-empty. Lookup by name: `WHERE nome = :linha` (not a `linha` column).

---

## tb_ritmos

| Column | Type | Null | Key | Default | Extra |
| --- | --- | --- | --- | --- | --- |
| id | int(11) | NO | PRI | NULL | auto_increment |
| nome | varchar(255) | NO | UNI | NULL |  |
| created_at | timestamp | NO |  | current_timestamp() |  |
| updated_at | timestamp | NO |  | current_timestamp() | on update current_timestamp() |

---

## tb_categorias

Select-only in admin (no CRUD UI in MVP).

| Column | Type | Null | Key | Default | Extra |
| --- | --- | --- | --- | --- | --- |
| id | int(11) | NO | PRI | NULL | auto_increment |
| nome | varchar(255) | NO | UNI | NULL |  |
| created_at | timestamp | NO |  | current_timestamp() |  |
| updated_at | timestamp | NO |  | current_timestamp() | on update current_timestamp() |

---

## tb_user

Auth for admin (bcrypt in `password`).

| Column | Type | Null | Key | Default | Extra |
| --- | --- | --- | --- | --- | --- |
| id | int(11) | NO | PRI | NULL | auto_increment |
| password | varchar(255) | NO |  | NULL |  |
| username | varchar(255) | NO | UNI | NULL |  |
| name | varchar(255) | NO |  | NULL |  |
| refreshToken | varchar(255) | NO |  | NULL |  |
| created_at | timestamp | NO |  | current_timestamp() |  |
| updated_at | timestamp | NO |  | current_timestamp() | on update current_timestamp() |

**Notes:** Session login uses `id`, `username`, `name`, `password` + `password_verify`. Do not audit password/token values.

---

## tb_roles

| Column | Type | Null | Key | Default | Extra |
| --- | --- | --- | --- | --- | --- |
| id | int(11) | NO | PRI | NULL | auto_increment |
| slug | varchar(64) | NO | UNI | NULL |  |
| name | varchar(100) | NO |  | NULL |  |
| created_at | timestamp | NO |  | current_timestamp() |  |
| updated_at | timestamp | NO |  | current_timestamp() | on update current_timestamp() |

---

## tb_permissions

| Column | Type | Null | Key | Default | Extra |
| --- | --- | --- | --- | --- | --- |
| id | int(11) | NO | PRI | NULL | auto_increment |
| slug | varchar(100) | NO | UNI | NULL |  |
| created_at | timestamp | NO |  | current_timestamp() |  |
| updated_at | timestamp | NO |  | current_timestamp() | on update current_timestamp() |

**Notes:** Concrete slugs include `ponto:create`, `linha:update`, `audit:read`.
The API guard matches exact strings; `linha:*` does not grant `linha:update`.

---

## tb_user_roles

| Column | Type | Null | Key | Default | Extra |
| --- | --- | --- | --- | --- | --- |
| user_id | int(11) | NO | PRI | NULL |  |
| role_id | int(11) | NO | PRI | NULL |  |
| created_at | timestamp | NO |  | current_timestamp() |  |

Composite PK `(user_id, role_id)`.

---

## tb_role_permissions

| Column | Type | Null | Key | Default | Extra |
| --- | --- | --- | --- | --- | --- |
| role_id | int(11) | NO | PRI | NULL |  |
| permission_id | int(11) | NO | PRI | NULL |  |
| created_at | timestamp | NO |  | current_timestamp() |  |

Composite PK `(role_id, permission_id)`.

---

## tb_audit_logs

| Column | Type | Null | Key | Default | Extra |
| --- | --- | --- | --- | --- | --- |
| id | bigint(20) unsigned | NO | PRI | NULL | auto_increment |
| actor_user_id | int(11) | YES | MUL | NULL |  |
| actor_username | varchar(255) | NO |  | NULL |  |
| action | varchar(50) | NO |  | NULL |  |
| resource_type | varchar(100) | NO | MUL | NULL |  |
| resource_id | varchar(255) | YES |  | NULL |  |
| before_json | longtext | YES |  | NULL |  |
| after_json | longtext | YES |  | NULL |  |
| origin | varchar(100) | NO |  | NULL |  |
| http_method | varchar(10) | NO |  | NULL |  |
| http_path | varchar(2048) | NO |  | NULL |  |
| ip | varchar(45) | YES |  | NULL |  |
| user_agent | text | YES |  | NULL |  |
| created_at | timestamp | NO | MUL | current_timestamp() |  |

**Notes:** Admin list shows lean columns (no JSON payloads). Mutations write audit in the same transaction.

---

## Not present in this DB

| Name | Status |
| --- | --- |
| `bot_tb_registered_channels` | Absent (`1146`); only in old `config/database/scripts/` |
| `icnt_*` | Legacy scripts under `config/database/` — superseded by `tb_*` for current app |
