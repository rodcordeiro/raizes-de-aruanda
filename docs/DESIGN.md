---
name: Raízes de Aruanda
description: >
  Catálogo público de pontos da Curimba do terreiro Raízes de Aruanda.
  Light, flat, leitura de letra em gira — sem dashboard.
colors:
  brand: "#77927B"
  brandContrast: "#FFFFFF"
  bg: "#FFFFFF"
  text: "#111111"
  muted: "#4A4A4A"
  border: "#DDE2DE"
  surfaceMuted: "#F5F7F6"
  activeTint: "#EEF2EF"
  chipInactive: "#EEF1EF"
  chipLabel: "#333333"
  handle: "#CDD2CD"
  scrim: "#00000073"          # rgba(0,0,0,0.45)
  videoBg: "#1A1A1A"
  youtube: "#E53935"          # exceção marca externa
  shadow: "#00000033"         # Pencil; CSS sheet ≈ rgba(0,0,0,0.2)
typography:
  fontFamily: "Source Sans 3"
  weights: [400, 600, 700]
rounded:
  sm: 8                       # filter, video
  sheet: 16                   # nav sheet top corners mobile
  pill: 999                   # ritmo chips
  full: 50%                   # logo
spacing:
  headerMobile: 60
  headerWeb: 64
  touch: 44
  chipBarMobile: 68           # 12+44+12; Pencil note cita 69 c/ border 1
components:
  header:
    backgroundColor: "{colors.brand}"
    textColor: "{colors.brandContrast}"
  navLineActive:
    backgroundColor: "{colors.activeTint}"
    textColor: "{colors.brand}"
    accent: "{colors.brand}"
  ritmoChipActive:
    backgroundColor: "{colors.brand}"
    textColor: "{colors.brandContrast}"
  ritmoChipInactiveMobile:
    backgroundColor: "{colors.chipInactive}"
    textColor: "{colors.chipLabel}"
  pontoDivider:
    borderColor: "{colors.border}"
  ytPlay:
    backgroundColor: "{colors.youtube}"
---

# Design System: Raízes de Aruanda

Agente: este arquivo é **reference** (cache de convenção + Named Rules). SSOT de valores: `assets/css/main.css` `:root`, `assets/css/mobile.css`, Pencil `docs/design/design.pen`. Glossário de domínio: `CONTEXT.md`. Antes de inventar token/componente, checar a tabela CSS↔Pencil e as Named Rules abaixo.

## Overview

**Creative North Star:** *A letra respira; o sage só marca o caminho da Curimba.*

Catálogo público **Linha → Ritmo → Ponto (letra)** para a Curimba achar o ponto na gira. Superfície light/flat; sage marca identidade e estado ativo; tipografia Source Sans 3 carrega a letra.

**Key Characteristics:**

- Um shell de catálogo (header + nav + conteúdo), não dashboard.
- Sage (`--brand` / `$color.brand`) = identidade + ativo; nunca accent paralelo.
- Letra é o conteúdo dominante; chrome fica quieto.
- Mobile: hero Linha rola; chips sticky. Desktop: sidebar 240.
- Glossário do terreiro (The Glossário Rule → `CONTEXT.md`).

## Colors

Paleta light: fundo `bg`, tinta `text`/`muted`, sage `brand` para chrome e estado.

### Primary

- **Brand / sage** (`brand`): header fill, nav active, chips active, hero Linha (mobile), category labels.
- **Brand contrast** (`brandContrast`): texto/ícone sobre fill brand.

### Neutral

- **bg**, **text**, **muted**, **border**, **surfaceMuted**, **activeTint**, **chipInactive**, **chipLabel**, **handle**, **scrim**, **videoBg**.
- **shadow**: só overlay sheet (Pencil); CSS sheet ≈ `rgba(0,0,0,0.2)` hardcoded.

### Exception

- **youtube**: só play button (The YouTube Exception Rule).

### Token map (CSS ↔ Pencil ↔ hex)

