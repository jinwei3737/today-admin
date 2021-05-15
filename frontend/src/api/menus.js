import axios from "@/untils/request";


export function getMenus(parameter) {
    return axios({
        url: '/menus',
        method: 'get',
        params: parameter
    })
}

export function add(parameter) {
    return axios({
        url: '/menu/add',
        method: 'post',
        data: parameter
    })
}

export function edit(parameter) {
    return axios({
        url: '/menu/edit',
        method: 'post',
        data: parameter
    })
}

export function del(parameter) {
    return axios({
        url: '/menu/delete',
        method: 'post',
        data: parameter
    })
}

export function removeBtn(parameter) {
    return axios({
        url: '/menu/remove_btn',
        method: 'post',
        data: parameter
    })
}

export function viewData() {
    return axios({
        url: '/menu/view_data',
        method: 'get'
    })
}
