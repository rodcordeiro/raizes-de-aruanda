import { PointForm } from "@/components/admin/point-form";
import { getLines, getRythms } from "@/lib/api";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { redirect } from "next/navigation";

export const metadata = { title: "Novo ponto — Raízes de Aruanda" };

export default async function NovoPontoPage() {
  const session = await getSession();
  if (!session || session.expired || !("token" in session)) {
    redirect("/admin/login");
  }
  if (!can(session.permissions, "ponto:create")) {
    return <p className="admin-alert admin-alert--error" role="alert">Acesso negado.</p>;
  }

  const [lines, ritmos] = await Promise.all([getLines(), getRythms(session.token)]);

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Novo ponto</h1>
          <p className="admin-page-lead">Cadastre letra, função, linha e ritmo.</p>
        </div>
      </div>
      <PointForm letra="" tipo="" linhaId="" ritmoId="" audioUrl="" gravarAudio={false} linhas={lines} ritmos={ritmos} />
    </>
  );
}
