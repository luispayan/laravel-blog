require('./bootstrap');

import Vue from 'vue';
import App from './components/App.vue';
import { BootstrapVue } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)

// Notifications
import VueAWN from "vue-awesome-notifications";
Vue.use(VueAWN, {
  position: "top-right",
});

document.addEventListener('DOMContentLoaded', () => {
    const app = new Vue({
        render: h => h(App)
    }).$mount('#app')
})