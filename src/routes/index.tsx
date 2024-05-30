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
		],
	},
]);
export { router };
