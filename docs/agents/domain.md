# Domain documentation — rodcordeiro/raizes-de-aruanda

## Estratégia
Contexto único neste repositório. Sua participação no workspace com a API não cria um monorepo de pacotes. No workspace, consulte também `../docs/agents/domain.md` a partir da raiz do repositório; em clone isolado, use as regras abaixo.

Next.js App Router, cliente da raizes.api. O glossário principal é `CONTEXT.md`, com referências de domínio em `.agents/references/domain.md` e decisões em `docs/adr/`. O design system é `docs/DESIGN.md`.

## Regras
- Termos de negócio aprovados pertencem ao `CONTEXT.md`; não registrar hipóteses como fatos.
- Decisões arquiteturais significativas pertencem a `docs/adr/NNNN-*.md`, com status, contexto, decisão e consequências.
- Especificações implementáveis pertencem a `docs/specs/`, com histórias de usuário, contratos, testes, critérios de aceitação e fora de escopo.
- Não duplicar contratos vivos: preferir referências às skills/referências existentes.
- Alterações de domínio e arquitetura devem acompanhar o PR da mudança correspondente.

Para SPEC-079, consulte `docs/specs/SPEC-079-WEB.md` e `docs/adr/0001-rbac-integrity.md`. Integrações API exigem consulta prévia à skill `.agents/skills/api-endpoints/`.

## Entregas transversais

Mantenha `docs/specs/SPEC-<id>-WEB.md` neste repositório e `docs/specs/SPEC-<id>-API.md` em `rodcordeiro/raizes.api`. Use o mesmo identificador de iniciativa, links recíprocos, dependências e critérios de integração. O número da issue não precisa coincidir entre repositórios.

A spec WEB descreve interface, estados, acessibilidade e consumo HTTP. Referencie o contrato definido pela API; não replique uma definição divergente. Em publicação, use URLs GitHub para a contraparte; caminhos para o repositório irmão só funcionam no workspace.

Concluído quando responsabilidades, critérios de aceite e validação web estão definidos, a spec API está vinculada quando necessária e contratos pendentes estão marcados como planejamento.
