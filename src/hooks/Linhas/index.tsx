import { api } from '@/libs/api';
import React from 'react';

interface LinhasContextProps {
	linhas: Linha[];
	categorias: Categoria[];
}

const LinhasContext = React.createContext({} as LinhasContextProps);

export const LinhasHook = ({ children }: React.PropsWithChildren) => {
	const [linhas, setLinhas] = React.useState<Linha[]>([]);
	const [categorias, setCategorias] = React.useState<Categoria[]>([]);

	React.useEffect(() => {
		api
			.get<Linha[]>('/api/v1/lines')
			.then((res) =>
				setLinhas(res.data.sort((a, b) => (a.nome < b.nome ? -1 : 1))),
			);
		api
			.get<Categoria[]>('/api/v1/categories')
			.then((res) => setCategorias(res.data));
	}, []);

	return (
		<LinhasContext.Provider
			value={{
				linhas,
				categorias,
			}}
		>
			{children}
		</LinhasContext.Provider>
	);
};

export function useLinhas() {
	return React.useContext(LinhasContext);
}
