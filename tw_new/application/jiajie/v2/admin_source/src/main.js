// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import i18n from './locale'
import iView from 'iview'
import ZkTable from 'vue-table-with-tree-grid'
import VueAMap from 'vue-amap'
import config from './config'
import installPlugin from './plugin'
import importDirective from './directive'
import axios from './libs/api.request'
import 'iview/dist/styles/iview.css' // 引入iview全局样式
import './index.less'
Vue.config.productionTip = false
Vue.use(iView, {
  i18n: (key, value) => i18n.t(key, value)
})
Vue.use(ZkTable)
Vue.use(VueAMap)
/**
 * @description 注册admin内置插件
 */
installPlugin(Vue)
/**
 * @description 全局注册应用配置
 */
Vue.prototype.$config = config
/**
 * 注册指令
 */
importDirective(Vue)

// 初始化vue-amap
VueAMap.initAMapApiLoader({
  // 高德的key
  key: '0c4feb71c7ebae0c7f02e339f7b470ff',
  // 插件集合
  plugin: ['AMap.Autocomplete', 'AMap.PlaceSearch', 'AMap.Scale', 'AMap.OverView', 'AMap.ToolBar', 'AMap.MapType', 'AMap.PolyEditor', 'AMap.CircleEditor', 'AMap.Geolocation', 'AMap.Geocoder'],
  // 高德 sdk 版本，默认为 1.4.4
  v: '1.4.4'
})

Vue.prototype.$http = async (url, data, method = 'post') => {
  if (!data) {
    data = {
      rows: 30
    }
  }
  const promise = await axios.request({
    url,
    data,
    method
  })
  if (typeof promise === 'object') {
    const response = promise.data
    if (response.error === 0) {
      return Promise.resolve(response)
    }
    return Promise.reject(response.msg)
  } else {
      this.$Message.info('后端接口异常')
  }
}

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  i18n,
  components: { App },
  template: '<App/>'
})
