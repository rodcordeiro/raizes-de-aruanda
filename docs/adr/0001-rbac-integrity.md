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

## Rodada 3 — decisões técnicas aprovadas

1. **Endpoint de substituição transacional**: substituir integralmente os vínculos role-permissão em uma operação de API, sem gravação parcial.
2. **Controle de concorrência**: rejeitar atualização baseada em estado obsoleto; UI deve recarregar antes de tentar novamente. Estratégia de versão/ETag pendente.
3. **Expansão de wildcard na persistência**: converter `recurso:*` em grants explícitos por ação no salvamento. Definir catálogo de ações, expansão de permissões existentes e impacto de futuras ações.
4. **Auditoria atômica**: gravação de eventos auditáveis e mutação RBAC na mesma transação; falha de auditoria provoca rollback.
5. **Autoalteração**: permitida apenas se não resultar na perda do último administrador efetivo.
6. **Exclusão protegida**: HTTP 409 quando houver usuários vinculados, com contagem de usuários no erro.
7. **Catálogo de permissões**: consulta e cadastro apenas nesta entrega; renomeação/exclusão excluídas.

## Consequências e validações pendentes

- A API precisa oferecer substituição atômica e proteção concorrente; o frontend não pode garantir essas invariantes isoladamente.
- O serviço deve validar a proteção do último administrador no estado resultante e sob concorrência, inclusive ao remover vínculos ou grants.
- A expansão de wildcard deve ser consistente com o catálogo efetivo de ações; a semântica de permissões futuras precisa de decisão explícita.
- A API deve disponibilizar contagem de usuários vinculados para a mensagem de bloqueio de exclusão.
- Definir status e payload de conflitos de versão, mecanismo de auditoria e compatibilidade dos endpoints atuais na especificação final.
