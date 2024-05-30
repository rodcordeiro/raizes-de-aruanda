import ComposeProviders from './hooks/composeProviders';
import { RouterProvider } from 'react-router-dom';
import { router } from './routes';

function App() {
	return (
		<ComposeProviders with={[]}>
			<RouterProvider router={router} />
		</ComposeProviders>
	);
}

export default App;
