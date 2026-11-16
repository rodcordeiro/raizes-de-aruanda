# Raízes de Aruanda

Glossário do terreiro e do catálogo público de pontos usados nas giras.

## Language

### Terreiro e gira

**Terreiro**:
Casa e comunidade de Umbanda.
_Avoid_: Igreja, templo, casa

**Raízes de Aruanda**:
Nome deste terreiro, ao qual o site pertence.
_Avoid_: Raizes, o site

**Gira**:
Reunião ou evento de celebração espiritual. Equivalente à missa católica.
_Avoid_: Missa, sessão, culto, reunião

**Curimba**:
Grupo que canta e toca os pontos durante a gira. O site é o canhoto dela.
_Avoid_: Coral, banda, músicos

**Assistência**:
Quem assiste a gira sem integrar a Curimba.
_Avoid_: Público, audiência, fiéis

### Forças

**Orixá**:
Divindade cultuada à qual uma linha pode pertencer. A mesma força pode existir também como linha de Guia; são linhas distintas (Orixá Exu ≠ Exu).
_Avoid_: Santo, deus, entidade

**Guia**:
Espírito que trabalha na gira. Cada falange é uma linha (Exu, Exu-mirim, Pomba-gira), distinta do Orixá homônimo quando houver.
_Avoid_: Entidade, espírito, santo

**Linha**:
Corrente de trabalho (falange) à qual o ponto pertence: Orixá, guia ou momento ritual. Não é o guia individual; o nome (Padilha, Tranca-Ruas, Zé Pilintra) vive na letra.
_Avoid_: Tag, playlist, guia nomeado

**Categoria**:
Agrupamento de linhas em Orixá, Guia ou Outros.
_Avoid_: Tipo, tag, pasta

**Outros**:
Categoria de linhas que são momentos rituais da gira, não Orixá nem Guia. Exemplos: Abertura, Encerramento, Defumação, Bater cabeça.
_Avoid_: Ritual, momento, extra

**Saudação**:
Cumprimento ritual da linha, dito ao anunciar o ponto.
_Avoid_: Greeting, salve, título

### Catálogo

**Ponto**:
Cântico ritualístico utilizado durante as giras de Umbanda. A entidade completa: letra, ritmo, função e áudio opcional.
_Avoid_: Música, hino, canto, letra

**Letra**:
Texto cantado de um ponto. Pode citar o guia individual; isso não cria uma linha.
_Avoid_: Ponto, lyric, conteúdo

**Ritmo**:
Toque e compasso do atabaque daquele ponto.
_Avoid_: Estilo, gênero, BPM

**Função**:
Papel do ponto na gira: chamada, sustentação, subida ou demanda.
_Avoid_: Tipo, momento, papel, categoria do ponto

**Chamada**:
Função do ponto que convoca a linha na gira.
_Avoid_: Tipo, abertura do ponto

**Sustentação**:
Função do ponto que mantém a presença da linha na gira.
_Avoid_: Tipo, meio, corpo

**Subida**:
Função do ponto que despede a linha na gira.
_Avoid_: Tipo, encerramento, despedida

**Demanda**:
Função do ponto ligada ao feitiço (trabalho espiritual): contra-feitiço, ao quebrar a demanda, ou embasamento do feitiço, ao demandar.
_Avoid_: Feitiço, trabalho, magia

## Administração — RBAC (escopo aprovado na issue #79, rodada 1)

**Role**: agrupamento nomeado de permissões atribuído a usuários. A gestão inclui criação, consulta, edição e exclusão; a exclusão deve ser bloqueada quando houver usuários vinculados.

**Permissão**: slug de autorização no formato `recurso:ação`. A interface permite listar e cadastrar slugs; edição e exclusão dependem de suporte explícito da API, ainda não confirmado.

**Atribuição de permissão**: vínculo entre role e permissão, administrado em matriz agrupada por recurso.

**Atribuição de role**: vínculo entre usuário e role; a interface deve permitir atribuir e revogar roles.

**Administrador de RBAC**: usuário autorizado pela permissão `role:assign` a gerenciar roles, permissões e vínculos.

**Superfícies previstas**: duas telas administrativas, Roles (incluindo matriz de permissões e atribuição a usuários) e Permissões. Fluxos detalhados, proteção contra perda de acesso e contratos adicionais permanecem em definição.

**Regra ainda não implementada**: impedir no backend a exclusão de roles vinculadas a usuários. O contrato atual da API documenta exclusão em cascata dos vínculos; a divergência precisa ser resolvida antes da implementação.

## RBAC — decisões aprovadas na issue #79, rodada 2

- **Roles de usuário**: um usuário pode possuir múltiplas roles; as permissões efetivas são a união das permissões concedidas pelas roles.
- **Último administrador**: operações não podem remover o último usuário efetivamente autorizado por `role:assign`; a regra precisa ser garantida no backend, inclusive sob concorrência.
- **Matriz de permissões**: o operador edita múltiplos vínculos role-permissão e confirma em um único salvamento. A atomicidade e o contrato de persistência ainda serão definidos.
- **Identidade de role**: slug e nome são editáveis, respeitando o contrato existente da API.
- **Wildcard**: a interface deve expandir visualmente slugs como `ponto:*` em permissões individuais. Ainda não foi decidido se a expansão modifica os vínculos persistidos; não assumir sem aprovação.
- **Atribuição de roles**: painel dedicado de busca de usuário, com consulta, atribuição e revogação de múltiplas roles; não implica uma terceira tela principal.
- **Auditoria**: criação, edição, exclusão e mudanças de vínculos RBAC devem gerar registros auditáveis; confirmar cobertura e mudanças necessárias na API.

**Pendências de arquitetura**: exclusão de role vinculada a usuários deve ser bloqueada (rodada 1); proteção do último administrador; salvamento em lote; semântica da expansão de wildcard; auditoria transacional. Estas são decisões de produto, não afirmações de implementação existente.

## RBAC — decisões aprovadas na issue #79, rodada 3

- **Substituição da matriz**: criar endpoint transacional na API para substituir integralmente as permissões vinculadas a uma role em uma única operação.
- **Concorrência**: detectar edição concorrente; em conflito, rejeitar salvamento e exigir recarregamento antes de nova tentativa.
- **Wildcard**: converter grants wildcard, como `ponto:*`, em permissões individuais explícitas ao salvar; definir catálogo de ações e tratamento de alterações futuras antes de implementar.
- **Auditoria**: falha na gravação de auditoria deve reverter a alteração RBAC na mesma transação.
- **Autoatribuição**: administrador pode alterar as próprias roles, desde que a proteção do último administrador continue satisfeita.
- **Exclusão**: a API deve retornar HTTP 409 ao tentar excluir role vinculada a usuários, incluindo a quantidade de usuários afetados para exibição na UI.
- **Permissões**: nesta entrega, somente consulta e cadastro; renomeação e exclusão de slugs fora do escopo.

**A definir na especificação final**: payload e versionamento do endpoint de substituição, tratamento de conflitos e granularidade da auditoria, catálogo de expansão de wildcards, fluxos de erro e critérios de aceitação.
