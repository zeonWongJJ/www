import Vue from 'vue'
import utils from '../utils/utils'
import Router from 'vue-router'
import store from '../vuex/store'
import axios from '../http'
import indexs from '@/page/index'
import login from '@/page/logo/login'
import loginTel from '@/page/logo/loginTel'
import main from '@/page/index/main'
//import header from '@/page/index/header'
//import left from '@/page/index/left'

//主体路由
//logo登陆注册

import forget from '@/page/logo/forget'
import share from '@/page/pages/share'


//servicesDetails服务详情
import services_details from '@/page/servicesDetails/services_details'

//releaseService发布服务
import release_service from '@/page/releaseService/release_service'
import release_category from '@/page/releaseService/release_category'
import release_rele from '@/page/releaseService/release_rele'


//releaseDemand发布需求
import release_demand from '@/page/releaseDemand/release_demand'
import release_dem_category from '@/page/releaseDemand/release_dem_category'
import release_dem_rele from '@/page/releaseDemand/release_dem_rele'
import payments from '@/page/releaseDemand/payments'

//home 首页
import home from '@/page/home/home'
import message from '@/page/home/message'
import search from '@/page/home/search'


//findServices找服务
import find_services from '@/page/findServices/find_service'
import findsub from '@/page/findServices/findsub'

//findJob找活干
import find_job from '@/page/findJob/find_job'
//detaiL需求详情
import detailDem from '@/page/findJob/detailDem'
//服务详情
import details from '@/page/pages/details'
import evaluate from '@/page/pages/evaluate'
import placeOrder from '@/page/pages/placeOrder'


//Mem会员中心
import member from '@/page/mem/member'
import about from '@/page/mem/about'
import editadd from '@/page/mem/editadd'//编辑地址
import receadd from '@/page/mem/receadd'//收货地址
import pers from '@/page/mem/pers'//换头像
import balance from '@/page/mem/balance'//我的余额
import balance_more from '@/page/mem/balance_more'//余额明细
import recharge from '@/page/mem/recharge'//余额充值
import credit from '@/page/mem/credit'//我的积分
import myColl from '@/page/myColl/myColl'//我的收藏
import credit_more from '@/page/mem/credit_more'//积分明细
import creditExplain from '@/page/mem/creditExplain'//积分说明
import orders from '@/page/mem/orders'//订单
import menvaluate from '@/page/mem/evaluate'//评价
import orderDetails from '@/page/mem/orderDetails'//订单详情
import myfb from '@/page/mem/myfb'//我的发布
import service from '@/page/mem/service'//联系客服
import myeval from '@/page/mem/myeval'//我的评论
import inviting from '@/page/mem/inviting'//邀请好友
import closeOrder from '@/page/mem/closeOrder'//关闭订单


import setup from '@/page/setting/setup'//设置
import setlogin from '@/page/setting/setlogin'//设置登录密码
import setpay from '@/page/setting/setpay'//设置支付密码

import balance_cash from '@/page/cash/balance_cash'//余额提现\积分提现
import setCash from '@/page/cash/setCash'//管理账户余额
import binding from '@/page/cash/binding'//验证安全
import binding_next from '@/page/cash/binding_next'//绑定


//******************************店铺 ******************************
import storeMain from '@/page/store/storeMain'//店铺主体
import upStore from '@/page/store/upStore'//开店
import myStore from '@/page/store/myStore'//我的店铺
import shop from '@/page/store/store'//我的店铺
import storeDeal from '@/page/store/storeDeal'//今日交易额
import serverList from '@/page/store/serverList'//服务列表
import commentAdmin from '@/page/store/commentAdmin'//评论管理
import storeOrders from '@/page/store/storeOrders'//我的订单
import storeApply from '@/page/store/storeApply'//申请开店
import store_orders from '@/page/store/store_orders'//接到的单列表
import storeProfit from '@/page/store/storeProfit'//店铺收益
import orderDetails_x from '@/page/store/orderDetails_x'//订单详情
import storeSet from '@/page/store/storeSet'//店铺设置
import store_staff from '@/page/store/store_staff'//员工管理
import staff from '@/page/store/staff'//员工详情

