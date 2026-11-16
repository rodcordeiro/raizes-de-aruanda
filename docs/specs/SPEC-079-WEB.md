# SPEC-079-WEB — Administração de roles e permissões

Status: escopo aprovado; implementação não iniciada.
Issue: https://github.com/rodcordeiro/raizes-de-aruanda/issues/79
Repositório: rodcordeiro/raizes-de-aruanda; base de análise: develop.
Contrato dependente: `rodcordeiro/raizes.api/docs/specs/SPEC-079-API.md` na branch `develop`.

## Objetivo
Disponibilizar duas telas principais em /admin: Roles (CRUD, matriz de permissões e painel de busca/atribuição de roles a usuários) e Permissões (listar e cadastrar slugs). Autorização de administração por `role:assign`. Não criar tela principal independente para usuários, nem editar/excluir slugs de permissões.

## Estado existente
Next.js App Router, Server Actions, sessão via cookies httpOnly e `getSession()`; API consumida por `apiFetch`. `can()` atualmente mostra ações quando `permissions` está ausente/vazia; essa convenção deve ser revista para operações RBAC, pois a API exige `role:assign`. Área admin e CRUD de catálogo existentes fornecem padrões visuais; seguir `docs/DESIGN.md`. A API atualmente tem endpoints individuais de grants, mas ainda não tem salvamento transacional/versionamento.

## Fluxos e navegação
1. Menu administrativo: Roles e Permissões, visíveis somente com `role:assign` efetivo. Proteção server-side nas páginas e Server Actions; nunca depender só de ocultação do menu. Para RBAC, permissões ausentes/vazias NÃO significam autorização.
2. `/admin/roles`: listar roles com slug, nome e quantidade de usuários; criar, editar slug/nome, abrir detalhe, excluir com confirmação. Se role em uso, mostrar erro 409 e userCount; nunca oferecer exclusão em cascata.
3. `/admin/roles/[id]`: matriz por recurso, linhas de ações explícitas e estado marcado/desmarcado. Mostrar grants wildcard legados expandidos em ações individuais; após salvar, persistir apenas grants explícitos. Identificar alterações pendentes e permitir cancelar.
4. `/admin/roles` com painel dedicado de busca de usuários: buscar/selecionar usuário, carregar roles atuais, atribuir/revogar múltiplas roles, exibir permissões efetivas e feedback por operação. Evitar assumir que a listagem atual da API é paginada.
5. `/admin/permissoes`: listar por recurso, pesquisar slugs, cadastrar `recurso:acao` com validação e indicação de duplicidade; sem edição/exclusão.
6. Estados de loading, vazio, erro de rede, 401 (sessão), 403 (sem permissão), 404 (recurso removido), 409 (conflito/versionamento, último administrador, role em uso) e 429 (limite).

## Salvamento da matriz
- Ao abrir, armazenar `version` e snapshot de grants, incluindo wildcard legado.
- Operador modifica vários checkboxes e confirma uma vez. Enviar `{version,permissionIds}` para `PUT /api/v1/rbac/roles/:id/permissions`; não disparar uma requisição por checkbox.
- Ao receber 409 de versão, preservar edição local e mostrar aviso + ação explícita de recarregar. Não sobrescrever silenciosamente. Ao recarregar, oferecer confirmação antes de descartar alterações locais.
- Expandir `recurso:*` apenas para ações existentes no catálogo; não assumir concessão de novas ações no futuro. Mostrar aviso de migração do wildcard e de alteração dos grants persistidos; exigir confirmação antes do primeiro salvamento de uma role com wildcard legado.
- Em erro, não afirmar que salvou; em sucesso, atualizar snapshot e versão retornada.
- Proteção de último administrador e integridade são responsabilidade da API; frontend exibe erros com linguagem compreensível.

## Contratos
Consumir contratos existentes do catálogo `.agents/skills/api-endpoints/references/rbac.md` e o SPEC-079-API para os endpoints propostos. Não tratar os novos endpoints como existentes antes do merge da API. `GET /users` hoje retorna lista integral e `GET /rbac/users/:id/authorization` retorna roles/permissions; busca pode ser client-side inicialmente, com avaliação de escala.

