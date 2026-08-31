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
| Admin auth (`admin/` login/sessão/RBAC) | **Ativa** (lote auth; sem CRUD) |
| Admin CRUD catálogo / dash | **Adiados** |
| `bot.php` (anúncio) | Secundário |

## Fluxo home

1. Escolher **Linha** (nav / sheet)
2. Ver **chips de Ritmo** (quantidade + nome → primeiro ponto do ritmo)
3. Ler **Pontos** (letra; embed YouTube se link)

## Decisões ativas (Nero)

- Reabrir admin de catálogo (spec); dashboard continua adiado — auth PHP/`tb_user` neste lote
- YouTube embed imediato
- Layout mobile stacked + chips por ritmo
- Brand sage `#77927B` (pen + CSS)
