import { PointForm } from "@/components/admin/point-form";
import { getLines, getPoint, getRythms } from "@/lib/api";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { notFound, redirect } from "next/navigation";

export const metadata = { title: "Editar ponto — Raízes de Aruanda" };

export default async function EditarPontoPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const session = await getSession();
  if (!session || session.expired || !("token" in session)) {
    redirect("/admin/login");
  }
  if (!can(session.permissions, "ponto:update")) {
    return <p className="admin-alert admin-alert--error" role="alert">Acesso negado.</p>;
  }

  const pointId = Number(id);
  const [point, lines, ritmos] = await Promise.all([getPoint(pointId), getLines(), getRythms(session.token)]);
  if (!point) {
    notFound();
  }

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Editar ponto</h1>
          <p className="admin-page-lead">Letra, função, linha, ritmo e áudio.</p>
        </div>
      </div>
      <PointForm
        id={point.id}
        letra={point.letra ?? ""}
        tipo={point.tipo ?? ""}
        linhaId={String(point.linha?.id ?? "")}
        ritmoId={String(point.ritmo?.id ?? "")}
        audioUrl={point.audio_url ?? ""}
        gravarAudio={Boolean(point.gravar_audio)}
        linhas={lines}
        ritmos={ritmos}
      />
    </>
  );
}
