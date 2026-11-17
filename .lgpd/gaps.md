# Gap analysis — WEB

Data: 2026-11-17. Prioridades P0/P1/P2 são recomendações de remediação, não declaração automática de infração ou incidente.

## Dimensões

| Dimensão | Estado | Evidência/pendência |
| --- | --- | --- |
| Inventário de dados/cookies/SDKs | PARCIAL | Cookies próprios e YouTube identificados; runtime/CDN pendentes |
| Bases legais/finalidades | GAP documental | Não atribuídas por atividade; alinhar com API |
| Encarregado/canal | GAP no repositório | Responsável operacional indicado, sem canal público versionado |
| Direitos dos titulares | GAP no repositório | Perfil não é fluxo completo; exportação do draft não basta |
| Consentimento, se aplicável | VALIDAÇÃO EXTERNA NECESSÁRIA | Não escolher checkbox antes da hipótese legal |
| Criptografia/transporte | PARCIAL | secure condicional; HTTPS externo não verificado |
| Auditoria/integridade | PARCIAL | Consulta API existente; novos campos restritos ainda não implementados |
| Retenção/bloqueio/backups | PARCIAL | Cookie maxAge existe; descarte das cópias/backup não evidenciado |
| Terceiros/contratos | VALIDAÇÃO EXTERNA NECESSÁRIA | YouTube, áudio remoto e hospedagem sem papéis comprovados |
| Transferências | VALIDAÇÃO EXTERNA NECESSÁRIA | Região e mecanismos não identificados |
| Incidentes | GAP no material inspecionado | Runbook público/interno não encontrado no recorte |
| Menores/ECA Digital | GAP no desenho implementado | Login de menores previsto; avaliar proteção, informação e representação |

## Ações de engenharia

| ID | Prioridade | Ação | Evidência |
| --- | --- | --- | --- |
| W01 | P1 alta | Integrar logout com revogação real de sessão API; manter decisão de encerrar só a atual | actions.ts:42 |
| W02 | P1 | Diferenciar indisponibilidade/conflito/invalidade e preservar cookies conforme draft | refresh/route.ts:21 |
| W03 | P1 | Avaliar carregamento externo, transparência e controle apropriado, conforme bases e menores; não presumir consentimento universal | line-view.tsx:80 |
| W04 | P1 | Tornar autorização de dados sensíveis restritiva e independente da visibilidade permissiva da UI | permissions.ts:6; contrato da API |
| W05 | P1 | Criar superfícies de aviso/canal e atendimento após definições organizacionais | Busca src/public sem resultados |
| W06 | P2 | Validar cabeçalhos, transporte, proteção de download/cache e controles do proxy | next.config.ts/compose.yml |

## Ações jurídicas/organizacionais

Identificar controlador e canal; bases/finalidades; melhor interesse e representação de menores; destinatários externos; retenção de downloads; contratos/transferências e runbook. Ver [gaps coordenados](../../.lgpd/gaps.md).

Referência: [LGPD, arts. 6º, 9º, 14, 18 e 46](https://www2.camara.leg.br/legin/fed/lei/2018/lei-13709-14-agosto-2018-787077-normaatualizada-pl.html). Revogação Redis, CSP e granularidade de módulos são controles de engenharia, não tecnologias impostas pela LGPD.
