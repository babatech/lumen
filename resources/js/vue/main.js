import Vue from 'vue'
import axios from 'axios'
import App from './App.vue'
import router from './router'

// Import the styles directly. (Or you could add them via script tags.)
import 'bootstrap/dist/css/bootstrap.css';

Vue.config.productionTip = false
Vue.prototype.$axios = axios

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
