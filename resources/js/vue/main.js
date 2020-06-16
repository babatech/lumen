import Vue from 'vue'
import axios from 'axios'
import App from './App.vue'
import router from './router'
import Vuex from 'vuex'
import { store } from './store'

import 'bootstrap/dist/css/bootstrap.css';

Vue.config.productionTip = false
Vue.prototype.$axios = axios

Vue.use(Vuex)

new Vue({
  router,
  render: h => h(App),
  store
}).$mount('#app')
