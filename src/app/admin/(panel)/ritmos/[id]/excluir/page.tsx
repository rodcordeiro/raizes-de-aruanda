import { deleteRythm } from "@/app/admin/actions";
import { Alerts } from "@/components/admin/list";
import { getRythm } from "@/lib/api";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { notFound, redirect } from "next/navigation";

export const metadata = { title: "Excluir ritmo — Raízes de Aruanda" };

export default async function ExcluirRitmoPage({
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
  if (!can(session.permissions, "ritmo:delete")) {
    return <p className="admin-alert admin-alert--error" role="alert">Acesso negado.</p>;
  }

  const ritmo = await getRythm(Number(id), session.token);
  if (!ritmo) {
    notFound();
  }

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Excluir ritmo</h1>
          <p className="admin-page-lead">{ritmo.nome}</p>
        </div>
      </div>
      <Alerts erro={query.erro} />
      <form className="admin-form" action={deleteRythm}>
        <input type="hidden" name="id" value={ritmo.id} />
        <p>Só é possível excluir um ritmo sem pontos.</p>
        <div className="admin-form__actions">
          <button className="admin-btn admin-btn--danger" type="submit">
            Excluir
          </button>
          <a className="admin-btn admin-btn--ghost" href="/admin/ritmos">
            Cancelar
          </a>
        </div>
      </form>
    </>
  );
}
