import React from 'react';
import { Menu, X } from 'react-feather';

type HeaderProps = {
	toggleSidebar: () => void;
};

export const Header = ({ toggleSidebar }: HeaderProps) => {
	const [open, updateOpen] = React.useState(false);

	const toggleOpen = () => {
		toggleSidebar();
		updateOpen((prev) => !prev);
	};

	return (
		<header className="bg-dark-burgundy-900 w-full h-fit text-white px-10 py-4 flex row items-center justify-between">
			<img
				src="https://rodcordeiro.github.io/shares/favicons/favicon-raizes/android-icon-192x192.png"
				alt="Logo raizes"
				className="rounded-full w-20 "
			/>
			<button onClick={toggleOpen}>{open ? <X /> : <Menu />}</button>
		</header>
	);
};
