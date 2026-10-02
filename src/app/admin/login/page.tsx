import { LoginForm } from "@/components/admin/login-form";
import { getSession } from "@/lib/session";
import { redirect } from "next/navigation";
import "@/styles/login.css";

export const metadata = { title: "Entrar no admin — Raízes de Aruanda" };

export default async function LoginPage() {
  const session = await getSession();
  if (session && !session.expired) {
    redirect("/admin/pontos");
  }

  return (
    <main className="login-page">
      <LoginForm />
    </main>
  );
}
