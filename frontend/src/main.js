import Vue from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import 'typeface-poppins';
import axios from 'axios'
import VueAxios from 'vue-axios'
import { createPinia, PiniaVuePlugin } from 'pinia'

axios.defaults.baseURL = process.env.VUE_APP_API_URL

Vue.use(VueAxios, axios)
Vue.use(PiniaVuePlugin)

const pinia = createPinia()

Vue.config.productionTip = false

new Vue({
  router,
  pinia,
  vuetify,
  render: h => h(App)
}).$mount('#app')
