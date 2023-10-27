import { createApp } from 'vue'
import mitt from 'mitt'
import router from '../router'
import App from './App.vue'


import 'ayoflex/dist/ayoflex.min.css'
import '../css/example.css'

let eventBus = mitt()
let app = createApp(App);

app.use(router);
app.config.globalProperties.$eventBus = eventBus;

app.mount('#app');
