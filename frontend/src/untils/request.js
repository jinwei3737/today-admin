import axios from "axios";
import {ElMessage} from "element-plus"
import {isArray} from "element-plus/lib/utils/util";

axios.defaults.baseURL = process.env.VUE_APP_URL
axios.defaults.headers.common["Content-Type"] = "application/json; charset=UTF-8"
axios.defaults.headers.common["Access-Control-Allow-Origin"] = "*"

// 请求拦截器 添加token
axios.interceptors.request.use(config => {
        //设置请求头
        if (localStorage.Token) {
            config.headers.Authorization = 'Bearer ' + localStorage.Token
        }
        return config
    }, error => {
        return Promise.reject(error)
    }
)

// 响应拦截器即异常处理
axios.interceptors.response.use(response => {
        return response.data
    }, (error) => {

        let errorMsg = []

        if (error.response.status === 500) {
            errorMsg.push('系统错误')
        } else if (error.response.status === 422) {
            for (let n in error.response.data.errors) {
                if (isArray(error.response.data.errors[n])) {
                    error.response.data.errors[n].forEach(msg => {
                        errorMsg.push(msg)
                    })
                }
            }
        }

        ElMessage.error(errorMsg[0])

        return Promise.resolve(error)
    }
)

export default axios
