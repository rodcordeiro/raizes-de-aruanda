/** @type {import('tailwindcss').Config} */
export default {
	content: ['./index.html', './src/**/*.{js,jsx,ts,tsx}'],
	theme: {
		extend: {
			colors: {
				'dark-burgundy': {
					50: '#fff4eb',
					100: '#ffe8d0',
					200: '#ffcca1',
					300: '#ffa765',
					400: '#ff7527',
					500: '#ff4f00',
					600: '#ff3000',
					700: '#d61e00',
					800: '#a91803',
					900: '#7b1506',
					950: '#490701',
				},
			},
		},
	},
	plugins: [],
};
