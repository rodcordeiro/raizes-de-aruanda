import { createBrowserRouter } from 'react-router-dom';

import { HomeScreen } from '@/features/Home';
import { Base } from '@/components/Layout/Base';

export const Routes = createBrowserRouter([
  {
    path: '/',
    Component: Base,
    children: [
      {
        path: '/',
        Component: HomeScreen,
      },
    ],
  },
]);
