declare global {
	interface Linha {
		id: number;
		createdAt: string;
		updatedAt: string;
		nome: string;
		canal_youtube: null | string;
		categoria: Categoria;
	}

	interface Categoria {
		id: number;
		createdAt: string;
		updatedAt: string;
		nome: string;
	}
}

export {};
