/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const receivableRoutes = {
  path: '/receivable',
  component: Layout,
  redirect: 'noredirect',
  name: '应收',
  meta: {
    title: 'receivable',
    icon: 'chart',
    permissions: ['view menu receivable'],
  },
  children: [
    {
      path: 'keyboard',
      component: () => import('@/views/receivable/List'),
      name: 'KeyboardChart',
      meta: { title: '应收报表', noCache: true },
    },
  ],
};

export default receivableRoutes;
