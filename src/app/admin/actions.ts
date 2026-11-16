"use server";

import { cookies } from "next/headers";
import { redirect } from "next/navigation";
import { apiFetch, readError } from "@/lib/api";
import { ACCESS_COOKIE, REFRESH_COOKIE, getSession, tokenCookie } from "@/lib/session";
import { isFuncao } from "@/lib/types";

type FormState = { error: string };

async function tokenOrLogin() {
  const session = await getSession();
  if (!session || session.expired || !("token" in session)) {
    redirect("/api/session/refresh");
  }
  return session.token;
}

export async function login(_prev: FormState, formData: FormData): Promise<FormState> {
  const username = String(formData.get("username") ?? "").trim();
  const password = String(formData.get("password") ?? "");
  const response = await apiFetch("/api/v1/auth/login", {
    method: "POST",
    body: JSON.stringify({ username, password }),
  });

  if (!response.ok) {
    return { error: response.status === 401 ? "Usuário ou senha inválidos." : await readError(response) };
  }

  const body = (await response.json()) as { accessToken?: string; refreshToken?: string };
  if (!body.accessToken || !body.refreshToken) {
    return { error: "Não foi possível entrar." };
  }

  const jar = await cookies();
  jar.set(ACCESS_COOKIE, body.accessToken, tokenCookie(60 * 60));
  jar.set(REFRESH_COOKIE, body.refreshToken, tokenCookie(60 * 60 * 24 * 10));
  redirect("/admin/pontos");
}

export async function logout() {
  const jar = await cookies();
  jar.set(ACCESS_COOKIE, "", tokenCookie(0));
  jar.set(REFRESH_COOKIE, "", tokenCookie(0));
  redirect("/admin/login");
}

export async function savePoint(_prev: FormState, formData: FormData): Promise<FormState> {
  const token = await tokenOrLogin();
  const id = String(formData.get("id") ?? "");
  const tipo = String(formData.get("tipo") ?? "");
  if (!isFuncao(tipo)) {
    return { error: "Escolha a função: Chamada, Sustentação, Subida ou Demanda." };
  }

  const audioUrl = String(formData.get("audio_url") ?? "").trim();
  const payload: {
    letra: string;
    tipo: string;
    linha: number;
    ritmo: number;
    gravar_audio: boolean;
    audio_url?: string;
  } = {
    letra: String(formData.get("letra") ?? ""),
    tipo,
    linha: Number(formData.get("linha")),
    ritmo: Number(formData.get("ritmo")),
    gravar_audio: formData.get("gravar_audio") === "1",
  };
  if (audioUrl !== "") {
    payload.audio_url = audioUrl;
  }

  const response = await apiFetch(id ? `/api/v1/points/${id}` : "/api/v1/points", {
    method: id ? "PUT" : "POST",
    token,
    body: JSON.stringify(payload),
  });

  if (!response.ok) {
    return { error: await readError(response) };
  }

  redirect("/admin/pontos?ok=Ponto salvo.");
}

export async function deletePoint(formData: FormData) {
  const token = await tokenOrLogin();
  const id = String(formData.get("id") ?? "");
  const response = await apiFetch(`/api/v1/points/${id}`, { method: "DELETE", token });
  if (!response.ok) {
    redirect(`/admin/pontos/${id}/excluir?erro=${encodeURIComponent(await readError(response))}`);
  }
  redirect("/admin/pontos?ok=Ponto excluído.");
}

export async function saveLine(_prev: FormState, formData: FormData): Promise<FormState> {
  const token = await tokenOrLogin();
  const id = String(formData.get("id") ?? "");
  const saudacao = String(formData.get("saudacao") ?? "").trim();
  const canal = String(formData.get("canal_youtube") ?? "").trim();
  const payload: {
    nome: string;
    categoria: number;
    saudacao: string | null;
    canal_youtube?: string;
  } = {
    nome: String(formData.get("nome") ?? "").trim(),
    categoria: Number(formData.get("categoria")),
    saudacao: saudacao === "" ? null : saudacao,
  };
  if (canal !== "") {
    payload.canal_youtube = canal;
  }

  const response = await apiFetch(id ? `/api/v1/lines/${id}` : "/api/v1/lines", {
    method: id ? "PUT" : "POST",
    token,
    body: JSON.stringify(payload),
  });

  if (!response.ok) {
    return { error: await readError(response) };
  }

  redirect("/admin/linhas?ok=Linha salva.");
}

export async function deleteLine(formData: FormData) {
  const token = await tokenOrLogin();
  const id = String(formData.get("id") ?? "");
  const response = await apiFetch(`/api/v1/lines/${id}`, { method: "DELETE", token });
  if (!response.ok) {
    redirect(`/admin/linhas/${id}/excluir?erro=${encodeURIComponent(await readError(response))}`);
  }
  redirect("/admin/linhas?ok=Linha excluída.");
}

export async function saveRythm(_prev: FormState, formData: FormData): Promise<FormState> {
  const token = await tokenOrLogin();
  const id = String(formData.get("id") ?? "");
  const payload = { nome: String(formData.get("nome") ?? "").trim() };
  const response = await apiFetch(id ? `/api/v1/rythm/${id}` : "/api/v1/rythm", {
    method: id ? "PUT" : "POST",
    token,
    body: JSON.stringify(payload),
  });

  if (!response.ok) {
    return { error: await readError(response) };
  }

  redirect("/admin/ritmos?ok=Ritmo salvo.");
}

export async function deleteRythm(formData: FormData) {
  const token = await tokenOrLogin();
  const id = String(formData.get("id") ?? "");
  const response = await apiFetch(`/api/v1/rythm/${id}`, { method: "DELETE", token });
  if (!response.ok) {
    redirect(`/admin/ritmos/${id}/excluir?erro=${encodeURIComponent(await readError(response))}`);
  }
  redirect("/admin/ritmos?ok=Ritmo excluído.");
}

export async function saveProfile(_prev: FormState, formData: FormData): Promise<FormState> {
  const token = await tokenOrLogin();
  const name = String(formData.get("name") ?? "").trim();
  const currentPassword = String(formData.get("currentPassword") ?? "");
  const newPassword = String(formData.get("newPassword") ?? "");
  const confirm = String(formData.get("newPasswordConfirm") ?? "");

  if (name === "") {
    return { error: "Informe o nome." };
  }
  if (currentPassword === "") {
    return { error: "Informe a senha atual." };
  }
  if ((newPassword !== "" || confirm !== "") && newPassword !== confirm) {
    return { error: "A confirmação não coincide com a nova senha." };
  }

  const payload: { name: string; currentPassword: string; newPassword?: string } = { name, currentPassword };
  if (newPassword !== "") {
    payload.newPassword = newPassword;
  }

  const response = await apiFetch("/api/v1/users/me", {
    method: "PATCH",
    token,
    body: JSON.stringify(payload),
  });

  if (!response.ok) {
    return { error: await readError(response) };
  }

  redirect("/admin/perfil?ok=Perfil atualizado.");
}
