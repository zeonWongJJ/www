// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from './http';
import VueAxios from 'vue-axios';
import vuex from 'vuex';
import 'babel-polyfill'
import store from './vuex/store';
import iView from 'iview';
import 'iview/dist/styles/iview.css';
import '../my-theme/index.less';
import '../reset/reset.css'
import $ from 'jquery'
import '../src/assets/css/jquery.orgchart.css'
import '../src/assets/js/html2canvas.min.js'
import '../src/assets/js/jquery.orgchart.js'
Vue.config.productionTip = false

Vue.use(iView);

// 用 axios 进行 Ajax 请求
Vue.use(VueAxios, axios);
//axios.defaults.headers.common['token'] = store.state.token;  

//Vue.prototype.axios = axios
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
   store,
    axios,
  components: { App },
  template: '<App/>'
})
