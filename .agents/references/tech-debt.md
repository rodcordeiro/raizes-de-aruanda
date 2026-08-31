# Tech debt

Gaps vs `$nero` → `references/guidelines/front-guidelines.md` e dívidas comprovadas.

| Item | Evidência | Prioridade |
| --- | --- | --- |
| Sem app React/Vite — PHP procedural monolítico | checkout | Aceito (stack real) |
| Sem testes automatizados front | sem `package.json` / PHPUnit home | Média |
| `index.php` não inclui `config/bootstrap.php` | includes da home | Baixa (Docker injeta env) |
| CSS morto `.yt-placeholder*` após embed imediato | `main.css` | Baixa |
| YouTube só `youtu.be` | regex em `index.php` | Média se links `watch?v=` existirem |
| Contraste brand↔branco ~3.4:1 | `docs/DESIGN.md` Contrast Caution | Monitorar |
| `$color.shadow` Pencil sem `--shadow` CSS nomeado | DESIGN / Iris | Baixa |
| Admin/dash sem polish v2 | decisão adiar | Fora do foco |
| `.old/`, `teste.php` no tree | paths | Não estender |
| README só badges — onboarding fraco | `README.md` | Baixa (AGENTS cobre agentes) |

Não reestruturar para “parecer” guideline React sem pedido explícito.
