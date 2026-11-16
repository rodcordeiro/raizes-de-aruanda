# ADR-0001 — Integridade das alterações de RBAC

- **Status:** Proposta — decisões de produto aprovadas nas rodadas 1 e 2 da issue #79; mecanismo técnico pendente
- **Data:** 2026-11-16
- **Referência:** https://github.com/rodcordeiro/raizes-de-aruanda/issues/79

## Contexto

O frontend Next.js consome a `raizes.api`. O contrato documentado expõe operações individuais de associação e revogação de permissões/roles, além de exclusão de roles com remoção de vínculos. A interface solicitada terá edição de matriz com salvamento único, múltiplas roles por usuário e proteção do último administrador.

## Decisões de produto aprovadas

1. Bloquear exclusão de role com usuários associados.
2. Impedir operações que removam o último usuário efetivamente autorizado por `role:assign`, inclusive sob concorrência.
3. Permitir editar a matriz de permissões e confirmar em um único salvamento.
4. Auditar criação, edição, exclusão e alterações de vínculos RBAC.
5. Expandir wildcard em permissões individuais na interface; semântica de persistência ainda não decidida.

## Questões técnicas em aberto

- Endpoint transacional para substituição do conjunto de permissões de uma role versus múltiplas chamadas com compensação.
- Estratégia de controle de concorrência e preservação do último administrador.
- Semântica de wildcard na UI e no backend (somente representação ou migração de grants).
- Política de falha de auditoria, rollback e estrutura dos eventos.

## Consequências

- A validação exclusivamente no frontend é insuficiente para as invariantes de segurança.
- O contrato atual da API provavelmente precisará ser estendido para cumprir atomicidade e proteção contra perda de acesso.
- Nenhuma decisão sobre endpoints ou schema adicional deve ser tratada como aprovada antes da próxima rodada.
