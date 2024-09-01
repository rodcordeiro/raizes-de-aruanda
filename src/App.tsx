import { Providers } from './hooks';
import { RouterProvider } from 'react-router-dom';
import { router } from './routes';

function App() {
	return (
		<Providers>
			<RouterProvider router={router} />
		</Providers>
	);
}

export default App;
