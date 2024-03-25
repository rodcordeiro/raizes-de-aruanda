import { Outlet } from 'react-router-dom';
import { Header } from '../Header';
import { SideBar } from '../Sidebar';

export const Base = () => {
  return (
    <div className="flex row bg-slate-100 dark:bg-gray-900 w-screen h-screen overflow-hidden">
      <SideBar />
      <main className="">
        <Header />
        <Outlet />
      </main>
    </div>
  );
};