import store_orders_x from '@/page/store/store_orders_x'//员工服务记录


Vue.use(Router)
const routes = [
  //登陆重定向，
  {
    path: '/',
    name: 'loginTel',
    component: loginTel,
    children: [{
      path: '/',
      name: 'login',
      component: login
    },
      {
        path: '/forget',
        name: 'forget',
        component: forget
      },

      //首頁搜一搜
      {
        path: '/message',
        name: 'message',
        component: message
      },
      {
        path: '/search',
        name: 'search',
        component: search
      },
      //分享
      {
        path: '/share',
        name: 'share',
        component: share
      },

      //releaseService发布服务
      {
        path: '/release_service',
        name: 'release_service',
        component: release_service
      },
      {
        path: '/release_rele',
        name: 'release_rele',
        component: release_rele
      },
      //类型
      {
        path: '/release_category',
        name: 'release_category',
        component: release_category
      },
      //需求酬金
      {
        path: '/release_dem_rele',
        name: 'release_dem_rele',
        component: release_dem_rele,
        meta: { keepAlive: true },//当前的.vue文件需要缓存
      },

      //需求类别
      {
        path: '/release_dem_category',
        name: 'release_dem_category',
        component: release_dem_category
      },
      //需求类别
      {
        path: '/release_dem_category',
        name: 'release_dem_category',
        component: release_dem_category
      },
//releaseDemand发布需求
      {
        path: '/release_demand',
        name: 'release_demand',
        component: release_demand
      },
      //发布需求支付页
      {
        path: '/payments',
        name: 'payments',
        component: payments
      },

      //需求详情
      {
        path: '/detailDem',
        name: 'detailDem',
        component: detailDem
      },

      //服务详情
      {
        path: '/details',
        name: 'details',
        component: details
      },
      //更多评论
      {
        path: '/evaluate',
        name: 'evaluate',
        component: evaluate
      },
      //下单
      {
        path: '/placeOrder',
        name: 'placeOrder',
        component: placeOrder
      },
      //editadd编辑地址
      {
        path: '/editadd',
        name: 'editadd',
        component: editadd
      },
      {
        path: '/receadd',
        name: 'receadd',
        component: receadd
      },
      //会员中心about
      {
        path: '/about',
        name: 'about',
        component: about
      },
      {
        path: '/pers',
        name: 'pers',
        component: pers
      },
      //设置
      {
        path: '/setup',
        name: 'setup',
        component: setup
      },
      {//修改登录密码
        path: '/setlogin',
        name: 'setlogin',
        component: setlogin
      },
      {//修改支付密码
        path: '/setpay',
        name: 'setpay',
        component: setpay
      },
      {//邀请好友
        path: '/inviting',
        name: 'inviting',
        component: inviting
      },
      {
        path: '/service',
        name: 'service',
        component: service
      },
      {
        path: '/myeval',
        name: 'myeval',
        component: myeval
      },
      //我的余额
      {
        path: '/balance',
        name: 'balance',
        component: balance
      },
      //余额明细
      {
        path: '/balance_more',
        name: 'balance_more',
        component: balance_more
      },
      //余额充值
      {
        path: '/recharge',
        name: 'recharge',
        component: recharge
      },
      //我的积分
      {
        path: '/credit',
        name: 'credit',
        component: credit
      },
      {
        path: '/myColl',
        name: 'myColl',
        component: myColl
      },
      //积分明细
      {
        path: '/credit_more',
        name: 'credit_more',
        component: credit_more
      },
      //积分说明
      {
        path: '/creditExplain',
        name: 'creditExplain',
        component: creditExplain
      },
      //提现
      {
        path: 'balance_cash',
        name: 'balance_cash',
        component: balance_cash
      },

      //我的发布
      {
        path: 'myfb',
        name: 'myfb',
        component: myfb
      },
      //订单
      {
        path: 'orders',
        name: 'orders',
        component: orders
      },
      //评价
      {
        path: 'menvaluate',
        name: 'menvaluate',
        component: menvaluate
      },
      //订单详情
      {
        path: 'orderDetails',
        name: 'orderDetails',
        component: orderDetails
      },
      {
        path: 'setCash',
        name: 'setCash',
        component: setCash
      },

      //提现绑定
      {
        path: 'binding',
        name: 'binding',
        component: binding
      },
      {
        path: 'binding_next',
        name: 'binding_next',
        component: binding_next
      },
      //店铺
      {
        path: 'storeMain',
        name: 'storeMain',
        component: storeMain
      },
      {
        path: 'upStore',
        name: 'upStore',
        component: upStore
      },
      {
        path: 'myStore',
        name: 'myStore',
        component: myStore
      },
      {
        path: 'shop',
        name: 'shop',
        component: shop
      },
      {
        path: 'storeDeal',
        name: 'storeDeal',
        component: storeDeal
      },
      {
        path: 'serverList',
        name: 'serverList',
        component: serverList
      },
      {
        path: 'commentAdmin',
        name: 'commentAdmin',
        component: commentAdmin
      },
      {
        path: 'storeOrders',
        name: 'storeOrders',
        component: storeOrders
      },
      {
        path: 'storeApply',
        name: 'storeApply',
        component: storeApply
      },
      {
        path: 'store_orders',
        name: 'store_orders',
        component: store_orders
      },
      {
        path: 'storeProfit',
        name: 'storeProfit',
        component: storeProfit
      },
      {
        path: 'orderDetails_x',
        name: 'orderDetails_x',
        component: orderDetails_x
      },
      {
        path: 'store_orders_x',
        name: 'store_orders_x',
        component: store_orders_x
      },
      {
        path: 'storeSet',
        name: 'storeSet',
        component: storeSet
      },
      {
        path: 'store_staff',
        name: 'store_staff',
        component: store_staff
      },
      {
        path: 'staff',
        name: 'staff',
        component: staff
      },
      //s服务列表
      {
        path: '/findsub',
        name: 'findsub',
        component: findsub
      },
      //servicesDetails服务详情
      {
        path: '/services_details',
        name: 'services_details',
        component: services_details
      },
      {
        path: '/closeOrder',
        name: 'closeOrder',
        component: closeOrder
      },

    ]
  },

  //	路由加在这里

  {
    path: '/main',
    name: 'indexs',
    component: indexs,
    children: [{
      path: '/',
      name: '/',
      component: main
    },

      //  主体路由
      //pagse 首页
      {
        path: '/home',
        name: 'home',
        component: home
      },
      //findJob找活干
      {
        path: '/find_job',
        name: 'find_job',
        component: find_job
      },

      //findServices找服务

      {
        path: '/find_services',
        name: 'find_services',
        component: find_services
      },


      //Mem会员中心
      {
        path: '/member',
        name: 'member',
        component: member
      },

    ]
  },

]
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
  if (to.path === '/share' || to.path === '/orderDetails' || to.path === '/forget') {
    next();
  } else if (getToken() && to.path === '/') { // 判断是否有token
    next({path: '/home'})
  } else if (!getToken() && to.path !== '/') {
    next({path: '/'});
  }
  next();
  store.commit('path', {to:to.path,from:from.path});
  /* else {
      if (whiteList.indexOf(to.path) !== -1) { // 在免登录白名单，直接进入
        next()
      } else {
        next('/login') // 否则全部重定向到登录页
        NProgress.done() // router在hash模式下 手动改变hash 重定向回来 不会触发afterEach 暂时hack方案 ps：history模式下无问题，可删除该行！
      }
    }*/
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
