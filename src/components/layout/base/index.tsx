import React from 'react';
import { Outlet } from 'react-router-dom';
import { Header } from '@/components/layout/Header';
import { Sidebar } from '../PublicSidebar';

export const BaseLayout = ({}: React.PropsWithChildren) => {
	const [sidebarVisible, setSidebarVisible] = React.useState<boolean>(false);
	const toggleSidebar = () => setSidebarVisible(!sidebarVisible);
	return (
		<div>
			<Header toggleSidebar={toggleSidebar} />
			<main>
				{sidebarVisible && <Sidebar />}
				<Outlet />
			</main>
		</div>
	);
};
