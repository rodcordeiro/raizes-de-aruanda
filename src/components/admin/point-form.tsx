"use client";

import { useActionState } from "react";
import { savePoint } from "@/app/admin/actions";
import { FUNCOES, isFuncao } from "@/lib/types";

type Option = { id: number; nome: string };

export function PointForm({
  id,
  letra,
  tipo,
  linhaId,
  ritmoId,
  audioUrl,
  gravarAudio,
  linhas,
  ritmos,
}: {
  id?: number;
  letra: string;
  tipo: string;
  linhaId: string;
  ritmoId: string;
  audioUrl: string;
  gravarAudio: boolean;
  linhas: Option[];
  ritmos: Option[];
}) {
  const [state, action, pending] = useActionState(savePoint, { error: "" });
  const stored = tipo.trim();
  const unknown = stored !== "" && !isFuncao(stored);

  return (
    <form className="admin-form" action={action}>
      {id ? <input type="hidden" name="id" value={id} /> : null}
      {state.error ? (
        <div className="admin-alert admin-alert--error" role="alert">
          <p>{state.error}</p>
        </div>
      ) : null}
      <details className="admin-help">
        <summary>Como preencher letra e áudio?</summary>
        <div className="admin-help__panel">
          <ul>
            <li>
              <strong>Letra:</strong> texto cantado, com quebras de linha. Guia citado na letra não cria Linha. Tradução (opcional): envolva em <code>&lt;i&gt;…&lt;/i&gt;</code> — só essas tags são renderizadas.
            </li>
            <li>
              <strong>Áudio:</strong> prefira URL do YouTube (<code>youtu.be</code> ou <code>watch</code>). O site embeda o vídeo na home — a Curimba vê se o áudio está disponível.
            </li>
            <li>
              <strong>Playlist da Linha</strong> (<code>canal_youtube</code>) é aparte: use o campo da Linha para a playlist da falange, não o áudio do Ponto.
            </li>
            <li>
              <strong>Gravar áudio:</strong> marque quando não há referência no YouTube, a casa canta diferente ou o ponto é autoral — precisamos gravar o áudio.
            </li>
            <li>Uploads ou MP3 ficam fora deste fluxo.</li>
          </ul>
        </div>
      </details>
      <div className="admin-field">
        <label className="admin-label" htmlFor="letra">
          Letra
        </label>
        <textarea className="admin-textarea" id="letra" name="letra" required rows={8} defaultValue={letra} />
      </div>
      <div className="admin-field">
        <label className="admin-label" htmlFor="tipo">
          Função
        </label>
        <select className="admin-select" id="tipo" name="tipo" required defaultValue={stored}>
          <option value="">Selecione…</option>
          {unknown ? <option value={stored}>{stored}</option> : null}
          {FUNCOES.map((funcao) => (
            <option value={funcao} key={funcao}>
              {funcao}
            </option>
          ))}
        </select>
        {unknown ? <p className="admin-hint">O valor gravado não é uma função. Escolha Chamada, Sustentação, Subida ou Demanda antes de salvar.</p> : null}
      </div>
      <div className="admin-field">
        <label className="admin-label" htmlFor="linha">
          Linha
        </label>
        <select className="admin-select" id="linha" name="linha" required defaultValue={linhaId}>
          <option value="">Selecione…</option>
          {linhas.map((linha) => (
            <option value={linha.id} key={linha.id}>
              {linha.nome}
            </option>
          ))}
        </select>
      </div>
      <div className="admin-field">
        <label className="admin-label" htmlFor="ritmo">
          Ritmo
        </label>
        <select className="admin-select" id="ritmo" name="ritmo" required defaultValue={ritmoId}>
          <option value="">Selecione…</option>
          {ritmos.map((ritmo) => (
            <option value={ritmo.id} key={ritmo.id}>
              {ritmo.nome}
            </option>
          ))}
        </select>
      </div>
      <div className="admin-field">
        <label className="admin-label" htmlFor="audio_url">
          Áudio
        </label>
        <input className="admin-input" id="audio_url" name="audio_url" type="text" inputMode="url" maxLength={255} placeholder="https://youtu.be/…" defaultValue={audioUrl} />
        <p className="admin-hint">Opcional. URL do YouTube para o embed na home.</p>
      </div>
      <div className="admin-field">
        <label className="admin-check">
          <input id="gravar_audio" name="gravar_audio" type="checkbox" value="1" defaultChecked={gravarAudio} />
          Gravar áudio
        </label>
      </div>
      <div className="admin-form__actions">
        <button className="admin-btn" type="submit" disabled={pending}>
          {id ? "Salvar" : "Criar ponto"}
        </button>
        <a className="admin-btn admin-btn--ghost" href="/admin/pontos">
          Cancelar
        </a>
      </div>
    </form>
  );
}
