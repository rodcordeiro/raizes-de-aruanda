"use client";

export default function AdminError({
  reset,
}: {
  error: Error & { digest?: string };
  reset: () => void;
}) {
  return (
    <div className="admin-alert admin-alert--error" role="alert">
      <p>Não foi possível carregar esta página.</p>
      <button className="admin-btn" type="button" onClick={() => reset()}>
        Tentar de novo
      </button>
    </div>
  );
}
