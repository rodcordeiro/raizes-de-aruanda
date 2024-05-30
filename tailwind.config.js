/** @type {import('tailwindcss').Config} */
export default {
	darkMode: 'class',
	content: [
		'./src/**/*.{ts,tsx}',
		'./src/**/**/*.{ts,tsx}',
		'./src/**/**/**/*.{ts,tsx}',
	],
	theme: {
		extend: {
			colors: {
				primary: '#7b1506',
			},
		},
	},
	plugins: {
		tailwindcss: {},
		autoprefixer: {},
	},
};
