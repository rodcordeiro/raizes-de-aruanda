import { createBrowserRouter } from 'react-router-dom';
import { BaseLayout } from '../components/layout/base';

const router = createBrowserRouter([
	{
		path: '/',
		element: <BaseLayout />,
		// errorElement: <ErrorPage />,
		children: [
			{
				path: '/',
				async lazy() {
					// Multiple routes in lazy file
					let { Home } = await import('../features/Home');
					return { Component: Home };
				},
			},
			{
				path: '/linha/:id',
				async lazy() {
					// Multiple routes in lazy file
					let { Linha } = await import('../features/Linha');
					return { Component: Linha };
				},
			},
		],
	},
]);
export { router };
