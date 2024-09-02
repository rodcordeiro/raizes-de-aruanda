import { defineConfig, ConfigEnv } from 'vite';
import path from 'path';
import react from '@vitejs/plugin-react';

// https://vitejs.dev/config/
export default defineConfig({
	plugins: [react()],
	base: '/umbanda.dev/',

	resolve: {
		alias: {
			'@': path.resolve(__dirname, './src'),
		},
	},
});
