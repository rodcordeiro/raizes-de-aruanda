import { Alerts, ListMeta, Pagination } from "@/components/admin/list";
import { getLines, getPoints } from "@/lib/api";
import { PAGE_SIZE, listWindow, truncate } from "@/lib/format";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";

export const metadata = { title: "Pontos — Raízes de Aruanda" };

export default async function PontosPage({
  searchParams,
}: {
  searchParams: Promise<{ linha?: string; pendente_gravar?: string; page?: string; ok?: string; erro?: string }>;
}) {
  const params = await searchParams;
  const session = await getSession();
  const permissions = session && "permissions" in session ? session.permissions : [];
  const canCreate = can(permissions, "ponto:create");
  const canUpdate = can(permissions, "ponto:update");
  const canDelete = can(permissions, "ponto:delete");
  const linhaId = Number(params.linha) || 0;
  const pendingAudio = params.pendente_gravar === "true";
  const requested = Number(params.page) || 1;
  const [lines, points] = await Promise.all([
    getLines(),
    getPoints(linhaId > 0 ? linhaId : undefined, pendingAudio),
  ]);
  const window = listWindow(points.length, requested, PAGE_SIZE);
  const rows = points.slice(window.start, window.start + PAGE_SIZE);
  const hrefFor = (page: number) => {
    const query = new URLSearchParams();
    if (linhaId > 0) query.set("linha", String(linhaId));
    if (pendingAudio) query.set("pendente_gravar", "true");
    if (page > 1) query.set("page", String(page));
    const text = query.toString();
    return text ? `/admin/pontos?${text}` : "/admin/pontos";
  };
  const emptyCopy = pendingAudio
    ? linhaId > 0
      ? "Nenhum ponto pendente de gravação nesta linha."
      : "Nenhum ponto pendente de gravação."
    : linhaId > 0
      ? "Nenhum ponto nesta linha."
      : "Nenhum ponto cadastrado ainda.";

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Pontos</h1>
          <p className="admin-page-lead">Catálogo de pontos: cada registro une letra, ritmo e função (chamada, sustentação, subida ou demanda) à sua linha.</p>
        </div>
      </div>
      <Alerts ok={params.ok} erro={params.erro} />
      <div className="admin-toolbar">
        <form className="admin-toolbar__form" method="get" action="/admin/pontos">
        <div className="admin-field admin-toolbar__filter">
          <label className="admin-label" htmlFor="filtro-linha">
            Filtrar por linha
          </label>
          <select className="admin-select" id="filtro-linha" name="linha" defaultValue={linhaId > 0 ? String(linhaId) : ""}>
            <option value="">Todas as linhas</option>
            {lines.map((linha) => (
              <option value={linha.id} key={linha.id}>
                {linha.nome}
              </option>
            ))}
          </select>
        </div>
        <label className="admin-switch" htmlFor="filtro-gravar">
          <input
            className="admin-switch__input"
            id="filtro-gravar"
            name="pendente_gravar"
            type="checkbox"
            role="switch"
            value="true"
            defaultChecked={pendingAudio}
          />
          <span className="admin-switch__track" aria-hidden="true">
            <span className="admin-switch__thumb" />
          </span>
          <span className="admin-switch__text">Pendente gravar áudio</span>
        </label>
        <button className="admin-btn admin-btn--ghost" type="submit">
          Filtrar
        </button>
        </form>
        {canCreate ? (
          <a className="admin-btn" href="/admin/pontos/novo">
            Novo ponto
          </a>
        ) : null}
      </div>
      {rows.length === 0 ? (
        <p className="admin-empty">{emptyCopy}</p>
      ) : (
        <>
          <ListMeta singular="ponto" plural="pontos" total={points.length} page={window.page} />
          <div className="admin-table-wrap">
            <table className="admin-table">
              <thead>
                <tr>
                  <th scope="col">Letra</th>
                  <th scope="col">Função</th>
                  <th scope="col">Linha</th>
                  <th scope="col">Ritmo</th>
                  <th scope="col">Gravar</th>
                  {canUpdate || canDelete ? <th scope="col">Ações</th> : null}
                </tr>
              </thead>
              <tbody>
                {rows.map((row) => (
                  <tr key={row.id}>
                    <td className="admin-table__letra">{truncate(row.letra || "")}</td>
                    <td>{row.tipo?.trim() || "—"}</td>
                    <td>{row.linha?.nome}</td>
                    <td>{row.ritmo?.nome}</td>
                    <td>{row.gravar_audio ? "Sim" : "—"}</td>
                    {canUpdate || canDelete ? (
                      <td className="admin-table__actions">
                        <div className="admin-actions">
                          {canUpdate ? (
                            <a className="admin-btn admin-btn--ghost" href={`/admin/pontos/${row.id}`}>
                              Editar
                            </a>
                          ) : null}
                          {canDelete ? (
                            <a className="admin-btn admin-btn--danger" href={`/admin/pontos/${row.id}/excluir`}>
                              Excluir
                            </a>
                          ) : null}
                        </div>
                      </td>
                    ) : null}
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
          <Pagination page={window.page} total={points.length} label="Paginação do catálogo" hrefFor={hrefFor} />
        </>
      )}
    </>
  );
}
