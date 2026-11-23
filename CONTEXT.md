# Raízes de Aruanda

Glossário do terreiro e do catálogo público de pontos usados nas giras.

## Filhos da casa — domínio confirmado em 2026-11-17, ainda não implementado

- **Filho da casa**: pessoa aceita na casa; o gerenciamento proposto abrange apenas filhos. Candidatos pertencem a uma especificação própria.
- **Ingresso**: após solicitação, participação na abertura de três giras e permanência assistindo durante cada gira; ao final, o jogo de búzios consulta o chão sobre a aceitação. Não há ingresso automático por contagem de giras.
- **Suspensão/afastamento**: período de seis meses sem possibilidade de retorno; ao término, a reativação depende de processo administrativo, sem automatismo nem solicitação de reativação pelo filho.
- **Licença temporária**: por atividade profissional ou tratamento de saúde, distinta de afastamento; permite retorno antes do prazo previsto.
- **Desligamento**: exige prazo mínimo definido em configuração geral, inicialmente de seis meses. O retorno exige o procedimento completo de ingresso, com três giras e jogo de búzios para aceitação.
- **Parametrização**: tela administrativa prevista para configurar o prazo mínimo de retorno após desligamento; alterações aplicam-se também aos desligamentos anteriores.
- **Cargo hierárquico**: progressão religiosa em Abiã, Yawo, Egbomi e Babalorixá/Yalorixá.
- **Função ritualística**: atribuição como Ogã ou Axogun, que pode coexistir com cargo hierárquico.

Detalhes de contrato e interface permanecem em discussão; regras aprovadas de acesso e permissões estão nas seções seguintes; estas definições não alteram o contrato RBAC existente.

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

## RBAC — decisões aprovadas na issue #79, rodada 4

- **Versionamento**: cada role possui versão monotônica, enviada no salvamento da matriz; conflito de versão retorna HTTP 409.
- **Conflito na UI**: preservar edição local e oferecer recarregamento explícito, sem sobrescrever silenciosamente.
- **Expansão de wildcard**: usar todos os slugs explícitos existentes do recurso no catálogo; novos slugs criados posteriormente não são concedidos automaticamente.
- **Último administrador**: contar usuários com permissão efetiva exata `role:assign`, independentemente do slug da role.
- **Auditoria**: registrar autor, recurso, operação e antes/depois, sem dados sensíveis, na mesma transação da mutação.
- **Documentação**: especificações independentes por repositório: `docs/specs/SPEC-079-WEB.md` (frontend) e `rodcordeiro/raizes.api/docs/specs/SPEC-079-API.md` (backend). Nenhuma implementação foi iniciada.

## Filhos da casa — decisões complementares de 2026-11-17

- Licença mantém acesso interno. Suspensão/afastamento e desligamento bloqueiam login e sessões já abertas. Ao tentar reativar filho, exibir modal de confirmação; cancelar mantém o estado atual. Reativação confirmada restabelece acesso se houver login habilitado no cadastro, removendo também bloqueios manuais. Bloqueio manual de login pode existir independentemente da situação religiosa.
- Administração e comando da casa gerenciam operações por roles/permissões. Permissões separadas aprovadas: consultar filhos; editar e auditar; alterar situação; visualizar guias; exportar; gerenciar parâmetros. Editar cadastro não autoriza alterar situação ou parâmetros. Slugs, atribuição às roles e requisitos cumulativos ainda serão definidos.
- Após nova aceitação de um desligado, preservar cadastro e registrar novo período de vínculo; todos os cargos hierárquicos e funções ritualísticas/administrativas devem ser reconfirmados.
- Criar tabela de logs para auditar toda atualização de filho. Atualização e log são atômicos na mesma transação; falha no log cancela a atualização. Registrar filho, autor, data, operação e campos alterados com antes/depois; motivo de saúde apenas como categoria, sem diagnóstico. Integração com tb_audit_logs, retenção e detalhamento do contrato ainda em discussão; nenhuma tabela ou migration implementada nesta rodada.

