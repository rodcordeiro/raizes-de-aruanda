import { defineConfig } from 'vite';
import path from 'path';
import react from '@vitejs/plugin-react';

// https://vitejs.dev/config/
export default defineConfig({
	plugins: [react()],
	base: process.env.NODE_ENV === 'development' ? '/umbanda.dev/' : '/',

	resolve: {
		alias: {
			'@': path.resolve(__dirname, './src'),
		},
	},
});
