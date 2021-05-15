import {createApp} from 'vue'
import ElementPlus from 'element-plus'
import 'element-plus/lib/theme-chalk/index.css'
import App from './App.vue'
import router from './router'
import store from "./store";
import './assets/iconfont/iconfont.css'
import './assets/css/main.css'
import './permission'

const app = createApp(App)
app.use(router)
app.use(store)
app.use(ElementPlus)
//自定义指定实现按钮级权限控制
app.directive('auth', {
    mounted: (el, binding) => {
        const key = binding.value;
        const permissions = store.getters.permissions;

        if(!permissions.includes(key)){
            el.parentNode && el.parentNode.removeChild(el)
        }
    }
})
app.mount('#app')
