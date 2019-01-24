import axios from 'axios'
import VueAxios from 'vue-axios'
import store from './vuex/store'
import router from './router'

// axios 配置

axios.defaults.timeout = 20000;
//axios.defaults.baseURL = 'http://127.0.0.1:8080/scerp.front.web';
//axios.defaults.baseURL = 'http://odps';
axios.defaults.baseURL = 'http://192.168.1.200:10001'; //线上的http
//axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
// axios.defaults.baseURL = 'http://localhost:3000';
//axios.defaults.headers['Content-Type'] = `application/x-www-form-urlencoded`;
// axios.defaults.headers = {"Access-Control-Allow-Headers":"token, X-Requested-With, Content-Type"};
// axios.defaults.headers = {"Access-Control-Allow-Headers":"Content-Type"};
//axios.defaults.headers.post['Content-Type'] = 'application/json;charset=UTF-8';
//const instance = axios.create()
//instance.defaults.headers.post['Content-Type'] = 'application/json;charset=UTF-8'
//console.log(axios.defaults);
//axios.defaults.headers={'token':store.state.token,'Content-Type':'application/json;charset=UTF-8'};
// http request 拦截器
axios.interceptors.request.use(
	config => {
		if(store.state.token) {
			config.headers['x-token'] = store.state.token
		}
		return config;
	},
	err => {
		return Promise.reject(err);

	}
);

// http response拦截器
// http response 拦截器
axios.interceptors.response.use(
  response => {
    const statusCode = response.data.error
    if (statusCode == 402) {
//          window.location = 'http://www.shdangdang.com/';
      localStorage.removeItem('token')
      router.push({path: '/'})
    } else if (response.data.status == 7) {
//          window.location = 'http://www.shdangdang.com/#/noright';
    } else if (response.data.msg === 'user-info-error') {
      localStorage.removeItem('token')
      router.push({path: '/'})
    } else if (response.data.msg === '令牌失效') {
      localStorage.removeItem('token')
      router.push({path: '/'})
    }
    return response;
  },
  error => {
    return Promise.reject(error);
  });
//axios.interceptors.response.use(
//	response => {
//		if(response.data.error == 401){
//
//					router.replace({
//						path: '/',
//
//					})
//		}
//		return response
//	},
//	error => {
//		return Promise.reject(error)
//	}
//
//)
export default axios;