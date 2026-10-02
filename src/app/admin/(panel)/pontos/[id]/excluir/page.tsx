import { deletePoint } from "@/app/admin/actions";
import { Alerts } from "@/components/admin/list";
import { getPoint } from "@/lib/api";
import { truncate } from "@/lib/format";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { notFound, redirect } from "next/navigation";

export const metadata = { title: "Excluir ponto — Raízes de Aruanda" };

export default async function ExcluirPontoPage({
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
  if (!can(session.permissions, "ponto:delete")) {
    return <p className="admin-alert admin-alert--error" role="alert">Acesso negado.</p>;
  }

  const point = await getPoint(Number(id));
  if (!point) {
    notFound();
  }

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Excluir ponto</h1>
          <p className="admin-page-lead">{truncate(point.letra || "", 120)}</p>
        </div>
      </div>
      <Alerts erro={query.erro} />
      <form className="admin-form" action={deletePoint}>
        <input type="hidden" name="id" value={point.id} />
        <p>Esta exclusão não pode ser desfeita.</p>
        <div className="admin-form__actions">
          <button className="admin-btn admin-btn--danger" type="submit">
            Excluir
          </button>
          <a className="admin-btn admin-btn--ghost" href="/admin/pontos">
            Cancelar
          </a>
        </div>
      </form>
    </>
  );
}
