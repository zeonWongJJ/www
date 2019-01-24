import axios from 'axios'
import VueAxios from 'vue-axios'
import store from './vuex/store'
import router from './router'

// axios 配置

axios.defaults.timeout = 20000;
//axios.defaults.baseURL = 'http://127.0.0.1:8080/scerp.front.web';
//axios.defaults.baseURL = 'http://odps';
axios.defaults.baseURL = 'http://192.168.1.200:10004'; //线上的http
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

// http response 拦截器
//axios.interceptors.response.use(
//	response => {
//		return response;
//	},
//	error => {
//		if(error.response) {
//			switch(error.response.status) {
//				case 401:
//					// 401 清除token信息并跳转到登录页面
//					store.commit('del_token');
//					router.replace({
//						path: 'login',
//						query: {
//							redirect: router.currentRoute.fullPath
//						}
//					})
//			}
//		}
//		// console.log(JSON.stringify(error));//console : Error: Request failed with status code 402
//		return Promise.reject(error.response.data) // 返回接口返回的错误信息
//	});
//axios.interceptors.request.use(config => {
//
//	return config
//
//}, error => {
//
//	return Promise.reject(error)
//
//})

// http response拦截器

axios.interceptors.response.use(

	response => {

		console.log('response拦截器11111111111')

		console.log(response)
		
		if(response.data.error == 401){
					// 401 清除token信息并跳转到登录页面
//					store.commit('del_token');
					router.replace({
						path: '/',
//						query: {
//							redirect: router.currentRoute.fullPath
//						}
					})
		}

		return response

	},

	error => {

		console.log('response拦截器22222222222')


		return Promise.reject(error)

	}

)
export default axios;