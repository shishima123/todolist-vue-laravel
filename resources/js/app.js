import VueRouter from 'vue-router'
import App from './App'
import Vue from 'vue'
import Toasted from 'vue-toasted'
require('./bootstrap')

window.Vue = require('vue')

window.Vue.use(VueRouter)

let Options = {
  duration: 5000
}
Vue.use(Toasted, Options)

const routes = [
  { path: '/', component: App }
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')
