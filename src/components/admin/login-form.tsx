"use client";

import { useActionState } from "react";
import { login } from "@/app/admin/actions";

export function LoginForm() {
  const [state, action, pending] = useActionState(login, { error: "" });

  return (
    <form action={action} className="login-form" autoComplete="on">
      <img className="login-logo" src="/logo-raizes.png" alt="Logotipo do Terreiro Raízes de Aruanda" width={96} height={96} />
      <h1 className="login-title">Entrar no admin</h1>
      {state.error ? (
        <p className="login-error" role="alert">
          {state.error}
        </p>
      ) : null}
      <div className="login-field">
        <label className="login-label" htmlFor="username">
          Usuário
        </label>
        <input className="login-input" id="username" name="username" type="text" required autoFocus autoComplete="username" maxLength={255} placeholder="seu.usuario" />
      </div>
      <div className="login-field">
        <label className="login-label" htmlFor="password">
          Senha
        </label>
        <input className="login-input" id="password" name="password" type="password" required autoComplete="current-password" placeholder="sua senha" />
      </div>
      <button className="login-submit" type="submit" disabled={pending}>
        Entrar
      </button>
    </form>
  );
}
