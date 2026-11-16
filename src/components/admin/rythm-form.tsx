"use client";

import { useActionState } from "react";
import { saveRythm } from "@/app/admin/actions";

export function RythmForm({ id, nome }: { id?: number; nome: string }) {
  const [state, action, pending] = useActionState(saveRythm, { error: "" });

  return (
    <form className="admin-form" action={action}>
      {id ? <input type="hidden" name="id" value={id} /> : null}
      {state.error ? (
        <div className="admin-alert admin-alert--error" role="alert">
          <p>{state.error}</p>
        </div>
      ) : null}
      <div className="admin-field">
        <label className="admin-label" htmlFor="nome">
          Nome
        </label>
        <input className="admin-input" id="nome" name="nome" type="text" required maxLength={255} defaultValue={nome} />
      </div>
      <div className="admin-form__actions">
        <button className="admin-btn" type="submit" disabled={pending}>
          {id ? "Salvar" : "Criar ritmo"}
        </button>
        <a className="admin-btn admin-btn--ghost" href="/admin/ritmos">
          Cancelar
        </a>
      </div>
    </form>
  );
}
