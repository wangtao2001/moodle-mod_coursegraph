import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import axios from 'axios'

export const init = (serverUrl, apiKey) => {
    axios.defaults.baseURL = serverUrl.endsWith('/') ? serverUrl + 'api/echarts' : serverUrl + '/api/echarts'
    axios.interceptors.request.use(config => {
        config.headers['api-key'] = apiKey
        return config
    })
    axios.interceptors.response.use(response => {
        return response.data
    })

    const pinia = createPinia()
    const app = createApp(App)
    app.use(pinia)

    app.mount('#app')
}
