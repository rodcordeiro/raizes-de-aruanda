import { api } from '@/libs/api';
import React from 'react';
import { useParams } from 'react-router-dom';

export const Linha = () => {
	const { id } = useParams();
	const [pontos, setPontos] = React.useState<Ponto[]>();

	React.useEffect(() => {
		api
			.get<Ponto[]>(`/api/v1/points?linha=${id}`)
			.then(({ data }) =>
				data.sort((a, b) => (a.ritmo.nome < b.ritmo.nome ? -1 : 1)),
			)
			.then((data) => setPontos(data));
	}, [id]);
	if (!pontos) return 'Carregando...';
	return (
		<div className="flex flex-col w-screen h-fit py-10">
			<h1 className="w-screen text-2xl text-center font-bold">
				Pontos de {pontos[0].linha.nome}
			</h1>
			{pontos.map((ponto, idx) => (
				<div className="flex flex-col px-6 py-4">
					<hr className="mb-2" />
					<h2 className="py-2 font-medium">
						{idx + 1} | {ponto.ritmo.nome}
					</h2>
					{ponto.letra
						.replace(/\r\n\r\n/, 'BREAK_LINE_KEY')
						.split('\r\n')
						.map((line) => {
							if (line.includes('BREAK_LINE_KEY')) {
								return line
									.split('BREAK_LINE_KEY')
									.map((paragraph, idx, arr) => {
										return (
											<p>
												{paragraph}
												{idx !== arr.length - 1 && (
													<>
														<br />
														<br />
													</>
												)}
											</p>
										);
									});
							}
							return <p>{line}</p>;
						})}
					{ponto.audio_url && (
						<audio src={ponto.audio_url} controls crossOrigin="anonymous" className='my-4'/>
					)}
				</div>
			))}
		</div>
	);
};
