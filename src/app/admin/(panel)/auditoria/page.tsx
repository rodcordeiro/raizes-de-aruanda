import { Alerts, ListMeta, Pagination } from "@/components/admin/list";
import { getAudit } from "@/lib/api";
import { formatWhen } from "@/lib/format";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { redirect } from "next/navigation";

export const metadata = { title: "Auditoria — Raízes de Aruanda" };

export default async function AuditoriaPage({ searchParams }: { searchParams: Promise<{ page?: string; erro?: string }> }) {
  const params = await searchParams;
  const session = await getSession();
  if (!session || session.expired || !("token" in session)) {
    redirect("/admin/login");
  }
  if (!can(session.permissions, "audit:read")) {
    return <p className="admin-alert admin-alert--error" role="alert">Acesso negado.</p>;
  }

  const page = Number(params.page) || 1;
  const result = await getAudit(session.token, page);
  if (result.denied) {
    return <p className="admin-alert admin-alert--error" role="alert">Acesso negado.</p>;
  }

  const rows = result.page.data ?? [];
  const total = result.page.total ?? rows.length;
  const current = result.page.page ?? page;
  const hrefFor = (next: number) => (next > 1 ? `/admin/auditoria?page=${next}` : "/admin/auditoria");

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Auditoria</h1>
          <p className="admin-page-lead">Registro de alterações e eventos do admin. Somente leitura.</p>
        </div>
      </div>
      <Alerts erro={params.erro} />
      {rows.length === 0 ? (
        <p className="admin-empty">Nenhum evento de auditoria registrado ainda.</p>
      ) : (
        <>
          <ListMeta singular="evento" plural="eventos" total={total} page={current} />
          <div className="admin-table-wrap">
            <table className="admin-table">
              <thead>
                <tr>
                  <th scope="col">Quando</th>
                  <th scope="col">Quem</th>
                  <th scope="col">Ação</th>
                  <th scope="col">Recurso</th>
                  <th scope="col">Origem</th>
                </tr>
              </thead>
              <tbody>
                {rows.map((row) => {
                  const type = (row.resourceType ?? "").trim();
                  const resourceId = row.resourceId ? String(row.resourceId) : "";
                  const resource = type ? (resourceId ? `${type} #${resourceId}` : type) : "—";
                  return (
                    <tr key={row.id}>
                      <td className="admin-table__when">{formatWhen(row.createdAt)}</td>
                      <td>{row.actorUsername || "—"}</td>
                      <td>{row.action}</td>
                      <td>{resource}</td>
                      <td>{row.origin || "—"}</td>
                    </tr>
                  );
                })}
              </tbody>
            </table>
          </div>
          <Pagination page={current} total={total} label="Paginação de auditoria" hrefFor={hrefFor} />
        </>
      )}
    </>
  );
}
