import axios from 'axios'
import store from '@/store'

class HttpRequest {
  constructor (baseURL) {
    this.baseURL = baseURL
    this.queue = {}
  }
  getInsideConfig () {
    let defaultConfig = {
      baseURL: this.baseURL,
      headers: {
        'X-SOURCE-SIGN': 'admin'
      }
    }
    if (store.state.user.token) {
      defaultConfig.headers['X-Token'] = store.state.user.token
    }
    return defaultConfig
  }
  destory (url) {
    delete this.queue[url]
  }
  interceptors (instance, url) {
    instance.interceptors.request.use(config => {
      this.queue[url] = true
      return config
    }, error => {
      return Promise.reject(error)
    })
    instance.interceptors.response.use(res => {
      this.destory(url)
      const {data, status} = res
      return {data, status}
    }, error => {
      this.destory(url)
      return Promise.reject(error)
    })
  }
  request (options) {
    const instance = axios.create()
    options = Object.assign(this.getInsideConfig(), options)
    this.interceptors(instance, options.url)
    return instance(options)
  }
}

export default HttpRequest
