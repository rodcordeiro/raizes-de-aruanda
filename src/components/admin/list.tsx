import { listMeta, pageStatus } from "@/lib/format";

export function Alerts({ ok, erro }: { ok?: string; erro?: string }) {
  return (
    <>
      {erro ? (
        <p className="admin-alert admin-alert--error" role="alert">
          {erro}
        </p>
      ) : null}
      {ok ? (
        <p className="admin-alert admin-alert--ok" role="status">
          {ok}
        </p>
      ) : null}
    </>
  );
}

export function ListMeta({ singular, plural, total, page }: { singular: string; plural: string; total: number; page: number }) {
  return (
    <p className="admin-list-meta" aria-live="polite">
      {listMeta(singular, plural, total, page)}
    </p>
  );
}

export function Pagination({
  page,
  total,
  label,
  hrefFor,
}: {
  page: number;
  total: number;
  label: string;
  hrefFor: (page: number) => string;
}) {
  const status = pageStatus(total, page);
  const totalPages = Math.max(1, Math.ceil(total / 20) || 1);
  if (totalPages <= 1) {
    return null;
  }

  return (
    <nav className="admin-pagination" aria-label={label}>
      {page > 1 ? (
        <a className="admin-btn admin-btn--ghost" href={hrefFor(page - 1)}>
          Anterior
        </a>
      ) : (
        <span className="admin-btn admin-btn--ghost is-disabled" aria-disabled="true">
          Anterior
        </span>
      )}
      <span className="admin-pagination__status">{status}</span>
      {page < totalPages ? (
        <a className="admin-btn admin-btn--ghost" href={hrefFor(page + 1)}>
          Próxima
        </a>
      ) : (
        <span className="admin-btn admin-btn--ghost is-disabled" aria-disabled="true">
          Próxima
        </span>
      )}
    </nav>
  );
}
