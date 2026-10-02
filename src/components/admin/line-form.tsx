"use client";

import { useActionState } from "react";
import { saveLine } from "@/app/admin/actions";

type Option = { id: number; nome: string };

export function LineForm({
  id,
  nome,
  categoriaId,
  canal,
  saudacao,
  categorias,
}: {
  id?: number;
  nome: string;
  categoriaId: string;
  canal: string;
  saudacao: string;
  categorias: Option[];
}) {
  const [state, action, pending] = useActionState(saveLine, { error: "" });

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
      <div className="admin-field">
        <label className="admin-label" htmlFor="categoria">
          Categoria
        </label>
        <select className="admin-select" id="categoria" name="categoria" required defaultValue={categoriaId}>
          <option value="">Selecione…</option>
          {categorias.map((categoria) => (
            <option value={categoria.id} key={categoria.id}>
              {categoria.nome}
            </option>
          ))}
        </select>
      </div>
      <div className="admin-field">
        <label className="admin-label" htmlFor="canal_youtube">
          Canal do YouTube
        </label>
        <input className="admin-input" id="canal_youtube" name="canal_youtube" type="text" inputMode="url" maxLength={255} placeholder="https://…" defaultValue={canal} />
        <p className="admin-hint">Opcional.</p>
      </div>
      <div className="admin-field">
        <label className="admin-label" htmlFor="saudacao">
          Saudação
        </label>
        <input className="admin-input" id="saudacao" name="saudacao" type="text" maxLength={100} defaultValue={saudacao} />
        <p className="admin-hint">Opcional. Cumprimento ritual da linha.</p>
      </div>
      <div className="admin-form__actions">
        <button className="admin-btn" type="submit" disabled={pending}>
          {id ? "Salvar" : "Criar linha"}
        </button>
        <a className="admin-btn admin-btn--ghost" href="/admin/linhas">
          Cancelar
        </a>
      </div>
    </form>
  );
}
