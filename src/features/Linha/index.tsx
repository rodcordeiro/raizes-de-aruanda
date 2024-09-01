import { api } from '@/libs/api';
import React from 'react';
import { useParams } from 'react-router-dom';

export const Linha = () => {
	const { id } = useParams();
	const [pontos, setPontos] = React.useState<Ponto[]>([]);

	React.useEffect(() => {
		api
			.get<Ponto[]>(`/api/v1/points?linha=${id}`)
			.then(({ data }) => setPontos(data));
	}, [id]);
	return (
		<div className="flex flex-col w-screen h-fit py-10 justify-center items-center ">
			<h1 className="w-2/3">Pontos de {pontos[0].linha.nome}</h1>
			{pontos.map((ponto) => (
				<div className="flex flex-col px-6 py-4">
					<h2>{ponto.ritmo.nome}</h2>
					<p>{ponto.letra}</p>
				</div>
			))}
		</div>
	);
};
