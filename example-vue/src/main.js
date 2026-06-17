import { createApp } from 'vue'
import App from './App.vue'
import { createPinia } from 'pinia'
import router from '@/router.js'

import PrimeVue from 'primevue/config'
import Aura from '@primeuix/themes/aura'
import ToastService from 'primevue/toastservice'
import 'primeicons/primeicons.css'

const app = createApp(App)
app.use(createPinia())
app.use(router)
app.use(PrimeVue, {
  theme: {
    preset: Aura,
  },
})
// Сервис всплывающих уведомлений (toast)
app.use(ToastService)
app.mount('#app')
