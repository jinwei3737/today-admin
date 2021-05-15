import {Layout, RouteView} from '@/layout'

export const asyncRouterMap = [
    {
        name: 'layout',
        component: Layout,
        meta: {title: 'Layout', icon: 'el-icon-user-solid'},
        children: [
            {
                path: '/system',
                name: 'system',
                meta: {title: '系统管理', icon: 'iconfont icon-permission', permissions: ['system']},
                component: RouteView,
                children: [
                    {
                        path: '/users',
                        name: 'users',
                        component: () => import('@/views/users/Index'),
                        meta: {title: '用户管理', icon: 'el-icon-user-solid', permissions: ['system.users']}
                    },
                    {
                        path: '/roles',
                        name: 'roles',
                        component: () => import('@/views/roles/Index'),
                        meta: {title: '角色管理', icon: 'iconfont icon-role', permissions: ['system.roles']}
                    },
                    {
                        path: '/menus',
                        name: 'menus',
                        component: () => import('@/views/menus/Index'),
                        meta: {title: '菜单管理', icon: 'el-icon-menu', permissions: ['system.menus']},
                    }
                ]
            },
            {
                path: '/orders',
                name: 'orders',
                meta: {title: '订单管理', icon: 'iconfont icon-permission', permissions: ['orders']},
                component: RouteView,
                children: [
                    {
                        path: '/order/list',
                        name: 'order_list',
                        component: () => import('@/views/orders/Index'),
                        meta: {title: '订单列表', icon: 'iconfont icon-role', permissions: ['order.list']}
                    },
                ]
            },
        ]
    }
]

export const constantRouterMap = [
    {
        path: '/login',
        name: 'login',
        hidden: true,
        component: () => import('@/views/Login'),
        meta: {title: '登录'}
    },
    {
        component: Layout,
        meta: {title: 'Layout'},
        hidden: true,
        children:[
            {
                path: '/404',
                hidden: true,
                component: () => import('@/views/404'),
                meta: {title: '404'}
            },
            {
                path: '/403',
                hidden: true,
                component: () => import('@/views/403'),
                meta: {title: '403'}
            },
        ]
    }
]
