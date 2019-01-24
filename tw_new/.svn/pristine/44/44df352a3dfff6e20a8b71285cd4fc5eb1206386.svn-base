import Vue from 'vue'
import Router from 'vue-router'
import store from '../vuex/store'

import indexs from '@/page/index'
import loginTel from '@/page/login/loginTel'
import login from '@/page/login/login'
import register from '@/page/login/register'
import main from '@/page/index/main'
import header from '@/page/index/header'
import left from '@/page/index/left'

import friends_dynamic from '@/page/dynamic/dynamic_pl'

//主体路由 路径

//任务task
import my_task from '@/page/tasks/my_task' //我的任务
import all_tasks from '@/page/tasks/all_tasks' //全部任务
import list_tasks from '@/page/tasks/list_tasks' //任务榜单
import release_task from '@/page/tasks/release_task' //发布计划
import planned_task from '@/page/tasks/planned_task' //计划任务
import task_detail from '@/page/tasks/task_sub/task_detail' //我的计划详情

//动作记录
import evaluate from '@/page/tasks/dz/evaluate' //评价
import journal from '@/page/tasks/dz/journal' //日志

import dz from '@/page/tasks/dz/dz'
//发布任务
import releases from '@/page/releases/releases' //发布任务

//结构structure

import struc_left from '@/page/structure/struc_left' //结构进去的第一页
import old_structure from '@/page/structure/old_structure' //结构进去的第一页

import st_release from '@/page/structure/st_release' //结构进去的第一页

//计划planned
import plan from '@/page/planned/plan' //计划进去的第一页
import participate_plan from '@/page/planned/participate_plan' //参与计划
import others_plan from '@/page/planned/others_plan' //他人计划
import plan_details from '@/page/planned/plan_details' //计划详情
import plan_release from '@/page/planned/plan_release' //发布计划

//改  新的计划
import plan_x from '@/page/planned/plan_x' //个人计划
import plan_list_x from '@/page/planned/plan_list_x' //个人计划列表
import release_plan_x from '@/page/planned/release_plan_x' //个人计划发布

import company_plan_x from '@/page/planned/company_plan_x' //公司计划










//绩效achievements
import achievements from '@/page/achievements/achievements' //绩效进去的第一页
import applyLeave from '@/page/achievements/applyLeave' //申请请假
import attendance from '@/page/achievements/attendance' //考勤
import leaveRecord from '@/page/achievements/leaveRecord' //请假记录
import approval from '@/page/achievements/approval' //审批记录
import approvalDetails from '@/page/achievements/approvalDetails'
//通知
import editNoti from '@/page/notify/editNoti' //编辑 公告
import systemNoti from '@/page/notify/systemNoti'
import approvalSV from '@/page/notify/approval'
import allNoti from '@/page/notify/allNoti'
import notice from '@/page/notify/notice'
//测试页
//import oaa from '@/page/structure/struc_left.vue'

