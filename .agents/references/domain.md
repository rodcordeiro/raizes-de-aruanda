# Domain

## Propósito

Site público de **Pontos** do terreiro **Raízes de Aruanda**: canhoto da **Curimba** na **gira** e estudo da **Assistência**. Não é roteiro da gira.

## Glossário

Fonte canônica: `CONTEXT.md` (não duplicar aqui).

Termos-chave: Terreiro, Gira, Curimba, Assistência, Orixá, Guia, Linha, Categoria, Outros, Saudação, Ponto, Letra, Ritmo, Função (Chamada / Sustentação / Subida).

## Superfícies

| Superfície | Status |
| --- | --- |
| Home pública (`index.php`) | **Ativa** — prioridade |
| Admin auth (`admin/` login/sessão/RBAC) | **Ativa** |
| Admin CRUD **Pontos** (`admin/pontos/`) | **Ativa** |
| Admin CRUD **Linha** (`admin/linhas/`) | **Ativa** |
| Admin CRUD **Ritmo** (`admin/ritmos/`) | **Ativa** |
| Admin **Auditoria** (`admin/auditoria/`, `audit:read`) | **Ativa** — listagem read-only |
| Dashboard / giras / uploads / users | **Adiados** |
| `bot.php` (anúncio) | Secundário |

## Fluxo home

1. Escolher **Linha** (nav / sheet)
2. Ver **chips de Ritmo** (quantidade + nome → primeiro ponto do ritmo)
3. Ler **Pontos** (letra; embed YouTube se link)

## Fluxo admin (catálogo)

1. Login (`tb_user` + sessão)
2. Listar pontos/linhas/ritmos (exige `canReadCatalog`); mutações com `ponto:*` / `linha:*` / `ritmo:*`
3. Criar / editar / excluir com CSRF + perm + audit same-tx (linha/ritmo: delete recusa se pontos ligados)
4. Auditoria: listagem paginada se `audit:read`

## Decisões ativas (Nero)

- Reabrir admin de catálogo (spec); dashboard continua adiado — auth + CRUD pontos/linhas/ritmos + auditoria neste checkout
- YouTube embed imediato
- Layout mobile stacked + chips por ritmo
- Brand sage `#77927B` (pen + CSS)
