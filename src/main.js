import { createApp } from 'vue'
import App from './App.vue'
import List from './Datebase-list.vue'


const app = createApp(App)
app.mount('#app')

const list = createApp(List)
list.mount('#list')