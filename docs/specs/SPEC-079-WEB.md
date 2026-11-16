# SPEC-079-WEB — Administração de roles e permissões

Status: escopo aprovado; implementação não iniciada.
Issue: https://github.com/rodcordeiro/raizes-de-aruanda/issues/79
Repositório: rodcordeiro/raizes-de-aruanda; base de análise: main.
Contrato dependente: `rodcordeiro/raizes.api/docs/specs/SPEC-079-API.md` na branch `docs/issue-79-rbac-api-spec`.

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
