import './bootstrap'
import {createApp} from "vue"
import App from './App.vue'
import Auth from './auth'
import router from "./router.js"

const app = createApp({
    components: {
        'app-component': App
    }
})
app.use(router)
app.config.globalProperties.$auth = new Auth(window.user)
app.mount('#app')

axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if(error.response.status === 403 || error.response.status === 419) {
        window.location.href = "/login";
    }
    return Promise.reject(error);
});
