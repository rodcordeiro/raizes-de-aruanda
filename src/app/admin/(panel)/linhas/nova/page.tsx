import { LineForm } from "@/components/admin/line-form";
import { getCategories } from "@/lib/api";
import { can } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { redirect } from "next/navigation";

export const metadata = { title: "Nova linha — Raízes de Aruanda" };

export default async function NovaLinhaPage() {
  const session = await getSession();
  if (!session || session.expired || !("token" in session)) {
    redirect("/admin/login");
  }
  if (!can(session.permissions, "linha:create")) {
    return <p className="admin-alert admin-alert--error" role="alert">Acesso negado.</p>;
  }

  const categorias = await getCategories();

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Nova linha</h1>
          <p className="admin-page-lead">Cadastre uma linha com nome, categoria e, se quiser, canal e saudação.</p>
        </div>
      </div>
      <LineForm nome="" categoriaId="" canal="" saudacao="" categorias={categorias} />
    </>
  );
}
