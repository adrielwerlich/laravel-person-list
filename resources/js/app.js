require('./bootstrap');
import Vue from 'vue/dist/vue.esm.js'
window.Vue = Vue
import VueMask from 'v-mask'
Vue.use(VueMask);

// ###### VueRouter Below #######

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import App from './components/Home.vue'

let routes = [
  //   {path: '/',
  
  //   children: [
  //   ]
    
  // }, 
  {
    path: '/person-form',
    name: 'PersonForm',
    component: require('./components/Form.vue').default
  },
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })

// ###### VueRouter Above #######


const app = new Vue({
  el: '#app',
  router,
  components: { App },
  render: h => h(App),
  data: {
    search: '',
  },
  methods: {
    
    
    
    
    
  }
});