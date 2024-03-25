import { SidebarHook } from './hooks/sidebar.hook';

export const SideBar = () => {
  SidebarHook();
  return (
    <aside className="hidden lg:block bg-dark-burgundy-800 dark:bg-dark-burgundy-900 ">
      <div className="w-60 flex justify-center items-start h-screen pt-10">
        <img
          src="https://rodcordeiro.github.io/shares/favicons/favicon-raizes/android-icon-192x192.png"
          width={100}
          height={100}
          className="rounded-lg"
        />
      </div>
    </aside>
  );
};
