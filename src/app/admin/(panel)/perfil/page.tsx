import { ProfileForm } from "@/components/admin/profile-form";
import { Alerts } from "@/components/admin/list";
import { getSession } from "@/lib/session";
import { redirect } from "next/navigation";

export const metadata = { title: "Meu perfil — Raízes de Aruanda" };

export default async function PerfilPage({ searchParams }: { searchParams: Promise<{ ok?: string; erro?: string }> }) {
  const params = await searchParams;
  const session = await getSession();
  if (!session || session.expired || !("user" in session)) {
    redirect("/admin/login");
  }

  return (
    <>
      <div className="admin-page-head">
        <div>
          <h1 className="admin-page-title">Meu perfil</h1>
          <p className="admin-page-lead">Altere o nome exibido e, se quiser, a sua senha.</p>
        </div>
      </div>
      <Alerts ok={params.ok} />
      <ProfileForm name={session.user.name} username={session.user.username} />
    </>
  );
}