## Critérios de aceitação
1. Sem `role:assign`, não exibir menu nem permitir renderização/Server Actions RBAC; API 403 não vaza dados.
2. Roles: criar, listar, editar slug/nome e excluir role sem usuários; validações e mensagens 400/404/409.
3. Role com usuários vinculados não pode ser excluída; exibir quantidade fornecida pela API.
4. Matriz agrupada por recurso exibe grants e wildcard legado corretamente.
5. Várias alterações são enviadas em uma única requisição transacional com versão.
6. Conflito 409 preserva alterações locais, oferece recarregar e não mostra sucesso falso.
7. Wildcard é expandido em slugs explícitos existentes e o operador é avisado da conversão; novas ações não são atribuídas automaticamente.
8. Painel permite buscar usuário e atribuir/revogar múltiplas roles, refletindo união das permissões.
9. Tentativa de remover último administrador exibe erro apropriado, sem perda de sessão ou alteração parcial.
10. Responsividade e acessibilidade: navegação por teclado, labels de checkboxes, foco e mensagens de erro; validar mobile ~370px.
11. Seguir tokens/design system; não criar cliente auth paralelo nem armazenar token no browser.
12. Testes de UI e integração cobrindo 401/403/404/409/429, rede, formulários e conflitos; smoke com API atualizada.

## Decomposição sugerida (não criar issues sem aprovação)
WEB-01 — Modelos, cliente RBAC e proteção de rotas/actions.
WEB-02 — Listagem, criação, edição e exclusão protegida de roles.
WEB-03 — Matriz por recurso, expansão de wildcard e salvamento versionado.
WEB-04 — Painel de busca de usuários e atribuição/revogação de roles.
WEB-05 — Catálogo e cadastro de permissões.
WEB-06 — UX de erros/conflitos, acessibilidade, responsividade e testes.

Dependências: WEB-01 antes das telas; WEB-02 depende API-02/API-04; WEB-03 depende API-01/API-03/API-04/API-05; WEB-04 depende API-04/API-05; WEB-05 pode começar com endpoints existentes; WEB-06 após integração.

## Revisão to-spec — histórias de usuário e fronteiras (2026-11-16)

### Histórias de usuário
1. Como administrador RBAC, quero acessar Roles e Permissões pelo menu, para gerenciar acessos.
2. Como usuário sem `role:assign`, quero não ter acesso às páginas e ações RBAC, para preservar a segregação.
3. Como administrador RBAC, quero listar, criar e editar roles, para organizar responsabilidades.
4. Como administrador RBAC, quero excluir uma role sem usuários e ver bloqueio quando em uso, para evitar revogação inesperada.
5. Como administrador RBAC, quero editar permissões por recurso numa matriz, para entender o alcance de cada role.
6. Como administrador RBAC, quero confirmar várias alterações de uma vez, para evitar estados intermediários.
7. Como administrador RBAC, quero preservar minhas alterações diante de conflito e escolher recarregar, para não perder trabalho.
8. Como administrador RBAC, quero visualizar a expansão de wildcards e confirmar sua conversão, para evitar concessões inesperadas.
9. Como administrador RBAC, quero buscar um usuário e consultar suas roles e permissões efetivas, para compreender seu acesso.
10. Como administrador RBAC, quero atribuir e revogar roles do usuário, para ajustar sua autorização.
11. Como administrador RBAC, quero listar e cadastrar permissões, para disponibilizar ações.
12. Como operador, quero receber erros compreensíveis e preservar dados de formulário quando possível, para corrigir problemas.
13. Como operador em dispositivo móvel ou teclado, quero usar todas as funções com acessibilidade, para administrar sem barreiras.

### Integração e UX fechadas
- O fluxo novo consome `GET /rbac/roles/:id` com `version` e `catalogVersion`; o salvamento único envia `{version,catalogVersion,permissionIds}`. Conflitos `RBAC_VERSION_CONFLICT` e `RBAC_CATALOG_CONFLICT` preservam escolhas locais, exibem a diferença e exigem recarregamento explícito. Nunca reenviar automaticamente após 409.
- Quando a role contém wildcard legado, a UI mostra o conjunto explícito correspondente, alerta que salvar substitui o wildcard e exige confirmação. Se não houver ações correspondentes, desabilitar salvamento da conversão e explicar o motivo.
- O painel de usuários é parte da tela Roles; consultar `GET /users` e `GET /rbac/users/:id/authorization`; vínculos são gravados por operações existentes com feedback individual, sem prometer atomicidade entre atribuições independentes.
- Em RBAC, `permissions` vazia/ausente significa **não autorizado**, independentemente do fallback geral de `can()`; o backend continua a fonte definitiva.
- As Server Actions não podem confiar apenas na navegação; devem validar sessão e permissão antes de cada mutação e propagar 401/403/404/409/429 com mensagens apropriadas.
- **Fronteira de testes**: validar páginas e Server Actions via integração HTTP e smoke de navegador desktop/mobile ~370px, teclado e foco; testes unitários complementares para expansão de wildcard e estados de conflito.

### Fora de escopo explícito
Tela principal separada de usuários, edição/exclusão de slugs de permissão, edição de dados cadastrais de usuários, novos grants diretos, persistência de tokens no browser, alteração da API no repositório frontend, dashboards e giras.
