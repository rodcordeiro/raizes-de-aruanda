import { RythmForm } from "@/components/admin/rythm-form";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { redirect } from "next/navigation";

export const metadata = { title: "Novo ritmo — Raízes de Aruanda" };

export default async function NovoRitmoPage() {
  const session = await getSession();
  if (!session || session.expired || !("token" in session)) {
    redirect("/admin/login");
  }
  if (!can(session.permissions, "ritmo:create")) {
    return <p className="admin-alert admin-alert--error" role="alert">Acesso negado.</p>;
  }

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Novo ritmo</h1>
          <p className="admin-page-lead">Nome do toque.</p>
        </div>
      </div>
      <RythmForm nome="" />
    </>
  );
}
