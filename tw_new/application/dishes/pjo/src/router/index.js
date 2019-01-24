import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import login from '@/login/login'
import setMenu from '@/setMenu/setMenu'
import Vant from 'vant';
import 'vant/lib/index.css';

Vue.use(Router)
Vue.use(Vant);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'login',
      component: login
    },
    {
      path: '/setMenu',
      name: 'setMenu',
      component: setMenu
    }
  ]
})
