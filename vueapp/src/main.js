import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
// import './index.css'
import axios from 'axios'

axios.defaults.baseURL = 'http://localhost:8082/api/tasks';

const app = createApp(App)

app.use(router)

app.mount('#app')
