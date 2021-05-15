const getters = {
    token: state => state.user.token,
    name: state => state.user.name,
    email: state => state.user.email,
    avatar: state => state.user.avatar,
    roles: state => state.user.roles,
    permissions: state => state.user.permissions,
    addRouters: state => state.permission.addRouters,
    routers: state => state.permission.routers,
    menus: state => state.permission.menus,
    active_index: state => state.permission.active_index,
}

export default getters