| Papel | CSS | Pencil | Hex |
|---|---|---|---|
| Brand | `--brand` | `$color.brand` | `#77927B` |
| Sobre brand | `--brand-contrast` | `$color.brandContrast` | `#FFFFFF` |
| Fundo | `--bg` | `$color.bg` | `#FFFFFF` |
| Texto | `--text` | `$color.text` | `#111111` |
| Secundário | `--text-muted` | `$color.muted` | `#4A4A4A` |
| Borda | `--border` | `$color.border` | `#DDE2DE` |
| Superfície | `--surface-muted` | `$color.surfaceMuted` | `#F5F7F6` |
| Tint ativo | `--active-tint` | `$color.activeTint` | `#EEF2EF` |
| Chip inativo | `--chip-inactive` | `$color.chipInactive` | `#EEF1EF` |
| Label chip | `--chip-label` | `$color.chipLabel` | `#333333` |
| Handle | `--handle` | `$color.handle` | `#CDD2CD` |
| Scrim | `--scrim` | `$color.scrim` | `rgba(0,0,0,0.45)` / `#00000073` |
| Vídeo | `--video-bg` | `$color.videoBg` | `#1A1A1A` |
| YouTube | `--youtube` | `$color.youtube` | `#E53935` |
| Sombra sheet | *(CSS hardcoded)* | `$color.shadow` | `#00000033` |
| Fonte | `--font` | `$font.family` | Source Sans 3 |
| Letra | `--letra-size` | `$font.size.letra` | 19px desktop |
| Header H | `--header-height` | `$space.headerWeb` / `$space.headerMobile` | 64 / 60 |
| Touch | `--touch` | — | 44px |

### Named Rules (color)

**The Semantic Color Rule.** `--brand` / `$color.brand` = identidade e estado ativo. Não criar `accent`/`primary` paralelo; não usar hex solto no código novo.

**The YouTube Exception Rule.** `--youtube` / `$color.youtube` só no botão play. Fora disso, paleta sage.

**The Contrast Caution Rule.** brand↔branco ~**3.4:1** (falha AA texto normal). Preferir fill brand + `brandContrast`, ou display grande (`linha-nome` mobile). Proibido: brand como texto miúdo sobre `bg` (body, labels pequenos). Category title 13px brand já no limite — não repetir o padrão.

## Typography

**Family:** Source Sans 3 (`--font` / `$font.family`). Weights: 400, 600, 700.

| Papel | Desktop | Mobile | Token / nota |
|---|---|---|---|
| Letra (corpo do ponto) | 19px / 1.5 / 400 | 18px / 1.55 / 400 | `--letra-size`, `--letra-lh` |
| Header title | 22/700 `brandContrast` | oculto | |
| Linha nome | 32/700 `text` (link brand) | **36/700 brand** | hero mobile |
| Ponto ritmo (`h2`) | 20/700 | 17/700 | |
| Chip label | 14/400 | 14/600 | |
| Category | 13/700 uppercase | idem | brand — Contrast Caution |
| Empty | letra size + `muted` | idem | |

### Named Rules (type / domain)

**The Letra Rule.** Corpo do ponto = `--text` + `--letra-size` (19 desktop / 18 mobile). Nunca brand no corpo da letra. `white-space: pre-wrap`.

**The Glossário Rule.** UI e docs de produto usam **Linha, Ritmo, Ponto, Letra, Curimba** — ver `CONTEXT.md`. Não: música, playlist, tag, lyric.

## Elevation

**The Flat Elevation Rule.** UI em rest = `bg` + borda 1px `--border` + tint. Sem cards, glass, multi-shadow. Elevação permitida só no nav sheet mobile (`shadow` / scrim).

## Layout

Breakpoint: `max-width: 768px` = mobile.

| | Desktop (>768) | Mobile (≤768) |
|---|---|---|
| Shell | header full-bleed + sidebar **240** | header + content; nav = bottom sheet |
| Linha | nome + chips inline | stacked: hero → chips sticky → pontos |
| Chips | wrap estático | sticky sob header; scroll-x; `scroll-padding-top: 68` |
| Pad conteúdo | ~32–40 | 16; pontos 20/16/32 |

### Named Rules (layout)

**The Linha Hero Rule.** Mobile: nome da Linha = hero (`brand`, 36/700); **não** sticky. Só os chips grudam.

**The Ritmo Chip Rule.** Chip = índice de Ritmo (contagem + nome). Active = fill `brand` + `brandContrast`. Inactive mobile = `chipInactive`/`chipLabel`. Desktop inactive pode usar `surfaceMuted`+border (dualidade intencional).