Vue.use(Router)
const routes = [
	//****重定向*******

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
				path: '/register',
				name: 'register',
				component: register
			},

		]
	},

	//	新路由加在这里 ，，，，，主页面路由
	{
		path: '/main',
		name: 'indexs',
		meta: {
			requireAuth: true,
		},
		component: indexs,
		children: [

			{
				path: '/',
				name: '/plan_x',
				component: plan_x
			},

			//	除了登陆的路由不放，其他的新路由都在这里，接力下去
			//  主体路由
			//-----------------任务------------------------			
			{
				path: '/my_task',
				name: 'my_task',
				component: my_task
			},
			{
				path: '/all_tasks',
				name: 'all_tasks',
				component: all_tasks
			},
			{
				path: '/list_tasks',
				name: 'list_tasks',
				component: list_tasks
			},
			{
				path: '/release_task',
				name: 'release_task',
				component: release_task
			},
			{
				path: '/planned_task',
				name: 'planned_task',
				component: planned_task
			},
			{
				path: '/task_detail',
				name: 'task_detail',
				component: task_detail
			},
			{
				path: '/releases',
				name: 'releases',
				component: releases
			},
			{
				path: '/evaluate',
				name: 'evaluate',
				component: evaluate
			},
			{
				path: '/journal',
				name: 'journal',
				component: journal
			},

			{
				path: '/dz',
				name: 'dz',
				component: dz
			},
			//************************任务以上************************
			//----------------------结构structure--------------------

			{
				path: '/struc_left',
				name: 'struc_left',
				component: struc_left,
			},

			{
				path: '/st_release',
				name: 'st_release',
				component: st_release
			},
			{
				path: '/old_structure',
				name: 'old_structure',
				component: old_structure
			},

			//************************结构structure 以上************************
			//
			//----------------------计划planned--------------------

			{
				path: '/plan',
				name: 'plan',
				component: plan
			},
			{
				path: '/participate_plan',
				name: 'participate_plan',
				component: participate_plan
			},
			{
				path: '/others_plan',
				name: 'others_plan',
				component: others_plan
			},
			{
				path: '/plan_release',
				name: 'plan_release',
				component: plan_release
			},
			{
				path: '/plan_details',
				name: 'plan_details',
				component: plan_details
			},
//			个人
			{
				path: '/plan_x',
				name: 'plan_x',
				component: plan_x
			},
			
			{
				path: '/plan_list_x',
				name: 'plan_list_x',
				component: plan_list_x
			},
				{
				path: '/release_plan_x',
				name: 'release_plan_x',
				component: release_plan_x
			},
			//公司
			{
				path: '/company_plan_x',
				name: 'company_plan_x',
				component: company_plan_x
			},
			
			
			
			
			
			
			

			//************************计划planned 以上************************
			//----------------------绩效achievements--------------------

			{
				path: '/achievements',
				name: 'achievements',
				component: achievements
			},
			{
				path: '/applyLeave',
				name: 'applyLeave',
				component: applyLeave
			},
			{
				path: '/attendance',
				name: 'attendance',
				component: attendance
			},
			{
				path: '/leaveRecord',
				name: 'leaveRecord',
				component: leaveRecord
			},
			{
				path: '/approval',
				name: 'approval',
				component: approval
			},
			{
				name: 'approvalDetails',
				path: '/approvalDetails',
				component: approvalDetails
			},
			//************************绩效achievements 以上************************

			{
				path: '/editNoti',
				name: 'editNoti',
				component: editNoti
			},
			{
				path: '/systemNoti',
				name: 'systemNoti',
				component: systemNoti
			},
			{
				path: '/approvalSV',
				name: 'approvalSV',
				component: approvalSV
			},
			{
				path: '/allNoti',
				name: 'allNoti',
				component: allNoti
			},
			{
				path: '/notice',
				name: 'notice',
				component: notice
			},
			//			动态------------------

			{
				path: '/friends_dynamic',
				name: 'friends_dynamic',
				component: friends_dynamic
			},

		]
	},

	//{
	//		path: '/main',
	//		name: 'indexs',
	//		meta: {
	//			requireAuth: true,
	//		},
	//		component: indexs,
	//		children: [{
	//				path: '/main',
	//				name: 'main',
	//				component: indexs
	//			},
	//			]
	//},

]
// 页面刷新，重新给 token 赋值
if(window.localStorage.getItem('member_id')) {
	store.commit('member_id', window.localStorage.getItem('member_id'));
}
if(window.localStorage.getItem('department')) {
	store.commit('department', window.localStorage.getItem('department'));
}
if(window.localStorage.getItem('task_id')) {
	store.commit('task_id', window.localStorage.getItem('task_id'));
}
if(window.localStorage.getItem('real_name')) {
	store.commit('real_name', window.localStorage.getItem('real_name'));
}
if(window.localStorage.getItem('department_id')) {
	store.commit('department_name', window.localStorage.getItem('department_id'));
}
if(window.localStorage.getItem('real_name')) {
	store.commit('real_name', window.localStorage.getItem('real_name'));
}
if(window.localStorage.getItem('token')) {
	store.commit('set_token', window.localStorage.getItem('token'))

}

const router = new Router({
	mode: "history",
	routes
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
router.beforeEach((to, from, next) => {
 if (getToken() && to.path === '/') { // 判断是否有token
    next({path: '/main'})
  } else if (!getToken() && to.path !== '/') {
    next({path: '/'});
  }
  next();
  store.commit('path', to.path);
  /* else {
      if (whiteList.indexOf(to.path) !== -1) { // 在免登录白名单，直接进入
        next()
      } else {
        next('/login') // 否则全部重定向到登录页
        NProgress.done() // router在hash模式下 手动改变hash 重定向回来 不会触发afterEach 暂时hack方案 ps：history模式下无问题，可删除该行！
      }
    }*/
})



//router.beforeEach((to, from, next) => {
//	if(to.matched.some(r => r.meta.requireAuth)) { //这里的requireAuth为路由中定义的 meta:{requireAuth:true}，意思为：该路由添加该字段，表示进入该路由需要登陆的  
//		if(store.state.token) {
//			next();
//		} else {
//			next({
//				path: '/',
//				query: {
//					//					redirect: to.fullPath
//				}
//			})
//		}
//	} else {
//		next();
//	}
//})


export default router;