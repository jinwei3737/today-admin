import axios from "@/untils/request";


export function login(parameter) {
    return axios({
        url: '/login',
        method: 'post',
        data: parameter
    })
}

export function logout(parameter) {
    return axios({
        url: '/logout',
        method: 'post',
        data: parameter
    })
}

export function info() {
    return axios({
        url: '/info',
        method: 'get',
    })
}
