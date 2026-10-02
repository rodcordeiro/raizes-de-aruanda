"use client";

import { useActionState } from "react";
import { saveProfile } from "@/app/admin/actions";

export function ProfileForm({ name, username }: { name: string; username: string }) {
  const [state, action, pending] = useActionState(saveProfile, { error: "" });

  return (
    <form className="admin-form" action={action}>
      {state.error ? (
        <div className="admin-alert admin-alert--error" role="alert">
          <p>{state.error}</p>
        </div>
      ) : null}
      <div className="admin-field">
        <label className="admin-label" htmlFor="username">
          Usuário
        </label>
        <input className="admin-input" id="username" value={username} readOnly />
        <p className="admin-hint">O login não muda nesta tela.</p>
      </div>
      <div className="admin-field">
        <label className="admin-label" htmlFor="name">
          Nome
        </label>
        <input className="admin-input" id="name" name="name" type="text" required maxLength={255} defaultValue={name} />
      </div>
      <div className="admin-field">
        <label className="admin-label" htmlFor="currentPassword">
          Senha atual
        </label>
        <input className="admin-input" id="currentPassword" name="currentPassword" type="password" required autoComplete="current-password" />
        <p className="admin-hint">Obrigatória para confirmar qualquer alteração.</p>
      </div>
      <div className="admin-field">
        <label className="admin-label" htmlFor="newPassword">
          Nova senha
        </label>
        <input className="admin-input" id="newPassword" name="newPassword" type="password" autoComplete="new-password" />
        <p className="admin-hint">Opcional. Em branco, o nome muda e a senha permanece.</p>
      </div>
      <div className="admin-field">
        <label className="admin-label" htmlFor="newPasswordConfirm">
          Confirmar nova senha
        </label>
        <input className="admin-input" id="newPasswordConfirm" name="newPasswordConfirm" type="password" autoComplete="new-password" />
      </div>
      <div className="admin-form__actions">
        <button className="admin-btn" type="submit" disabled={pending}>
          Salvar
        </button>
      </div>
    </form>
  );
}
