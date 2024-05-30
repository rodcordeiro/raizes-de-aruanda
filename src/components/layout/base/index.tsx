import React from 'react';
import { Outlet } from 'react-router-dom';
import { Header } from '@/components/layout/Header';

export const BaseLayout = ({}: React.PropsWithChildren) => {
	return (
		<div>
			<Header />
			<Outlet />
		</div>
	);
};
