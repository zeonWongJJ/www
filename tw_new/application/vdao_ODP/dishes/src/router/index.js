import Vue from 'vue'
import Router from 'vue-router'
import store from '../vuex/store'
import utils from '@/utils/utils'
import axios from '../http'

//主体路由
//logo登陆注册
//方案1

Vue.use(Router)
const routes = [
//	路由加在这里

//登陆重定向，
{
  path: '/',
  name: 'main',
  component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/main'),
  redirect: {
    name: 'dishes_home'
  },
    children: [
      {
        path: '/index',
        name: 'index',
        component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/index'),
        children: [
          {
            path: '/dishes_home',
            name: 'dishes_home',
            component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/home/home')
          },

          {
            path: '/dishes_memder',
            name: 'dishes_memder',
            component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/my_men/memder')
          },

          {
            path: '/census',
            name: 'census',
            component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/census/census')
          },

        ]
      },
      {
        path: '/setMenu',
        name: 'setMenu',
        component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/my_men/setMenu')
      },
      {
        path: '/login',
        name: 'login',
        component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/login/login')
      },
      {
        path: '/addcai',
        name: 'addcai',
        component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/my_men/addcai')
      },
      {
        path: '/Statistics',
        name: 'Statistics',
        component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/my_men/Statistics')
      },
      {
        path: '/setLikes',
        name: 'setLikes',
        component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/my_men/setLikes')
      },
      {
        path: '/censusDetails',
        name: 'censusDetails',
        component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/census/censusDetails')
      },
      {
        path: '/detailed',
        name: 'detailed',
        component: ()=>import(/* webpackChunkName: "group-foo" */ '@/dishes/my_men/detailed')
      },
    ]
  },
]

//	{
//
//			children: [{
//				path: '/index',
//				name: 'index',
//				component: resolve => require(['@/pages/index'],resolve),
//				children: [
//					//  主体路由
//					//pagse 首页
//					{
//						path: '/home',
//						name: 'home',
//						component: resolve => require(['@/pages/home/home'],resolve)
//					},
//					//赚钱
//					{
//						path: '/makemoney',
//						name: 'makemoney',
//						component: resolve => require(['@/pages/makemoneys/makemoney'],resolve)
//					},
//					//消息
//					{
//						path: '/mymess',
//						name: 'mymess',
//						component: resolve => require(['@/pages/information/mymess'],resolve)
//					},
//					//订单
//					{
//						path: '/ten_about',
//						name: 'ten_about',
//						component: resolve => require(['@/pages/reservation/ten_about'],resolve)
//					},
//					//Mem会员中心
//					{
//						path: '/member',
//						name: 'member',
//						component: resolve =>require(['@/pages/my/my_memder'],resolve)
//					},
//				]
//			}]
//}

// 页面刷新，重新给 token 赋值
if (window.localStorage.getItem('token')) {
  store.commit('token', window.localStorage.getItem('token'));
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

function getUsername() {
  return localStorage.getItem('username');
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

const homePage = ['/dishes_home', '/census', '/dishes_memder'] // 最顶层的页面

router.beforeEach((to, from, next) => {
  if (utils.is_android_app()) {
    const indexOf = homePage.indexOf(to.path)
    let json = {
      isArrowFinish: indexOf > -1
    };
    android.androidFinish(JSON.stringify(json));
  }
  if (!getToken() && (to.path !== '/login')) { // 判断是否有token并需要登录
    next({path:'/login'});
  } else
    if (getToken() && !getUsername() && (to.path !== '/setMenu')){
    next({path: '/setMenu'});
  } else {
    next()
  }
  /* else {
      if (whiteList.indexOf(to.path) !== -1) { // 在免登录白名单，直接进入
        next()
      } else {
        next('/login') // 否则全部重定向到登录页
        NProgress.done() // router在hash模式下 手动改变hash 重定向回来 不会触发afterEach 暂时hack方案 ps：history模式下无问题，可删除该行！
      }
    }*/
  //store.commit('path', {to:to.path,from:from.path});
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
