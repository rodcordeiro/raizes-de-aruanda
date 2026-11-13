import { CatalogClient } from "@/components/catalog-client";
import { CloseIcon, MenuIcon } from "@/components/icons";
import type { Line } from "@/lib/types";

function groupLines(lines: Line[]) {
  const groups: { nome: string; lines: Line[] }[] = [];
  for (const line of lines) {
    const nome = line.categoria?.nome || "Outros";
    const existing = groups.find((group) => group.nome === nome);
    if (existing) {
      existing.lines.push(line);
    } else {
      groups.push({ nome, lines: [line] });
    }
  }
  for (const group of groups) {
    group.lines.sort((a, b) => a.nome.localeCompare(b.nome, "pt-BR", { sensitivity: "base" }));
  }
  return groups;
}

export function PublicShell({
  lines,
  activeName,
  children,
}: {
  lines: Line[];
  activeName?: string;
  children: React.ReactNode;
}) {
  const groups = groupLines(lines);

  return (
    <div id="conteudo">
      <header id="header">
        <a className="brand" href="/" aria-label="Raízes de Aruanda — início">
          <img src="/android-icon-192x192.png" alt="Raízes de Aruanda" width={48} height={48} />
        </a>
        <span className="header-title">Pontos de Umbanda</span>
        <button type="button" className="mobile-menu" id="menu-open" aria-label="Abrir menu de linhas" aria-controls="nav-sheet" aria-expanded="false">
          <MenuIcon />
        </button>
      </header>
      <main id="main">{children}</main>
      <div className="nav-scrim" id="nav-scrim" hidden />
      <aside id="nav-sheet" className="nav-sheet" aria-label="Navegação por linhas">
        <div className="nav-sheet-handle" aria-hidden="true" />
        <div className="nav-sheet-header">
          <h2 id="nav-sheet-title">Linhas</h2>
          <button type="button" className="nav-close" id="menu-close" aria-label="Fechar menu">
            <CloseIcon />
          </button>
        </div>
        <label className="nav-filter-label" htmlFor="nav-filter">
          Buscar linha
        </label>
        <input type="search" id="nav-filter" className="nav-filter" placeholder="Buscar linha…" autoComplete="off" />
        <nav>
          <ul className="nav-categories">
            {groups.map((group) => (
              <li className="nav-category" key={group.nome}>
                <span className="nav-category-title">{group.nome}</span>
                <ul className="nav-lines">
                  {group.lines.map((line) => {
                    const active = activeName === line.nome;
                    return (
                      <li key={line.id}>
                        <a
                          className={active ? "nav-line is-active" : "nav-line"}
                          href={`/?buscar=${encodeURIComponent(line.nome)}`}
                          data-linha={line.nome.toLocaleLowerCase("pt-BR")}
                          aria-current={active ? "page" : undefined}
                        >
                          {line.nome}
                        </a>
                      </li>
                    );
                  })}
                </ul>
              </li>
            ))}
          </ul>
        </nav>
      </aside>
      <CatalogClient activeKey={activeName ?? "home"} />
    </div>
  );
}
