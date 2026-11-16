# Domain

## Propósito

Site público de **Pontos** do terreiro **Raízes de Aruanda**: canhoto da **Curimba** na **gira** e estudo da **Assistência**. Não é roteiro da gira.

## Glossário

Fonte canônica: `CONTEXT.md` (não duplicar aqui).

Termos-chave: Terreiro, Gira, Curimba, Assistência, Orixá, Guia, Linha, Categoria, Outros, Saudação, Ponto, Letra, Ritmo, Função (Chamada / Sustentação / Subida / Demanda).

## Superfícies

| Superfície | Status |
| --- | --- |
| Home (`/`) | **Ativa** |
| Ordem ritualística (`/ordem-ritualistica`) | **Ativa** |
| Admin login e sessão | **Ativa** |
| CRUD Pontos, Linhas, Ritmos | **Ativa** |
| Auditoria (`audit:read`) | **Ativa** — lista read-only |
| Perfil (`/admin/perfil`) | **Ativa** |
| Dashboard, giras, uploads, CRUD de users | **Adiados** |

## Fluxo home

1. Escolher **Linha** (nav / sheet)
2. Ver **chips de Ritmo**
3. Ler **Pontos** (letra; embed YouTube ou áudio direto)

## Fluxo admin

1. Login na API; sessão em cookie httpOnly
2. Listar e mutar catálogo conforme `permissions` (lista vazia ou ausente mostra as ações)
3. Excluir linha ou ritmo falha se ainda houver pontos
4. Auditoria paginada quando a lista de permissões incluir `audit:read`

## Decisões ativas (Nero)

- Front Next.js cliente HTTP da raizes.api (2026-10-02). Dashboard e UI de giras continuam adiados.
- YouTube embed imediato
- Layout mobile stacked + chips por ritmo
- Brand sage nos tokens (`docs/DESIGN.md`)
