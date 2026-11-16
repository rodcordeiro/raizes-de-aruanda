# Issue tracker — rodcordeiro/raizes-de-aruanda

## Sistema
GitHub Issues do repositório `rodcordeiro/raizes-de-aruanda`. Branch de trabalho e integração: `develop`. A branch de produção/main não é alvo de tickets sem instrução explícita.

## Convenções
- Uma issue por entrega verificável, com objetivo, escopo, critérios de aceitação e seção `Blocked by:` para dependências.
- Referenciar SPEC/ADR e issue mãe quando houver; PRs devem citar issues relacionadas.
- Criar issues no repositório responsável pelo código; dependências entre API e frontend devem usar links absolutos.
- Não fechar issues mãe automaticamente ao publicar tickets. Fechar somente após validação da entrega.
- Para tickets sem bloqueios, usar a categoria de triagem `ready-for-agent` somente quando o label estiver configurado no repositório; não presumir que existe.
- Projeto de acompanhamento: [GitHub Projects #16](https://github.com/users/rodcordeiro/projects/16). A criação de issues não implica associação automática ao Project.

## Vocabulário recomendado de triagem (não aplicado ao GitHub)
`needs-triage`, `needs-info`, `ready-for-agent`, `ready-for-human`, `wontfix`. O repositório não possui skill local de triage identificada nesta inspeção; não foram criados ou modificados labels. Mapear labels existentes antes de ativar o fluxo.

## Fluxo
Especificar (to-spec) → decompor (to-tickets) → validar dependências → implementar em branch baseada em develop → PR → testes/revisão → merge → fechamento.
