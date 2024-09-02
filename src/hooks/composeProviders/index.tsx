import React, { ReactNode } from 'react';

interface iComposeProvidersProps {
	with: { Provider: React.ElementType; properties?: object }[];
	children: ReactNode;
}

const ComposeProviders: React.FC<iComposeProvidersProps> = ({
	children,
	with: Providers,
}) => (
	<>
		{Providers.reduce(
			(AccProviders, { Provider, properties }) => (
				<Provider {...properties}>{AccProviders}</Provider>
			),
			children,
		)}
	</>
);

export default ComposeProviders;
