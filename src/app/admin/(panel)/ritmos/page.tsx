import { Alerts, ListMeta, Pagination } from "@/components/admin/list";
import { getRythms } from "@/lib/api";
import { PAGE_SIZE, listWindow } from "@/lib/format";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { redirect } from "next/navigation";

export const metadata = { title: "Ritmos — Raízes de Aruanda" };

export default async function RitmosPage({ searchParams }: { searchParams: Promise<{ page?: string; ok?: string; erro?: string }> }) {
  const params = await searchParams;
  const session = await getSession();
  if (!session || session.expired || !("token" in session)) {
    redirect("/admin/login");
  }

  const permissions = session.permissions;
  const canCreate = can(permissions, "ritmo:create");
  const canUpdate = can(permissions, "ritmo:update");
  const canDelete = can(permissions, "ritmo:delete");
  const ritmos = await getRythms(session.token);
  const window = listWindow(ritmos.length, Number(params.page) || 1, PAGE_SIZE);
  const rows = ritmos.slice(window.start, window.start + PAGE_SIZE);
  const hrefFor = (page: number) => (page > 1 ? `/admin/ritmos?page=${page}` : "/admin/ritmos");

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Ritmos</h1>
          <p className="admin-page-lead">Toques do atabaque usados nos pontos.</p>
        </div>
        {canCreate ? (
          <a className="admin-btn" href="/admin/ritmos/novo">
            Novo ritmo
          </a>
        ) : null}
      </div>
      <Alerts ok={params.ok} erro={params.erro} />
      {rows.length === 0 ? (
        <p className="admin-empty">Nenhum ritmo cadastrado ainda.</p>
      ) : (
        <>
          <ListMeta singular="ritmo" plural="ritmos" total={ritmos.length} page={window.page} />
          <div className="admin-table-wrap">
            <table className="admin-table">
              <thead>
                <tr>
                  <th scope="col">Nome</th>
                  {canUpdate || canDelete ? <th scope="col">Ações</th> : null}
                </tr>
              </thead>
              <tbody>
                {rows.map((row) => (
                  <tr key={row.id}>
                    <td>{row.nome}</td>
                    {canUpdate || canDelete ? (
                      <td className="admin-table__actions">
                        <div className="admin-actions">
                          {canUpdate ? (
                            <a className="admin-btn admin-btn--ghost" href={`/admin/ritmos/${row.id}`}>
                              Editar
                            </a>
                          ) : null}
                          {canDelete ? (
                            <a className="admin-btn admin-btn--danger" href={`/admin/ritmos/${row.id}/excluir`}>
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
          <Pagination page={window.page} total={ritmos.length} label="Paginação de ritmos" hrefFor={hrefFor} />
        </>
      )}
    </>
  );
}
