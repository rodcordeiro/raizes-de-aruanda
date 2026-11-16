export const PAGE_SIZE = 20;

export function listWindow(total: number, page: number, perPage = PAGE_SIZE) {
  const totalPages = Math.max(1, Math.ceil(total / perPage) || 1);
  const current = Math.min(Math.max(1, page || 1), total === 0 ? 1 : totalPages);
  const from = total === 0 ? 0 : (current - 1) * perPage + 1;
  const to = Math.min(current * perPage, total);

  return {
    total,
    page: current,
    perPage,
    totalPages,
    from,
    to,
    start: (current - 1) * perPage,
  };
}

export function listMeta(singular: string, plural: string, total: number, page: number, perPage = PAGE_SIZE) {
  const window = listWindow(total, page, perPage);
  if (window.total < 1) {
    return `0 ${plural}`;
  }

  const noun = window.total === 1 ? singular : plural;
  return `${window.total} ${noun} · exibindo ${window.from}–${window.to} · ${window.perPage} itens`;
}

export function pageStatus(total: number, page: number, perPage = PAGE_SIZE) {
  const window = listWindow(total, page, perPage);
  return `Página ${window.page} de ${window.totalPages} · ${window.perPage} itens`;
}

export function truncate(text: string, max = 80) {
  const flat = text.replace(/\s+/g, " ").trim();
  if (flat.length <= max) {
    return flat;
  }

  return `${flat.slice(0, Math.max(1, max - 1))}…`;
}

export function formatWhen(iso: string) {
  const date = new Date(iso);
  if (Number.isNaN(date.getTime())) {
    return iso;
  }

  return new Intl.DateTimeFormat("pt-BR", {
    dateStyle: "short",
    timeStyle: "short",
    timeZone: "America/Sao_Paulo",
  }).format(date);
}

export function youtubeId(url: string | null | undefined) {
  if (!url) {
    return null;
  }

  const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]{6,})/i);
  return match?.[1] ?? null;
}

export function isDirectAudio(url: string | null | undefined) {
  return Boolean(url && /\.(mp3|mp4|m4a|ogg|wma)(\?|$)/i.test(url));
}

export function letraHtml(value: string) {
  return value
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/&lt;i&gt;/gi, "<i>")
    .replace(/&lt;\/i&gt;/gi, "</i>");
}

export function sameName(left: string, right: string) {
  return left.localeCompare(right, "pt-BR", { sensitivity: "base" }) === 0;
}