**The Nav Rail Rule.** Linha ativa = `activeTint` + barra 3px `brand` à esquerda + texto brand 600. Categoria (Orixá/Guia/Outros) = uppercase brand. Sem card na nav.

**The Touch Rule.** Alvos interativos mobile ≥ `--touch` (44px): menu, close, nav-line, chips.

## Components

Só o que existe no produto. Specs densas; frames Pencil + CSS são a prova.

### Header
- Fill `brand`; H 64 web / 60 mobile; sticky z-40.
- Logo círculo 48→40; título “Pontos de Umbanda” 22/700 `brandContrast` (hidden ≤768).
- Hamburger 44×44 + ícone 24 — só mobile.

### Nav sheet / sidebar
- Desktop: fixed 240, `border-right`, pad 24/16, sob header.
- Mobile: bottom sheet max `min(80vh, 680)`, radius 16 16 0 0, slide `translateY`, shadow.

### Scrim / handle
- Scrim full-bleed `scrim`; handle 36×4 r2 `handle`.
- Sheet header “Linhas” 18/700 + close 44.

### Filter
- Search `nav-filter`: H ≥44, radius 8, border; placeholder `muted` “Buscar linha…”.

### Category / Nav line
- Category: 13/700 uppercase letter-spacing, color `brand`.
- Line: minH 36 web / 44 mobile; active = The Nav Rail Rule.

### Linha nome
- Desktop: 32/700 `text`; link canal YT em `brand`.
- Mobile: pad 20/16/12/16; The Linha Hero Rule.

### Ritmo chips
- Desktop: wrap, H32, border, `surfaceMuted`, 14/400.
- Mobile: sticky top 0 no scrollport `#main`, H44, gap 10, pad 12/16, scroll-x; The Ritmo Chip Rule; bar = 68px → `scroll-padding-top` / `scroll-margin-top` nos pontos.

### Ponto
- `h2.ponto-ritmo` “N| Ritmo”; letra `.ponto-letra` (The Letra Rule).
- Divisor 1px `border`; gap ~20–24.

### YT placeholder / embed
- 16:9, max 640, radius 8, bg `videoBg`.
- Play 56 circle `youtube` (The YouTube Exception Rule); label 14 `brandContrast`.

### Empty
- “Nenhum ponto encontrado para esta linha.” — `muted` + letra size.

### Print (`print.css`)
- Some nav/chips/vídeo/áudio; letra preta; header brand com `print-color-adjust: exact`.

## Do's and Don'ts

### Do

1. **Do** referenciar tokens `--brand` / `$color.brand` — não hex solto em CSS/pen novo.
2. **Do** manter chips sticky e título da Linha rolável no mobile (The Linha Hero Rule).
3. **Do** falar Linha, Ritmo, Ponto, Letra, Curimba (The Glossário Rule).
4. **Do** alvos ≥ 44px no mobile (The Touch Rule).
5. **Do** flat + border; elevação só no sheet overlay (The Flat Elevation Rule).
6. **Do** vermelho YouTube só no play (The YouTube Exception Rule).
7. **Do** nav active = tint + barra 3px (The Nav Rail Rule).
8. **Do** print = letra legível, sem chrome de navegação.

### Don't

1. **Don't** brand como texto miúdo em `bg` (The Contrast Caution Rule).
2. **Don't** sticky título + chips juntos (~142px — rejeitado no Pencil).
3. **Don't** cards, purple gradients, dark-mode default.
4. **Don't** chamar Ponto de “música” / Linha de “playlist”.
5. **Don't** duplicar sage em tokens `accent`/`primary`.
6. **Don't** `--youtube` em chrome/nav.
7. **Don't** tipografia display/serif genérica na letra.
8. **Don't** estética dashboard/admin no catálogo público.

## Pointers

- Pencil: [`docs/design/design.pen`](design/design.pen) (frames `*_v2`)
- CSS: [`assets/css/main.css`](../assets/css/main.css), [`mobile.css`](../assets/css/mobile.css), [`print.css`](../assets/css/print.css)
- Glossário: [`CONTEXT.md`](../CONTEXT.md)
- Markup: `index.php`, `components/`
