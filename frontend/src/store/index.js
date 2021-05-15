import Vuex from 'vuex'
import user from './modules/user'

// default router permission control
import permission from './modules/permission'

import getters from "./getters";

const store = new Vuex.Store({
    modules:{
        user,
        permission
    },
    state: {

    },
    mutations: {

    },
    actions: {

    },
    getters
})

export default store
