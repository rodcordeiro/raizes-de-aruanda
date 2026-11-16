import { Alerts, ListMeta, Pagination } from "@/components/admin/list";
import { getLines } from "@/lib/api";
import { PAGE_SIZE, listWindow } from "@/lib/format";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";

export const metadata = { title: "Linhas — Raízes de Aruanda" };

export default async function LinhasPage({ searchParams }: { searchParams: Promise<{ page?: string; ok?: string; erro?: string }> }) {
  const params = await searchParams;
  const session = await getSession();
  const permissions = session && "permissions" in session ? session.permissions : [];
  const canCreate = can(permissions, "linha:create");
  const canUpdate = can(permissions, "linha:update");
  const canDelete = can(permissions, "linha:delete");
  const lines = await getLines();
  const window = listWindow(lines.length, Number(params.page) || 1, PAGE_SIZE);
  const rows = lines.slice(window.start, window.start + PAGE_SIZE);
  const hrefFor = (page: number) => (page > 1 ? `/admin/linhas?page=${page}` : "/admin/linhas");

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Linhas</h1>
          <p className="admin-page-lead">Falanges do catálogo, com categoria, saudação e canal do YouTube.</p>
        </div>
        {canCreate ? (
          <a className="admin-btn" href="/admin/linhas/nova">
            Nova linha
          </a>
        ) : null}
      </div>
      <Alerts ok={params.ok} erro={params.erro} />
      {rows.length === 0 ? (
        <p className="admin-empty">Nenhuma linha cadastrada ainda.</p>
      ) : (
        <>
          <ListMeta singular="linha" plural="linhas" total={lines.length} page={window.page} />
          <div className="admin-table-wrap">
            <table className="admin-table">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Nome</th>
                  <th scope="col">Categoria</th>
                  <th scope="col">Saudação</th>
                  <th scope="col">Canal do YouTube</th>
                  {canUpdate || canDelete ? <th scope="col">Ações</th> : null}
                </tr>
              </thead>
              <tbody>
                {rows.map((row) => (
                  <tr key={row.id}>
                    <td>{row.id}</td>
                    <td>{row.nome}</td>
                    <td>{row.categoria?.nome}</td>
                    <td>{row.saudacao?.trim() || "—"}</td>
                    <td>{row.canal_youtube?.trim() || "—"}</td>
                    {canUpdate || canDelete ? (
                      <td className="admin-table__actions">
                        <div className="admin-actions">
                          {canUpdate ? (
                            <a className="admin-btn admin-btn--ghost" href={`/admin/linhas/${row.id}`}>
                              Editar
                            </a>
                          ) : null}
                          {canDelete ? (
                            <a className="admin-btn admin-btn--danger" href={`/admin/linhas/${row.id}/excluir`}>
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
          <Pagination page={window.page} total={lines.length} label="Paginação de linhas" hrefFor={hrefFor} />
        </>
      )}
    </>
  );
}
