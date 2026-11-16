import { LineForm } from "@/components/admin/line-form";
import { getCategories, getLine } from "@/lib/api";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { notFound, redirect } from "next/navigation";

export const metadata = { title: "Editar linha — Raízes de Aruanda" };

export default async function EditarLinhaPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const session = await getSession();
  if (!session || session.expired || !("token" in session)) {
    redirect("/admin/login");
  }
  if (!can(session.permissions, "linha:update")) {
    return <p className="admin-alert admin-alert--error" role="alert">Acesso negado.</p>;
  }

  const [line, categorias] = await Promise.all([getLine(Number(id), session.token), getCategories()]);
  if (!line) {
    notFound();
  }

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Editar linha</h1>
          <p className="admin-page-lead">{line.nome}</p>
        </div>
      </div>
      <LineForm
        id={line.id}
        nome={line.nome}
        categoriaId={String(line.categoria?.id ?? "")}
        canal={line.canal_youtube ?? ""}
        saudacao={line.saudacao ?? ""}
        categorias={categorias}
      />
    </>
  );
}
