import router from './router'
import store from "./store";
import {ElMessage} from "element-plus";
import {removeToken} from "./untils/auth";

const whiteList = ['/login'] //免登录白名单

router.beforeEach((to, from, next) => {
    if (localStorage.Token) {
        //有token
        if (to.path === '/login') {
            next({path: '/403'})
        } else {
            if (store.getters.roles.length > 0) {
                //已获取权限
                next()
            } else {
                //通过GetInfo获取权限
                store.dispatch('getInfo').then(res => {
                    store.dispatch('generateRoutes', res).then(() => {
                        // 根据roles权限生成可访问的路由表,动态添加可访问路由表
                        router.addRoute(store.getters.addRouters[0])

                        // 请求带有 redirect 重定向时，登录自动重定向到该地址
                        const redirect = decodeURIComponent(from.query.redirect || to.path)
                        if (to.path === redirect) {
                            //set the replace: true so the navigation will not leave a history record
                            next({...to, replace: true})
                        } else {
                            // 跳转到目的路由
                            next({path: redirect})
                        }
                    })
                }).catch(() => {
                    ElMessage.error('您没有权限访问或已退出登录')
                    removeToken()
                    next(`/login?redirect=${to.path}`)
                })
            }
        }
    } else {
        if (whiteList.includes(to.path)) {
            // 在免登录白名单，直接进入
            next()
        } else {
            next({path: '/login'})
        }
    }
})

router.afterEach(() => {
    // finish progress bar

})
