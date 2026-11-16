# Domain documentation — rodcordeiro/raizes-de-aruanda

## Estratégia
**Single-context**: uma fonte de contexto principal, sem CONTEXT-MAP.md ou contextos por pacote. Não foram identificados sinais de monorepo/workspaces na raiz durante o setup.

Next.js App Router, cliente da raizes.api. O glossário principal é `CONTEXT.md`, com referências de domínio em `.agents/references/domain.md` e decisões em `docs/adr/`. O design system é `docs/DESIGN.md`.

## Regras
- Termos de negócio aprovados pertencem ao `CONTEXT.md`; não registrar hipóteses como fatos.
- Decisões arquiteturais significativas pertencem a `docs/adr/NNNN-*.md`, com status, contexto, decisão e consequências.
- Especificações implementáveis pertencem a `docs/specs/`, com histórias de usuário, contratos, testes, critérios de aceitação e fora de escopo.
- Não duplicar contratos vivos: preferir referências às skills/referências existentes.
- Alterações de domínio e arquitetura devem acompanhar o PR da mudança correspondente.

Para SPEC-079, consulte `docs/specs/SPEC-079-WEB.md` e `docs/adr/0001-rbac-integrity.md`. Integrações API exigem consulta prévia à skill `.agents/skills/api-endpoints/`.
