# Discovery técnico — WEB

Data: 2026-11-17. Base d74392c e árvore local. Escopo: src, configuração Next/Compose e fluxos da administração, catálogo e sessão. Sem acesso à produção.

| Evidência | Observação e limite |
| --- | --- |
| [session.ts](../src/lib/session.ts), função tokenCookie | httpOnly, SameSite=lax, secure apenas em produção e path=/; getSession consulta users/me. Não comprova TLS/proxy nem isolamento contra ataques reais |
| [api.ts](../src/lib/api.ts), apiFetch | Token em Authorization e cache=no-store. API_BASE_URL tem padrão HTTP local; transporte de produção não aferido |
| [actions.ts](../src/app/admin/actions.ts), linhas 42–47 | logout só limpa cookies; não chama revogação da API. Token copiado anteriormente pode continuar válido no servidor |
| [route.ts](../src/app/api/session/refresh/route.ts), linhas 21–24 | Qualquer erro HTTP de refresh apaga cookies; indisponibilidade e conflito não são diferenciados. Não atende o draft novo |
| [permissions.ts](../src/lib/permissions.ts), linhas 6–8 | can retorna true se lista de permissões vazia/ausente. É visibilidade da UI, não autorização; backend deve negar. Não reutilizar esse padrão para dados sensíveis |
| [middleware.ts](../src/middleware.ts) e layout administrativo | Middleware só injeta pathname; proteção de login fica no layout/getSession e API. Não declarar bypass apenas pela ausência de auth no middleware |
| [line-view.tsx](../src/components/line-view.tsx), linha 80 | Iframe youtube.com é renderizado sem ação prévia; áudio direto pode carregar de URL externa. Falta inventário real de requisições/cookies e destinatários |
| [format.ts](../src/lib/format.ts), letraHtml | Escapa HTML e reabilita somente i; não classificar dangerouslySetInnerHTML como XSS confirmado sem demonstrar bypass |
| [layout.tsx](../src/app/layout.tsx) | next/font/google no build; isso não prova requisição do navegador à Google Fonts em cada acesso |
| [next.config.ts](../next.config.ts) e [compose.yml](../compose.yml) | Sem política explícita de cabeçalhos/criptografia de produção nesses arquivos; proxy externo desconhecido |

## Descoberta de governança

Busca em src/public por privacidade, privacy, encarregado, consent, lgpd e termos não encontrou implementação de aviso/canal/DSAR. Isso é ausência de evidência versionada, não prova de ausência de documentos físicos externos. Não foram encontrados usos de localStorage/sessionStorage no src pesquisado. Não declarar ausência de cookies de terceiros sem medir runtime.

## Separação do planejado

Cadastro religioso, contas de menores, convite UUID, múltiplas sessões Redis, exportações e controle de guias são decisões do draft, não capacidades comprovadas nesta WEB. Logs do proxy/CDN/hospedagem, arquivos baixados e cache de navegador não foram inspecionados.
