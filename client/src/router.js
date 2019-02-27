import Vue from 'vue'
import Router from 'vue-router'
import Admin from '@/views/Admin'

Vue.use(Router);

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'admin',
      component: Admin,
    },
  ]
})
