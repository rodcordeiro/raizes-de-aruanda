import { RythmForm } from "@/components/admin/rythm-form";
import { getRythm } from "@/lib/api";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { notFound, redirect } from "next/navigation";

export const metadata = { title: "Editar ritmo — Raízes de Aruanda" };

export default async function EditarRitmoPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const session = await getSession();
  if (!session || session.expired || !("token" in session)) {
    redirect("/admin/login");
  }
  if (!can(session.permissions, "ritmo:update")) {
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
          <h1 className="admin-page-title">Editar ritmo</h1>
          <p className="admin-page-lead">{ritmo.nome}</p>
        </div>
      </div>
      <RythmForm id={ritmo.id} nome={ritmo.nome} />
    </>
  );
}
