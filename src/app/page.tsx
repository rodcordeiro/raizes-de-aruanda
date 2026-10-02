import { LineView, Presentation } from "@/components/line-view";
import { PublicShell } from "@/components/public-shell";
import { getLines, getPoints } from "@/lib/api";
import { sameName } from "@/lib/format";

export default async function HomePage({ searchParams }: { searchParams: Promise<{ buscar?: string }> }) {
  const { buscar = "" } = await searchParams;
  const lines = await getLines();
  const selected = buscar ? lines.find((line) => sameName(line.nome, buscar)) ?? null : null;
  const points = selected ? await getPoints(selected.id) : [];

  return (
    <PublicShell lines={lines} activeName={selected?.nome}>
      {buscar ? <LineView line={selected} points={points} fallbackName={buscar} /> : <Presentation />}
    </PublicShell>
  );
}
