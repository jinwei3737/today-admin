export function getToken() {
    return 'Bearer ' + localStorage.Token
}

export function setToken(token) {
    return localStorage.setItem('Token', token)
}

export function removeToken() {
    return localStorage.removeItem('Token')
}



