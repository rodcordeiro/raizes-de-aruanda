import type { AuditPage, Category, Line, Point, Rythm, User } from "@/lib/types";

const BASE = process.env.API_BASE_URL ?? "http://localhost:3333";

type FetchInit = RequestInit & { token?: string };

export async function apiFetch(path: string, init: FetchInit = {}) {
  const headers = new Headers(init.headers);
  if (init.token) {
    headers.set("Authorization", `Bearer ${init.token}`);
  }
  if (init.body && !headers.has("Content-Type")) {
    headers.set("Content-Type", "application/json");
  }

  const { token: _token, ...rest } = init;
  return fetch(`${BASE}${path}`, { ...rest, headers, cache: "no-store" });
}

export async function readError(response: Response) {
  try {
    const data = (await response.json()) as { message?: string | string[] };
    if (Array.isArray(data.message)) {
      return data.message.join(" ");
    }
    if (typeof data.message === "string" && data.message.trim() !== "") {
      return data.message;
    }
  } catch {
    /* corpo vazio ou não JSON */
  }

  if (response.status === 401) {
    return "Sessão expirada. Entre novamente.";
  }
  if (response.status === 403) {
    return "Acesso negado.";
  }
  if (response.status === 429) {
    return "Muitas tentativas. Aguarde e tente de novo.";
  }

  return "Não foi possível concluir.";
}

async function readJson<T>(response: Response): Promise<T> {
  if (response.status === 204) {
    return undefined as T;
  }

  return (await response.json()) as T;
}

export async function getLines() {
  const response = await apiFetch("/api/v1/lines");
  if (!response.ok) {
    throw new Error(await readError(response));
  }
  return readJson<Line[]>(response);
}

export async function getLine(id: number, token: string) {
  const response = await apiFetch(`/api/v1/lines/${id}`, { token });
  if (!response.ok) {
    return null;
  }
  return readJson<Line>(response);
}

export async function getCategories() {
  const response = await apiFetch("/api/v1/categories");
  if (!response.ok) {
    throw new Error(await readError(response));
  }
  return readJson<Category[]>(response);
}

export async function getPoints(linhaId?: number, pendenteGravar = false) {
  const query = new URLSearchParams();
  if (linhaId) query.set("linha", String(linhaId));
  if (pendenteGravar) query.set("pendente_gravar", "true");
  const suffix = query.size > 0 ? `?${query}` : "";
  const response = await apiFetch(`/api/v1/points${suffix}`);
  if (!response.ok) {
    throw new Error(await readError(response));
  }
  return readJson<Point[]>(response);
}

export async function getPoint(id: number) {
  const response = await apiFetch(`/api/v1/points/${id}`);
  if (!response.ok) {
    return null;
  }
  return readJson<Point>(response);
}

export async function getRythms(token: string) {
  const response = await apiFetch("/api/v1/rythm", { token });
  if (!response.ok) {
    throw new Error(await readError(response));
  }
  return readJson<Rythm[]>(response);
}

export async function getRythm(id: number, token: string) {
  const response = await apiFetch(`/api/v1/rythm/${id}`, { token });
  if (!response.ok) {
    return null;
  }
  return readJson<Rythm>(response);
}

export async function getMe(token: string) {
  const response = await apiFetch("/api/v1/users/me", { token });
  if (!response.ok) {
    return { ok: false as const, status: response.status };
  }

  const user = await readJson<User>(response);
  const permissions = Array.isArray(user.permissions)
    ? user.permissions.filter((slug) => typeof slug === "string" && slug.trim() !== "")
    : [];

  return {
    ok: true as const,
    status: 200,
    user: {
      id: user.id,
      name: user.name ?? "",
      username: user.username ?? "",
    },
    permissions,
  };
}

export async function getAudit(token: string, page: number) {
  const response = await apiFetch(`/api/v1/audit-logs?page=${page}&limit=20`, { token });
  if (response.status === 403) {
    return { denied: true as const };
  }
  if (!response.ok) {
    throw new Error(await readError(response));
  }

  return { denied: false as const, page: await readJson<AuditPage>(response) };
}
