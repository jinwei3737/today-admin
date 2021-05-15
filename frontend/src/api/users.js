import axios from "@/untils/request";


export function getUsers(parameter) {
    return axios({
        url: '/users',
        method: 'get',
        params: parameter
    })
}

export function add(parameter) {
    return axios({
        url: '/user/add',
        method: 'post',
        data: parameter
    })
}

export function detail(parameter) {
    return axios({
        url: '/user/detail',
        method: 'get',
        params: parameter
    })
}

export function edit(parameter) {
    return axios({
        url: '/user/edit',
        method: 'post',
        data: parameter
    })
}

export function del(parameter) {
    return axios({
        url: '/user/delete',
        method: 'post',
        data: parameter
    })
}

export function removeRole(parameter) {
    return axios({
        url: '/user/remove_role',
        method: 'post',
        data: parameter
    })
}

export function removePermission(parameter) {
    return axios({
        url: '/user/remove_permission',
        method: 'post',
        data: parameter
    })
}

export function viewData() {
    return axios({
        url: '/user/view_data',
        method: 'get'
    })
}
