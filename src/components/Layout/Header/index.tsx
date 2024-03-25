import React from 'react';
import { Switch } from '@/components/ui/switch';

export const Header = () => {
  const [isDark, setIsDark] = React.useState<boolean>(false);
  React.useEffect(() => {
    const theme = localStorage.getItem('@raizes:theme');
    if (theme) setIsDark(theme === 'dark');
  }, []);

  function handleThemeToogle() {
    setIsDark(!isDark);
    localStorage.setItem('@raizes:theme', isDark ? 'light' : 'dark');
    document.documentElement.classList.toggle('dark');
  }
  return (
    <div className="h-24 bg-dark-burgundy-800 dark:bg-dark-burgundy-900 lg:bg-white dark:lg:bg-gray-800  w-screen">
      <div className="flex row items-center top-4 right-4 absolute">
        <Switch
          className="w-10 m-4"
          onCheckedChange={handleThemeToogle}
          checked={isDark}
        />
        <p>Dark</p>
      </div>
    </div>
  );
};
