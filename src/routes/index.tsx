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
					let { Home } = await import('../features/Home');
					return { Component: Home };
				},
			},
			{
				path: '/linha/:id',
				async lazy() {
					let { Linha } = await import('../features/Linha');
					return { Component: Linha };
				},
			},
		],
	},
	{
		path: '/admin',
		element: (
			<main>
				<h1>Ainda não implementado</h1>
			</main>
		),
	},
]);
export { router };
