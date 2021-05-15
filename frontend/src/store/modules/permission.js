import {asyncRouterMap, constantRouterMap} from '@/config/router.config'

function hasPermission(route, permissions) {
    if (route.name === 'layout') {
        return true
    }
    if (route.meta && route.meta.permissions) {
        return permissions.some(permission => route.meta.permissions.includes(permission))
    } else {
        return false
    }
}

/**
 * 单账户多角色时，使用该方法可过滤角色不存在的菜单
 *
 * @param roles
 * @param route
 * @returns {*}
 */
// eslint-disable-next-line
function hasRole(roles, route) {
    if (route.meta && route.meta.roles) {
        return route.meta.roles.includes(roles.id)
    } else {
        return true
    }
}

function filterAsyncRouter(routerMap, permissions) {
    const res = []
    routerMap.forEach(route => {
        const tmp = {...route}
        if (hasPermission(tmp, permissions)) {
            if (tmp.children) {
                tmp.children = filterAsyncRouter(tmp.children, permissions)
            }

            res.push(tmp)
        }
    })

    return res
}

const permission = {
    state: {
        addRouters: [],
        routers: [],
        menus: [],
        active_index: 0
    },
    mutations: {
        SET_ROUTES: (state, routes) => {
            state.addRouters = routes
            state.routers = constantRouterMap.concat(routes)
        },
        SET_MENUS: (state, menus) => {
            state.menus = menus
        },
        SET_ACTIVE_INDEX: (state, active_index) => {
            state.active_index = active_index
        }
    },
    actions: {
        generateRoutes({commit}, {permissions}) {
            return new Promise(resolve => {
                let accessedRoutes = filterAsyncRouter(asyncRouterMap, permissions)
                commit('SET_ROUTES', accessedRoutes)
                resolve(accessedRoutes)
            })
        }
    }
}

export default permission
