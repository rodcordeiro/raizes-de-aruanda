import ComposeProviders from './composeProviders';
import { LinhasHook } from './Linhas';

export function Providers({ children }: React.PropsWithChildren) {
	return (
		<ComposeProviders
			with={[
				{
					Provider: LinhasHook,
				},
			]}
		>
			{children}
		</ComposeProviders>
	);
}
