# Issue tracker — rodcordeiro/raizes-de-aruanda

## Escopo e referências

Issues e PRs deste repositório tratam de interface web e consumo HTTP. Entregas de API pertencem a `rodcordeiro/raizes.api`.
Ambos usam o [Project #16](https://github.com/users/rodcordeiro/projects/16).

No workspace, leia também `../docs/agents/issue-tracker.md` a partir da raiz do repositório. Em clone isolado, estas regras continuam aplicáveis. Todos os demais caminhos locais deste documento partem da raiz deste repositório.

## Publicar tickets

1. Leia spec, issue e comentários; confira duplicatas, dependências e ordem no Project.
2. Crie uma issue por entrega verificável, com objetivo, escopo, critérios de aceite, validação, spec/ADR e `Blocked by:`. Entre repositórios, use URLs ou referências completas; números isolados são ambíguos.
3. Specs transversais originam issues separadas por repositório, vinculadas entre si. Não feche a issue mãe apenas ao decompor tickets.
4. Associe cada issue ao Project #16 e confirme a associação; ela não é garantida pela criação.

## Executar tickets

1. Priorize itens `ready` na ordem do Project; confira se todos os bloqueios foram resolvidos antes de iniciar.
2. Mova para `in progress` e trabalhe em branch baseada em `develop`. PRs de produção/main exigem instrução explícita.
3. Após implementar e validar, mova para `in review`, aguardando conclusão do PR. Referencie a issue e a spec no PR.
4. Reavalie dependentes nos dois repositórios. Mova para `ready` apenas se todos os bloqueios estiverem resolvidos; revisão não substitui merge/deploy quando a dependência exigir disponibilidade do contrato.
5. Feche a issue somente após validação da entrega e conclusão do PR. Não invente um status final do Project; confira suas opções e automações.

Confirme campos e IDs antes de mudar status. Se o Project estiver inacessível, informe a operação pendente; não declare associação ou transição como executada.

## Ferramentas e triagem

Prefira o conector GitHub quando suportar a operação; use `gh` autenticado como alternativa. Na CLI, informe `--repo rodcordeiro/raizes-de-aruanda`; para Projects, `--owner rodcordeiro`. Use `--body-file` para corpos multilinha.

Configure triagem somente se houver skill local de triage. Inspecione labels existentes antes de mapear os papéis `needs-triage`, `needs-info`, `ready-for-agent`, `ready-for-human` e `wontfix`. Labels não substituem o status do Project.

Concluído quando destino, associação, estado, dependências e evidências de validação estão confirmados, ou quando cada impedimento está explicitamente reportado.
