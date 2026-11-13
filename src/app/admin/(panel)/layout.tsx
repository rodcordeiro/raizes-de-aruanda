import { logout } from "@/app/admin/actions";
import { can, canReadCatalog } from "@/lib/permissions";
import { getSession } from "@/lib/session";
import { cookies, headers } from "next/headers";
import { redirect } from "next/navigation";
import "@/styles/admin.css";

const LINKS = [
  { href: "/admin/pontos", label: "Pontos", key: "pontos" },
  { href: "/admin/linhas", label: "Linhas", key: "linhas" },
  { href: "/admin/ritmos", label: "Ritmos", key: "ritmos" },
] as const;

export default async function AdminLayout({ children }: { children: React.ReactNode }) {
  const session = await getSession();
  if (!session || session.expired || !("user" in session)) {
    const jar = await cookies();
    if (jar.get("raizes_refresh")?.value) {
      redirect("/api/session/refresh");
    }
    redirect("/admin/login");
  }

  const name = session.user.name.trim() || session.user.username;
  const showCatalog = canReadCatalog(session.permissions);
  const showAudit = can(session.permissions, "audit:read");
  const pathname = (await headers()).get("x-pathname") ?? "";

  return (
    <div className="admin-body">
      <header className="admin-header">
        <div className="admin-header__inner">
          <a className="admin-brand" href="/admin/pontos">
            <span className="admin-brand__full">Raízes de Aruanda · Admin</span>
            <span className="admin-brand__short">Admin</span>
          </a>
          <div className="admin-header__user">
            <a className="admin-header__name" href="/admin/perfil" title="Meu perfil" aria-label="Meu perfil">
              {name}
            </a>
            <form action={logout}>
              <button className="admin-header__logout" type="submit">
                Sair
              </button>
            </form>
          </div>
        </div>
      </header>
      <div className="admin-layout">
        <aside className="admin-sidebar">
          <nav className="admin-nav" aria-label="Administração">
            {showCatalog
              ? LINKS.map((link) => (
                  <a className="admin-nav__link" href={link.href} key={link.key} aria-current={pathname.startsWith(link.href) ? "page" : undefined}>
                    {link.label}
                  </a>
                ))
              : null}
            {showAudit ? (
              <a className="admin-nav__link" href="/admin/auditoria" aria-current={pathname.startsWith("/admin/auditoria") ? "page" : undefined}>
                Auditoria
              </a>
            ) : null}
          </nav>
        </aside>
        <main className="admin-main">{children}</main>
      </div>
    </div>
  );
}
