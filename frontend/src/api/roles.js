import axios from "@/untils/request";


export function getRoles(parameter) {
    return axios({
        url: '/roles',
        method: 'get',
        params: parameter
    })
}

export function add(parameter) {
    return axios({
        url: '/role/add',
        method: 'post',
        data: parameter
    })
}

export function edit(parameter) {
    return axios({
        url: '/role/edit',
        method: 'post',
        data: parameter
    })
}

export function del(parameter) {
    return axios({
        url: '/role/delete',
        method: 'post',
        data: parameter
    })
}

export function removePermission(parameter) {
    return axios({
        url: '/role/remove_permission',
        method: 'post',
        data: parameter
    })
}

export function viewData() {
    return axios({
        url: '/role/view_data',
        method: 'get'
    })
}
