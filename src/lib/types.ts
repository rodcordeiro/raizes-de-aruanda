export type Category = {
  id: number;
  nome: string;
  createdAt?: string;
  updatedAt?: string;
};

export type Line = {
  id: number;
  nome: string;
  canal_youtube?: string | null;
  saudacao?: string | null;
  categoria: Category;
  createdAt?: string;
  updatedAt?: string;
};

export type Rythm = {
  id: number;
  nome: string;
  createdAt?: string;
  updatedAt?: string;
};

export type Point = {
  id: number;
  letra: string;
  tipo: string | null;
  gravar_audio?: boolean;
  audio_url?: string | null;
  linha: Line;
  ritmo: Rythm;
  createdAt?: string;
  updatedAt?: string;
};

export type User = {
  id: number;
  name: string;
  username: string;
  createdAt?: string;
  updatedAt?: string;
  permissions?: string[];
};

export type AuditLog = {
  id: string;
  actorUserId?: number | null;
  actorUsername?: string | null;
  action: string;
  resourceType?: string | null;
  resourceId?: string | null;
  origin?: string | null;
  createdAt: string;
};

export type AuditPage = {
  data: AuditLog[];
  page: number;
  limit: number;
  total: number;
};

export const FUNCOES = ["Chamada", "Sustentação", "Subida", "Demanda"] as const;

export type Funcao = (typeof FUNCOES)[number];

export function isFuncao(value: string): value is Funcao {
  return (FUNCOES as readonly string[]).includes(value);
}
