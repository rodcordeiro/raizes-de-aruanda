import { ExternalIcon } from "@/components/icons";
import { isDirectAudio, letraHtml, youtubeId } from "@/lib/format";
import type { Line, Point } from "@/lib/types";

function ritmoKey(nome: string) {
  return nome.toLocaleLowerCase("pt-BR");
}

export function LineView({ line, points, fallbackName }: { line: Line | null; points: Point[]; fallbackName: string }) {
  const nome = line?.nome || fallbackName;
  const saudacao = line?.saudacao?.trim() ?? "";
  const playlist = line?.canal_youtube?.trim() ?? "";
  const chips: { key: string; nome: string; count: number; firstId: number }[] = [];

  for (const point of points) {
    const nomeRitmo = point.ritmo?.nome ?? "";
    const key = ritmoKey(nomeRitmo);
    const existing = chips.find((chip) => chip.key === key);
    if (existing) {
      existing.count += 1;
    } else {
      chips.push({ key, nome: nomeRitmo, count: 1, firstId: point.id });
    }
  }

  return (
    <section id="busca">
      <div className="linha-hero" id="linha-hero">
        <div className="linha-nome" id="linha-nome" aria-describedby={saudacao ? "linha-saudacao" : undefined}>
          {nome}
        </div>
        {saudacao ? (
          <p className="linha-saudacao" id="linha-saudacao">
            {saudacao}
          </p>
        ) : null}
        {playlist ? (
          <a className="linha-playlist" href={playlist} target="_blank" rel="noopener noreferrer" aria-label="Abrir playlist no YouTube (abre em nova aba)">
            <ExternalIcon />
            <span>Abrir playlist no YouTube</span>
          </a>
        ) : null}
      </div>
      {chips.length > 0 ? (
        <nav className="ritmo-chips" id="ritmo-chips" aria-label="Índice de ritmos">
          {chips.map((chip, index) => (
            <a
              key={chip.key}
              className={index === 0 ? "ritmo-chip is-active" : "ritmo-chip"}
              href={`#${chip.firstId}`}
              data-ponto-id={String(chip.firstId)}
              data-ritmo={chip.key}
            >
              {chip.count} {chip.nome}
            </a>
          ))}
        </nav>
      ) : null}
      <h1 className="linha-title visually-hidden">{nome}</h1>
      <div id="pontos">
        {points.length === 0 ? (
          <p className="empty-state">Nenhum ponto encontrado para esta linha.</p>
        ) : (
          points.map((point, index) => {
            const ritmo = point.ritmo?.nome ?? "";
            const tipo = (point.tipo ?? "").trim();
            const extra = tipo.toLocaleLowerCase("pt-BR") === "subida" || tipo.toLocaleLowerCase("pt-BR") === "demanda" ? ` (${tipo})` : "";
            const video = youtubeId(point.audio_url);
            const audio = isDirectAudio(point.audio_url) ? point.audio_url : null;
            return (
              <article className="ponto" id={String(point.id)} data-ritmo={ritmoKey(ritmo)} key={point.id}>
                <h2 className="ponto-ritmo">
                  <span>{index + 1}</span>| {ritmo}
                  {extra ? <span>{extra}</span> : null}
                </h2>
                <div className="ponto-letra" dangerouslySetInnerHTML={{ __html: letraHtml(point.letra ?? "") }} />
                {video ? (
                  <iframe
                    className="yt-embed"
                    src={`https://www.youtube.com/embed/${video}`}
                    title={`Áudio do ponto ${point.id}`}
                    allowFullScreen
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerPolicy="strict-origin-when-cross-origin"
                  />
                ) : null}
                {audio ? (
                  <audio controls preload="none">
                    <source src={audio} type="audio/mpeg" />
                  </audio>
                ) : null}
              </article>
            );
          })
        )}
      </div>
    </section>
  );
}

export function Presentation() {
  return (
    <section id="apresentacao">
      <h1>Apresentação</h1>
      <p>Pontos de Umbanda utilizados durante as giras pela curimba do terreiro Raízes de Aruanda, bem como para o compartilhamento de conhecimentos.</p>
      <br />
      <hr />
      <p>
        Regência de 2026: <a href="/?buscar=Omulu" className="brand">Omulu</a> e <a href="/?buscar=Oxum" className="brand">Oxum</a>.
      </p>
      <br />
      <hr />
      <p>
        <a href="/ordem-ritualistica" className="brand">Ordem ritualística de abertura da casa.</a>
      </p>
      <p>Neste link você encontrará o passo a passo, o procedimento ritualístico, executado para a abertura de cada gira.</p>
    </section>
  );
}
