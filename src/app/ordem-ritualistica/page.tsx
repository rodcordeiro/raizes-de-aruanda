import { PublicShell } from "@/components/public-shell";
import { getLines } from "@/lib/api";

export const metadata = { title: "Ordem ritualística — Raízes de Aruanda" };

export default async function OrdemPage() {
  const lines = await getLines();

  return (
    <PublicShell lines={lines}>
      <article id="ordem-ritualistica" className="doc-page">
        <h1>Ordem ritualística de abertura</h1>
        <p>
          A abertura de cada gira no terreiro Raízes de Aruanda segue uma ordem fixa. Este texto é o canhoto da Curimba e também referência para os filhos da casa: o procedimento ritualístico executado antes do trabalho das linhas.
        </p>
        <ol className="ordem-passos">
          <li>Saudamos a matriarca — ou, em sua ausência, o patriarca.</li>
          <li>
            Cantamos para a defumação e para a entrada dos demais filhos, nesta ordem:
            <ul>
              <li>egbomis;</li>
              <li>yawos;</li>
              <li>abians.</li>
            </ul>
          </li>
          <li>Cantamos para as yalorixás da casa entrarem.</li>
          <li>Cantamos para os babalorixás da casa entrarem.</li>
        </ol>
        <p>
          <strong>5.</strong> Cantamos para o babalorixá patriarca da casa entrar somente se ele ainda não tiver sido o primeiro a entrar — ou seja, quando a abertura não começou pela saudação ao patriarca.
        </p>
        <ol className="ordem-passos" start={6}>
          <li>
            Saudamos a esquerda: as linhas de Exu, Pomba-gira e Exu-mirim, saudadas no início de cada trabalho, nesta ordem:
            <ol>
              <li>
                <a href="/?buscar=Exu#880" className="brand">Exu Arranca Toco</a> (Pai Edgar) — ponto 880
              </li>
              <li>
                <a href="/?buscar=Exu#707" className="brand">Exu do Lodo</a> (Mãe Leonor e Pai Gilberto) — ponto 707
              </li>
              <li>Pombagira Maria Mulambo (Mãe Leonor e Mãe Jaciara) — ponto não registrado</li>
              <li>
                <a href="/?buscar=Pomba-gira#887" className="brand">Pombagira Dona Pitombeira</a> (Pai Edgar) — ponto 887
              </li>
              <li>
                <a href="/?buscar=Exu-mirim#718" className="brand">Exu Mirim</a> (Egbomi Anderson) — ponto 718
              </li>
            </ol>
          </li>
          <li>Cantamos o ponto para retirar as esteiras de bater cabeça.</li>
          <li>Cantamos para abrir a gira.</li>
          <li>
            Saudamos os orixás da casa:
            <ul>
              <li>Oxóssi;</li>
              <li>Xangô;</li>
              <li>Oyá.</li>
            </ul>
          </li>
          <li>Saudamos o orixá regente do ano em nossa casa.</li>
          <li>Cantamos para o orixá que será saudado na gira.</li>
          <li>Cantamos para a linha que será saudada na gira.</li>
        </ol>
        <p>
          <strong>13.</strong> Se o ano estiver regido por dois orixás — como em 2026, com <a href="/?buscar=Omulu" className="brand">Omulu</a> e <a href="/?buscar=Oxum" className="brand">Oxum</a> —, cantamos também para o segundo orixá regente da casa.
        </p>
        <ol className="ordem-passos" start={14}>
          <li>Saudamos o fechamento da gira.</li>
          <li>Saudamos o fechamento do couro: o encerramento espiritual dos trabalhos daquela gira.</li>
        </ol>
      </article>
    </PublicShell>
  );
}
