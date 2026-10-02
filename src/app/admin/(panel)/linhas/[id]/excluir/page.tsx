import { deleteLine } from "@/app/admin/actions";
import { Alerts } from "@/components/admin/list";
import { getLine } from "@/lib/api";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { notFound, redirect } from "next/navigation";

export const metadata = { title: "Excluir linha — Raízes de Aruanda" };

export default async function ExcluirLinhaPage({
  params,
  searchParams,
}: {
  params: Promise<{ id: string }>;
  searchParams: Promise<{ erro?: string }>;
}) {
  const { id } = await params;
  const query = await searchParams;
  const session = await getSession();
  if (!session || session.expired || !("token" in session)) {
    redirect("/admin/login");
  }
  if (!can(session.permissions, "linha:delete")) {
    return <p className="admin-alert admin-alert--error" role="alert">Acesso negado.</p>;
  }

  const line = await getLine(Number(id), session.token);
  if (!line) {
    notFound();
  }

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Excluir linha</h1>
          <p className="admin-page-lead">{line.nome}</p>
        </div>
      </div>
      <Alerts erro={query.erro} />
      <form className="admin-form" action={deleteLine}>
        <input type="hidden" name="id" value={line.id} />
        <p>Só é possível excluir uma linha sem pontos.</p>
        <div className="admin-form__actions">
          <button className="admin-btn admin-btn--danger" type="submit">
            Excluir
          </button>
          <a className="admin-btn admin-btn--ghost" href="/admin/linhas">
            Cancelar
          </a>
        </div>
      </form>
    </>
  );
}
