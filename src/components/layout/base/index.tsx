import React from 'react';
import { Outlet } from 'react-router-dom';
import { Header } from '@/components/layout/Header';

export const BaseLayout = ({}: React.PropsWithChildren) => {
	const [sidebarVisible, setSidebarVisible] = React.useState<boolean>(false);
	const toggleSidebar = () => setSidebarVisible(!sidebarVisible);
	return (
		<div>
			<Header toggleSidebar={toggleSidebar} />
			<main>
				{sidebarVisible && <aside>oi</aside>}
				<Outlet />
			</main>
		</div>
	);
};