- Prazos de afastamento/desligamento contam da data efetiva, com lançamento administrativo retroativo permitido; data efetiva e data de registro são distintas.

## Filhos da casa — cadastro confirmado em 2026-11-17

- Obrigatórios: nome completo, data de nascimento, telefone e/ou WhatsApp e contato de emergência com nome, telefone/WhatsApp e parentesco. Idade calculada a partir da data de nascimento. E-mail e demais campos opcionais.
- Coroa e ajuntó são campos distintos com seleção de múltiplos orixás. Guias são uma lista de nome e linha. Demais campos incluem apelido/nome social, data de ingresso, cargos e situação.
- Filho pode existir sem conta de acesso.
- Cargo hierárquico opcional, com no máximo um vigente por filho; múltiplas funções ritualísticas e administrativas podem coexistir.
- Guias têm visualização restrita por permissão específica atribuída às roles administrativas autorizadas. Na auditoria, editores sem essa permissão veem apenas “lista de guias alterada”; antes/depois é restrito aos autorizados.
- Quem pode editar filhos também pode consultar sua auditoria, respeitando as restrições de visibilidade dos dados.

- Todo novo cadastro de filho inicia com situação ativa.

## Filhos da casa — licença, exclusão e privacidade

- Licença temporária exige data inicial; previsão de retorno opcional.
- Prazo geral de desligamento pode ser inferior a seis meses; seis meses é o valor inicial.
- No retorno após desligamento, cargos e funções anteriores permanecem no histórico e só voltam a vigorar após reconfirmação administrativa.
- Não haverá soft delete. Desabilitar cadastro/login, mantendo consulta do cadastro e histórico para administradores.
- Adequação à LGPD é requisito; desabilitação não substitui eliminação/anonimização quando aplicável. Base legal para dados sensíveis, retenção, direitos dos titulares e tratamento de menores e terceiros ainda precisam ser definidos. Nenhuma declaração de conformidade nesta etapa.

- Há filhos menores; responsável legal obrigatório com nome, parentesco e telefone/WhatsApp, podendo ser também contato de emergência. Autorizações e comprovação de representação ainda serão definidas. Não existe aviso de privacidade ou documento de autorização para uso dos dados, conforme relato do mantenedor.
- Responsável administrativo ou pelo site atende solicitações sobre dados pessoais; canal ainda em definição.
- Exportação com permissão específica: lista simplificada em CSV (nome completo, apelido/nome social, idade calculada, cargo hierárquico, situação) e ficha individual em PDF (dados cadastrais autorizados, responsável legal, contato de emergência e histórico de vínculos; auditoria apenas na tela). Guias só constam no PDF com as permissões de exportação e visualização de guias cumulativamente.
- Auditar exportações com autor, data e seleção exportada, sem copiar o arquivo gerado para o log.

## Cadastro unificado e sessões — decisão aprovada, não implementada

- Manter tb_user e IDs; cadastro de membro é a função principal e credenciais são opcionais. Administração habilita login por username único e convite temporário para senha; sem cadastro duplicado.
- Remover refreshToken de tb_user; armazenar estado de múltiplas sessões e hash do refresh no Redis em Docker. Renovação não atualiza cadastro.
- Login concede 15 dias; cada renovação válida redefine expiração para 10 dias a partir da renovação, mesmo reduzindo o prazo anterior, sem limite absoluto. Access token tem validade aprovada de 1h.
- Validar sessão Redis em cada acesso protegido. Redis indisponível bloqueia temporariamente login/refresh/acesso protegido, sem fallback MySQL; perda de sessões exige novo login.
- Logout encerra sessão atual; troca/recuperação de senha e bloqueios revogam todas.
- Migrar encerrando sessões existentes; recuperar senha do admin por comando no servidor, sem exibir senha, preservando ID/roles. Completar campos legados posteriormente sem dados fictícios.
- Atomicidade da rotação, falhas parciais MySQL/Redis, consumo do convite, contratos e configuração operacional permanecem pendentes. Nenhum Redis foi iniciado nem senha redefinida nesta discussão.

