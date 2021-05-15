import {login, info, logout} from '@/api/auth'
import {getToken, setToken, removeToken} from "@/untils/auth";

const user = {
    state: {
        token: getToken(),
        name: '',
        email: '',
        avatar: '',
        roles: [],
        permissions: [],
    },

    mutations: {
        SET_TOKEN: (state, token) => {
            state.token = token
        },
        SET_NAME: (state, name) => {
            state.name = name
        },
        SET_EMAIL: (state, email) => {
            state.email = email
        },
        SET_AVATAR: (state, avatar) => {
            state.avatar = avatar
        },
        SET_ROLES: (state, roles) => {
            state.roles = roles
        },
        SET_PERMISSIONS: (state, permissions) => {
            state.permissions = permissions
        },
    },

    actions: {
        // 登录
        login({commit}, userInfo) {
            return new Promise((resolve, reject) => {
                login(userInfo).then(res => {
                    if (res.code === 200) {
                        commit('SET_TOKEN', res.data.token)
                        setToken(res.data.token)
                        resolve(res)
                    } else {
                        resolve(res)
                    }
                }).catch(error => {
                    reject(error)
                })
            })
        },

        // 获取用户信息
        getInfo({commit}) {
            return new Promise((resolve, reject) => {
                info().then(response => {
                    if (response.code === 200) {
                        const {data} = response

                        const {roles, name, email, avatar, permissions} = data
                        // roles must be a non-empty array
                        if (!roles || roles.length <= 0) {
                            reject('getInfo: roles must be a non-null array!')
                        }
                        commit('SET_ROLES', roles)
                        commit('SET_NAME', name)
                        commit('SET_EMAIL', email)
                        commit('SET_AVATAR', avatar)
                        commit('SET_PERMISSIONS', permissions)
                        resolve(data)
                    } else {
                        reject(response)
                    }
                }).catch(error => {
                    reject(error)
                })
            })
        },

        // 登出
        logout({commit}) {
            return new Promise((resolve) => {
                logout().then(res => {
                    resolve(res)
                }).catch(error => {
                    resolve(error)
                }).finally(() => {
                    commit('SET_TOKEN', '')
                    commit('SET_ROLES', [])
                    commit('SET_NAME', '')
                    commit('SET_EMAIL', '')
                    commit('SET_AVATAR', '')
                    commit('SET_PERMISSIONS', [])
                    commit('SET_ACTIVE_INDEX', '')
                    commit('SET_ROUTES', [])
                    commit('SET_MENUS', [])

                    removeToken()
                })
            })
        }

    }
}

export default user
