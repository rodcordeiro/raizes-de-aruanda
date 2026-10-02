"use client";

export default function RootError({
  reset,
}: {
  error: Error & { digest?: string };
  reset: () => void;
}) {
  return (
    <main id="main">
      <div id="apresentacao">
        <div className="catalog-error" role="alert">
          <p>Não foi possível carregar o catálogo.</p>
          <button className="catalog-retry" type="button" onClick={() => reset()}>
            Tentar de novo
          </button>
        </div>
      </div>
    </main>
  );
}