- Rodada complementar aprovada: access token de 1h; refresh concorrente com troca atômica e um vencedor, conflito recuperável sem apagar sessão vencedora; indisponibilidade Redis preserva cookies. Não armazenar versão de autenticação/revogação no MySQL. Protocolo de coordenação de falhas parciais e replay ainda pendente; resposta perdida exige novo login apenas na sessão afetada.

- Em alteração sensível, aceito restringir temporariamente operações de sessão e manter restrição até reconciliação se houver falha parcial; protocolo ainda pendente. Se a resposta de uma rotação concluída se perder, exigir novo login apenas para a sessão afetada, sem reenvio do novo refresh e sem revogar outras sessões.

- Aprovado: reinício Redis invalida sessões sem restaurar snapshots antigos. Convite de senha por UUID associado ao usuário no Redis, uso único e TTL 24h; reemissão invalida anterior. Nome completo exige permissão de editar filho.
- Reconciliação automática por cron na API a cada minuto, para operações pendentes há mais de cinco minutos sem progresso, preservando bloqueios manuais e vínculo. Tabela MySQL de operações pendentes permite recuperação após reinício, sem tokens nem versão de autenticação; estados e concorrência ainda pendentes. Planejamento, não implementação.

- Rodada G1–G4 aprovada: reconciliação após mais de cinco minutos sem progresso, com execução exclusiva; retry a cada minuto e aviso após cinco falhas, sem liberar restrição. Canal do aviso e protocolo técnico pendentes.
- Editar guias exige edição de filho e visualização de guias cumulativamente. Falha ao auditar exportação impede entrega de CSV/PDF, com erro e possibilidade de nova tentativa.

## Retorno e contatos — rodada B1–B4 aprovada

- Três giras para retorno de desligado começam após terminar o prazo mínimo; na reativação, operador autorizado atesta três giras e aceitação pelos búzios e informa data da aceitação, com auditoria sem detalhes do jogo.
- Prazo geral em meses inteiros não negativos, padrão seis. Zero remove apenas a espera, preservando procedimento de ingresso completo.
- Um telefone, um WhatsApp, um e-mail opcional, um contato de emergência e um responsável legal obrigatório para menor. Telefone e WhatsApp podem compartilhar número; ao menos um é obrigatório. Responsável pode ser também contato de emergência.

## Datas, auditoria e listagem — rodada C1–C4 aprovada

- Prazos de afastamento/desligamento em meses de calendário, ajustando para último dia quando necessário; elegibilidade na data resultante em America/Sao_Paulo, sem reativação automática.
- Data efetiva de situação aceita hoje/passado, não futuro; previsão de retorno da licença pode ser futura.
- Auditar também criação de filho e alteração de parâmetros na mesma transação; criação sem antes, parâmetros com antes/depois, autor e data.
- Lista com busca por nome completo/apelido e filtros por situação/cargo hierárquico. CSV exporta todos os resultados filtrados, não só a página visível, respeitando permissões.

## Catálogos e convite — rodada DQ1–DQ4 aprovada

- Coroa/ajuntó reutilizam o catálogo existente de linhas classificadas como Orixá; guias usam nome individual e linha do catálogo existente.
- Apenas atribuição de cargos/funções previamente cadastrados nesta entrega; CRUD do catálogo fica no draft de cargos.
- Habilitar login e emitir convite exigem user:invite e consulta de filhos cumulativamente. Editar cadastro isoladamente não permite habilitar credenciais.
- Identificação de categorias elegíveis e efeitos de exclusão/renomeação de itens vinculados ainda serão especificados.

## Confirmação para análise de privacidade

O mantenedor confirmou que o terreiro possui pessoa jurídica e menores também terão login. Natureza sem fins lucrativos, porte e dispensas ATPP não comprovados. No workspace, diagnóstico preliminar e gaps em ../.lgpd/STATUS.md e ../.lgpd/gaps.md; não constituem conformidade ou política aprovada. Regras do uso direto por menores e governança continuam em definição.
