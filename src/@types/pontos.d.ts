declare global {
	interface Ponto {
		id: number;
		createdAt: string;
		updatedAt: string;
		letra: string;
		tipo: null;
		audio_url: null | string;
		linha: Linha;
		ritmo: Categoria;
	}
}

export {};
