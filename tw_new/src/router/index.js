import Vue from 'vue'
import utils from '../utils/utils'
import Router from 'vue-router'
import store from '../vuex/store'
import axios from '../http'
import index from '@/pages/index'
import main from '@/pages/main'
//import header from '@/page/index/header'
//import left from '@/page/index/left'

//主体路由
//logo登陆注册

Vue.use(Router)
const routes = [
//	路由加在这里

  
  //登陆重定向，
  {
   path: '/',
		name: 'main',
		component: resolve => require(['@/pages/main'],resolve),
		redirect: {
			name: 'home'
		},
		children: [{
				path: '/index',
				name: 'index',
				component: resolve => require(['@/pages/index'],resolve),
				children: [
					//  主体路由
					//pagse 首页
					{
						path: '/home',
						name: 'home',
						component: resolve => require(['@/pages/home/home'],resolve)
					},


				]
			}],
		},
	]



  

//]
// 页面刷新，重新给 token 赋值
if (window.localStorage.getItem('token')) {
  store.commit('login', window.localStorage.getItem('token'));
}

var router = new Router({
  routes/*,
	mode: 'history',*/
//  打包后打开页面刷新当前页面会404 HTML5 History 模式
//  	 routes: [shop
//  	 { path: '*', component: NotFoundComponent }
//  	 ]
});

function getToken() {
  return localStorage.getItem('token');
  // check_token().then(() => {
  //   return true
  // }).catch(() => {
  //   return false
  // })
}

function check_token() {
  const _fetch = axios({
    url: '/user.check.token'
    , method: 'post'
    , data: {}
  });
  return new Promise((resolve, reject) => {
    _fetch.then(rs => {
      if (rs.data.error == 0) {
        return resolve()
      } else {
        return reject()
      }
    }).catch(() => {
      return reject()
    })
  })
}

// if(store.state.token) {
// 	next();
// } else {
// 	next({
// 		path: '/home',
// 		//  query: {redirect: to.fullPath}
// 	})
// }

const homePage = ['/home', '/find_job', '/find_services', '/member'] // 最顶层的页面

router.beforeEach((to, from, next) => {
  if (utils.is_android_app()) {
    const indexOf = homePage.indexOf(to.path)
    let json = {
      isArrowFinish: indexOf > -1
    };
    androidBack.androidFinish(JSON.stringify(json));
  }
  if(!getToken() && (to.path === '/member1')) { // 判断是否有token并需要登录
    next({path:'/login'});
  }
  /* else {
      if (whiteList.indexOf(to.path) !== -1) { // 在免登录白名单，直接进入
        next()
      } else {
        next('/login') // 否则全部重定向到登录页
        NProgress.done() // router在hash模式下 手动改变hash 重定向回来 不会触发afterEach 暂时hack方案 ps：history模式下无问题，可删除该行！
      }
    }*/
  store.commit('path', {to:to.path,from:from.path});
  next();
})
//	if(to.matched.some(r => r.meta.requireAuth)) {
//		if(store.state.token) {
//
//			next();
//		} else {
//			next({
//				path: '/home',
//				//  query: {redirect: to.fullPath}
//			})
//		}
//	} else {
//		next();
//	}


export default router;
