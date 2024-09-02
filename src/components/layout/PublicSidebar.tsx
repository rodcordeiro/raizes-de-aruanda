import { Home } from 'react-feather';

import { useLinhas } from '@/hooks/Linhas';

export function Sidebar() {
	const { linhas, categorias } = useLinhas();
	return (
		<aside className="bg-dark-burgundy-900 w-full h-fit flex flex-col justify-start items-start py-2 px-6">
			{linhas && (
				<div>
					{categorias.map((category) => (
						<div className="mb-2">
							<h2 className="text-white font-medium">{category.nome}</h2>
							<div className="flex flex-col pl-4">
								{linhas
									?.filter((l) => l.categoria.id === category.id)
									.map((linha) => (
										<a href={`/linha/${linha.id}`} className="text-gray-200">
											{linha.nome}
										</a>
									))}
							</div>
						</div>
					))}
				</div>
			)}
			<a
				href={`/admin`}
				className="text-gray-200 my-4 flex justify-center items-center gap-2"
			>
				<Home size={16} />
				Admin
			</a>
		</aside>
	);
}
